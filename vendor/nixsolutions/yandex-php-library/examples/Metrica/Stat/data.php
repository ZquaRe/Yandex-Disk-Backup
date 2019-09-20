<?php
/**
 * User: Tanya Kalashnik
 * Date: 21.07.14 11:18
 */

use Yandex\Metrica\Stat\StatClient;


$data = [];
$errorMessage = false;

//Is auth
if (isset($_COOKIE['yaAccessToken']) && isset($_COOKIE['yaClientId'])) {
    $settings = require_once '../../settings.php';


    try {
        $statClient = new StatClient($_COOKIE['yaAccessToken']);

        if (isset($_GET['counter-id']) && $_GET['counter-id']) {
            $counterId = $_GET['counter-id'];

            $paramsModel = new Yandex\Metrica\Stat\Models\TableParams();
            $paramsModel->setPreset(\Yandex\Metrica\Stat\AvailableValues::PRESET_TECH_PLATFORMS)
                /**
                 * Список измерений, разделенных запятой
                 */
                ->setDimensions(\Yandex\Metrica\Stat\DimensionsConst::S_BROWSER)

                /**
                 * Идентификатор счетчика
                 */
                ->setId($counterId);
            /**
             * @see http://api.yandex.ru/metrika/doc/beta/api_v1/data.xml
             */
            $data = $statClient->data()->getTable($paramsModel);
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
        <li><a href="/examples/Metrica/Stat">Stat</a></li>
        <li class="active">Отчет "Технологии - Браузеры"</li>
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
                    <h3>Отчет «Технологии — Браузеры»:</h3>
                    <table id="accountTable" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <td>Браузер</td>
                                <?php for ($i = 0; $i < count($data->getQuery()->getMetrics()); $i++) { ?>
                                <td><?= $data->getQuery()->getMetrics()[$i] ?></td>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (!is_null($data->getData())) {
                            foreach ($data->getData() as $dimensions) { ?>
                                <tr>
                                    <td><?= $dimensions->getDimensions()->current()->getName() ?></td>
                                    <?php for ($i = 0; $i < count($data->getQuery()->getMetrics()); $i++) { ?>
                                    <td><?= $dimensions->getMetrics()[$i] ?></td>
                                    <?php } ?>
                                </tr>
                            <?php
                            }
                        }
                        ?>
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
