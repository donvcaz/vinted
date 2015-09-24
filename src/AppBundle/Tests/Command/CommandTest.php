<?php

namespace AppBundle\Tests\Command;

use AppBundle\Entity\Shipment;
use AppBundle\EntityList\ProviderList;
use AppBundle\Exception\PackageSizeException;
use AppBundle\Exception\StringFormatException;
use AppBundle\Rules\RuleAbstract;
use AppBundle\Rules\RulesService;
use AppBundle\Service\ConfigService;
use AppBundle\Service\EntityListService;
use AppBundle\Service\TextFileService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommandTest extends WebTestCase
{
    public function testProviderList()
    {
        /** @var ProviderList $providerList */

        $client = static::createClient();

        $providerList = $client->getContainer()->get('entity_list_service')->getProviderList();

        $this->assertEquals(false,$providerList->isEmpty(), 'Provider list was empty');
    }

    /**
     * Making test with data witch included in folders :
     * /Tests/data input data and provider list
     * /Tests/config Rules config
     */
    public function testTransactions()
    {
        /** @var ProviderList $providerList */
        /** @var RulesService $rulesService */

        $client = static::createClient();

        $this->setExpectedException('AppBundle\Exception\StringFormatException');

        //setting new configuration service with test config file
        $client->getContainer()->set('configuration_service', new ConfigService($client->getKernel(), '@AppBundle/Tests/config/config.json'));

        $entityListService = new EntityListService($client->getKernel(), '@AppBundle/Tests/data/providers.txt');
        $providerList = $entityListService->getProviderList();
        $rulesService = $client->getContainer()->get('rules_service');

        $this->assertEquals(false,$providerList->isEmpty(), 'Provider list was empty');

        $textFileService = new TextFileService($client->getKernel(), '@AppBundle/Tests/data/input.txt');
        $i = 0;
        while (($line = $textFileService->next())) {
            $shipment = new Shipment();
            $shipment->fromString($line, $providerList);

            $shipment = $rulesService->applyAllRules($shipment);

            $this->assertEquals($this->getAllowedPrices()[$i], $shipment->getPrice(), 'Price not match');
            $this->assertEquals($this->getAllowedDiscounts()[$i], $shipment->getDiscount(), 'Discount not match');
            $i++;
        }
    }

    private function getAllowedPrices()
    {
        return [
            0   => 1.50,
            1   => 1.50,
            2   => 6.90,
            3   => 1.50,
            4   => 1.50,
            5   => 6.90,
            6   => 4.00,
            7   => 3.00,
            8   => 0.00,
            9   => 6.90,
            10  => 1.50,
            11  => 1.50,
            12  => 6.90,
            13  => 3.00,
            14  => 4.90,
            15  => 1.50,
            16  => 6.90,
            17  => 1.90,
            18  => 6.90,
            19  => null,
            20  => 1.50
        ];
    }

    private function getAllowedDiscounts()
    {
        return [
            0   => 0.50,
            1   => 0.50,
            2   => 0.00,
            3   => 0.00,
            4   => 0.50,
            5   => 0.00,
            6   => 0.00,
            7   => 0.00,
            8   => 6.90,
            9   => 0.00,
            10  => 0.50,
            11  => 0.50,
            12  => 0.00,
            13  => 0.00,
            14  => 0.00,
            15  => 0.50,
            16  => 0.00,
            17  => 0.10,
            18  => 0.00,
            19  => 0.00,
            20  => 0.50
        ];
    }
}
