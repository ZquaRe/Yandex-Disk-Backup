<?php
/**
 * User: tanchik
 * Date: 15.07.14 18:18
 */

use Yandex\Metrica\Management\ManagementClient;

$filters = array();
$errorMessage = false;
$counterId = null;

//Is auth
if (isset($_COOKIE['yaAccessToken']) && isset($_COOKIE['yaClientId'])) {
    $settings = require_once '../../settings.php';

    try {
        $managementClient = new ManagementClient($_COOKIE['yaAccessToken']);

        if (isset($_GET['counter-id']) && $_GET['counter-id']) {
            $counterId = $_GET['counter-id'];

            //GET /management/v1/counter/{counterId}/filters;
            /**
             * @see http://api.yandex.ru/metrika/doc/beta/management/filters/filters.xml
             */
            $filters = $managementClient->filters()->getFilters($counterId);
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
        <li class="active">Фильтры</li>
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
                <h3>Фильтры:</h3>
                <table id="filterTable" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>Тип данных</td>
                        <td>Отношение или действие</td>
                        <td>Значение</td>
                        <td>Тип</td>
                        <td>Статус</td>
                        <td>Первый IP-адрес диапазона</td>
                        <td>Последний IP-адрес диапазона</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($filters instanceof Traversable) {
                        foreach ($filters as $filter) {
                            ?>
                            <tr data-filter-id="<?= $filter->getId() ?>">
                                <td><?= $filter->getId() ?></td>
                                <td><?= $filter->getAttr() ?></td>
                                <td><?= $filter->getType() ?></td>
                                <td><?= $filter->getValue() ?></td>
                                <td><?= $filter->getAction() ?></td>
                                <td><?= $filter->getStatus() ?></td>
                                <td><?= $filter->getStartIp() ?></td>
                                <td><?= $filter->getEndIp() ?></td>
                                <td style="text-align: center">
                                    <button type="button"
                                            class="btn btn-info showFilter">
                                        <span title="Открыть" class="glyphicon glyphicon-eye-open"></span>
                                    </button>
                                    <br/>

                                    <button type="button"
                                            class="btn btn-warning updateFilter">
                                        <span title="Изменить"
                                              class="glyphicon glyphicon-edit"></span>
                                    </button>
                                    <br/>
                                    <button type="button" class="btn btn-danger deleteFilter">
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

                <button id="openAddFilterModal" type="button" class="btn btn-success">
                        <span title="Создать фильтр"
                              class="glyphicon glyphicon-plus"> Создать фильтр</span>
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
<div class="modal fade" id="showFilterModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Информация о фильтре</h4>
            </div>
            <div class="modal-body">
                <p><label>ID:</label> <span id="showFilterId"></span></p>

                <p><label>Тип данных:</label> <span id="showFilterAttr"></span></p>

                <p><label>Отношение или действие:</label> <span id="showFilterType"></span></p>

                <p><label>Значение:</label> <span id="showFilterValue"></span></p>

                <p><label>Тип:</label> <span id="showFilterAction"></span></p>

                <p><label>Статус:</label> <span id="showFilterStatus"></span></p>

                <p><label>Первый IP-адрес диапазона:</label> <span id="showFilterStartIp"></span></p>

                <p><label>Последний IP-адрес диапазона:</label> <span id="showFilterEndIp"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="addFilterModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Создание фильтра</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label for="addFilterAttr" class="col-sm-2 control-label">Тип данных</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="attr" placeholder="Тип данных">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addFilterType" class="col-sm-2 control-label">Отношение или действие</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="type" placeholder="Отношение или действие">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addFilterValue" class="col-sm-2 control-label">Значение</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="value" placeholder="Значение">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addFilterAction" class="col-sm-2 control-label">Тип</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="action" placeholder="Тип">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addFilterStatus" class="col-sm-2 control-label">Статус</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="status" placeholder="Статус">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addFilterStartIp" class="col-sm-2 control-label">Первый IP-адрес диапазона</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="start_ip" placeholder="Первый IP-адрес диапазона">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addFilterEndIp" class="col-sm-2 control-label">Последний IP-адрес диапазона</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="end_ip" placeholder="Последний IP-адрес диапазона">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" id="saveFilter" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteFilterModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Удалить фильтр?</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="deleteFilterId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                <button type="button" id="deleteFilter" class="btn btn-danger">Удалить!</button>
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

    var $filterTable = $("#filterTable");
    var addModal = $('#addFilterModal');

    $filterTable.on('click', '.showFilter', function () {
        var $el = $(this);
        var filterId = $el.parents('tr').data('filter-id');

        console.log(filterId);

        $.get(
            "/examples/Metrica/api.php",
            {
                method: 'getFilter',
                counterId: <?= $counterId ?>,
                filterId: filterId
            },
            function (data) {
                var response = JSON.parse(data);
                if (response.status === 'ok' && response.result !== null) {

                    $('#showFilterId').text(response.result.id);
                    $('#showFilterAttr').text(response.result.attr);
                    $('#showFilterType').text(response.result.type);
                    $('#showFilterValue').text(response.result.value);
                    $('#showFilterAction').text(response.result.action);
                    $('#showFilterStatus').text(response.result.status);
                    $('#showFilterStartIp').text(response.result.start_ip);
                    $('#showFilterEndIp').text(response.result.end_ip);

                    $('#showFilterModal').modal('show');
                } else {
                    displayError(response.message);
                }
            }
        );
    });


    $('#openAddFilterModal').click(function () {
        addModal.find('.modal-title').text('Создание фильтра');
        addModal.find('form').trigger("reset");
        addModal.modal('show');
    });

    $filterTable.on('click', '.updateFilter', function () {
        var $el = $(this);
        var filterId = $el.parents('tr').data('filter-id');

        addModal.find('.modal-title').text('Редактирование счетчика');
        addModal.find('form').trigger("reset");

        $.get(
            "/examples/Metrica/api.php",
            {
                method: 'getFilter',
                counterId: <?= $counterId ?>,
                filterId: filterId
            },
            function (data) {
                var response = JSON.parse(data);
                if (response.status === 'ok' && response.result !== null) {
                    $('input[name="id"]').val(response.result.id);
                    $('input[name="attr"]').val(response.result.attr);
                    $('input[name="type"]').val(response.result.type);
                    $('input[name="value"]').val(response.result.value);
                    $('input[name="action"]').val(response.result.action);
                    $('input[name="status"]').val(response.result.status);
                    $('input[name="start_ip"]').val(response.result.start_ip);
                    $('input[name="end_ip"]').val(response.result.end_ip);

                    $('#addFilterModal').modal('show');
                } else {
                    displayError(response.message);
                }
            }
        );
    });


    $filterTable.on('click', '.deleteFilter', function () {
        var $el = $(this);
        var filterId = $el.parents('tr').data('filter-id');
        $('#deleteFilterId').val(filterId);
        $('#deleteFilterModal').modal('show');
    });

    $('#saveFilter').click(function () {
        var filterId = $('input[name="id"]').val(),
            data = $('#addFilterModal form').serialize();

        if (filterId) {
            $.post(
                "/examples/Metrica/api.php",
                {
                    method: 'updateFilter',
                    counterId: <?= $counterId ?>,
                    filterId: filterId,
                    params: data
                },
                function (data) {

                    $('#addFilterModal').modal('hide');

                    var response = JSON.parse(data);
                    if (response.status === 'ok' && response.result !== null) {

                        var html = '\
                                <tr data-filter-id="' + response.result.id + '">\
                                    <td>' + response.result.id + '</td>\
                                    <td>' + response.result.attr + '</td>\
                                    <td>' + response.result.type + '</td>\
                                    <td>' + response.result.value + '</td>\
                                    <td>' + response.result.action + '</td>\
                                    <td>' + response.result.status + '</td>\
                                    <td>' + response.result.start_ip + '</td>\
                                    <td>' + response.result.end_ip + '</td>\
                                    <td style="text-align: center">\
                                        <button type="button" class="btn btn-info showFilter">\
                                            <span title="Открыть" class="glyphicon glyphicon-eye-open"></span>\
                                        </button>\
                                        <button type="button" class="btn btn-warning updateFilter">\
                                            <span title="Изменить" class="glyphicon glyphicon-edit"></span>\
                                        </button>\
                                        <button type="button" class="btn btn-danger deleteFilter">\
                                                <span title="Удалить" class="glyphicon glyphicon-trash"></span>\
                                        </button>\
                                    </td>\
                                </tr>';

                        $filterTable.find('tbody>tr').each(function () {
                            if ($(this).data('filter-id') == response.result.id) {
                                $(this).replaceWith(html);
                            }
                        });

                    } else {
                        displayError(response.message);
                    }
                }
            );
        } else {
            $.post(
                "/examples/Metrica/api.php",
                {
                    method: 'addFilter',
                    counterId: <?= $counterId ?>,
                    params: $('#addFilterModal form').serialize()
                },
                function (data) {
                    $('#addFilterModal').modal('hide');

                    var response = JSON.parse(data);
                    if (response.status === 'ok' && response.result !== null) {

                        var html = '\
                            <tr data-filter-id="' + response.result.id + '">\
                                <td>' + response.result.id + '</td>\
                                <td>' + response.result.attr + '</td>\
                                <td>' + response.result.type + '</td>\
                                <td>' + response.result.value + '</td>\
                                <td>' + response.result.action + '</td>\
                                <td>' + response.result.status + '</td>\
                                <td>' + response.result.start_ip + '</td>\
                                <td>' + response.result.end_ip + '</td>\
                                <td style="text-align: center">\
                                    <button type="button" class="btn btn-info showFilter">\
                                        <span title="Открыть" class="glyphicon glyphicon-eye-open"></span>\
                                    </button>\
                                    <button type="button" class="btn btn-warning updateFilter">\
                                        <span title="Изменить" class="glyphicon glyphicon-edit"></span>\
                                    </button>\
                                    <button type="button" class="btn btn-danger deleteFilter">\
                                            <span title="Удалить" class="glyphicon glyphicon-trash "></span>\
                                    </button>\
                                </td>\
                            </tr>';

                        $filterTable.find('tbody').append(html);


                    } else {
                        displayError(response.message);
                    }
                }
            );
        }
    });


    $('#deleteFilter').click(function () {

        var counterId = $.trim($('#deleteFilterId').val());
        $.post(
            "/examples/Metrica/api.php",
            {
                method: 'deleteFilter',
                counterId: <?= $counterId ?>,
                filterId: $('#deleteFilterId').val()
            },
            function (data) {

                $('#deleteFilterModal').modal('hide');

                var response = JSON.parse(data);
                if (response.status === 'ok' && response.result !== null) {

                    $filterTable.find('tbody>tr').each(function () {
                        if ($(this).data('filter-id') == response.result.id) {
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
