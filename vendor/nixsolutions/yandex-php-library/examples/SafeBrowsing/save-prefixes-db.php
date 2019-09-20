<?php
/**
 * Example of usage Yandex\SafeBrowsing package
 *
 * @author   Alexander Khaylo <naxel@land.ru>
 * @created  07.02.14 14:00
 */
ini_set('memory_limit', '256M');
set_time_limit(300);

use Yandex\Common\Exception\YandexException;
use Yandex\SafeBrowsing\Adapter\RedisAdapter;
use Yandex\SafeBrowsing\SafeBrowsingClient;
use Yandex\SafeBrowsing\SafeBrowsingException;

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
        <li class="active">Сохранение базы префиксов хешей вредоносных сайтов</li>
    </ol>
    <h3>Сохранение базы префиксов хешей вредоносных сайтов</h3>
    <?php
    try {
        $settings = require_once '../settings.php';

        if (empty($settings['safebrowsing']['key'])) {
            throw new SafeBrowsingException('Empty Safe Browsing key');
        }
        if (empty($settings['safebrowsing']['redis_dsn'])) {
            throw new SafeBrowsingException('Empty Safe Browsing Redis DSN');
        }

        $key = $settings['safebrowsing']['key'];
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

        $shaVarsList = $safeBrowsing->getShavarsList();?>

        <p>Списки опасных сайтов:</p>
        <ul>
            <?php
            foreach ($shaVarsList as $shaVar) {
                ?>
                <li><?= $shaVar ?></li>
            <?php } ?>
        </ul>
        <?php
        $safeBrowsing->setMalwareShavars($shaVarsList);
        $malwaresData = $safeBrowsing->getMalwaresData();

        if (is_array($malwaresData)) {
            foreach ($malwaresData as $shaVar => $chunks) {
                if (isset($chunks['added'])) {
                    foreach ($chunks['added'] as $chunkNum => $hashPrefixes) {
                        foreach ($hashPrefixes as $hashPrefix) {
                            $redisAdapter->saveHashPrefix($shaVar, $chunkNum, $hashPrefix);
                        }
                    }
                }
            }
        }
        ?>
        <div class="alert alert-success">Сохранены префиксы хешей в Redis</div>
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
                    <a href="save-prefixes-db.php">Сохранение базы префиксов хешей вредоносных сайтов (начнется
                        автоматически)</a>
                </li>
            </ul>
        </div>
    <?php

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
