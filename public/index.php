<?php

declare(strict_types=1);

use App\Authorization\LogIn\PostLoginAction;
use App\Authorization\RequireAuthMiddleware;
use App\GetHelloWorldAction;
use App\Persistence\AppPdo;
use App\Persistence\AppPdoFactory;
use App\ToDo\Add\GetAddToDoAction;
use App\ToDo\Add\PostAddToDoAction;
use App\ToDo\GetToDoListAction;
use App\ToDo\PostMarkCompletedAction;
use App\ToDo\PostMarkUnCompletedAction;
use BuzzingPixel\Container\Container;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\ResponseFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container(
    [
        AppPdo::class => static function (ContainerInterface $container): AppPdo {
            $factory = $container->get(AppPdoFactory::class);
            assert($factory instanceof AppPdoFactory);

            return $factory->create();
        },
        ResponseFactoryInterface::class => ResponseFactory::class,
    ],
);

$app = AppFactory::create(container: $container);

$app->get('/', GetHelloWorldAction::class);

$app->get('/todos', GetToDoListAction::class)
    ->add(RequireAuthMiddleware::class);

$app->get('/todos/add', GetAddToDoAction::class)
    ->add(RequireAuthMiddleware::class);

$app->post('/todos/add', PostAddToDoAction::class)
    ->add(RequireAuthMiddleware::class);

$app->post(
    '/todos/mark/completed',
    PostMarkCompletedAction::class,
)->add(RequireAuthMiddleware::class);

$app->post(
    '/todos/mark/uncompleted',
    PostMarkUnCompletedAction::class,
)->add(RequireAuthMiddleware::class);

$app->post('/login', PostLoginAction::class);

$app->run();
