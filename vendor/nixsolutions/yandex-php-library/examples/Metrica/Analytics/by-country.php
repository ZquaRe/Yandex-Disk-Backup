<?php
/**
 * User: tanchik
 * Date: 28.07.14 13:32
 */

use Yandex\Metrica\Analytics\AnalyticsClient;

$data = array();
$errorMessage = false;

//Is auth
if (isset($_COOKIE['yaAccessToken']) && isset($_COOKIE['yaClientId'])) {
    $settings = require_once '../../settings.php';

    try {
        $analyticsClient = new AnalyticsClient($_COOKIE['yaClientId']);

        if (isset($_GET['counter-id']) && $_GET['counter-id']) {
            $counterId = $_GET['counter-id'];

            $paramsObj = new \Yandex\Metrica\Analytics\Models\Params();
            $paramsObj
                /**
                 * Метрики позволяют получать данные о статистике посещаемости и активности пользователей сайта.
                 * Если в запросе вы не укажете ни одной группировки,
                 * то API вернет общее значение метрики для выбранного временного интервала
                 * без разделения его на какие-либо группы
                 */
                ->setMetrics(\Yandex\Metrica\Analytics\MetricConst::GA_PAGE_VIEWS)

                /**
                 * Дата начала отчетного периода
                 */
                ->setStartDate('6daysAgo')

                /**
                 * Дата окончания отчетного периода
                 */
                ->setEndDate('today')

                /**
                 * Номер счетчика, данные которого необходимо получить
                 */
                ->setIds('ga:' . $_GET['counter-id'])

                /**
                 * Измерения группируют данные по критериям
                 */
                ->setDimensions(\Yandex\Metrica\Analytics\DimensionsConst::GA_COUNTRY);

            $analyticsClient = new AnalyticsClient($_COOKIE['yaAccessToken']);

            /**
             * @see http://api.yandex.ru/metrika/doc/beta/ga/queries/requestjson.xml
             */
            $data = $analyticsClient->ga()->getGaData($paramsObj);
        }
    } catch (\Exception $ex) {
        $errorMessage = $ex->getMessage();
        if ($errorMessage === 'PlatformNotAllowed') {
            $errorMessage .= '<p>Возможно, у приложения нет прав на доступ к ресурсу. Попробуйте '
                . '<a href="' . rtrim(str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__), "/") . '/../OAuth/' . '">авторизироваться</a> и повторить.</p>';
        }
    }
}
?>
<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Yandex.SDK: Metrica Demo</title>

    <link rel="stylesheet" href="//yandex.st/bootstrap/3.0.3/css/bootstrap.min.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="/examples/Disk/css/style.css">

</head>
<body>

<div class="container">
    <div class="jumbotron">
        <h2><a href="/examples/Metrica"><span class="glyphicon glyphicon-tasks"></span></a> Пример работы с Яндекс Метрикой</h2>
    </div>
    <ol class="breadcrumb">
        <li><a href="/examples">Examples</a></li>
        <li><a href="/examples/Metrica">Metrica</a></li>
        <li><a href="/examples/Metrica/Analytics">Analytics</a></li>
        <li class="active">Просмотры по странам</li>
    </ol>
    <?php
    if (!isset($_COOKIE['yaAccessToken']) || !isset($_COOKIE['yaClientId'])) {
        ?>
        <div class="alert alert-info">
            Для просмотра этой страницы вам необходимо авторизироваться.
            <a id="goToAuth" href="/examples/OAuth" class="alert-link">Перейти на страницу авторизации</a>.
        </div>
    <?php
    } else {
        if ($errorMessage) {
            ?>
            <div class="alert alert-danger"><?= $errorMessage ?></div>
        <?php
        } else {
            ?>
            <div>
                <?php
                if ($data) {
                    ?>
                    <h3>Сравнение визитов с мобильных и не мобильных устройств:</h3>
                    <table id="accountTable" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <td>Страна</td>
                            <td>Количество просмотров</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($data->getRows() as $row) { ?>
                            <tr>
                                <td><?= current($row) ?></td>
                                <td><?= end($row) ?></td>
                            </tr>
                        <?php
                        } ?>
                        </tbody>
                    </table>
                <?php
                }
                ?>
            </div>
        <?php
        }
    }
    ?>
</div>

<script src="http://yandex.st/jquery/2.0.3/jquery.min.js"></script>
<script src="http://yandex.st/bootstrap/3.0.3/js/bootstrap.min.js"></script>

</body>
</html>