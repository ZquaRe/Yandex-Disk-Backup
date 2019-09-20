<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Yandex Disk Test Page</title>
    <link rel="stylesheet" href="//yandex.st/bootstrap/3.0.0/css/bootstrap.min.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <?php
    if (isset($_COOKIE['yaAccessToken']) && isset($_COOKIE['yaClientId'])) :
    ?>
        <script src="js/require.js"></script>
        <script src="js/index.js"></script>
    <?php
    endif;
    ?>

</head>
<body>
<div class="container">
    <div class="jumbotron">
        <h2><span class="glyphicon glyphicon-hdd"></span> Пример работы с Яндекс Диском</h2>
    </div>
    <ol class="breadcrumb">
        <li><a href="/examples">Examples</a></li>
        <li class="active">Disk</li>
    </ol>
    <div id="app"></div>
<?php
if (!isset($_COOKIE['yaAccessToken']) || !isset($_COOKIE['yaClientId'])) {
    ?>
    <div class="alert alert-info">
        Для просмотра этой страници вам необходимо авторизироваться.
        <a id="goToAuth" href="<?php echo rtrim(str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__), "/") . '/../OAuth/'?>" class="alert-link">Перейти на страницу авторизации</a>.
    </div>
    <script src="http://yandex.st/jquery/2.0.3/jquery.min.js"></script>
    <script src="http://yandex.st/jquery/cookie/1.0/jquery.cookie.min.js"></script>
    <script>
        $(function () {
            $('#goToAuth').click(function (e) {
                $.cookie('back', location.href, { expires: 256, path: '/' });
            });
        });
    </script>
<?php
}
?>
</div>
</body>
</html>