<?php
$settings = require_once '../settings.php';
use Yandex\Dictionary\DictionaryClient;
use Yandex\Common\Exception\ForbiddenException;
use Yandex\Dictionary\Exception\DictionaryException;

$errorMessage = false;

// Is auth
if (isset($_COOKIE['yaAccessToken']) && isset($_COOKIE['yaClientId'])) {

    if (!isset($settings["dictionary"]["key"]) || !$settings["dictionary"]["key"]) {
        throw new DictionaryException('Empty dictionary key. Get key from https://tech.yandex.ru/keys/get/?service=dict');
    }

    $dictionaryClient = new DictionaryClient($settings["dictionary"]["key"]);

    if (isset($_POST['word']) && $_POST['word'] && isset($_POST['language']) && $_POST['language']) {
        $translation = explode('-', $_POST['language']);
        if (count($translation) === 2) {
            $from = $translation[0];
            $to   = $translation[1];
            $dictionaryClient
                ->setTranslateFrom($from)
                ->setTranslateTo($to);
            $result = $dictionaryClient->lookup($_POST['word']);
            if ($result) {
                /** @var \Yandex\Dictionary\DictionaryDefinition $dictionaryDefinition */
                $dictionaryDefinition  = $result[0];
                $dictionaryTranslation = $dictionaryDefinition->getTranslations();
                /** @var \Yandex\Dictionary\DictionaryTranslation $dictionaryTranslation */
                $dictionaryTranslation = $dictionaryDefinition->getTranslations()[0];
                $word                  = $dictionaryTranslation->getText();
            }
        }
    }

    try {
        $languages = $dictionaryClient->getLanguages();
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
        <h2><span class="glyphicon glyphicon-shopping-cart"></span> Пример работы с API Словаря</h2>
    </div>
    <ol class="breadcrumb">
        <li><a href="/examples">Examples</a></li>
        <li class="active">Dictionary</li>
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
    } elseif (isset($languages)) {
        ?>
        <div>
            <form class="form-horizontal" action="index.php" method="post">
                <div class="form-group">
                    <label for="inputLanguage" class="col-sm-4 control-label">Язык</label>

                    <div class="col-sm-8">
                        <select class="form-control" name="language" id="inputLanguage">
                            <?php foreach ($languages as $languageNames) { ?>
                                <option value="<?= $languageNames[0] . '-' . $languageNames[1] ?>"
                                    <?= ($_POST['language'] === $languageNames[0] . '-' . $languageNames[1]) ?
                                        'selected' : '' ?>
                                    >
                                    <?= $languageNames[0] . ' - ' . $languageNames[1] ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">

                    <label for="inputWord" class="col-sm-4 control-label">Слово</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputWord" name="word"
                               placeholder="Слово">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Перевод</label>

                    <div class="col-sm-8">
                        <?= (isset($word)) ? $word : '' ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Перевести</button>
            </form>
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
