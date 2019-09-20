<?php
/**
 * Example of usage Yandex\SiteSearchPinger package
 *
 * @author   Anton Shevchuk
 * @created  07.08.13 10:32
 */

use Yandex\SiteSearchPinger\SiteSearchPinger;
use Yandex\SiteSearchPinger\Exception\SiteSearchPingerException;
use Yandex\Common\Exception\YandexException as YandexException;

?>
<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Yandex PHP Library: Pinger Demo</title>
    <link rel="stylesheet" href="//yandex.st/bootstrap/3.0.0/css/bootstrap.min.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="/examples/Disk/css/style.css">
</head>
<body>
<div class="container">
    <div class="jumbotron">
        <h2><span class="glyphicon glyphicon-search"></span> Пример работы с Яндекс Пингером</h2>
    </div>
    <div class="col-md-8">
        <ol class="breadcrumb">
            <li><a href="/examples">Examples</a></li>
            <li class="active">SiteSearchPinger</li>
        </ol>
        <?php
        try {

            $settings = require_once '../settings.php';
            $pinger = new SiteSearchPinger();

            if (!isset($settings["pinger"]["key"]) || !$settings["pinger"]["key"]) {
                throw new SiteSearchPingerException('Empty pinger key');
            }
            if (!isset($settings["pinger"]["login"]) || !$settings["pinger"]["login"]) {
                throw new SiteSearchPingerException('Empty pinger key');
            }
            if (!isset($settings["pinger"]["searchId"]) || !$settings["pinger"]["searchId"]) {
                throw new SiteSearchPingerException('Empty pinger key');
            }

            $pinger->key = $settings["pinger"]["key"];
            $pinger->login = $settings["pinger"]["login"];
            $pinger->searchId = $settings["pinger"]["searchId"];

            $url = [
                "http://anton.shevchuk.name/php/php-development-environment-under-macos/",
                "http://anton.shevchuk.name/php/php-framework-bluz-update/",
                "http://ya.ru",
                "http://yandex.ru",
                "yaru",
                "yarus",
            ];

            $added = $pinger->ping($url);

            echo "OK. " . $added . " from " . sizeof($url) . " urls was added to queue<br/>";

            if (sizeof($pinger->invalidUrls)) {
                echo "Invalid Urls:" . "<br/>";
                foreach ($pinger->invalidUrls as $url => $reason) {
                    echo $url . " - " . $reason . "<br/>";
                }
            }
        } catch (SiteSearchPingerException $e) {
            echo "Site Search Pinger Exception:<br/>";
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
</div>
</body>
</html>
