<?php
/**
 * User: naxel
 * Date: 12.02.14 16:07
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

            /**
             * Один или несколько дополнительных параметров возвращаемого объекта
             */
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
        <h2>
            <a href="/examples/Metrica"><span class="glyphicon glyphicon-tasks"></span></a>
            Пример работы с Яндекс Метрикой
        </h2>
    </div>
    <ol class="breadcrumb">
        <li><a href="/examples">Examples</a></li>
        <li><a href="/examples/Metrica">Metrica</a></li>
        <li class="active">Счетчики</li>
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
                        <td>Статус</td>
                        <td>Название</td>
                        <td>Сайт</td>
                        <td>Тип</td>
                        <td>Владелец</td>
                        <td>Права</td>
                        <td>Действия</td>
                        <td>Дополнения</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($counters instanceof Traversable) {
                        foreach ($counters as $counter) {
                            ?>
                            <tr data-counter-id="<?= $counter->getId() ?>">
                                <td><?= $counter->getId() ?></td>
                                <td><?= $counter->getCodeStatus() ?></td>
                                <td><?= $counter->getName() ?></td>
                                <td><?= $counter->getSite() ?></td>
                                <td><?= $counter->getType() ?></td>
                                <td><?= $counter->getOwnerLogin() ?></td>
                                <td><?= $counter->getPermission() ?></td>
                                <td style="text-align: center">

                                    <button type="button"
                                            class="btn btn-info showCounter">
                                        <span title="Открыть" class="glyphicon glyphicon-eye-open"></span>
                                    </button>

                                    <button type="button"
                                            class="btn btn-warning updateCounter">
                                        <span title="Изменить"
                                              class="glyphicon glyphicon-edit"></span>
                                    </button>
                                    <button type="button" class="btn btn-danger deleteCounter">
                                            <span title="Удалить"
                                                  class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </td>
                                <td>
                                    <a href="/examples/Metrica/Management/filters.php?counter-id=<?= $counter->getId(
                                    ) ?>"
                                       class="btn btn-primary">Фильтры</a><br/>
                                    <a href="/examples/Metrica/Management/grants.php?counter-id=<?= $counter->getId(
                                    ) ?>"
                                       class="btn btn-success">Разрешения</a><br/>
                                    <a href="/examples/Metrica/Management/operations.php?counter-id=
                                       <?= $counter->getId() ?>"
                                       class="btn btn-info">Операции</a><br/>
                                    <a href="/examples/Metrica/Management/goals.php?counter-id=<?= $counter->getId() ?>"
                                       class="btn btn-warning">Цели</a>
                                </td>
                            </tr>

                        <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <button id="openAddCounterModal" type="button" class="btn btn-success">
                        <span title="Создать счетчик"
                              class="glyphicon glyphicon-plus"> Создать счетчик</span>
                </button>
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

<!-- Modal -->
<div class="modal fade" id="showCounterModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Просмотр Счетчика</h4>
            </div>
            <div class="modal-body">
                <p><label>ID:</label> <span id="showCounterId"></span></p>

                <p><label>Статус:</label> <span id="showCounterCodeStatus"></span></p>

                <p><label>Название:</label> <span id="showCounterName"></span></p>

                <p><label>Сайт:</label> <span id="showCounterSite"></span></p>

                <p><label>Тип:</label> <span id="showCounterType"></span></p>

                <p><label>Владелец:</label> <span id="showCounterOwnerLogin"></span></p>

                <p><label>Права:</label> <span id="showCounterPermission"></span></p>

                <div>
                    <label for="showCounterCode">Код счетчика для вставки:</label>

                    <p>
                        <textarea style="width: 100%" name="code" id="showCounterCode" cols="85" rows="10"></textarea>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="addCounterModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Создание счетчика</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="addCounterName" class="col-sm-2 control-label">Название</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="addCounterName" placeholder="Название">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addCounterSite" class="col-sm-2 control-label">Домен</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="addCounterSite" placeholder="Домен">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" id="createCounter" class="btn btn-primary">Создать</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="updateCounterModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Редактирование счетчика</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <input type="hidden" id="updateCounterId">

                    <div class="form-group">
                        <label for="updateCounterName" class="col-sm-2 control-label">Название</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="updateCounterName" placeholder="Название">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="updateCounterSite" class="col-sm-2 control-label">Домен</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="updateCounterSite" placeholder="Домен">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" id="saveCounter" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="deleteCounterModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Удалить счетчик?</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="deleteCounterId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                <button type="button" id="deleteCounter" class="btn btn-danger">Удалить!</button>
            </div>
        </div>
    </div>
</div>

<script src="http://yandex.st/jquery/2.0.3/jquery.min.js"></script>
<script src="http://yandex.st/jquery/cookie/1.0/jquery.cookie.min.js"></script>
<script src="http://yandex.st/bootstrap/3.0.3/js/bootstrap.min.js"></script>

<script>
$(function () {

    $('#goToAuth').click(function (e) {
        $.cookie('back', location.href, { expires: 256, path: '/' });
    });

    var $countersTable = $("#countersTable");

    $countersTable.on('click', '.showCounter', function () {
        var $el = $(this);
        var counterId = $el.parents('tr').data('counter-id');

        $.get(
            "/examples/Metrica/api.php",
            {
                method: 'getCounter',
                counterId: counterId
            },
            function (data) {
                var response = JSON.parse(data);
                if (response.status === 'ok' && response.result !== null) {

                    $('#showCounterId').text(response.result.id);
                    $('#showCounterCodeStatus').text(response.result.code_status);
                    $('#showCounterName').text(response.result.name);
                    $('#showCounterSite').text(response.result.site);
                    $('#showCounterType').text(response.result.type);
                    $('#showCounterOwnerLogin').text(response.result.owner_login);
                    $('#showCounterPermission').text(response.result.permission);
                    $('#showCounterCode').text(response.result.code);

                    $('#showCounterModal').modal('show');
                } else {
                    displayError(response.message);
                }
            }
        );
    });


    $('#openAddCounterModal').click(function () {
        $('form.form-horizontal').get(0).reset();
        $('#addCounterModal').modal('show');
    });

    $countersTable.on('click', '.updateCounter', function () {
        var $el = $(this);
        var counterId = $el.parents('tr').data('counter-id');

        $.get(
            "/examples/Metrica/api.php",
            {
                method: 'getCounter',
                counterId: counterId
            },
            function (data) {
                var response = JSON.parse(data);
                if (response.status === 'ok' && response.result !== null) {
                    $('#updateCounterId').val(response.result.id);
                    $('#updateCounterName').val(response.result.name);
                    $('#updateCounterSite').val(response.result.site);

                    $('#updateCounterModal').modal('show');
                } else {
                    displayError(response.message);
                }
            }
        );
    });


    $countersTable.on('click', '.deleteCounter', function () {
        var $el = $(this);
        var counterId = $el.parents('tr').data('counter-id');
        $('#deleteCounterId').val(counterId);
        $('#deleteCounterModal').modal('show');
    });


    $('#createCounter').click(function () {
        var counterName = $.trim($('#addCounterName').val());
        var counterSite = $.trim($('#addCounterSite').val());

        if (counterName.length === 0 || counterSite.length === 0) {
            alert('Заполните поле названия счетчика и/или домен.');
        }

        $.post(
            "/examples/Metrica/api.php",
            {
                method: 'addCounter',
                counterSite: counterSite,
                counterName: counterName
            },
            function (data) {
                $('#addCounterModal').modal('hide');

                var response = JSON.parse(data);
                if (response.status === 'ok' && response.result !== null) {

                    var html = '\
                            <tr data-counter-id="' + response.result.id + '">\
                                <td>' + response.result.id + '</td>\
                                <td>' + response.result.code_status + '</td>\
                                <td>' + response.result.name + '</td>\
                                <td>' + response.result.site + '</td>\
                                <td>' + response.result.type + '</td>\
                                <td>' + response.result.owner_login + '</td>\
                                <td>' + response.result.permission + '</td>\
                                <td style="text-align: center">\
                                    <button type="button" class="btn btn-info showCounter">\
                                        <span title="Открыть" class="glyphicon glyphicon-eye-open"></span>\
                                    </button>\
                                    <button type="button" class="btn btn-warning updateCounter">\
                                        <span title="Изменить" class="glyphicon glyphicon-edit"></span>\
                                    </button>\
                                    <button type="button" class="btn btn-danger deleteCounter">\
                                            <span title="Удалить" class="glyphicon glyphicon-trash "></span>\
                                    </button>\
                                </td>\
                                <td>\
                                    <a href="/examples/Metrica/Management/filters.php?counter-id=' + response.result.id + '" class="btn btn-primary">Фильтры</a><br />\
                                    <a href="/examples/Metrica/Management/grants.php?counter-id=' + response.result.id + '" class="btn btn-success">Разрешения</a><br />\
                                    <a href="/examples/Metrica/Management/operations.php?counter-id=' + response.result.id + '" class="btn btn-info">Операции</a><br />\
                                    <a href="/examples/Metrica/Management/goals.php?counter-id=' + response.result.id + '" class="btn btn-warning">Цели</a>\
                                </td>\
                            </tr>';

                    $countersTable.find('tbody').append(html);


                } else {
                    displayError(response.message);
                }
            }
        );
    });


    $('#saveCounter').click(function () {
        var counterName = $.trim($('#updateCounterName').val());
        var counterSite = $.trim($('#updateCounterSite').val());
        var counterId = $.trim($('#updateCounterId').val());

        if (counterName.length === 0 || counterSite.length === 0) {
            alert('Заполните поле названия счетчика и/или домен.');
        }

        $.post(
            "/examples/Metrica/api.php",
            {
                method: 'updateCounter',
                counterId: counterId,
                counterSite: counterSite,
                counterName: counterName
            },
            function (data) {

                $('#updateCounterModal').modal('hide');

                var response = JSON.parse(data);
                if (response.status === 'ok' && response.result !== null) {

                    var html = '\
                            <tr data-counter-id="' + response.result.id + '">\
                                <td>' + response.result.id + '</td>\
                                <td>' + response.result.code_status + '</td>\
                                <td>' + response.result.name + '</td>\
                                <td>' + response.result.site + '</td>\
                                <td>' + response.result.type + '</td>\
                                <td>' + response.result.owner_login + '</td>\
                                <td>' + response.result.permission + '</td>\
                                <td style="text-align: center">\
                                    <button type="button" class="btn btn-info showCounter">\
                                        <span title="Открыть" class="glyphicon glyphicon-eye-open"></span>\
                                    </button>\
                                    <button type="button" class="btn btn-warning updateCounter">\
                                        <span title="Изменить" class="glyphicon glyphicon-edit"></span>\
                                    </button>\
                                    <button type="button" class="btn btn-danger deleteCounter">\
                                            <span title="Удалить" class="glyphicon glyphicon-trash"></span>\
                                    </button>\
                                </td>\
                                <td>\
                                    <a href="/examples/Metrica/Management/filters.php?counter-id=' + response.result.id + '" class="btn btn-primary">Фильтры</a><br />\
                                    <a href="/examples/Metrica/Management/grants.php?counter-id=' + response.result.id + '" class="btn btn-success">Разрешения</a><br />\
                                    <a href="/examples/Metrica/Management/operations.php?counter-id=' + response.result.id + '" class="btn btn-info">Операции</a><br />\
                                    <a href="/examples/Metrica/Management/goals.php?counter-id=' + response.result.id + '" class="btn btn-warning">Цели</a>\
                                </td>\
                            </tr>';

                    $("#countersTable").find('tbody>tr').each(function () {
                        if ($(this).data('counter-id') == response.result.id) {
                            $(this).replaceWith(html);
                        }
                    });

                } else {
                    displayError(response.message);
                }
            }
        );
    });


    $('#deleteCounter').click(function () {

        var counterId = $.trim($('#deleteCounterId').val());
        $.post(
            "/examples/Metrica/api.php",
            {
                method: 'deleteCounter',
                counterId: counterId
            },
            function (data) {

                $('#deleteCounterModal').modal('hide');

                var response = JSON.parse(data);
                if (response.status === 'ok' && response.result !== null) {

                    $("#countersTable").find('tbody>tr').each(function () {
                        if ($(this).data('counter-id') == response.result.id) {
                            $(this).replaceWith('');
                        }
                    });

                } else {
                    displayError(response.message);
                }
            }
        );
    });

});


/**
 * @param message string
 */
function displayError(message) {
    $('#errorMessage').text(message);
    $('#errorModal').modal('show');
}

</script>
</body>
</html>
