<?php require_once 'backend/config.php'; ?>
<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title><?php echo APP_TITLE; ?></title>
    <meta name="description" content="Stream Viewer Sample">
    <meta name="author" content="Salman Khimani">

    <!-- gmail configurations -->
    <meta name="google-signin-scope" content="<?php echo GOOGLE_SIGNIN_SCOPE; ?>">
    <meta name="google-signin-client_id" content="<?php echo GOOGLE_CLIENT_ID; ?>">
    <meta name="google-site-verification" content="<?php echo GOOGLE_SITE_VERIFICATION; ?>" />

    <!-- stylesheets -->
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <link rel="stylesheet" href="css/main.css">

    <!--[if lt IE 9]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <![endif]-->
    <!-- jquery -->
    <script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- bootstrap -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
            integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
            crossorigin="anonymous"></script>
</head>

<body>

<div id="body" class="w-100"></div>
<script type="text/javascript" src="js/scripts.js"></script>

</body>
</html>