<?php
// Remove reposes
exec("find . | grep .git | xargs rm -rf");

$branchName = getenv('TRAVIS_BRANCH');
$fileName = 'yandex-php-library_.phar';

$phar = new Phar($fileName, 0, $fileName);
// Add files to Phar
$phar->buildFromDirectory(dirname(__FILE__), '/vendor/');
$phar->buildFromDirectory(dirname(__FILE__), '/src/');
$phar->addFile('CHANGELOG.md');
$phar->addFile('LICENSE');
$phar->addFile('README.md');

require_once dirname(__FILE__) . '/vendor/autoload.php';
use Yandex\Disk\DiskClient;

$disk = new DiskClient();
$disk->setAccessToken(getenv('ACCESS_TOKEN'));
// Send to Yandex.DisK
$disk->uploadFile(
    '/builds/',
    array(
        'path' => $fileName,
        'size' => filesize($fileName),
        'name' => str_replace('.phar', $branchName . '.phar', $fileName)
    )
);

// Compressing
if (Phar::canCompress(Phar::BZ2)) {
    $phar->compress(Phar::BZ2, 'phar.bz2');
    //Send to Yandex.DisK
    $fileName .= '.bz2';
    $disk->uploadFile(
        '/builds/',
        array(
            'path' => $fileName,
            'size' => filesize($fileName),
            'name' => str_replace('.phar.bz2', $branchName . '.phar.bz2', $fileName)
        )
    );
}
