<?php
$settings = require_once '../settings.php';
use Yandex\Market\Partner\PartnerClient;
use Yandex\Common\Exception\ForbiddenException;

$errorMessage = false;
$order = null;

//Is auth
if (isset($_COOKIE['yaAccessToken']) && isset($_COOKIE['yaClientId'])
    && isset($_GET['campaignId']) && $_GET['campaignId']
    && isset($_GET['orderId']) && $_GET['orderId']
) {

    $market = new PartnerClient($_COOKIE['yaAccessToken']);
    $market->setClientId($_COOKIE['yaClientId']);
    $market->setLogin($settings['global']['marketLogin']);

    try {
        $market->setCampaignId($_GET['campaignId']);

        if (isset($_GET['status']) && $_GET['status']) {
            if (isset($_GET['substatus']) && $_GET['substatus']) {
                $market->setOrderStatus($_GET['orderId'], $_GET['status'], $_GET['substatus']);
            } else {
                $market->setOrderStatus($_GET['orderId'], $_GET['status']);
            }
        }
        /** @var Yandex\Market\Models\Order $orders */
        $order = $market->getOrder($_GET['orderId']);
    } catch (ForbiddenException $ex) {
        $errorMessage = $ex->getMessage();
        $errorMessage .= '<p>Возможно, у приложения нет прав на доступ к ресурсу. Попробуйте '
            . '<a href="' . rtrim(str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__), "/") . "/../OAuth/"  . '">авторизироваться</a> и повторить.</p>';

    } catch (Exception $ex) {
        $errorMessage = $ex->getMessage();
    }
}
$orderStatusesTexts = [
    PartnerClient::ORDER_STATUS_RESERVED => 'заказ в резерве',
    PartnerClient::ORDER_STATUS_UNPAID => 'заказ оформлен, но еще не оплачен',
    PartnerClient::ORDER_STATUS_PROCESSING => 'заказ находится в обработке',
    PartnerClient::ORDER_STATUS_DELIVERY => 'заказ передан в доставку',
    PartnerClient::ORDER_STATUS_PICKUP => 'заказ доставлен в пункт самовывоза',
    PartnerClient::ORDER_STATUS_DELIVERED => 'заказ получен покупателем',
    PartnerClient::ORDER_STATUS_CANCELLED => 'заказ отменен',
];
?>
<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Yandex PHP Library: Market Demo</title>
    <link rel="stylesheet" href="//yandex.st/bootstrap/3.0.0/css/bootstrap.min.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="/examples/Disk/css/style.css">
</head>
<body>
<div class="container">
<div class="jumbotron">
    <h2><span class="glyphicon glyphicon-shopping-cart"></span> Пример работы с Яндекс Маркетом</h2>
</div>
<div><span class="glyphicon glyphicon-arrow-left"></span> <a href="/examples/Market/">Назад</a></div>
<?php
if (!isset($_GET['campaignId']) || !$_GET['campaignId'] || !isset($_GET['orderId']) || !$_GET['orderId']) {
    ?>
    <div class="alert alert-info">
        Для просмотра этой страницы вам необходимо передать orderId и campaignId
        <a id="goToAuth" href="/examples/Market/" class="alert-link">Перейти назад</a>.
    </div>
<?php
} elseif (!isset($_COOKIE['yaAccessToken']) || !isset($_COOKIE['yaClientId'])) {
    ?>
    <div class="alert alert-info">
        Для просмотра этой страницы вам необходимо авторизироваться.
        <a id="goToAuth" href="<?php echo rtrim(str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__), "/") . '/../OAuth/'?>" class="alert-link">Перейти на страницу авторизации</a>.
    </div>
<?php
} elseif ($errorMessage) {
    ?>

    <div class="alert alert-danger">
        <?= $errorMessage ?>
    </div>
<?php
} elseif (isset($market)) {

    if ($errorMessage) {
        ?>
        <div class="alert alert-danger"><?= $errorMessage ?></div>
    <?php
    } elseif ($order) {
        ?>
        <div class="col-md-8">
        <h2>Информация о Заказе:</h2>
        <h3>Запрос:</h3>
        <p>
            <a href="http://api.yandex.ru/market/partner/doc/dg/reference/get-campaigns-id-orders-id.xml">
                GET /campaigns/{campaignId}/orders/{orderId}
            </a>
        </p>

        <h3>Ответ:</h3>
        <h3>Информация о заказе:</h3>
        <p>
            <label>ID:</label> <?= $order->getId() ?>
        </p>
        <p>
            <label>Статус:</label> <?php
            echo $orderStatusesTexts[$order->getStatus()];
            ?>
        </p>
        <?php
        if ($order->getStatus() === PartnerClient::ORDER_STATUS_PROCESSING) {
            ?>
            <p>
                <a href="/examples/Market/view-order.php?orderId=<?= $order->getId(
                ) ?>&campaignId=<?= $_GET['campaignId'] ?>&status=DELIVERY">Заказ готов к передаче в службу
                    доставки</a>
            </p>
            <p>
                <a href="/examples/Market/view-order.php?orderId=<?= $order->getId(
                ) ?>&campaignId=<?= $_GET['campaignId'] ?>&status=CANCELLED&substatus=USER_UNREACHABLE">Не удалось
                    связаться с покупателем</a>
            </p>
            <p>
                <a href="/examples/Market/view-order.php?orderId=<?= $order->getId(
                ) ?>&campaignId=<?= $_GET['campaignId'] ?>&status=CANCELLED&substatus=USER_CHANGED_MIND">Покупатель
                    отменил заказ по собственным причинам</a>
            </p>
        <?php
        } elseif ($order->getStatus() === PartnerClient::ORDER_STATUS_DELIVERY) {
            ?>
            <p>
                <a href="/examples/Market/view-order.php?orderId=<?= $order->getId(
                ) ?>&campaignId=<?= $_GET['campaignId'] ?>&status=PICKUP">Заказ доставлен в пункт самовывоза</a>
            </p>
            <p>
                <a href="/examples/Market/view-order.php?orderId=<?= $order->getId(
                ) ?>&campaignId=<?= $_GET['campaignId'] ?>&status=DELIVERED">Заказ вручен покупателю</a>
            </p>
            <p>
                <a href="/examples/Market/view-order.php?orderId=<?= $order->getId(
                ) ?>&campaignId=<?= $_GET['campaignId'] ?>&status=CANCELLED&substatus=USER_UNREACHABLE">Не удалось
                    связаться с покупателем</a>
            </p>
            <p>
                <a href="/examples/Market/view-order.php?orderId=<?= $order->getId(
                ) ?>&campaignId=<?= $_GET['campaignId'] ?>&status=CANCELLED&substatus=USER_CHANGED_MIND">Покупатель
                    отменил заказ по собственным причинам</a>
            </p>
        <?php
        }
        ?>

        <p>
            <label>Дата оформления заказа:</label> <?= $order->getCreationDate() ?>
        </p>
        <p>
            <label>Валюта:</label> <?= $order->getCurrency() ?>
        </p>
        <p>
            <label>Общая сумма заказа в валюте заказа без учета доставки:</label> <?= $order->getItemsTotal() ?>
        </p>
        <p>
            <label>Общая сумма заказа в валюте заказа с учетом доставки:</label> <?= $order->getTotal() ?>
        </p>
        <hr/>
        <h3>Товары:</h3>
        <?php
        if ($order->getItems() instanceof Traversable) {
            /** @var Yandex\Market\Models\Item $item */
            foreach ($order->getItems() as $item) {
                ?>
                <p>
                    <label>ID товара:</label> <?= $item->getOfferId() ?>
                </p>
                <p>
                    <label>Категория:</label> <?= $item->getFeedCategoryId() ?>
                </p>
                <p>
                    <label>Название товара:</label> <?= $item->getOfferName() ?>
                </p>
                <p>
                    <label>Цена:</label> <?= $item->getPrice() ?>
                </p>
                <p>
                    <label>Количество:</label> <?= $item->getCount() ?>
                </p>
                <hr/>
            <?php
            }
        }
        ?>
        <?php if ($order->getBuyer()) { ?>
            <h3>Покупатель:</h3>
            <p>
                <label>Фамилия:</label> <?= $order->getBuyer()->getLastName() ?>
            </p>
            <p>
                <label>Имя:</label> <?= $order->getBuyer()->getFirstName() ?>
            </p>
            <p>
                <label>Телефон:</label> <?= $order->getBuyer()->getPhone() ?>
            </p>
            <p>
                <label>Email:</label> <?= $order->getBuyer()->getEmail() ?>
            </p>
        <?php } ?>
        <h3>Доставка:</h3>
        <p>
            <label>Способ доставки заказа:</label> <?php
            if ($order->getDelivery()->getType() === PartnerClient::DELIVERY_TYPE_DELIVERY) {
                ?>
                курьерская доставка
            <?php
            } elseif ($order->getDelivery()->getType() === PartnerClient::DELIVERY_TYPE_PICKUP) {
                ?>
                самовывоз
            <?php
            } else {
                ?>
                почта
            <?php
            }
            ?>
        </p>
        <p>
            <label>Название службы доставки:</label> <?= $order->getDelivery()->getServiceName() ?>
        </p>
        <p>
            <label>Стоимость доставки в валюте заказа:</label> <?= $order->getDelivery()->getPrice() ?>
        </p>
        <p>
            <label>Диапазон дат доставки:</label> <?=
            $order->getDelivery()->getDates()->getFromDate() . ' - '
            . $order->getDelivery()->getDates()->getToDate() ?>
        </p>
        <p>
            <label>Страна:</label> <?= $order->getDelivery()->getAddress()->getCountry() ?>
        </p>
        <p>
            <label>Город либо населенный пункт:</label> <?= $order->getDelivery()->getAddress()->getCity() ?>
        </p>
        <p>
            <label>Улица:</label> <?= $order->getDelivery()->getAddress()->getStreet() ?>
        </p>
        <p>
            <label>Номер дома или владения:</label> <?= $order->getDelivery()->getAddress()->getHouse() ?>
        </p>
        <p>
            <label>ФИО получателя заказа:</label> <?= $order->getDelivery()->getAddress()->getRecipient() ?>
        </p>
        <p>
            <label>Номер телефона получателя заказа:</label> <?=
            $order->getDelivery()->getAddress()->getPhone() ?>
        </p>

    <?php
    }
    ?>
    </div>
<?php
}
?>
</div>
<script src="http://yandex.st/jquery/2.0.3/jquery.min.js"></script>
<script src="http://yandex.st/jquery/cookie/1.0/jquery.cookie.min.js"></script>
<script>
    $(function () {
        $('#goToAuth').click(function (e) {
            $.cookie('back', location.href, {expires: 256, path: '/'});
        });
    });
</script>
</body>
</html>

