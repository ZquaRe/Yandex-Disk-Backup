<?php
$settings = require_once '../settings.php';
use Yandex\Market\Partner\PartnerClient;

$postCartJson = file_get_contents("php://input");
$debug = false;
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $debug = true;
    //Пример запроса от Яндекс.Маркета:
    $postCartJson = '{"cart":{"currency":"UAH","items":[{"feedId":362211,"offerId":"15","feedCategoryId":"11","offerName":"dvd 02","count":1}],"delivery":{"region":{"id":27819,"name":"Каховка","type":"CITY","parent":{"id":20542,"name":"Херсонская область","type":"SUBJECT_FEDERATION","parent":{"id":20526,"name":"Юг","type":"REGION","parent":{"id":187,"name":"Украина","type":"COUNTRY"}}}}}}}';
}

//POST /cart
//@see http://api.yandex.ru/market/partner/doc/dg/reference/post-cart.xml
if ($_SERVER['REQUEST_METHOD'] == 'POST' || $debug) {

    //Get
    $cartRequest = new \Yandex\Market\Models\PostCartRequest();
    $cartRequest->fromJson($postCartJson);
    $currency = $cartRequest->getCart()->getCurrency();
    /** @var Yandex\Market\Models\Items $requestedItems */
    $requestedItems = $cartRequest->getCart()->getItems();

    //Ответ магазина на запрос от Яндекс.Маркета
    $postCartResponse = new \Yandex\Market\Models\PostCartResponse();
    //Корзина
    $cart = new \Yandex\Market\Models\CartResponse();

    //Товары в корзине
    $items = new \Yandex\Market\Models\Items();
    /** @var Yandex\Market\Models\Item $requestedItem */
    foreach ($requestedItems as $requestedItem) {
        //Информация о товаре в корзине.
        $item = new \Yandex\Market\Models\Item();
        $item->setFeedId((int)$requestedItem->getFeedId());
        $item->setOfferId($requestedItem->getOfferId());
        $item->setPrice(300);
        $item->setCount($requestedItem->getCount());
        $item->setDelivery(true);
        $items->add($item);
    }
    $cart->setItems($items);

    //Способы оплаты, доступные для корзины.
    $cart->setPaymentMethods(
        [
            //Способ оплаты заказа
            PartnerClient::PAYMENT_METHOD_CASH_ON_DELIVERY,
            PartnerClient::PAYMENT_METHOD_CARD_ON_DELIVERY,
        ]
    );

    //Опции доставки, доступные для корзины.
    $deliveryOptions = new \Yandex\Market\Models\DeliveryOptions();
    //Информация о доставке #1
    $deliveryOption1 = new \Yandex\Market\Models\DeliveryOption();
    $deliveryOption1->setType(PartnerClient::DELIVERY_TYPE_PICKUP);
    $datesRange1 = new \Yandex\Market\Models\DatesRange();
    $datesRange1->setFromDate(date('d-m-Y'));
    $datesRange1->setToDate(date('d-m-Y', mktime(0, 0, 0, date("m"), date("d") + 3, date("Y"))));
    $deliveryOption1->setDates($datesRange1);
    $deliveryOption1->setServiceName('СПСР');
    $deliveryOption1->setPrice(0);
    $deliveryOption1->setId("1");
    //Информация о пункте самовывоза.
    $outlets = new \Yandex\Market\Models\Outlets();
    $outlet1 = new \Yandex\Market\Models\Outlet();
    $outlet1->setId(9);
    $outlet2 = new \Yandex\Market\Models\Outlet();
    $outlet2->setId(10);
    $outlet3 = new \Yandex\Market\Models\Outlet();
    $outlet3->setId(11);
    $outlets->add($outlet1);
    $outlets->add($outlet2);
    $outlets->add($outlet3);
    $deliveryOption1->setOutlets($outlets);

    //Информация о доставке #2
    $deliveryOption2 = new \Yandex\Market\Models\DeliveryOption();
    $deliveryOption2->setType(PartnerClient::DELIVERY_TYPE_DELIVERY);
    $datesRange2 = new \Yandex\Market\Models\DatesRange();
    $datesRange2->setFromDate(date('d-m-Y', mktime(0, 0, 0, date("m"), date("d") + 5, date("Y"))));
    $deliveryOption2->setDates($datesRange1);
    $deliveryOption2->setServiceName('Собственная служба доставки');
    $deliveryOption2->setPrice(350);
    $deliveryOption2->setId("2");

    $deliveryOptions->add($deliveryOption1);
    $deliveryOptions->add($deliveryOption2);
    $cart->setDeliveryOptions($deliveryOptions);

    $postCartResponse->setCart($cart);

    header('Content-Type: application/json');
    echo $postCartResponse->toJson();
}