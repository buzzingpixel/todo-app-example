<?php

declare(strict_types=1);

use App\Persistence\AppPdo;
use App\Persistence\AppPdoFactory;
use BuzzingPixel\Container\Container;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Psr7\Factory\ResponseFactory;

require __DIR__ . '/vendor/autoload.php';

return new Container(
    [
        AppPdo::class => static function (ContainerInterface $container): AppPdo {
            $factory = $container->get(AppPdoFactory::class);
            assert($factory instanceof AppPdoFactory);

            return $factory->create();
        },
        ResponseFactoryInterface::class => ResponseFactory::class,
    ],
);
