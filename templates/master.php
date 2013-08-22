<!DOCTYPE html>
<html lang="en">
    <head>
        <link href='http://fonts.googleapis.com/css?family=Lato|Rokkitt' rel='stylesheet' type='text/css'>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?=$description?>">
        <meta name="keywords" content="<?=$keywords?>">
        <meta name="author" content="<?=$author?>">
        <title><?=$title?></title>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.no-icons.min.css" rel="stylesheet">
        <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css" media="screen" />
        <link rel="shortcut icon" href="favicon.ico" />
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="../../assets/js/html5shiv.js"></script>
          <script src="../../assets/js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
    <div id="wrap">
        <div id="sidebar">
            <div id="person-name-holder" class="text-center">
                <img class="img-circle img-responsive" src="img/123hIDA72hfdkA.jpg" alt="">
                <h3>Marko Z. Aleksic</h3>
            </div>
            <ul id="navigation" class="list-unstyled">
                <li><a href="#objectives" class="active">Objectives</a></li>
                <li><a href="#education">Education</a></li>
                <li><a href="#experience">Experience</a></li>
                <li><a href="#skills">Skills</a></li>
                <li><a href="#projects">Projects</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
        <div id="container">
            <?php foreach ($sections as $section): ?>
                <?php @include("sections/{$section}.php") ?>
            <?php endforeach ?>
            <div id="footer">
                <p>
                    &copy; 2013 Marko Aleksic. All Rights Reserved. <br>
                    Powered by <a href="http://www.slimframework.com/">Slim Framework</a>
                </p>
            </div>
        </div>
    </div>
        <a class="gotop" href="#top"><i class="icon icon-arrow-up"></i> go to top</a>
        <!-- le java scirpt -->
        <script async src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script async src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
        <script async src="//cdnjs.cloudflare.com/ajax/libs/jquery.isotope/1.5.25/jquery.isotope.js"></script>
        <script async src="//cdnjs.cloudflare.com/ajax/libs/jquery-smooth-scroll/1.4.10/jquery.smooth-scroll.min.js"></script>
        <script async src="//cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.2/waypoints.js"></script>
        <script async src="js/app.js"></script>
    </body>
</html>