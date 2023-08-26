<?php

declare(strict_types=1);

use App\GetHelloWorldAction;
use App\Persistence\AppPdo;
use App\Persistence\AppPdoFactory;
use BuzzingPixel\Container\Container;
use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container(
    [
        AppPdo::class => static function (ContainerInterface $container): AppPdo {
            $factory = $container->get(AppPdoFactory::class);
            assert($factory instanceof AppPdoFactory);

            return $factory->create();
        },
    ],
);

$app = AppFactory::create(container: $container);

$app->get('/', GetHelloWorldAction::class);

$app->run();
