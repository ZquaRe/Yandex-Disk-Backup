<?php
/**
 * Example of usage Yandex\Disk package
 *
 * @author   Alexander Mitsura
 * @created  15.10.13 10:39
 */

$settings = require_once '../../settings.php';

use Yandex\OAuth\OAuthClient;

$client = new OAuthClient($settings['global']['clientId']);

if (isset($_COOKIE['yaAccessToken'])) {

    $file = $_GET['file'];
    $size = $_GET['size'];

    $client->setAccessToken($_COOKIE['yaAccessToken']);

    // XXX: how it should be (using user access token)
    //$diskClient = new \Yandex\Disk\DiskClient($client->getAccessToken());

    // XXX: how it is now (using magic access token)
    $diskClient = new \Yandex\Disk\DiskClient($client->getAccessToken());

    $diskClient->setServiceScheme(\Yandex\Disk\DiskClient::HTTPS_SCHEME);

    $file = $diskClient->getImagePreview($file, $size);
    header('Content-Description: File Transfer');
    header('Connection: Keep-Alive');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Date: ' . $file['headers']['date']);
    header('Content-Type: image/jpeg');
    header('Content-Length: ' . $file['headers']['content-length']);
    header('Accept-Ranges: ' . $file['headers']['accept-ranges']);
    echo $file['body'];
}