<?php

declare(strict_types=1);

namespace App\Notes;

use App\Authorization\UserSession;
use BuzzingPixel\Templating\TemplateEngineFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function assert;

readonly class GetNoteListAction
{
    public function __construct(
        private NoteRepository $repository,
        private TemplateEngineFactory $templateEngineFactory,
    ) {
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $session = $request->getAttribute('session');
        assert($session instanceof UserSession);

        $notes = $this->repository->findAll(
            $session->user()->id->toNative(),
        );

        $response->getBody()->write(
            $this->templateEngineFactory->create()
                ->templatePath(__DIR__ . '/GetNoteListUi.phtml')
                ->addVar('notes', $notes)
                ->render(),
        );

        return $response;
    }
}
