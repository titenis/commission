<?php

namespace Commission\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Commission\FileReader;
use Commission\Calculator;
use Commission\PaymentCreator;

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

        $this->setName('commissions:get-from-file');
        $this->setDescription('Gets commissions from csv file');
        $this->addArgument('filePath', InputArgument::REQUIRED, 'Path to the file source');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = $input->getArgument('filePath');

        $fileArray = $this->FileReader->readFile($filePath);
        $payments = $this->PaymentCreator->createFromArray($fileArray);

        var_dump($payments);

        return 0;
    }
}