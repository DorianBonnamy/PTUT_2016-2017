<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<?php

require __DIR__ . '/../vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$app = new Silex\Application();
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app['connection'] = [
    'driver' => 'pdo_mysql',
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'dbname' => 'articles'
];


$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
$app['doctrine_config'] = Setup::createYAMLMetadataConfiguration([__DIR__ . '/../config'], true);
$app['em'] = function ($app) {
    return EntityManager::create($app['connection'], $app['doctrine_config']);
};

$app->get('/', 'DUT\\Controllers\\ItemsController::indexAction');

$app->register(new Silex\Provider\TwigServiceProvider(), ['twig.path' => __DIR__.'/../views',]);
$app['debug'] = true;
$app->run();
