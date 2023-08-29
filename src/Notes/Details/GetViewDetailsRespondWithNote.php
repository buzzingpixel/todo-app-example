<?php

declare(strict_types=1);

namespace App\Notes\Details;

use App\Notes\Note;
use BuzzingPixel\Templating\TemplateEngineFactory;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

class GetViewDetailsRespondWithNote implements GetViewDetailsResponder
{
    private Note $note;

    public function withNote(Note $note): static
    {
        $clone = clone $this;

        $clone->note = $note;

        return $clone;
    }

    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly TemplateEngineFactory $templateEngineFactory,
    ) {
    }

    public function respond(): ResponseInterface
    {
        $response = $this->responseFactory->createResponse();

        $response->getBody()->write(
            $this->templateEngineFactory->create()
                ->templatePath(__DIR__ . '/GetViewDetailsUi.phtml')
                ->addVar('note', $this->note)
                ->render(),
        );

        return $response;
    }
}
