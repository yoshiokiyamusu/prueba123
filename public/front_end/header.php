<!doctype html>
<html lang="en">


  <head>
    <title>Cocotfyma<?php if(isset($page_title)) { echo '- ' . h($page_title); } ?></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<!--
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo url_for('stylesheets/bootstrap.min.css'); ?>">
    <script src="<?php echo url_for('stylesheets/jquery.min.js'); ?>"></script>
    <script src="<?php echo url_for('stylesheets/bootstrap.min.js'); ?>"></script>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <link href="<?php echo url_for('stylesheets/fontawesome/css/all.css'); ?>" rel="stylesheet"> <!-- https://fontawesome.com/icons/ -->
  </head>

  <body>
    <header class="container">
      <div class="row">
         <?php if($session->is_logged_in()){ ?>
             <div class="col-6 ml-5 pull-left"><h9>User:<?php echo $session->username; ?></h9></div>
             <div class="col-lg-5 col-md-5 col-sm-3 col-xs-3 text-right pull-right"><a class="topright" href="<?php echo url_for('logout.php'); ?>">log out</a></div>
         <?php } ?>
       </div>

      <h4>
        <a class="titlex" href="<?php echo url_for('/index.php'); ?>">
          <!--<img class="logo_icon" src="<?php //echo url_for('/images/logo_empresa.JPG') ?>" /><br />-->

        </a>
      </h4>
      <?php header("Content-Type: text/html;charset=utf-8"); ?>
    </header>

    <?php echo display_session_message(); ?>
