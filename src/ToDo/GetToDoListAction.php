<?php

declare(strict_types=1);

namespace App\ToDo;

use App\Authorization\UserSession;
use BuzzingPixel\Templating\TemplateEngineFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function assert;

readonly class GetToDoListAction
{
    public function __construct(
        private ToDoRepository $repository,
        private TemplateEngineFactory $templateEngineFactory,
    ) {
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $session = $request->getAttribute('session');
        assert($session instanceof UserSession);

        $todos = $this->repository->findAll(
            $session->user()->id->toNative(),
        );

        $response->getBody()->write(
            $this->templateEngineFactory->create()
                ->templatePath(__DIR__ . '/GetToDoListUi.phtml')
                ->addVar('todos', $todos)
                ->render(),
        );

        return $response;
    }
}
