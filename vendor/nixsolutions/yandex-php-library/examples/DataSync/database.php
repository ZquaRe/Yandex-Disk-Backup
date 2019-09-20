<?php
if (!isset($_REQUEST['databaseId']) || !$_REQUEST['databaseId']) {
    header('Location: index.php');
}
$settings = require_once '../settings.php';
use Yandex\DataSync\DataSyncClient;
use Yandex\Common\Exception\ForbiddenException;
use \Yandex\DataSync\Models\Database\Delta\RecordFieldValue;
use \Yandex\DataSync\Models\Database\Delta\RecordField;
use \Yandex\DataSync\Models\Database\Delta\Record;
use \Yandex\DataSync\Models\Database\Delta;

$errorMessage = false;

// Is auth
if (isset($_COOKIE['yaAccessToken']) && isset($_COOKIE['yaClientId'])) {
    $dataSync   = new DataSyncClient($_COOKIE['yaAccessToken']);
    $context    = Yandex\DataSync\DataSyncClient::CONTEXT_USER;
    $databaseId = $_REQUEST['databaseId'];
    //Устанавливаем Контекст базы данных (app или user)
    $dataSync->setContext($context);
    //Устанавливаем Идентификатор базы данных (можно указать позже, непосредственно в запросах)
    $dataSync->setDatabaseId($databaseId);

    try {
        //Получение информации о базе данных
        //@see https://tech.yandex.ru/datasync/http/doc/tasks/get-database-docpage/
        $database = $dataSync->getDatabase($databaseId);

        if (isset($_REQUEST['action'])) {
            if ($_REQUEST['action'] === 'editTitle' && isset($_REQUEST['title']) && $_REQUEST['title']) {
                //Изменение заголовка базы данных
                //@see https://tech.yandex.ru/datasync/http/doc/tasks/edit-title-docpage/
                $database = $dataSync->updateDatabaseTitle($_REQUEST['title'], $databaseId);
            } elseif ($_REQUEST['action'] === 'createField'
                && isset($_REQUEST['collectionId']) && $_REQUEST['collectionId']
                && isset($_REQUEST['recordId']) && $_REQUEST['recordId']
                && isset($_REQUEST['recordChangeType']) && $_REQUEST['recordChangeType']
            ) {
                if ($_REQUEST['recordChangeType'] === Record::CHANGE_TYPE_INSERT
                    || $_REQUEST['recordChangeType'] === Record::CHANGE_TYPE_UPDATE
                    || $_REQUEST['recordChangeType'] === Record::CHANGE_TYPE_SET
                    || $_REQUEST['recordChangeType'] === Record::CHANGE_TYPE_DELETE

                ) {
                    $delta = new Delta();
                    //Поясняющий комментарий к изменению.
                    $delta->setDeltaId('insert record ' . $_REQUEST['recordId']);
                    //Запись
                    $record = new Record();
                    //Тип изменения, применяемого к записи.
                    //@see https://tech.yandex.ru/datasync/http/doc/tasks/create-changes-docpage/#changes-types
                    $record->setChangeType($_REQUEST['recordChangeType'])
                        //Идентификатор коллекции, которой принадлежит запись. Уникальный для БД
                        ->setCollectionId($_REQUEST['collectionId'])
                        //Идентификатор записи. Уникальный для Коллекции
                        ->setRecordId($_REQUEST['recordId']);

                    if (isset($_REQUEST['fieldChangeType']) && $_REQUEST['fieldChangeType']
                        && isset($_REQUEST['fieldId']) && $_REQUEST['fieldId']
                    ) {
                        //Поле
                        $field = new RecordField();
                        //Тип изменения, применяемого к полю записи
                        //@see https://tech.yandex.ru/datasync/http/doc/tasks/create-changes-docpage/#changes-types
                        $field->setChangeType($_REQUEST['fieldChangeType']);
                        //Идентификатор поля.
                        $field->setFieldId($_REQUEST['fieldId']);
                        if (isset($_REQUEST['value']) && $_REQUEST['value']) {

                            //Указание значение и его типа
                            //Если Тип значения не указан, то он определиться автоматически
                            //@see https://tech.yandex.ru/datasync/http/doc/tasks/create-changes-docpage/#data-types
                            $recordFieldValue = new RecordFieldValue();
                            $recordFieldValue->setValue($_REQUEST['value']);
                            //установка Значения
                            $field->setValue($recordFieldValue);
                        }
                        //Изменения отдельных полей записи.
                        $record->setChanges([$field]);
                    }
                    //Изменения отдельных записей базы данных.
                    $delta->setChanges([$record]);
                    //@see https://tech.yandex.ru/datasync/http/doc/tasks/create-changes-docpage/
                    $dataSync->saveDelta($delta->toArray(), $database->getRevision());
                    //Получение "свежей" информации о БД
                    $database = $dataSync->getDatabase($databaseId);
                }
            }
        }

        //Получение снапшота базы данных
        //@see https://tech.yandex.ru/datasync/http/doc/tasks/get-snapshot-docpage/
        $snapshotResponse = $dataSync->getDatabaseSnapshot($database->getDatabaseId());
        $collections      = [];
        /** @var Record $record */
        foreach ($snapshotResponse->getRecords()->getItems() as $record) {
            //$record - запись в Коллекции
            $collections[$record->getCollectionId()][$record->getRecordId()] = [];
            foreach ($record->getFields()->getAll() as $field) {
                //$field - поле в Записи
                $collections[$record->getCollectionId()][$record->getRecordId()][$field->getFieldId()] =
                    $field->getValue()->getValue();
            }
        }
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
    <li><a href="/examples/DataSync">DataSync</a></li>
    <li class="active"><?= $database->getDatabaseId() ?></li>
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
} elseif (isset($database)) {
    ?>
    <div>
        <form class="form-horizontal" action="database.php?databaseId=<?= $database->getDatabaseId() ?>" method="post">
            <div class="form-group">
                <label class="col-sm-2 control-label">Идентификатор</label>

                <div class="col-sm-10">
                    <?= $database->getDatabaseId() ?>
                </div>
            </div>
            <div class="form-group">
                <label for="databaseTitle" class="col-sm-2 control-label">Название</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" id="databaseTitle"
                           name="title"
                           value="<?= $database->getTitle() ?>"
                           placeholder="Название">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Номер ревизии</label>

                <div class="col-sm-10">
                    <?= $database->getRevision() ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Количество записей</label>

                <div class="col-sm-10">
                    <?= $database->getRecordsCount() ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Дата и время модификации</label>

                <div class="col-sm-10">
                    <?= $database->getModified() ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Дата и время создания</label>

                <div class="col-sm-10">
                    <?= $database->getCreated() ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Размер</label>

                <div class="col-sm-10">
                    <?= $database->getSize() ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="hidden" name="action" value="editTitle">
                    <button type="submit" class="btn btn-default">Сохранить</button>
                </div>
            </div>
        </form>

        <?php foreach ($collections as $collectionName => $records) { ?>
            <div class="col-sm-2"><h3><?php echo $collectionName;//Идентификатор Коллекции ?></h3></div>
            <div class="col-sm-10">
                <?php foreach ($records as $recordName => $fields) { ?>
                    <h4><?php echo $recordName;//Идентификатор Записи ?></h4>
                    <table id="accountTable" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <td>Поле</td>
                            <td>Значение</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($fields as $fieldName => $value) { ?>
                            <tr>
                                <td><?php echo $fieldName;//Идентификатор Поля ?></td>
                                <td><?php echo $value;//Значение Поля ?></td>
                            </tr>

                        <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        <?php } ?>

        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#createFieldModal">
            Создать новую запись в БД
        </button>

        <!-- Modal -->
        <div class="modal fade" id="createFieldModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="form-horizontal" action="database.php?databaseId=<?= $database->getDatabaseId() ?>"
                          method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Создать новую запись в БД</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="inputCollectionId" class="col-sm-4 control-label">Идентификатор
                                    коллекции</label>

                                <div class="col-sm-8">
                                    <input type="text" name="collectionId" list="collections"
                                           class="form-control"
                                           id="inputCollectionId"
                                           placeholder="Идентификатор коллекции"/>
                                    <datalist id="collections"></datalist>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputRecordId" class="col-sm-4 control-label">Идентификатор записи</label>

                                <div class="col-sm-8">
                                    <input type="text" name="recordId" list="records"
                                           class="form-control"
                                           id="inputRecordId"
                                           placeholder="Идентификатор записи"/>
                                    <datalist id="records"></datalist>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputRecordChangeType" class="col-sm-4 control-label">Тип изменения
                                    записи</label>

                                <div class="col-sm-8">
                                    <select class="form-control" name="recordChangeType" id="inputRecordChangeType">
                                        <option value="insert">insert - Добавление новой записи.</option>
                                        <option value="update">update - Частичное изменение записи (изменяются только
                                            указанные поля, все существующие поля записи сохраняются).
                                        </option>
                                        <option value="set">set - Полное изменение записи (все существующие поля
                                            удаляются).
                                        </option>
                                        <option value="delete">delete - Удаление записи.</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputFieldChangeType" class="col-sm-4 control-label">Тип изменения
                                    поля</label>

                                <div class="col-sm-8">
                                    <select class="form-control" name="fieldChangeType" id="inputFieldChangeType">
                                        <option value="set">set - Добавление нового поля или изменение значения уже
                                            существующего.
                                        </option>
                                        <option value="delete">delete - Удаление поля.</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputFieldId" class="col-sm-4 control-label">Идентификатор поля</label>

                                <div class="col-sm-8">
                                    <input type="text" name="fieldId"
                                           class="form-control"
                                           id="inputFieldId"
                                           placeholder="Идентификатор поля"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="value" class="col-sm-4 control-label">Данные, которые необходимо
                                    синхронизировать</label>

                                <div class="col-sm-8">
                                    <input type="text" name="value"
                                           class="form-control"
                                           id="value"
                                           placeholder="Данные, которые необходимо синхронизировать"/>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="action" value="createField">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
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
    var collections = [];
    $(function () {
        $('#goToAuth').click(function (e) {
            $.cookie('back', location.href, {expires: 256, path: '/'});
        });
        collections = <?=($collections)? json_encode($collections): '[]'?>;

        var $records = $('#records');
        var $collections = $('#collections');
        //Populate datalist from collections
        var collectionsHtml = '';
        for (var collectionName in  collections) {
            collectionsHtml += '<option value="' + collectionName + '">' + collectionName + '</option>';
        }
        $collections.html(collectionsHtml);

        $('#inputCollectionId').change(function () {
            var collectionId = $(this).val();
            //Remove old
            $records.find('option').remove();
            //Populate from collection
            if (collectionId && collections.hasOwnProperty(collectionId)) {
                var recordsHtml = '';
                for (var recordName in  collections[collectionId]) {
                    recordsHtml += '<option value="' + recordName + '">' + recordName + '</option>';
                }
                $records.html(recordsHtml);
            }
        });
    });
</script>
</body>
</html>
