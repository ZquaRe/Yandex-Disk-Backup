<?php
/*
 _______   __   __  ___  __  ___      ___   .___________.                                                                                                                                                                                                                                                                                                                                                                                            
|       \ |  | |  |/  / |  |/  /     /   \  |           |                                                                                                                                                                                                                                                                                                                                                                                            
|  .--.  ||  | |  '  /  |  '  /     /  ^  \ `---|  |----`                                                                                                                                                                                                                                                                                                                                                                                            
|  |  |  ||  | |    <   |    <     /  /_\  \    |  |                                                                                                                                                                                                                                                                                                                                                                                                 
|  '--'  ||  | |  .  \  |  .  \   /  _____  \   |  |                                                                                                                                                                                                                                                                                                                                                                                                 
|_______/ |__| |__|\__\ |__|\__\ /__/     \__\  |__|                                                                                                                                                                                                                                                                                                                                                                                                 

Öncelikle Videoyu İzliyerek API Key Oluşturunuz.

https://www.youtube.com/watch?v=t20Ye0A1dRY&t=51s

https://tech.yandex.com/disk/webdav/

oauth.yandex.ru/authorize?response_type=token&client_id=TOKENID

Tayfun Erbilen'in BackuPhp kütüphanesi kullanılmıştır,
Vendor içerisinde Backup Klasöründedir. Autload.php'e ek olarak required edilerek eklenmiştir.
Eğer kendi Vendor dosyanız var ise ayrıca BackuPhp kütüphanesini projenize dahil ediniz.

Bu php dosyasının bulunduğu yere Backup adında bir dosya oluşturunuz.

Localde Çalışıyor, SSL Lazım Sadece.
*/


date_default_timezone_set('Europe/Istanbul');
//Yandex Disk Klasör Adı, İsteğe Bağlı Değiştirilebilir. Yandex Disk kendisi oluşturacaktır.
define('BackupFolder', 'Backup');

//Veritabanı bilgileri
define('host', 'localhost');
define('user', 'root');
define('pass', '');
define('dbname', '');

//Yandex API Access Token
define('diskapi', '');

require 'vendor/autoload.php';
use Yandex\Disk\DiskClient;
//
$diskClient = new DiskClient(diskapi);
$diskClient->setServiceScheme(DiskClient::HTTPS_SCHEME);
$aylar = array(1 => "Ocak", 2 => "Şubat", 3 => "Mart", 4 => "Nisan", 5 => "Mayıs", 6 => "Haziran", 7 => "Temmuz", 8 => "Ağustos", 9 => "Eylül", 10 => "Ekim", 11 => "Kasım", 12 => "Aralık");
//Eğer BackupFolder belirlenen klasör yoksa oluşturuyoruz.
$BackupFolder = $diskClient->directoryContents('/');
foreach ($BackupFolder as $dirItem) {
    if ($dirItem['resourceType'] == 'dir') {
        if ($dirItem['displayName'] != BackupFolder) {
            $BackUP = $diskClient->createDirectory('/' . BackupFolder);
        }
    }
}
$Tarih = date("d") . ' ' . $aylar[date("n") ] . ' ' . date("Y");
//Oluşturduğumuz BackupFolder tanımlı klasöre giriyoruz.
$dirContent = $diskClient->directoryContents('/' . BackupFolder);
foreach ($dirContent as $dirItem) {
    if ($dirItem['resourceType'] == 'dir') {
        if ($dirItem['displayName'] != $Tarih) {
            $dirContent = $diskClient->createDirectory('/' . BackupFolder . '/' . $Tarih);
        }
    }
}
/*
//Giriş yapmış kullanıcı verilerini gösterir (İsteğe bağlı, loglamak isterseniz kullanabilirsiniz.)
$login = $diskClient->getLogin();
echo $login.'<br>';

*/
//Yükleme verilerini yükseltiyoruz, yüksek mblı veriler için geçerlidir.
ini_set("memory_limit", "120000M");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
//Site dosyalarınız içerisinde bu php dosyasının kurulu olduğu yere Backup adında klasör oluşturunuz.
//Geçici Backup dosyamızı oluşturuyoruz.
$uniqid = __DIR__ . '/Backup/' . uniqid(uniqid(uniqid(strtotime('now')))) . '.sql';
$backup = new Backup();
$BackupName = 'Backup_' . date("H:i:s", strtotime('now')) . '.sql';
// Mysql yedeği almak için
$mysqlBackup = $backup->mysql(['host' => host, 'user' => user, 'pass' => pass, 'dbname' => dbname, 'file' => $uniqid]);
if ($mysqlBackup) {
    //SQL Dosyası oluşturursa onu Yandex Disk'e yükleyecek.
    $diskClient->uploadFile('/' . BackupFolder . '/' . $Tarih . '/', array('path' => $uniqid, 'size' => filesize($uniqid), 'name' => $BackupName));
    if ($diskClient) {
        //Oluşturulan dosyayı siliyoruz.
        unlink($uniqid);
    }
}
