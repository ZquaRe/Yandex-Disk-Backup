<?php
/**
 * Example of usage Yandex\SafeBrowsing package
 *
 * @author   Alexander Khaylo <naxel@land.ru>
 * @created  31.01.14 18:47
 */

use Yandex\SafeBrowsing\SafeBrowsingClient;
use Yandex\SafeBrowsing\SafeBrowsingException;
use Yandex\Common\Exception\YandexException;

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
    <div class="jumbotron">
        <h2><span class="glyphicon glyphicon glyphicon-certificate"></span> Пример работы с Safe Browsing API Яндекса</h2>
    </div>
    <ol class="breadcrumb">
        <li><a href="/examples">Examples</a></li>
        <li class="active">SafeBrowsing</li>
    </ol>
    <h3>Проверить адреса</h3>
    <?php
    try {

        $settings = require_once '../settings.php';

        if (!isset($settings["safebrowsing"]["key"]) || !$settings["safebrowsing"]["key"]) {
            throw new SafeBrowsingException('Empty Safe Browsing key');
        }

        if (isset($_GET['url']) && $_GET['url']) {
            $url = $_GET['url'];

            $key = $settings["safebrowsing"]["key"];

            $safeBrowsing = new SafeBrowsingClient($key);

            /**
             * Using "gethash" request
             */
            if ($safeBrowsing->searchUrl($url)) {
                ?>
                <div class="alert alert-danger">Найден полный хеш для "<?= htmlentities($url) ?>" в списке опасных сайтов</div>
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
                    <a href="lookup.php">Lookup API и Check Adult API</a>
                </li>
                <li>
                    <a href="local-search.php">Поиск префикса хеша сайта в локальной БД</a>
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
