<?php
/**
 * User: tanchik
 * Date: 15.07.14 18:18
 */

use Yandex\Metrica\Management\ManagementClient;

$operations = array();
$errorMessage = false;
$counterId = null;

//Is auth
if (isset($_COOKIE['yaAccessToken']) && isset($_COOKIE['yaClientId'])) {
    $settings = require_once '../../settings.php';

    try {
        $managementClient = new ManagementClient($_COOKIE['yaAccessToken']);

        if (isset($_GET['counter-id']) && $_GET['counter-id']) {
            $counterId = $_GET['counter-id'];
            //GET /management/v1/counter/{counterId}/operations;
            /**
             * @see http://api.yandex.ru/metrika/doc/beta/management/operations/operations.xml
             */
            $operations = $managementClient->operations()->getOperations($counterId);
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
        <li class="active">Операции</li>
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
                <h3>Операции:</h3>
                <table id="operationsTable" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>Тип</td>
                        <td>Поле для фильтрации</td>
                        <td>Значение для замены</td>
                        <td>Статус</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($operations instanceof Traversable) {
                        foreach ($operations as $operation) {
                            ?>
                            <tr data-operation-id="<?= $operation->getId() ?>">
                                <td><?= $operation->getId() ?></td>
                                <td><?= $operation->getAction() ?></td>
                                <td><?= $operation->getAttr() ?></td>
                                <td><?= $operation->getValue() ?></td>
                                <td><?= $operation->getStatus() ?></td>
                                <td style="text-align: center">

                                    <button type="button"
                                            class="btn btn-info showOperation">
                                        <span title="Открыть" class="glyphicon glyphicon-eye-open"></span>
                                    </button>

                                    <button type="button"
                                            class="btn btn-warning updateOperation">
                                        <span title="Изменить"
                                              class="glyphicon glyphicon-edit"></span>
                                    </button>
                                    <button type="button" class="btn btn-danger deleteOperation">
                                            <span title="Удалить"
                                                  class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </td>
                            </tr>
                        <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <button id="openAddOperationModal" type="button" class="btn btn-success">
                        <span title="Создать счетчик"
                              class="glyphicon glyphicon-plus"> Создать операцию</span>
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
<div class="modal fade" id="showOperationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Информация об операции</h4>
            </div>
            <div class="modal-body">
                <p><label>ID:</label> <span id="showOperationId"></span></p>

                <p><label>Тип:</label> <span id="showOperationAction"></span></p>

                <p><label>Поле для фильтрации:</label> <span id="showOperationAttr"></span></p>

                <p><label>Значение для замены:</label> <span id="showOperationValue"></span></p>

                <p><label>Статус:</label> <span id="showOperationStatus"></span></p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="addOperationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Создание операции</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="addOperationAction" class="col-sm-2 control-label">Тип</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="addOperationAction" placeholder="Тип">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addOperationAttr" class="col-sm-2 control-label">Поле для фильтрации</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="addOperationAttr" placeholder="Поле для фильтрации">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addOperationValue" class="col-sm-2 control-label">Значение для замены</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="addOperationValue" placeholder="Значение для замены">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addOperationStatus" class="col-sm-2 control-label">Статус</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="addOperationStatus" placeholder="Статус">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" id="createOperation" class="btn btn-primary">Создать</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="updateOperationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Изменение операции</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <input type="hidden" id="updateOperationId">

                    <div class="form-group">
                        <label for="updateOperationAction" class="col-sm-2 control-label">Тип</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="updateOperationAction" placeholder="Тип">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="updateOperationAttr" class="col-sm-2 control-label">Поле для фильтрации</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="updateOperationAttr" placeholder="Поле для фильтрации">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="updateOperationValue" class="col-sm-2 control-label">Значение для замены</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="updateOperationValue" placeholder="Значение для замены">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="updateOperationStatus" class="col-sm-2 control-label">Статус</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="updateOperationStatus" placeholder="Статус">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" id="saveOperation" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="deleteOperationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Удалить операцию?</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="deleteOperationId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                <button type="button" id="deleteOperation" class="btn btn-danger">Удалить!</button>
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

    var $operationsTable = $("#operationsTable");

    $operationsTable.on('click', '.showOperation', function () {
        var $el = $(this);
        var operationId = $el.parents('tr').data('operation-id');

        $.get(
            "/examples/Metrica/api.php",
            {
                method: 'getOperation',
                counterId: <?= $counterId ?>,
                operationId: operationId
            },
            function (data) {
                var response = JSON.parse(data);
                if (response.status === 'ok' && response.result !== null) {

                    $('#showOperationId').text(response.result.id);
                    $('#showOperationAction').text(response.result.action);
                    $('#showOperationAttr').text(response.result.attr);
                    $('#showOperationValue').text(response.result.value);
                    $('#showOperationStatus').text(response.result.status);

                    $('#showOperationModal').modal('show');
                } else {
                    displayError(response.message);
                }
            }
        );
    });


    $('#openAddOperationModal').click(function () {
        $('#addOperationModal').modal('show');
    });

    $operationsTable.on('click', '.updateOperation', function () {
        var $el = $(this);
        var operationId = $el.parents('tr').data('operation-id');

        $.get(
            "/examples/Metrica/api.php",
            {
                method: 'getOperation',
                counterId: <?= $counterId ?>,
                operationId: operationId,
                action: $('#updateOperationAction').val(),
                attr: $('#updateOperationAttr').val(),
                value: $('#updateOperationValue').val(),
                status: $('#updateOperationStatus').val()
            },
            function (data) {
                var response = JSON.parse(data);
                if (response.status === 'ok' && response.result !== null) {
                    $('#updateOperationId').val(response.result.id);
                    $('#updateOperationAction').val(response.result.action);
                    $('#updateOperationAttr').val(response.result.attr);
                    $('#updateOperationValue').val(response.result.value);
                    $('#updateOperationStatus').val(response.result.status);

                    $('#updateOperationModal').modal('show');
                } else {
                    displayError(response.message);
                }
            }
        );
    });


    $operationsTable.on('click', '.deleteOperation', function () {
        var operationId = $el.parents('tr').data('operation-id');
        $('#deleteOperationId').val(operationId);
        $('#deleteOperationModal').modal('show');
    });


    $('#createOperation').click(function () {
        $.post(
            "/examples/Metrica/api.php",
            {
                method: 'addOperation',
                counterId: <?= $counterId ?>,
                action: $('#addOperationAction').val(),
                attr: $('#addOperationAttr').val(),
                value: $('#addOperationValue').val(),
                status: $('#addOperationStatus').val()
            },
            function (data) {
                $('#addOperationModal').modal('hide');

                var response = JSON.parse(data);
                if (response.status === 'ok' && response.result !== null) {

                    var html = '\
                            <tr data-operation-id="' + response.result.id + '">\
                                <td>' + response.result.id + '</td>\
                                <td>' + response.result.action + '</td>\
                                <td>' + response.result.attr + '</td>\
                                <td>' + response.result.value + '</td>\
                                <td>' + response.result.status + '</td>\
                                <td style="text-align: center">\
                                    <button type="button" class="btn btn-info showOperation">\
                                        <span title="Открыть" class="glyphicon glyphicon-eye-open"></span>\
                                    </button>\
                                    <button type="button" class="btn btn-warning updateOperation">\
                                        <span title="Изменить" class="glyphicon glyphicon-edit"></span>\
                                    </button>\
                                    <button type="button" class="btn btn-danger deleteOperation">\
                                            <span title="Удалить" class="glyphicon glyphicon-trash "></span>\
                                    </button>\
                                </td>\
                            </tr>';

                    $operationsTable.find('tbody').append(html);


                } else {
                    displayError(response.message);
                }
            }
        );
    });


    $('#saveOperation').click(function () {
        $.post(
            "/examples/Metrica/api.php",
            {
                method: 'updateOperation',
                counterId: <?= $counterId ?>,
                operationId: operationId
            },
            function (data) {

                $('#updateOperationModal').modal('hide');

                var response = JSON.parse(data);
                if (response.status === 'ok' && response.result !== null) {

                    var html = '\
                            <tr data-operation-id="' + response.result.id + '">\
                                <td>' + response.result.id + '</td>\
                                <td>' + response.result.action + '</td>\
                                <td>' + response.result.attr + '</td>\
                                <td>' + response.result.value + '</td>\
                                <td>' + response.result.status + '</td>\
                                <td style="text-align: center">\
                                    <button type="button" class="btn btn-info showOperation">\
                                        <span title="Открыть" class="glyphicon glyphicon-eye-open"></span>\
                                    </button>\
                                    <button type="button" class="btn btn-warning updateOperation">\
                                        <span title="Изменить" class="glyphicon glyphicon-edit"></span>\
                                    </button>\
                                    <button type="button" class="btn btn-danger deleteOperation">\
                                            <span title="Удалить" class="glyphicon glyphicon-trash"></span>\
                                    </button>\
                                </td>\
                            </tr>';

                    $operationsTable.find('tbody>tr').each(function () {
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


    $('#deleteOperation').click(function () {

        var operationId = $.trim($('#deleteOperationId').val());
        $.post(
            "/examples/Metrica/api.php",
            {
                method: 'deleteOperation',
                counterId: <?= $counterId ?>,
                operationId: operationId
            },
            function (data) {

                $('#deleteOperationModal').modal('hide');

                var response = JSON.parse(data);
                if (response.status === 'ok' && response.result !== null) {

                    $operationsTable.find('tbody>tr').each(function () {
                        if ($(this).data('operation-id') == response.result.id) {
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
