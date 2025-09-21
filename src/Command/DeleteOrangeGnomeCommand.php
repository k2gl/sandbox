<?php

namespace App\Command;

use App\Entity\OrangeGnome;
use App\Repository\OrangeGnomeRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name       : 'app:orange-gnome-delete',
    description: 'Delete random OrangeGnome',
)]
class DeleteOrangeGnomeCommand extends Command
{
    public function __construct(
        private(set) OrangeGnomeRepository $orangeGnomeRepository,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $orangeGnome = $this->orangeGnomeRepository->getRandom();
        $this->orangeGnomeRepository->remove($orangeGnome);

        $io->success(print_r([
                ' deleted ',
                ' $orangeGnome ' => $orangeGnome,
                'dd.3117 at'     => __FILE__ . ':' . __LINE__,
            ]
            , true
        ));


        return Command::SUCCESS;
    }
}
