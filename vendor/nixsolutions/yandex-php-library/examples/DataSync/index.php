<?php
$settings = require_once '../settings.php';
use Yandex\DataSync\DataSyncClient;
use Yandex\Common\Exception\ForbiddenException;

$errorMessage = false;

// Is auth
if (isset($_COOKIE['yaAccessToken']) && isset($_COOKIE['yaClientId'])) {
    $dataSync = new DataSyncClient($_COOKIE['yaAccessToken']);
    $context  = DataSyncClient::CONTEXT_USER;
    //Устанавливаем Контекст базы данных (app или user)
    $dataSync->setContext($context);

    try {

        if (isset($_REQUEST['action'])) {
            if ($_REQUEST['action'] === 'createDb' && isset($_REQUEST['databaseId']) && $_REQUEST['databaseId']) {
                //Создание базы данных
                //@see https://tech.yandex.ru/datasync/http/doc/tasks/add-database-docpage/
                $dataSync->createDatabase($_REQUEST['databaseId']);
            } elseif ($_REQUEST['action'] === 'deleteDb' && isset($_REQUEST['databaseId']) && $_REQUEST['databaseId']) {
                //Удаление базы данных
                //@see https://tech.yandex.ru/datasync/http/doc/tasks/delete-database-docpage/
                $dataSync->deleteDatabase($_REQUEST['databaseId']);
            }
        }

        //Получение ответа со списком баз данных
        //@see https://tech.yandex.ru/datasync/http/doc/tasks/get-databases-docpage/
        $databasesResponse = $dataSync->getDatabases();
        //Баз данных
        $databases = $databasesResponse->getItems()->getAll();
    } catch (ForbiddenException $ex) {
        $errorMessage = $ex->getMessage();
        $errorMessage .= '<p>Возможно, у приложения нет прав на доступ к ресурсу. Попробуйте '
            . '<a href="' . rtrim(str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__), "/") . "/../OAuth/" .
            '">авторизироваться</a> и повторить.</p>';
    } catch (Exception $ex) {
        $errorMessage = $ex->getMessage();
    }
}
?>
<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Yandex PHP Library: DataSync Demo</title>
    <link rel="stylesheet" href="//yandex.st/bootstrap/3.0.0/css/bootstrap.min.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="/examples/Disk/css/style.css">
</head>
<body>
<div class="container">
    <div class="jumbotron">
        <h2><span class="glyphicon glyphicon-shopping-cart"></span> Пример работы с Яндекс DataSync HTTP API</h2>
    </div>
    <ol class="breadcrumb">
        <li><a href="/examples">Examples</a></li>
        <li class="active">DataSync</li>
    </ol>
    <?php
    if (!isset($_COOKIE['yaAccessToken']) || !isset($_COOKIE['yaClientId'])) {
        ?>
        <div class="alert alert-info">
            Для просмотра этой страници вам необходимо авторизироваться.
            <a id="goToAuth"
               href="<?php echo rtrim(str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__), "/") . '/../OAuth/' ?>"
               class="alert-link">Перейти на страницу авторизации</a>.
        </div>
    <?php
    } elseif ($errorMessage) {
        ?>
        <div class="alert alert-danger">
            <?= $errorMessage ?>
        </div>
    <?php
    } elseif (isset($databases)) {
        ?>
        <div>
            <h3>Базы данных:</h3>
            <table id="accountTable" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <td>Идентификатор</td>
                    <td>Название</td>
                    <td>Номер ревизии</td>
                    <td>Количество записей</td>
                    <td>Дата и время модификации</td>
                    <td>Дата и время создания</td>
                    <td>Размер</td>
                    <td>Действия</td>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($databases as $database) {
                    ?>
                    <tr>
                        <td>
                            <a href="database.php?databaseId=<?= $database->getDatabaseId() ?>">
                                <?= $database->getDatabaseId() ?>
                            </a>
                        </td>
                        <td><?= $database->getTitle() ?></td>
                        <td><?= $database->getRevision() ?></td>
                        <td><?= $database->getRecordsCount() ?></td>
                        <td><?= $database->getModified() ?></td>
                        <td><?= $database->getCreated() ?></td>
                        <td><?= $database->getSize() ?></td>
                        <td>
                            <a href="index.php?action=deleteDb&databaseId=<?= $database->getDatabaseId() ?>">
                                <button type="button" class="btn btn-danger">Удалить</button>
                            </a>
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#createDbModal">
                Создать новую БД
            </button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="createDbModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="form-horizontal" action="index.php" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Создать новую БД</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="inputDatabaseId" class="col-sm-4 control-label">Идентификатор БД</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="inputDatabaseId" name="databaseId"
                                           placeholder="Идентификатор БД">
                                    <input type="hidden" name="action" value="createDb">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php
    }
    ?>
    <script src="http://yandex.st/jquery/2.0.3/jquery.min.js"></script>
    <script src="http://yandex.st/jquery/cookie/1.0/jquery.cookie.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script>
        $(function () {
            $('#goToAuth').click(function (e) {
                $.cookie('back', location.href, {expires: 256, path: '/'});
            });
        });
    </script>
</body>
</html>
