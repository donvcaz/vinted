<?php

namespace AppBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CountShipmentCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('vinted:shipment')
            ->setDescription('')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get('client_service')->outputTransactions($output);
    }
}
