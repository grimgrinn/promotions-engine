<?php

namespace App\Command;

use App\Entity\Product;
use ContainerA3Mvm9K\getProductRepositoryService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Repository\ProductRepository;

#[AsCommand(
    name: 'testdb',
    description: 'Add a short description for your command',
)]
class TestdbCommand extends Command
{

    public function __construct(protected readonly EntityManagerInterface $entityManager, string $name = null)
    {
        parent::__construct($name);

    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    function solution($arr)
    {
        $assoc = [];
        foreach($arr as $el=>$ell)
        {
            isset($assoc[$ell]) ?
                $assoc[$ell]++  :
                $assoc[$ell] = 1;
        }
        asort($assoc);
        return array_key_first($assoc);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $io = new SymfonyStyle($input, $output);
//        $productrepo = $this->entityManager->getRepository(Product::class);
//        $protudct = $productrepo->find(1);
//        echo $protudct->getId();
        phpinfo();
        /*
        $arr  = [1,23,56,3,15,3,3,3,23,23,1,56,1];

        $solution = $this->solution($arr);
        echo $solution;
        */
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
