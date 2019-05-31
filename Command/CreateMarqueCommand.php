<?php

namespace App\Command;

use App\Service\MarqueService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateMarqueCommand extends Command
{
    /** @var MarqueService */
    private $marqueService;

    /**
     * @param MarqueService $marqueService
     */
    public function __construct(MarqueService $marqueService)
    {
        $this->marqueService = $marqueService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:create-marque')

            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new marque.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to add new marque in db...')

            // configure an argument
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the marque.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('name')) {
            $question = new Question('<question>Please choose a name: </question>');
            $question->setValidator(function ($name) {
                if (empty($name)) {
                    throw new \Exception('Name can not be empty');
                }

                return $name;
            });

            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument('name', $answer);
        }
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Marque Creator',
            '============',
            '',
        ]);

        // retrieve the argument value using getArgument()
        $output->writeln(sprintf('Name: %s', $input->getArgument('name')));

        $this->categoryService->create($input->getArgument('name'));

        $output->writeln('<fg=green>Marque successfully created!</>');
    }
}
