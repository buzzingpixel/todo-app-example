<?php

declare(strict_types=1);

namespace App\Authorization\LogIn;

use BuzzingPixel\Templating\TemplateEngineFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

readonly class GetLogInAction
{
    public function __construct(
        private TemplateEngineFactory $templateEngineFactory,
    ) {
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $response->getBody()->write(
            $this->templateEngineFactory->create()
                ->templatePath(__DIR__ . '/GetLoginUi.phtml')
                ->addVar('returnTo', $request->getUri()->getPath())
                ->addVar('hideTabs', true)
                ->render(),
        );

        return $response;
    }
}
