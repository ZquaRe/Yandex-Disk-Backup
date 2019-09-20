<?php
/**
 * User: Tanya Kalashnik
 * Date: 15.07.14 18:18
 */

use Yandex\Metrica\Management\ManagementClient;

$grants = array();
$errorMessage = false;
$counterId = null;

//Is auth
if (isset($_COOKIE['yaAccessToken']) && isset($_COOKIE['yaClientId'])) {
    $settings = require_once '../../settings.php';


    try {
        $managementClient = new ManagementClient($_COOKIE['yaAccessToken']);

        if (isset($_GET['counter-id']) && $_GET['counter-id']) {
            $counterId = $_GET['counter-id'];
            //GET /management/v1/counter/{counterId}/grants;
    
            /**
             * @see http://api.yandex.ru/metrika/doc/beta/management/grants/grants.xml
             */
            $grants = $managementClient->grants()->getGrants($counterId);
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
        <li class="active">Разрешения</li>
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
                <h3>Разрешения:</h3>
                <table id="grantTable" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <td>Логин пользователя</td>
                        <td>Уровень доступа</td>
                        <td>Дата предоставления доступа</td>
                        <td>Комментарий</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($grants instanceof Traversable) {
                        foreach ($grants as $grant) {
                            ?>
                            <tr data-user-login="<?= $grant->getUserLogin() ?>">
                                <td><?= $grant->getUserLogin() ?></td>
                                <td><?= $grant->getPerm() ?></td>
                                <td><?= $grant->getCreatedAt() ?></td>
                                <td><?= $grant->getComment() ?></td>
                                <td style="text-align: center">

                                    <button type="button"
                                            class="btn btn-info showGrant">
                                        <span title="Открыть" class="glyphicon glyphicon-eye-open"></span>
                                    </button>

                                    <button type="button"
                                            class="btn btn-warning updateGrant">
                                        <span title="Изменить"
                                              class="glyphicon glyphicon-edit"></span>
                                    </button>
                                    <button type="button" class="btn btn-danger deleteGrant">
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
                <button id="openAddGrantModal" type="button" class="btn btn-success">
                        <span title="Создать счетчик"
                              class="glyphicon glyphicon-plus"> Создать разрешение</span>
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
<div class="modal fade" id="showGrantModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Просмотр разрешения</h4>
            </div>
            <div class="modal-body">
                <p><label>Логин пользователя:</label> <span id="showGrantUserLogin"></span></p>

                <p><label>Уровень доступа:</label> <span id="showGrantPerm"></span></p>

                <p><label>Дата предоставления доступа:</label> <span id="showGrantCreateAt"></span></p>

                <p><label>Комментарий:</label> <span id="showGrantComment"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="addGrantModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Создание разрешения</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="addGrantUserLogin" class="col-sm-2 control-label">Логин пользователя</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="addGrantUserLogin" placeholder="Логин пользователя">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addGrantPerm" class="col-sm-2 control-label">Уровень доступа</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="addGrantPerm" placeholder="Уровень доступа">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addGrantCreateAt" class="col-sm-2 control-label">Дата предоставления доступа</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="addGrantCreateAt" placeholder="Дата предоставления доступа">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addGrantComment" class="col-sm-2 control-label">Комментарий</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="addGrantComment" placeholder="Комментарий">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" id="createGrant" class="btn btn-primary">Создать</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="updateGrantModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Редактирование разрешения</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="updateGrantUserLogin" class="col-sm-2 control-label">Логин пользователя</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="updateGrantUserLogin" placeholder="Логин пользователя">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="updateGrantPerm" class="col-sm-2 control-label">Уровень доступа</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="updateGrantPerm" placeholder="Уровень доступа">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="updateGrantCreateAt" class="col-sm-2 control-label">Дата предоставления доступа</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="updateGrantCreateAt" placeholder="Дата предоставления доступа">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="updateGrantComment" class="col-sm-2 control-label">Комментарий</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="updateGrantComment" placeholder="Комментарий">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" id="saveGrant" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="deleteGrantModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Удалить счетчик?</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="deleteGrantUserLogin">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                <button type="button" id="deleteGrant" class="btn btn-danger">Удалить!</button>
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

    var $grantTable = $("#grantTable");

    $grantTable.on('click', '.showGrant', function () {
        var $el = $(this);
        var userLogin = $el.parents('tr').data('user-login');
        $.get(
            "/examples/Metrica/api.php",
            {
                method: 'getGrant',
                userLogin: userLogin,
                counterId: <?= $counterId ?>

            },
            function (data) {
                var response = JSON.parse(data);
                if (response.status === 'ok' && response.result !== null) {

                    $('#showGrantUserLogin').text(response.result.user_login);
                    $('#showGrantPerm').text(response.result.perm);
                    $('#showGrantCreateAt').text(response.result.created_at);
                    $('#showGrantComment').text(response.result.comment);


                    $('#showGrantModal').modal('show');
                } else {
                    displayError(response.message);
                }
            }
        );
    });


    $('#openAddGrantModal').click(function () {
        $('#addGrantModal').modal('show');
    });

    $grantTable.on('click', '.updateGrant', function () {
        var $el = $(this);
        var userLogin = $el.parents('tr').data('user-login');
        $.get(
            "/examples/Metrica/api.php",
            {
                method: 'getGrant',
                userLogin: userLogin,
                counterId: <?= $counterId ?>
            },
            function (data) {
                var response = JSON.parse(data);
                if (response.status === 'ok' && response.result !== null) {
                    $('#updateGrantUserLogin').val(response.result.user_login);
                    $('#updateGrantPerm').val(response.result.perm);
                    $('#updateGrantCreateAt').val(response.result.created_at);
                    $('#updateGrantComment').val(response.result.comment);

                    $('#updateGrantModal').modal('show');
                } else {
                    displayError(response.message);
                }
            }
        );
    });


    $grantTable.on('click', '.deleteGrant', function () {
        var $el = $(this);
        var userLogin = $el.parents('tr').data('user-login');
        $('#deleteGrantUserLogin').val(userLogin);
        $('#deleteGrantModal').modal('show');
    });


    $('#createGrant').click(function () {
        $.post(
            "/examples/Metrica/api.php",
            {
                method: 'addGrant',
                userLogin: $('#addGrantUserLogin').val(),
                counterId: <?= $counterId ?>,
                perm: $('#addGrantPerm').val(),
                createdAt: $('#addGrantCreateAt').val(),
                comment: $('#addGrantComment').val()
            },
            function (data) {
                $('#addGrantModal').modal('hide');

                var response = JSON.parse(data);
                if (response.status === 'ok' && response.result !== null) {

                    var html = '\
                            <tr data-user-login="' + response.result.user_login + '">\
                                <td>' + response.result.user_login + '</td>\
                                <td>' + response.result.perm + '</td>\
                                <td>' + response.result.created_at + '</td>\
                                <td>' + response.result.comment + '</td>\
                                <td style="text-align: center">\
                                    <button type="button" class="btn btn-info showGrant">\
                                        <span title="Открыть" class="glyphicon glyphicon-eye-open"></span>\
                                    </button>\
                                    <button type="button" class="btn btn-warning updateGrant">\
                                        <span title="Изменить" class="glyphicon glyphicon-edit"></span>\
                                    </button>\
                                    <button type="button" class="btn btn-danger deleteGrant">\
                                            <span title="Удалить" class="glyphicon glyphicon-trash "></span>\
                                    </button>\
                                </td>\
                            </tr>';

                    $grantTable.find('tbody').append(html);


                } else {
                    displayError(response.message);
                }
            }
        );
    });


    $('#saveGrant').click(function () {
        $.post(
            "/examples/Metrica/api.php",
            {
                method: 'updateGrant',
                userLogin: $('#updateGrantUserLogin').val(),
                counterId: <?= $counterId ?>,
                perm: $('#updateGrantPerm').val(),
                createdAt: $('#updateGrantCreateAt').val(),
                comment: $('#updateGrantComment').val()
            },
            function (data) {

                $('#updateGrantModal').modal('hide');

                var response = JSON.parse(data);
                if (response.status === 'ok' && response.result !== null) {

                    var html = '\
                            <tr data-counter-id="' + response.result.id + '">\
                                <td>' + response.result.id + '</td>\
                                <td>' + response.result.code_status + '</td>\
                                <td>' + response.result.name + '</td>\
                                <td>' + response.result.site + '</td>\
                                <td>' + response.result.owner_login + '</td>\
                                <td>' + response.result.type + '</td>\
                                <td>' + response.result.permission + '</td>\
                                <td style="text-align: center">\
                                    <button type="button" class="btn btn-info showGrant">\
                                        <span title="Открыть" class="glyphicon glyphicon-eye-open"></span>\
                                    </button>\
                                    <button type="button" class="btn btn-warning updateGrant">\
                                        <span title="Изменить" class="glyphicon glyphicon-edit"></span>\
                                    </button>\
                                    <button type="button" class="btn btn-danger deleteGrant">\
                                            <span title="Удалить" class="glyphicon glyphicon-trash"></span>\
                                    </button>\
                                </td>\
                            </tr>';

                    $grantTable.find('tbody>tr').each(function () {
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


    $('#deleteGrant').click(function () {

        var userLogin = $.trim($('#deleteGrantUserLogin').val());
        $.post(
            "/examples/Metrica/api.php",
            {
                method: 'deleteGrant',
                counterId: <?= $counterId ?>,
                userLogin: userLogin
            },
            function (data) {

                $('#deleteGrantModal').modal('hide');

                var response = JSON.parse(data);
                if (response.status === 'ok' && response.result !== null) {

                    $grantTable.find('tbody>tr').each(function () {
                        if ($(this).data('user-login') == response.result.id) {
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
