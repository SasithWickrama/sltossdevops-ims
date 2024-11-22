<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  $user = $_SESSION['$usrid'];
  $ulevel = $_SESSION['$p_level'];

  $oneg = $_SESSION['$oneg'];
} else {
  echo '<script type="text/javascript"> document.location = "login.html";</script>';
}
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>main | Ribe</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- favicon
		============================================ -->
  <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
  <!-- Google Fonts
		============================================ -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i,800" rel="stylesheet">
  <!-- Bootstrap CSS
		============================================ -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Bootstrap CSS
		============================================ -->
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <!-- adminpro icon CSS
		============================================ -->
  <link rel="stylesheet" href="css/adminpro-custon-icon.css">
  <!-- meanmenu icon CSS
		============================================ -->
  <link rel="stylesheet" href="css/meanmenu.min.css">
  <!-- mCustomScrollbar CSS
		============================================ -->
  <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
  <!-- animate CSS
		============================================ -->
  <link rel="stylesheet" href="css/animate.css">
  <!-- normalize CSS
		============================================ -->
  <link rel="stylesheet" href="css/normalize.css">
  <!-- form CSS
		============================================ -->
  <link rel="stylesheet" href="css/form.css">
  <!-- style CSS
		============================================ -->
  <link rel="stylesheet" href="style.css">
  <!-- responsive CSS
		============================================ -->
  <link rel="stylesheet" href="css/responsive.css">
  <!-- modernizr JS
		============================================ -->
  <script src="js/vendor/modernizr-2.8.3.min.js"></script>

  <style>
    .footer {
      position: fixed;
      left: 0;
      bottom: 0;
      width: 100%;
      background-color: red;
      color: white;
      text-align: center;
    }
  </style>

  <style>
    .style10 {
      color: #FF0000;
      font-weight: bold;
    }

    .style11 {
      color: #000000
    }

    .odd {
      color: #FF0000;
    }

    .bodyx {
      background-image: url(img/img14.jpg);
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-position: center;
      ba opacity: 10%;
    }

    .background {
      position: fixed;
      width: 100%;
      height: 100%;
      background-image: url(img/img14.jpg);
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
    }

    nav {
      margin-left: 10%;
      margin-top: 15%;
    }

    ul {
      list-style-type: none;
    }

    li {
      height: 25px;
      float: left;
      margin-right: 0px;
      border-right: 1px solid #aaa;
      padding: 0 20px;
    }

    li:last-child {
      border-right: none;
    }

    li a {
      text-decoration: none;
      color: #c0392b;
      font: 35px/1 "Arial Black", Gadget, sans-serif;
      -webkit-transition: all 0.5s ease;
      text-shadow: -1px -1px 0px rgba(255, 255, 255, 0.3), 1px 1px 0px rgba(0, 0, 0, 0.8);

    }

    li a:hover {
      color: #d3b405;
    }

    li.active a {
      font-weight: bold;
      color: #333;
    }
  </style>


</head>

<body class="materialdesign">

  <div class="wrapper-pro">
    <!--<div class="header-top-area">
                <div class="fixed-header-top">
                    <div class="container-fluid">
                        <div class="row">


                        </div>
                    </div>
                </div>
            </div>-->
    <!-- Header top area end-->

    <!-- login Start-->

    <div align="center" class="background">
      <nav>
        <ul style="margin-left: 0%;">
          <li><a href="PSTN/list_tid">PSTN</a></li>
          <li><a href="ftth/res_sus_ftth">FTTH</a></li>
          <li><a href="volte/list_details">VoLTE</a></li>
          <li><a href="VoBB/create_user">VoBB</a></li>
          <li><a href="ipend/useradd_socheck">IP-Endpoint</a></li>
          <li><a href="cor/t_numblock">COR</a></li>
          <li><a href="crbt/config_no">CRBT</a></li>
          <li><a href="centrex/no_create">CENTREX</a></li>
          <li><a href="nms/useradd_nms">NMS</a></li>          
          <?php
          if ($oneg == 'Y') {
            ?>
            <li><a href="oneg/pe_oneg">1GB PE</a></li>
            <?php
          }
          ?>
        </ul>
      </nav>
      <br /><br />
    </div>
    <br />



    <!-- login End-->
  </div>
  </div>
  <!-- Footer Start-->
  <div class="footer-copyright-area footer">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="footer-copy-right">
            <p>Copyright &#169; 2016-2020 All rights reserved. <span style="color: #FF0000">IT Solution & DevOps</span></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer End-->
  <!-- jquery
		============================================ -->
  <script src="js/vendor/jquery-1.11.3.min.js"></script>
  <!-- bootstrap JS
		============================================ -->
  <script src="js/bootstrap.min.js"></script>
  <!-- meanmenu JS
		============================================ -->
  <script src="js/jquery.meanmenu.js"></script>
  <!-- mCustomScrollbar JS
		============================================ -->
  <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
  <!-- sticky JS
		============================================ -->
  <script src="js/jquery.sticky.js"></script>
  <!-- scrollUp JS
		============================================ -->
  <script src="js/jquery.scrollUp.min.js"></script>
  <!-- form validate JS
		============================================ -->
  <script src="js/jquery.form.min.js"></script>
  <script src="js/jquery.validate.min.js"></script>
  <script src="js/form-active.js"></script>
  <!-- main JS
		============================================ -->
  <script src="js/main.js"></script>

  <style>
    /* customizable snowflake2 styling */
    .snowflake2 {
      color: #fff;
      font-size: 2em;
      font-family: Arial, sans-serif;
      text-shadow: 0 0 5px #000;
    }

    @-webkit-keyframes snowflakes-fall {
      0% {
        top: -20%
      }

      100% {
        top: 100%
      }
    }

    @-webkit-keyframes snowflakes-shake {

      0%,
      100% {
        -webkit-transform: translateX(0);
        transform: translateX(0)
      }

      70% {
        -webkit-transform: translateX(70px);
        transform: translateX(80px)
      }
    }

    @keyframes snowflakes-fall {
      0% {
        top: -10%
      }

      100% {
        top: 100%
      }
    }

    @keyframes snowflakes-shake {

      0%,
      100% {
        transform: translateX(0)
      }

      50% {
        transform: translateX(80px)
      }
    }

    .snowflake2 {
      position: fixed;
      top: -10%;
      z-index: 9999;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      cursor: default;
      -webkit-animation-name: snowflakes-fall, snowflakes-shake;
      -webkit-animation-duration: 10s, 3s;
      -webkit-animation-timing-function: linear, ease-in-out;
      -webkit-animation-iteration-count: infinite, infinite;
      -webkit-animation-play-state: running, running;
      animation-name: snowflakes-fall, snowflakes-shake;
      animation-duration: 10s, 3s;
      animation-timing-function: linear, ease-in-out;
      animation-iteration-count: infinite, infinite;
      animation-play-state: running, running
    }

    .snowflake2:nth-of-type(0) {
      left: 11%;
      -webkit-animation-delay: 0s, 0s;
      animation-delay: 0s, 0s
    }

    .snowflake2:nth-of-type(1) {
      left: 20%;
      -webkit-animation-delay: 1s, 1s;
      animation-delay: 1s, 1s
    }

    .snowflake2:nth-of-type(2) {
      left: 30%;
      -webkit-animation-delay: 8s, .5s;
      animation-delay: 8s, .5s
    }

    .snowflake2:nth-of-type(3) {
      left: 40%;
      -webkit-animation-delay: 6s, 2s;
      animation-delay: 6s, 2s
    }

    .snowflake2:nth-of-type(4) {
      left: 40%;
      -webkit-animation-delay: 2s, 2s;
      animation-delay: 2s, 2s
    }

    .snowflake2:nth-of-type(5) {
      left: 60%;
      -webkit-animation-delay: 8s, 3s;
      animation-delay: 8s, 3s
    }

    .snowflake2:nth-of-type(6) {
      left: 70%;
      -webkit-animation-delay: 8s, 2s;
      animation-delay: 8s, 2s
    }

    .snowflake2:nth-of-type(7) {
      left: 70%;
      -webkit-animation-delay: 2.5s, 1s;
      animation-delay: 2.5s, 1s
    }

    .snowflake2:nth-of-type(8) {
      left: 90%;
      -webkit-animation-delay: 1s, 0s;
      animation-delay: 1s, 0s
    }

    .snowflake2:nth-of-type(9) {
      left: 95%;
      -webkit-animation-delay: 3s, 1.5s;
      animation-delay: 3s, 1.5s
    }

    .snowflake2:nth-of-type(10) {
      left: 35%;
      -webkit-animation-delay: 2s, 0s;
      animation-delay: 2s, 0s
    }

    .snowflake2:nth-of-type(11) {
      left: 75%;
      -webkit-animation-delay: 6s, 2.5s;
      animation-delay: 6s, 2.5s
    }
  </style>
  <!-- <div class="snowflakes" aria-hidden="true">
  <div class="snowflake2">
  ❅
  </div>
  <div class="snowflake2">
  ❆
  </div>
  <div class="snowflake2">
  ❅
  </div>
  <div class="snowflake2">
  ❆
  </div>
  <div class="snowflake2">
  ❅
  </div>
  <div class="snowflake2">
  ❆
  </div>
  <div class="snowflake2">
    ❅
  </div>
  <div class="snowflake2">
    ❆
  </div>
  <div class="snowflake2">
    ❅
  </div>
  <div class="snowflake2">
    ❆
  </div>
  <div class="snowflake2">
    ❅
  </div>
  <div class="snowflake2">
    ❆
  </div>
</div> -->
</body>

</html>