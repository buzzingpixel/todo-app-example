<?php

declare(strict_types=1);

namespace App\Authorization;

use Silly\Application;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Question\Question;

use function assert;
use function is_string;

readonly class CreateUserCommand
{
    public function __construct(
        private Application $app,
        private UserRepository $repository,
    ) {
    }

    public function __invoke(
        InputInterface $input,
        ConsoleOutputInterface $output,
    ): int {
        $questionHelper = $this->app->getHelperSet()->get('question');

        assert($questionHelper instanceof QuestionHelper);

        $email = '';

        $name = '';

        $password = '';

        while ($email === '') {
            $question = new Question('Email: ', '');

            $email = $questionHelper->ask($input, $output, $question);

            assert(is_string($email));
        }

        while ($name === '') {
            $question = new Question('Name: ', '');

            $name = $questionHelper->ask($input, $output, $question);

            assert(is_string($name));
        }

        while ($password === '') {
            $question = new Question('Password: ', '');

            $question->setHidden(true);

            $question->setHiddenFallback(false);

            $password = $questionHelper->ask($input, $output, $question);

            assert(is_string($password));
        }

        $result = $this->repository->createUser(
            $email,
            $name,
            $password,
        );

        return (int) $result->success;
    }
}
