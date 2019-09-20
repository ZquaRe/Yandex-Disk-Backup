<?php
/**
 * User: Tanya Kalashnik
 * Date: 28.07.14 11:13
 */

use Yandex\Metrica\Management\ManagementClient;

$counters = array();
$errorMessage = false;

//Is auth
if (isset($_COOKIE['yaAccessToken']) && isset($_COOKIE['yaClientId'])) {
    $settings = require_once '../../settings.php';

    try {
        $managementClient = new ManagementClient($_COOKIE['yaAccessToken']);

        $paramsObj = new \Yandex\Metrica\Management\Models\CountersParams();
        $paramsObj
            /**
             * Тип счетчика. Возможные значения:
             * simple ― счетчик создан пользователем в Метрике;
             * partner ― счетчик импортирован из РСЯ.
             */
            ->setType(\Yandex\Metrica\Management\AvailableValues::TYPE_SIMPLE)
            ->setField('goals,mirrors,grants,filters,operations');

        /**
         * @see http://api.yandex.ru/metrika/doc/beta/management/counters/counters.xml
         */
        $counters = $managementClient->counters()->getCounters($paramsObj)->getCounters();
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
        <li class="active">Analytics</li>
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
                <h3>Счетчики:</h3>
                <table id="countersTable" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>Название</td>
                        <td>Количество посещений</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($counters instanceof Traversable) {
                        foreach ($counters as $counter) {
                            ?>
                            <tr data-counter-id="<?= $counter->getId() ?>">
                                <td><?= $counter->getId() ?></td>
                                <td><?= $counter->getName() ?></td>
                                <td class="pageviews"></td>
                                <td>
                                    <a href="/examples/Metrica/Analytics/by-country.php?counter-id=<?= $counter->getId(
                                    ) ?>"
                                       class="btn btn-primary">Отчет по странам</a><br/>
                                </td>
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

<!-- Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Ошибка</h4>
            </div>
            <div class="modal-body">
                <div id="errorMessage"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<script src="http://yandex.st/jquery/2.0.3/jquery.min.js"></script>
<script src="http://yandex.st/bootstrap/3.0.3/js/bootstrap.min.js"></script>

<script>
    $(function() {
        $('table tbody tr').each(function() {
            var $this = $(this);
            $.get(
                "/examples/Metrica/api.php",
                {
                    method: 'getPageViewsCount',
                    counterId: $this.data('counter-id')
                },
                function (data) {
                    var response = JSON.parse(data);
                    $this.find('td.pageviews').html(response.result)
                }
            );
        });
    });
</script>

</body>
</html>
