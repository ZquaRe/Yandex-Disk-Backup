<?php
$settings = require_once '../settings.php';
session_start();

//Set manual token to cookies
if (isset($_POST['token'])) {
    setcookie("yaAccessToken", $_POST['token'], null, '/');
}

if (isset($_REQUEST['back'])) {
    $_SESSION['back'] = $_REQUEST['back'];
}


use Yandex\OAuth\OAuthClient;

// Client secret is not required in this case
$client = new OAuthClient($settings['global']['clientId']);
$state = 'yandex-php-library';
if (isset($_REQUEST['type'])) {

    switch ($_REQUEST['type']) {
        case 'code':
            $client->authRedirect(true, OAuthClient::CODE_AUTH_TYPE, $state);
            break;
        case 'token':
            $client->authRedirect(true, OAuthClient::TOKEN_AUTH_TYPE, $state);
            break;
        default:
            // do nothing
            break;
    }
}

?>
<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Yandex PHP Library: OAuth Demo</title>

    <link rel="stylesheet" href="//yandex.st/bootstrap/3.0.0/css/bootstrap.min.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="/examples/Disk/css/style.css">
    <style>
        .btn {
            padding: 6px 12px;
        }
    </style>
</head>
<body>


<div class="container">
    <div>
        <ol class="breadcrumb">
            <li><a href="/examples">Examples</a></li>
            <li class="active">OAuth</li>
        </ol>
        <h3>Регистрация и настройка приложения</h3>
        <ol>
            <li>Создаем новое приложение на <a href="https://oauth.yandex.ru/client/new">этой</a> странице</li>
            <li>Указываем права на доступ к API, к которым хотите получить доступ.
                К примеру, если хотим получить доступ к Яндекс.Диску, то обязательно поставьте
                галочку напротив "Доступ к Яндекс.Диску для приложений".
            </li>
            <li>
                Указываем Callback URI. К примеру, для этого сайта он должен быть
                таким: <a
                    href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/examples/OAuth/callback.php">http://<?php echo $_SERVER['HTTP_HOST'] ?>
                    /examples/OAuth/callback.php</a>
            </li>
            <li>Нажимаем "Создать" (Подробней о регистрации приложения вы можете прочитать на
                <a href="http://api.yandex.ru/oauth/doc/dg/tasks/register-client.xml">этой</a> странице).
            </li>
            <li>После создания приложения, заходим в его настройки и получаете "Id приложения" и "Пароль приложения",
                которые необходимы для авторизации.
            </li>
            <li>Далее заходим в <a href="../settings.ini">settings.ini</a> и сохраняете там полученные идентификатор
                приложения и его пароль.
            </li>
        </ol>
        <h3>Автоматическая авторизация</h3>

        <p>
            Для автоматической авторизации необходимо в <a href="../settings.ini">settings.ini</a>
            указать идентификатор приложения и секретный ключ.
        </p>
        <ul>
            <li>
                <?php if (
                    isset($settings['global']['clientId']) && $settings['global']['clientId'] &&
                    isset($settings['global']['clientSecret']) && $settings['global']['clientSecret']
                ) {
                    ?>
                    <a href="?type=code">Авторизоваться через сервер.</a>
                    <span style="color: #3276B1;" class="glyphicon glyphicon-ok-circle"></span>
                    Используется промежуточный код и секретный ключ, чтобы получить
                    <a href="http://api.yandex.ru/oauth/doc/dg/reference/obtain-access-token.xml">Токен</a> доступа.

                <?php
                } else {
                    ?>
                    <a href="#">Авторизоваться через сервер.</a>
                    <span style="color: #FF0000;" class="glyphicon glyphicon-remove-circle"></span>
                    Необходимо в <a href="../settings.ini">settings.ini</a> указать идентификатор
                    <a href="https://oauth.yandex.ru/client/my">приложения</a> и секретный ключ.
                <?php
                }
                ?>
            </li>
            <li>
                <?php if (isset($settings['global']['clientId']) && $settings['global']['clientId']) {
                    ?>
                    <a href="?type=token">Авторизоваться через браузер.</a>
                    <span style="color: #3276B1;" class="glyphicon glyphicon-ok-circle"></span>
                <?php
                } else {
                    ?>
                    <a href="#">Авторизоваться через браузер.</a>
                    <span style="color: #FF0000;" class="glyphicon glyphicon-remove-circle"></span>
                    Необходим указать идентификатор <a href="https://oauth.yandex.ru/client/my">приложения</a>.
                <?php
                }
                ?>
            </li>
        </ul>

        <h3>Получение отладочного <a
                href="http://api.yandex.ru/oauth/doc/dg/reference/obtain-access-token.xml">токена</a> вручную:</h3>

        <p>Данный метод авторизации подходит, если вы используете стороннее приложение.</p>
        <ol>
            <li>
                Авторизуйтесь на Яндексе с учетной записью пользователя,
                от имени которого будет работать приложение
            </li>
            <li>Скопируйте идентификатор приложения в поле ниже
                <form id="formCreateToke" target="_blank" method="get" action="https://oauth.yandex.ru/authorize">
                    <input name="response_type" type="hidden" value="token"/>

                    <div class="input-group">
                        <input name="client_id" placeholder="Идентификатор приложения" type="text"
                               class="form-control">
                      <span class="input-group-btn">
                          <input class="btn btn-primary" type="submit" value="Сгенерировать токен"/>
                      </span>
                    </div>
                </form>
            </li>

            <li>Нажмите "Сгенерировать токен"</li>
            <li>Вас перенаправит на страницу указанную в Callback URI в настройках приложения если она указана,
                если токая страница не указана, то на отладочную страницу - она полностью белая
            </li>
            <li>Скопируйте из адресной строки значение параметра access_token</li>
            <li>
                Если вы хотите использовать полученный токен в примерах,
                пройдите по шагам описанных в пункте "Установка отладочного токена вручную"
            </li>

        </ol>

        <h3>Установка отладочного токена вручную:</h3>

        <p>Может понадобиться, если вы получили токен вручную.</p>
        <ol>
            <li>Вставьте сгенерированный ранее токен в полее ввода ниже

                <form method="post">
                    <div class="input-group">
                        <input name="token" placeholder="Токен" type="text" class="form-control">
                          <span class="input-group-btn">
                              <input class="btn btn-primary" type="submit" value="Запомнить токен"/>
                          </span>
                    </div>
                </form>
            </li>
            <li>Нажмите "Запомнить токен"</li>
            <?php
            if (isset($_COOKIE['back']) && $_COOKIE['back']) {
                echo '<li>Вернуться на <a href="' . htmlentities($_COOKIE['back']) . '">'
                    . htmlentities($_COOKIE['back']) . '</a></li>';
            }
            ?>
        </ol>
    </div>
</div>

<script src="http://yandex.st/jquery/2.0.3/jquery.min.js"></script>
<script src="http://yandex.st/jquery/cookie/1.0/jquery.cookie.min.js"></script>
<script>
    $(function () {
        $('#formCreateToke').submit(function (e) {
            $.cookie('yaClientId', $('#client_id').val(), { expires: 256, path: '/' });
        });
    });
</script>
</body>
</html>
