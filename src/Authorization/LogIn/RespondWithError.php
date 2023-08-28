<?php

declare(strict_types=1);

namespace App\Authorization\LogIn;

use BuzzingPixel\Templating\TemplateEngineFactory;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

readonly class RespondWithError implements Responder
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private TemplateEngineFactory $templateEngineFactory,
    ) {
    }

    public function respond(
        LogInResult $result,
        PostData $postData,
    ): ResponseInterface {
        $response = $this->responseFactory->createResponse(401);

        $response->getBody()->write(
            $this->templateEngineFactory->create()
                ->templatePath(
                    __DIR__ . '/RespondWithErrorUi.phtml',
                )
                ->addVar('message', $result->message)
                ->render(),
        );

        return $response;
    }
}
