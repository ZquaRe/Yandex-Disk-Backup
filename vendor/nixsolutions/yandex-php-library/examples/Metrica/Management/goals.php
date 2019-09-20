<?php
/**
 * User: naxel
 * Date: 17.02.14 11:29
 */
use Yandex\Metrica\Management\ManagementClient;

$goals = array();
$errorMessage = false;

//Is auth
if (isset($_COOKIE['yaAccessToken']) && isset($_COOKIE['yaClientId'])) {
    $settings = require_once '../../settings.php';

    try {
        $managementClient = new ManagementClient($_COOKIE['yaAccessToken']);

        if (isset($_GET['counter-id']) && $_GET['counter-id']) {
            $counterId = $_GET['counter-id'];
            //GET /management/v1/counter/{counterId}/goals;
            /**
             * @see http://api.yandex.ru/metrika/doc/beta/management/goals/goals.xml
             */
            $goals = $managementClient->goals()->getGoals($counterId);
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
        <li><a href="/examples/Metrica/Management/counters.php">Счетчики</a></li>
        <li class="active">Цели</li>
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
                <h3>Цели:</h3>
                <table id="countersTable" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>Название</td>
                        <td>Тип</td>
                        <td>Класс</td>
                        <td>Тип цели для клиентов Яндекс.Маркета</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($goals instanceof Traversable) {
                        foreach ($goals as $goal) {
                            ?>
                            <tr>
                                <td><?= $goal->getId() ?></td>
                                <td><?= $goal->getName() ?></td>
                                <td><?= $goal->getType() ?></td>
                                <td><?= $goal->getClass() ?></td>
                                <td><?= $goal->getFlag() ?></td>
                            </tr>

                        <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        <?php
        }
    }
    ?>
</div>
</body>
</html>
