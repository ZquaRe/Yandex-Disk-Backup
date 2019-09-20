<?php
/**
 * Example of usage Yandex\SafeBrowsing package
 *
 * @author   Alexander Khaylo <naxel@land.ru>
 * @created  07.02.14 14:00
 */
ini_set('memory_limit', '256M');
set_time_limit(300);

use Yandex\SafeBrowsing\SafeBrowsingClient;
use Yandex\SafeBrowsing\SafeBrowsingException;
use Yandex\Common\Exception\YandexException;
use Yandex\SafeBrowsing\Adapter\RedisAdapter;

?>
<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Yandex PHP Library: Safe Browsing Demo</title>
    <link rel="stylesheet" href="//yandex.st/bootstrap/3.0.0/css/bootstrap.min.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="/examples/Disk/css/style.css">
</head>
<body>

<div class="container">
    <ol class="breadcrumb">
        <li><a href="/examples">Examples</a></li>
        <li><a href="/examples/SafeBrowsing">SafeBrowsing</a></li>
        <li class="active">Обновление локальной базы префиксов хешей вредоносных сайтов</li>
    </ol>
    <h3>Обновление локальной базы префиксов хешей вредоносных сайтов</h3>
    <?php
    try {

        $settings = require_once '../settings.php';

        if (empty($settings["safebrowsing"]["key"])) {
            throw new SafeBrowsingException('Empty Safe Browsing key');
        }
        if (empty($settings['safebrowsing']['redis_dsn'])) {
            throw new SafeBrowsingException('Empty Safe Browsing Redis DSN');
        }

        $key = $settings["safebrowsing"]["key"];
        $redisDsn = $settings['safebrowsing']['redis_dsn'];
        $redisOptions = [];
        if (isset($settings['safebrowsing']['redis_database'])) {
            $redisOptions['parameters']['database'] = $settings['safebrowsing']['redis_database'];
        }
        if (isset($settings['safebrowsing']['redis_password'])) {
            $redisOptions['parameters']['password'] = $settings['safebrowsing']['redis_password'];
        }

        $safeBrowsing = new SafeBrowsingClient($key);
        $redisAdapter = new RedisAdapter($redisDsn, $redisOptions);

        $localShaVars = $redisAdapter->getShaVars();
        $localChunkNums = [];

        foreach ($localShaVars as $shaVar) {
            $localChunkNums[$shaVar] = $redisAdapter->getChunkNums($shaVar);
        }



        /**
         * Example:
         */
        //$savedChunks['ydx-malware-shavar'] = [
        //    'added' => [
        //        'min' => 1,
        //        'max' => 30000
        //    ],
        //    'removed' => [
        //        'min' => 1,
        //        'max' => 30000
        //    ]
        //
        //];
        $savedChunks = [];

        foreach ($localChunkNums as $shaVar => $chunkNums) {
            $minChunkNum = false;
            $maxChunkNum = false;

            foreach ($chunkNums as $chunkNum) {
                if (!$maxChunkNum && !$minChunkNum) {
                    $minChunkNum = $chunkNum;
                    $maxChunkNum = $chunkNum;
                } elseif ($chunkNum > $maxChunkNum) {
                    $maxChunkNum = $chunkNum;
                } elseif ($chunkNum < $minChunkNum) {
                    $minChunkNum = $chunkNum;
                }
            }

            if ($minChunkNum && $maxChunkNum) {
                $savedChunks[$shaVar]['added'] = [
                    'min' => $minChunkNum,
                    'max' => $maxChunkNum
                ];
            }
        }

        $malwaresData = $safeBrowsing->getMalwaresData($savedChunks);

        if (is_string($malwaresData) && $malwaresData === 'pleasereset') {
            ?>
            <div class="alert alert-info">Нужно сбросить БД</div>
        <?php
        } else {
            $newPrefixes = [];
            $removedPrefixes = [];
            $newChunks = 0;
            $removedChunks = 0;
            if (is_array($malwaresData)) {
                foreach ($malwaresData as $shaVar => $chunks) {

                    //Need add new malwares hash prefixes
                    if (isset($chunks['added'])) {
                        foreach ($chunks['added'] as $chunkNum => $hashPrefixes) {
                            foreach ($hashPrefixes as $hashPrefix) {
                                if (!$redisAdapter->getHashPrefix($hashPrefix)) {
                                    $redisAdapter->saveHashPrefix($shaVar, $chunkNum, $hashPrefix);
                                    $newChunks++;
                                }
                            }
                        }
                    }

                    //Need remove chunks
                    if (isset($chunks['removed'])) {
                        foreach ($chunks['removed'] as $chunkNum => $hashPrefixes) {
                            foreach ($hashPrefixes as $hashPrefix) {
                                if ($redisAdapter->getHashPrefix($hashPrefix)) {
                                    $redisAdapter->removeHashPrefix($shaVar, $chunkNum, $hashPrefix);
                                    $removedChunks++;
                                }
                            }
                        }
                    }

                    //Need remove chunks range
                    if (isset($chunks['delete_added_ranges'])) {
                        foreach ($chunks['delete_added_ranges'] as $range) {
                            for ($i = $range['min']; $i <= $range['max']; $i++) {
                                $redisAdapter->removeChunkNum($shaVar, $chunkNum);
                                $removedChunks++;
                            }
                        }
                    }
                }
            }
            ?>
            <div class="alert alert-info">Новых кусков: <?= $newChunks ?></div>
            <div class="alert alert-info">Кусков, в которых содержаться более не опасные
                сайты: <?= $removedChunks ?></div>
            <div class="alert alert-success">Локальная БД обновлена успешно.</div>
            <div>
                Также можно посмотреть примеры:
                <ul>
                    <li>
                        <a href="index.php">Проверить адреса</a>
                    </li>
                    <li>
                        <a href="local-search.php">Поиск префикса хеша сайта в локальной БД</a>
                    </li>
                    <li>
                        <a href="lookup.php">Lookup API и Check Adult API</a>
                    </li>
                    <li>
                        <a href="update-prefixes-db.php">Обновить локальную базу префиксов хешей вредоносных сайтов
                            (начнется автоматически)</a>
                    </li>
                </ul>
            </div>
        <?php
        }

    } catch (SafeBrowsingException $e) {
        echo "Safe Browsing Exception:<br/>";
        echo nl2br($e->getMessage());
    } catch (YandexException $e) {
        echo "Yandex Library Exception:<br/>";
        echo nl2br($e->getMessage());
    } catch (\Exception $e) {
        echo get_class($e) . "<br/>";
        echo nl2br($e->getMessage());
    }
    ?>
</div>

</body>
</html>
