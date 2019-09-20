<?php
/**
 * Example of usage Yandex\SafeBrowsing package
 *
 * @author   Alexander Khaylo <naxel@land.ru>
 * @created  07.02.14 13:57
 */

use Yandex\Common\Exception\YandexException;
use Yandex\SafeBrowsing\Adapter\RedisAdapter;
use Yandex\SafeBrowsing\SafeBrowsingClient;
use Yandex\SafeBrowsing\SafeBrowsingException;

ini_set('memory_limit', '256M');
?>
<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Yandex PHP Library: Safe Browsing Demo</title>
    <link rel="stylesheet" href="//yandex.st/bootstrap/3.0.0/css/bootstrap.min.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="/examples/Disk/css/style.css">
    <style>
        .btn {
            padding: 6px 12px;
        }
    </style>
</head>
<body>

<div class="container">
    <ol class="breadcrumb">
        <li><a href="/examples">Examples</a></li>
        <li><a href="/examples/SafeBrowsing">SafeBrowsing</a></li>
        <li class="active">Поиск префикса хеша сайта в локальной БД</li>
    </ol>
    <h3>Поиск префикса хеша сайта в локальной БД</h3>
    <?php
    try {

        $settings = require_once '../settings.php';

        if (empty($settings['safebrowsing']['key'])) {
            throw new SafeBrowsingException('Empty Safe Browsing key');
        }
        if (empty($settings['safebrowsing']['redis_dsn'])) {
            throw new SafeBrowsingException('Empty Safe Browsing Redis DSN');
        }

        if (isset($_GET['url']) && $_GET['url']) {
            $url = $_GET['url'];

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

            $hashes = $safeBrowsing->getHashesByUrl($url);

            if ($shaVars = $redisAdapter->getShaVarsByHashes($hashes)) {
                ?>
                <div class="alert alert-danger">
                    <p>Хеш для "<?= htmlentities($url) ?>" найден в списках:</p>
                    <ul>
                        <?php foreach ($shaVars as $shaVar) { ?>
                            <li><?= $shaVar ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php
            } else {
                ?>
                <div class="alert alert-success"><?= htmlentities($url) ?> - не найден в списке опасных сайтов</div>
            <?php
            }
        }
        ?>

        <form method="get">
            <div class="input-group">
                <input name="url" placeholder="URL" type="text" class="form-control"/>
                <span class="input-group-btn">
                    <input class="btn btn-primary" type="submit" value="Проверить URL"/>
                </span>
            </div>
        </form>
        <p>
            Пример: http://www.wmconvirus.narod.ru/
        </p>
        <div>
            Также можно посмотреть примеры:
            <ul>
                <li>
                    <a href="index.php">Проверить адреса</a>
                </li>
                <li>
                    <a href="lookup.php">Lookup API и Check Adult API</a>
                </li>
                <li>
                    <a href="save-prefixes-db.php">Сохранение базы префиксов хешей вредоносных сайтов (начнется
                        автоматически)</a>
                </li>
                <li>
                    <a href="update-prefixes-db.php">Обновить локальную базу префиксов хешей вредоносных сайтов (начнется
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
