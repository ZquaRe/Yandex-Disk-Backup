<?php
/**
 * Example of usage Yandex\Disk package
 *
 * @author   Alexander Mitsura
 * @created  15.10.13 10:41
 */

$settings = require_once '../../settings.php';

use Yandex\OAuth\OAuthClient;

$client = new OAuthClient($settings['global']['clientId']);

if (isset($_COOKIE['yaAccessToken'])) {

    $target = $_POST['target'];

    $client->setAccessToken($_COOKIE['yaAccessToken']);

    // XXX: how it should be (using user access token)
    //$diskClient = new \Yandex\Disk\DiskClient($client->getAccessToken());

    // XXX: how it is now (using magic access token)
    $diskClient = new \Yandex\Disk\DiskClient($client->getAccessToken());

    $diskClient->setServiceScheme(\Yandex\Disk\DiskClient::HTTPS_SCHEME);

    header('Content-type: application/json');
    $response = [];

    if ($url = $diskClient->startPublishing($target)) {
        $response['status'] = 'publishing';
        $response['url'] = $url;
    } else {
        $response['status'] = 'not publishing';
    }

    echo json_encode($response);
}