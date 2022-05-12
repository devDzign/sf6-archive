<?php

namespace App\Command;

use App\Entity\LegalCategories;
use App\Services\ConvertCsvToArray;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import:legal-categories',
    description: 'Add a short description for your command',
)]
class ImportLegalCategoriesCommand extends Command
{

    private const FILE_PATH =  'public/uploads/import/legal-categories.csv';

    public function __construct(private ConvertCsvToArray $convertCsvToArray, private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $now = new \DateTime();
        $output->writeln('<comment>Start : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');

        // Importing CSV on DB via Doctrine ORM
        $this->import($output);

        // Showing when the script is over
        $now = new \DateTime();
        $output->writeln('<comment>End : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }


    protected function import(OutputInterface $output)
    {
        // Getting php array of data from CSV
        $data = $this->convertCsvToArray->convert(self::FILE_PATH, ';');

        // Define the size of record, the frequency for persisting the data and the current index of records
        $size = count($data);
        $batchSize = 20;
        $i = 1;

        // Starting progress
        $progress = new ProgressBar($output, $size);
        $progress->start();

        // Processing on each row of data
        foreach ($data as $row) {
            $legalCategory = new LegalCategories();
            $legalCategory
                ->setCode($row['Code'])
                ->setWording($row['Libellé']);

            // Persisting the current legal category
            $this->entityManager->persist($legalCategory);

            // Each 20 category legal persisted we flush everything
            if (($i % $batchSize) === 0) {
                $this->entityManager->flush();
                // Detaches all objects from Doctrine for memory save
                $this->entityManager->clear();

                // Advancing for progress display on console
                $progress->advance($batchSize);

                $now = new \DateTime();
                $output->writeln(' of legal categories imported ... | ' . $now->format('d-m-Y G:i:s'));
            }
            $i++;
        }

        // Flushing and clear data on queue
        $this->entityManager->flush();
        $this->entityManager->clear();

        // Ending the progress bar process
        $progress->finish();
    }
}
