<?php

namespace Commission\Command;

use Commission\Calculator;
use Commission\FileReader;
use Commission\PaymentCreator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class GetCommissionsCommand
 *
 * @package Commission\Command
 */
class GetCommissionsCommand extends Command
{
    /**
     * @var FileReader
     */
    private $FileReader;
    /**
     * @var PaymentCreator
     */
    private $PaymentCreator;
    /**
     * @var Calculator
     */
    private $Calculator;

    protected function configure()
    {
        $container = new ContainerBuilder();
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
        $loader->load('../../config/parameters.yml');
        $loader->load('../../config/services.yml');

        $this->FileReader = $container->get('file-reader');
        $this->PaymentCreator = $container->get('payment-creator');
        $this->Calculator = $container->get('calculator');

        $this->setName('commissions:get-from-file');
        $this->setDescription('Calculates and outputs commissions from csv file');
        $this->addArgument('filePath', InputArgument::REQUIRED, 'Path to the file source');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = $input->getArgument('filePath');

        $fileArray = $this->FileReader->readFile($filePath);
        $payments = $this->PaymentCreator->createFromArray($fileArray);
        $results = $this->Calculator->calculateCommissions($payments);

        foreach ($results as $singleResult) {
            $output->writeln($singleResult);
        }
    }
}