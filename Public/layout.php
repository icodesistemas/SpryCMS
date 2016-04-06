<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administrador</title>

    <link href="/Public/css/metro.css" rel="stylesheet">
    <link href="/Public/css/metro-icons.css" rel="stylesheet">
    <link href="/Public/css/style.css" rel="stylesheet">

    <script src="/Public/js/jquery.js"></script>
    <script src="/Public/js/metro.js"></script>
    <script src="/Public/js/principal.js"></script>

</head>
<body>
    <div data-role="dialog" id="dialog-place-top-right" class="padding20 dialog" data-close-button="true" data-place="top-right" style="width: auto; height: auto; visibility: visible; right: 0px; top: 0px;">
        <h1><?= Spry::getMessage() ?></h1>
        <p></p>
        <span class="dialog-close-button"></span>
    </div>
    <div class = "loading">
        <div data-role="preloader" data-type="cycle" data-style="white"></div>
    </div>

    <?php

        if(count($_REQUEST) > 0 && (!isset($_SESSION['id_session']) || $_SESSION['id_session'] == 0 ) ){
            include(__APPLICATION_PATH.'/'.__APPLICATION_FOLDER_VIEW.'/'.'vista-default.php');

        }else{

            include($Spry->getView());
        }



    ?>

<script>
    $(function(){
        showMetroDialog('#dialog-place-top-right');
        setTimeout(function(){
            hideMetroDialog('#dialog-place-top-right')
        },3000)
    })
</script>
</body>
</html>