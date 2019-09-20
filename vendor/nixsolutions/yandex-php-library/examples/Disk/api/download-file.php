<?php
/**
 * Example of usage Yandex\Disk package
 *
 * @author   Alexander Mitsura
 * @created  15.10.13 10:37
 */

$settings = require_once '../../settings.php';

use Yandex\OAuth\OAuthClient;

$client = new OAuthClient($settings['global']['clientId']);

if (isset($_COOKIE['yaAccessToken'])) {

    $file = $_GET['file'];

    $client->setAccessToken($_COOKIE['yaAccessToken']);

    // XXX: how it should be (using user access token)
    //$diskClient = new \Yandex\Disk\DiskClient($client->getAccessToken());

    // XXX: how it is now (using magic access token)
    $diskClient = new \Yandex\Disk\DiskClient($client->getAccessToken());

    $diskClient->setServiceScheme(\Yandex\Disk\DiskClient::HTTPS_SCHEME);

    $file = $diskClient->downloadFile($file);
    header('Content-Description: File Transfer');
    header('Connection: Keep-Alive');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Content-type: ' . $file['headers']['last-modified']);
    header('Etag: ' . $file['headers']['etag']);
    header('Date: ' . $file['headers']['date']);
    header('Content-Type: ' . $file['headers']['content-type']);
    header('Content-Length: ' . $file['headers']['content-length']);
    header('Content-Disposition: ' . $file['headers']['content-disposition']);
    header('Accept-Ranges: ' . $file['headers']['accept-ranges']);

    echo $file['body'];
}