<?php
/**
 * Example of usage Yandex\Disk package
 *
 * @author   Alexander Mitsura
 * @created  15.10.13 10:35
 */

$settings = require_once '../../settings.php';

use Yandex\OAuth\OAuthClient;

$client = new OAuthClient($settings['global']['clientId']);

if (isset($_COOKIE['yaAccessToken'])) {

    $directory = $_POST['directory'];

    $client->setAccessToken($_COOKIE['yaAccessToken']);

    // XXX: how it should be (using user access token)
    //$diskClient = new \Yandex\Disk\DiskClient($client->getAccessToken());

    // XXX: how it is now (using magic access token)
    $diskClient = new \Yandex\Disk\DiskClient($client->getAccessToken());

    $diskClient->setServiceScheme(\Yandex\Disk\DiskClient::HTTPS_SCHEME);

    header('Content-type: application/json');
    echo json_encode($diskClient->directoryContents($directory));
}