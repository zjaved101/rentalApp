<?php

require('../vendor/autoload.php');

$app = new Silex\Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

// Register view rendering
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

// Our web handlers

$app->get('/', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return $app['twig']->render('index.twig');
});

$app->get('/contacts', function() use($app) {
  $output = '<!DOCTYPE html>
  <html>
  <head>
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/stylesheets/main.css" />
  </head>
  
  <body>
    <nav class="navbar navbar-default navbar-static-top navbar-inverse">
      <div class="container">
        <ul class="nav navbar-nav">
          <li class="active">
            <a href="/"><span class="glyphicon glyphicon-home"></span> Home</a>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="navbar-right">
            <a href="/contacts"><span class="glyphicon glyphicon-book"></span> Contacts</a>
          </li>
        </ul>
      </div>
    </nav>
    ';
  $contacts = file('contacts.txt');
  $output .= "<h1>Contacts</h1>";
  foreach ($contacts as $contact) {
      list($name, $email) = explode(":", $contact);
      $output .= "<h2>Name</h2>\n<p>$name</p>\n";
      $output .= "<h2>Email</h2>\n<p>$email</p>\n";
  }

  $output .= '</body>
  </html>';

  return $output;
});

$app->run();
