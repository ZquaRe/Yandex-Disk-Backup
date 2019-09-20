<?php
/**
 * User: Tanya Kalashnik
 * Date: 15.07.14 18:18
 */

use Yandex\Metrica\Management\ManagementClient;


$accounts = array();
$errorMessage = false;

//Is auth
if (isset($_COOKIE['yaAccessToken']) && isset($_COOKIE['yaClientId'])) {
    $settings = require_once '../../settings.php';


    try {
        $managementClient = new ManagementClient($_COOKIE['yaAccessToken']);

        /**
         * @see http://api.yandex.ru/metrika/doc/beta/management/accounts/accounts.xml
         */
        $accounts = $managementClient->accounts()->getAccounts();
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
        <li class="active">Accounts</li>
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
                <h3>Аккаунты:</h3>
                <table id="accountTable" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <td>Пользователь</td>
                        <td>Дата создания</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($accounts instanceof Traversable) {
                        foreach ($accounts as $account) {
                            ?>
                            <tr data-user-login="<?= $account->getUserLogin() ?>">
                                <td><?= $account->getUserLogin() ?></td>
                                <td><?= $account->getCreatedAt() ?></td>
                                <td style="text-align: center">
                                    <button type="button" class="btn btn-danger deleteAccount">
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
<div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Удалить аккаунт?</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="deleteUserLogin">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                <button type="button" id="deleteAccount" class="btn btn-danger">Удалить!</button>
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

    var $accountTable = $("#accountTable");

    $accountTable.on('click', '.deleteAccount', function () {
        var $el = $(this);
        var userLogin = $el.parents('tr').data('user-login');
        $('#deleteCounterId').val(userLogin);
        $('#deleteAccountModal').modal('show');
    });
    

    $('#deleteAccount').click(function () {

        var userLogin = $.trim($('#deleteCounterId').val());
        $.post(
            "/examples/Metrica/api.php",
            {
                method: 'deleteAccount',
                userLogin: userLogin
            },
            function (data) {

                $('#deleteAccountModal').modal('hide');

                var response = JSON.parse(data);
                if (response.status === 'ok' && response.result !== null) {

                    $("#accountTable").find('tbody>tr').each(function () {
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
