<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?php echo $pageTitle ?> | Toodle</title>
  <meta name="description" content="">
  <meta name="author" content="Terry Morgan <terry.morgan@marmaladeontoast.co.uk>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
  <link  href="http://fonts.googleapis.com/css?family=Special+Elite:regular" rel="stylesheet" type="text/css" >

  <link rel="stylesheet" href="/css/style.css?v=2">
  <!-- Uncomment if you are specifically targeting less enabled mobile browsers
  <link rel="stylesheet" media="handheld" href="css/handheld.css?v=2">  -->

  <script src="/js/libs/modernizr-1.7.min.js"></script>
</head>
<body>
  <div id="container">
    <header role="banner" class="clearfix">
      <h1>Toodle</h1>

      <?php if ($isLoggedin): ?>

      <nav class="clearfix">
        <ul>
          <li><a href="/">My ToDos</a></li>
          <li><a href="/users/my_profile">My profile</a></li>
          <li><a href="/users/logout">Logout</a></li>
        </ul>
      </nav>

      <p>Oh hai, <?php echo $username; ?></p>

      <?php endif; ?>
    </header>
    <div id="main-content" role="main">