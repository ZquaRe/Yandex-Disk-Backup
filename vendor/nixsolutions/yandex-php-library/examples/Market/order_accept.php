<?php
$settings = require_once '../settings.php';
use Yandex\Market\Partner\PartnerClient;

$json = file_get_contents("php://input");
$debug = false;
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $debug = true;
    //Пример запроса от Яндекс.Маркета:
    $json = '{"order":{"id":94508,"fake":true,"currency":"UAH","paymentType":"POSTPAID","paymentMethod":"CASH_ON_DELIVERY","delivery":{"type":"DELIVERY","price":350,"serviceName":"Собственная служба доставки","id":"2","dates":{"fromDate":"02-07-2014","toDate":"05-07-2014"},"region":{"id":27819,"name":"Каховка","type":"CITY","parent":{"id":20542,"name":"Херсонская область","type":"SUBJECT_FEDERATION","parent":{"id":20526,"name":"Юг","type":"REGION","parent":{"id":187,"name":"Украина","type":"COUNTRY"}}}},"address":{"country":"Украина","city":"Каховка","street":"Ленина","house":"14","floor":"3"}},"items":[{"feedId":362211,"offerId":"14","feedCategoryId":"2","offerName":"Sovet TC1","price":300,"count":1,"delivery":true}],"notes":"Примечание"}}';
}

//POST /order/accept
//@see http://api.yandex.ru/market/partner/doc/dg/reference/post-order-accept.xml
if ($_SERVER['REQUEST_METHOD'] == 'POST' || $debug) {

    //Передача заказа и запрос на принятие заказа
    //Get
    $postOrderAccept = new \Yandex\Market\Models\PostOrderAccept();
    $postOrderAccept->fromJson($json);

    //Ответ магазина на запрос от Яндекс.Маркета
    $postOrderAcceptResponse = new \Yandex\Market\Models\PostOrderAcceptResponse();
    //Заказ
    $acceptOrder = new \Yandex\Market\Models\AcceptOrder();
    //Идентификатор заказа, присвоенный магазином. Указывается, если заказ принят.
    $id = rand(1000, 10000);
    if ($id % 2 === 0) {
        $acceptOrder->setId('' . $id);
        //Признак принятия заказа
        $acceptOrder->setAccepted(true);
    } else {
        //Признак отказа заказа
        $acceptOrder->setAccepted(false);
        $acceptOrder->setReason(PartnerClient::ORDER_DECLINE_REASON_OUT_OF_DATE);
    }

    $postOrderAcceptResponse->setOrder($acceptOrder);

    header('Content-Type: application/json');
    echo $postOrderAcceptResponse->toJson();
}