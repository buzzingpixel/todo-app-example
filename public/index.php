<?php

declare(strict_types=1);

use App\GetHelloWorldAction;
use BuzzingPixel\Container\Container;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();

$app = AppFactory::create(container: $container);

$app->get('/', GetHelloWorldAction::class);

$app->run();
