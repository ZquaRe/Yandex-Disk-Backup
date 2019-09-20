<?php
$settings = require_once '../settings.php';
use Yandex\Market\Partner\PartnerClient;

$json = file_get_contents("php://input");
$debug = false;
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $debug = true;
    //Пример запроса от Яндекс.Маркета:
    $json = '{"order":{"id":94737,"fake":true,"currency":"UAH","status":"CANCELLED","substatus":"USER_CHANGED_MIND","creationDate":"02-07-2014 16:24:49","itemsTotal":300,"total":650,"delivery":{"type":"DELIVERY","price":350,"serviceName":"Собственная служба доставки","id":"2","dates":{"fromDate":"02-07-2014","toDate":"05-07-2014"},"region":{"id":27819,"name":"Каховка","type":"CITY","parent":{"id":20542,"name":"Херсонская область","type":"SUBJECT_FEDERATION","parent":{"id":20526,"name":"Юг","type":"REGION","parent":{"id":187,"name":"Украина","type":"COUNTRY"}}}},"address":{"country":"Украина","city":"Каховка","street":"Ленина","house":"14","entrance":"1","entryphone":"2","floor":"3","recipient":"Александр Хайло","phone":"+380937266014"}},"buyer":{"id":"nRNCmpjDkqDJDG6McBS4QA==","lastName":"Khaylo","firstName":"Alexander","phone":"+380937266014","email":"alex.khaylo@yandex.ua"},"items":[{"feedId":362211,"offerId":"14","feedCategoryId":"2","offerName":"Sovet TC1","price":300,"count":1}],"notes":"Примечание"}}';
}

//POST /order/status
//@see http://api.yandex.ru/market/partner/doc/dg/reference/post-order-status.xml
if ($_SERVER['REQUEST_METHOD'] == 'POST' || $debug) {

    //Передача заказа и запрос на принятие заказа
    //Get
    $postOrderStatus = new \Yandex\Market\Models\PostOrderStatus();
    $postOrderStatus->fromJson($json);
    $status = $postOrderStatus->getOrder()->getStatus();
    $subStatus = $postOrderStatus->getOrder()->getSubstatus();

    exit;
}
