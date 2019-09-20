<?php
/**
 * User: naxel
 * Date: 17.02.14 12:41
 */
use Yandex\Metrica\Management\ManagementClient;

$delegates = array();
$errorMessage = false;

//Is auth
if (isset($_COOKIE['yaAccessToken']) && isset($_COOKIE['yaClientId'])) {
    $settings = require_once '../../settings.php';

    try {
        $managementClient = new ManagementClient($_COOKIE['yaAccessToken']);

        //GET /delegates
        /**
         * @see http://api.yandex.ru/metrika/doc/beta/management/delegates/delegates.xml
         */
        $delegates = $managementClient->delegates()->getDelegates();
    } catch (\Exception $ex) {
        $errorMessage = $ex->getMessage();
        if ($errorMessage === 'PlatformNotAllowed') {
            $errorMessage .= '<p>Возможно, у приложения нет прав на доступ к ресурсу. Попробуйте '
                . '<a href="' . rtrim(str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__), "/") . '/../OAuth/' . '">авторизироваться</a> и повторить.</p>';
        }
        echo $errorMessage;
    }
} ?>

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
        <li class="active">Delegates</li>
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
                <h3>Представители:</h3>
                <table id="delegatesTable" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <td>Пользователь</td>
                        <td>Дата создания</td>
                        <td>Комментарий</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($delegates instanceof Traversable) {
                        foreach ($delegates as $delegate) {
                            ?>
                            <tr data-user-login="<?= $delegate->getUserLogin() ?>">
                                <td><?= $delegate->getUserLogin() ?></td>
                                <td><?= $delegate->getCreatedAt() ?></td>
                                <td><?= $delegate->getComment() ?></td>
                                <td style="text-align: center">
                                    <button type="button" class="btn btn-danger deleteDelegate">
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
                <button id="openAddDelegateModal" type="button" class="btn btn-success">
                        <span title="Добавить представителя"
                              class="glyphicon glyphicon-plus"> Добавить представителя</span>
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
<div class="modal fade" id="addDelegateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Добавление представителя</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="addDelegateUserLogin" class="col-sm-2 control-label">Пользователь</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="addDelegateUserLogin" placeholder="Пользователь">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addDelegateCreateAt" class="col-sm-2 control-label">Дата создания</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="addDelegateCreateAt" placeholder="Дата создания">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addDelegateComment" class="col-sm-2 control-label">Комментарий</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="addDelegateComment" placeholder="Комментарий">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" id="createDelegate" class="btn btn-primary">Добавить</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="deleteDelegateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Удалить представителя?</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="deleteDelegateUserLogin">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                <button type="button" id="deleteDelegate" class="btn btn-danger">Удалить!</button>
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

    var $delegatesTable = $("#delegatesTable");

    $('#openAddDelegateModal').click(function () {
        $('#addDelegateModal').modal('show');
    });

    $delegatesTable.on('click', '.deleteDelegate', function () {
        var $el = $(this);
        var userLogin = $el.parents('tr').data('user-login');
        $('#deleteDelegateUserLogin').val(userLogin);
        $('#deleteDelegateModal').modal('show');
    });


    $('#createDelegate').click(function () {
        var userLogin = $.trim($('#addDelegateUserLogin').val());
        var createAt = $.trim($('#addDelegateCreateAt').val());
        var comment = $.trim($('#addDelegateComment').val());

        if (userLogin.length === 0 || createAt.length === 0) {
            alert('Заполните поле пользователь и/или дата создания.');
        }

        $.post(
            "/examples/Metrica/api.php",
            {
                method: 'addDelegate',
                userLogin: userLogin,
                createAt: createAt,
                comment: comment
            },
            function (data) {
                $('#addDelegateModal').modal('hide');

                var response = JSON.parse(data);
                if (response.status === 'ok' && response.result !== null) {

                    var html = '\
                            <tr data-user-login="' + response.result.user_login + '">\
                                <td>' + response.result.user_login + '</td>\
                                <td>' + response.result.create_at + '</td>\
                                <td>' + response.result.comment + '</td>\
                                <td style="text-align: center">\
                                    <button type="button" class="btn btn-danger deleteDelegate">\
                                            <span title="Удалить" class="glyphicon glyphicon-trash"></span>\
                                    </button>\
                                </td>\
                            </tr>';

                    $delegatesTable.find('tbody').append(html);


                } else {
                    displayError(response.message);
                }
            }
        );
    });


    $('#deleteDelegate').click(function () {

        var userLogin = $.trim($('#deleteDelegateUserLogin').val());
        $.post(
            "/examples/Metrica/api.php",
            {
                method: 'deleteDelegate',
                userLogin: userLogin
            },
            function (data) {

                $('#deleteDelegateModal').modal('hide');

                var response = JSON.parse(data);
                if (response.status === 'ok' && response.result !== null) {

                    $delegatesTablefind('tbody>tr').each(function () {
                        if ($(this).data('user-login') == response.result.user_login) {
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
