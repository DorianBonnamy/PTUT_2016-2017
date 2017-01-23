<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<?php

require __DIR__ . '/../vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$app = new Silex\Application();
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

/**
 * DEPENDANCES
 */
$app['connection'] = [
    'driver' => 'pdo_mysql',
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'dbname' => 'articles'
];

$app['admin']=0;
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
$app['doctrine_config'] = Setup::createYAMLMetadataConfiguration([__DIR__ . '/../config'], true);
$app['em'] = function ($app) {
    return EntityManager::create($app['connection'], $app['doctrine_config']);
};


/**
 * ROUTES
 */

$app->get('/', 'DUT\\Controllers\\ItemsController::indexAction');

$app->get('/remove/{index}', 'DUT\\Controllers\\ItemsController::removeAction');

$app->get('/removeCom/{index}', 'DUT\\Controllers\\ItemsController::removeCom');

$app->post('/create', 'DUT\\Controllers\\ItemsController::CreateArticle');

$app->get('/article/{index}', 'DUT\\Controllers\\ItemsController::ViewArticle');

$app->post('/comments/{index}', 'DUT\\Controllers\\ItemsController::CommentArticle');

$app->register(new Silex\Provider\TwigServiceProvider(), ['twig.path' => __DIR__.'/../views',]);


$app['debug'] = true;
$app->run();
