<?php
declare(strict_types=1);

namespace App\Console\User;


use App\Domain\User\Inputs\CreateInput;
use App\Domain\User\UseCases\CreateUser;
use App\Infrastructure\Validator\ValidationException;
use App\Infrastructure\Validator\Validator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAdminCommand extends Command
{
    private CreateUser $handler;
    private Validator $validator;

    public function __construct(CreateUser $handler, Validator $validator)
    {
        parent::__construct();
        $this->handler = $handler;
        $this->validator = $validator;
    }

    protected function configure(): void
    {
        $this->setName('app:create-admin');
        $this->setDescription('Создать админа');
        $this->addArgument('email', InputArgument::REQUIRED, 'Введите email пользователя');
        $this->addArgument('password', InputArgument::REQUIRED, 'Введите пароль пользователя');
        $this->addArgument('role', InputArgument::REQUIRED, 'Введите роль пользователя');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $createUserInput = new CreateInput();
        $createUserInput->email = $input->getArgument('email');
        $createUserInput->password = $input->getArgument('password');
        $createUserInput->role = $input->getArgument('role');

        if ($errors = $this->validator->validate($createUserInput)) {
            throw new ValidationException($errors);
        }

        $this->handler->handle($createUserInput);

        $output->writeln('<info>Done!</info>');
        return 0;
    }
}
