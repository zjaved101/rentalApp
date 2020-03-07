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
  $output = "";
  $contacts = file('contacts.txt');
  $output .= "<h1>Contacts</h1>";
  foreach ($contacts as $contact) {
      list($name, $email) = split(":", $contact);
      $output .= "<h2>Name</h2>\n<p>$name</p>\n";
      $output .= "<h2>Email</h2>\n<p>$email</p>";
  }

  return $output;
});

$app->run();
