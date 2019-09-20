<?php
/**
 * Example of usage Yandex\Speller package
 *
 * @author   Dmitriy Savchenko
 * @created  06.11.15 16:33
 */
$settings = require_once '../settings.php';

use Yandex\Speller\SpellerClient;

?>
<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Yandex PHP Library: Speller Demo</title>
    <link rel="stylesheet" href="//yandex.st/bootstrap/3.0.0/css/bootstrap.min.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="/examples/Disk/css/style.css">
</head>
<body>
<div class="container">
    <div class="jumbotron">
        <h2><span class="glyphicon glyphicon-search"></span> Пример работы с Яндекс Спеллер</h2>
    </div>
    <div class="col-md-8">
        <ol class="breadcrumb">
            <li><a href="/examples">Examples</a></li>
            <li><a href="/examples/Speller">Speller</a></li>
            <li class="active">checkTexts</li>
        </ol>
        <h3>checkTexts</h3>
        <form class="form-horizontal" method="post">
            <div class="form-group">
                <label for="text0" class="col-sm-2 control-label">text</label>
                <div class="col-sm-10">
                    <textarea id="text0"
                              name="text0"
                              class="form-control"
                              rows="3"
                              placeholder="Text to check"
                              required><?= isset($_POST['text0']) ? $_POST['text0'] : ''; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="text1" class="col-sm-2 control-label">text</label>
                <div class="col-sm-10">
                    <textarea id="text1"
                              name="text1"
                              class="form-control"
                              rows="3"
                              placeholder="Text to check"
                              required><?= isset($_POST['text1']) ? $_POST['text1'] : ''; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="lang" class="col-sm-2 control-label">lang</label>
                <div class="col-sm-10">
                    <input type="text"
                           class="form-control"
                           id="lang"
                           name="lang"
                           placeholder="ru,en"
                           value="<?= isset($_POST['lang']) ? $_POST['lang'] : SpellerClient::LANGUAGE_DEFAULT; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="options" class="col-sm-2 control-label">options</label>
                <div class="col-sm-10">
                    <input type="number"
                           class="form-control"
                           id="options"
                           name="options"
                           placeholder="0"
                           value="<?= isset($_POST['options']) ? $_POST['options'] : SpellerClient::OPTION_DEFAULT; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="format" class="col-sm-2 control-label">format</label>
                <div class="col-sm-10">
                    <select class="form-control" id="format" name="format">
                        <option <?php if (isset($_POST['format']) && $_POST['format'] === SpellerClient::CHECK_TEXT_FORMAT_PLAIN) { ?> selected <?php } ?> ><?=SpellerClient::CHECK_TEXT_FORMAT_PLAIN?></option>
                        <option <?php if (isset($_POST['format']) && $_POST['format'] === SpellerClient::CHECK_TEXT_FORMAT_HTML) { ?> selected <?php } ?>><?=SpellerClient::CHECK_TEXT_FORMAT_HTML?></option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="callback" class="col-sm-2 control-label">callback</label>
                <div class="col-sm-10">
                    <input type="text"
                           class="form-control"
                           id="callback"
                           name="callback"
                           placeholder="your callback function name here"
                           value="<?= isset($_POST['callback'])?$_POST['callback']:''; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="ie" class="col-sm-2 control-label">ie</label>
                <div class="col-sm-10">
                    <select class="form-control" id="ie" name="ie">
                        <option <?php if (isset($_POST['ie']) && $_POST['ie'] === 'utf-8') { ?> selected <?php } ?> >utf-8</option>
                        <option <?php if (isset($_POST['ie']) && $_POST['ie'] === '1251') { ?> selected <?php } ?>>1251</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="submit" class="btn btn-default">Invoke</button>
                </div>
            </div>
        </form>
        <h4>Result</h4>
        <?php
        $result = [];

        if (isset($_POST['submit'])) {
            $spellerClient = new SpellerClient();

            $result = $spellerClient->checkTexts(
                [
                    $_POST['text0'],
                    $_POST['text1'],
                ],
                [
                    'lang' => $_POST['lang'],
                    'options' => $_POST['options'],
                    'format' => $_POST['format'],
                    'callback' => $_POST['callback'],
                    'ie' => $_POST['ie'],
                ]
            );
        }
        $resultString = json_encode($result, JSON_PRETTY_PRINT);
        ?>
        <pre><?=$resultString?></pre>
    </div>
</div>
</body>
</html>
