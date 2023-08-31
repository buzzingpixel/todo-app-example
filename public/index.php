<?php

declare(strict_types=1);

use App\Authorization\LogIn\PostLoginAction;
use App\Authorization\RequireAuthMiddleware;
use App\GetHelloWorldAction;
use App\Notes\Add\GetAddNoteAction;
use App\Notes\Add\PostAddNoteAction;
use App\Notes\Details\GetViewDetailsAction;
use App\Notes\GetNoteListAction;
use App\Notes\PostDeleteNoteAction;
use App\ToDo\Add\GetAddToDoAction;
use App\ToDo\Add\PostAddToDoAction;
use App\ToDo\GetToDoListAction;
use App\ToDo\PostDeleteToDoAction;
use App\ToDo\PostMarkDoneAction;
use App\ToDo\PostMarkNotDoneAction;
use Slim\Factory\AppFactory;

$container = require dirname(__DIR__) . '/boot.php';

$app = AppFactory::create(container: $container);

$app->get('/', GetHelloWorldAction::class);

$app->post('/login', PostLoginAction::class);

$app->get('/todos', GetToDoListAction::class)
    ->add(RequireAuthMiddleware::class);

$app->get('/todos/add', GetAddToDoAction::class)
    ->add(RequireAuthMiddleware::class);

$app->post('/todos/add', PostAddToDoAction::class)
    ->add(RequireAuthMiddleware::class);

$app->post(
    '/todos/mark/done',
    PostMarkDoneAction::class,
)->add(RequireAuthMiddleware::class);

$app->post(
    '/todos/mark/not-done',
    PostMarkNotDoneAction::class,
)->add(RequireAuthMiddleware::class);

$app->post(
    '/todos/delete',
    PostDeleteToDoAction::class,
)->add(RequireAuthMiddleware::class);

$app->get('/notes', GetNoteListAction::class)
    ->add(RequireAuthMiddleware::class);

$app->get('/notes/add', GetAddNoteAction::class)
    ->add(RequireAuthMiddleware::class);

$app->post('/notes/add', PostAddNoteAction::class)
    ->add(RequireAuthMiddleware::class);

$app->get('/notes/view/{id}', GetViewDetailsAction::class)
    ->add(RequireAuthMiddleware::class);

$app->post(
    '/notes/delete',
    PostDeleteNoteAction::class,
)->add(RequireAuthMiddleware::class);

$app->run();
