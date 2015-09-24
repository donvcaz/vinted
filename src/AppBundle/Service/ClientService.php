<?php
/**
 * Created by PhpStorm.
 * User: Donatas
 * Date: 15.9.24
 * Time: 09.40
 */

namespace AppBundle\Service;


use AppBundle\Entity\Shipment;
use AppBundle\Exception\PackageSizeException;
use AppBundle\Exception\StringFormatException;
use AppBundle\Rules\RuleAbstract;
use AppBundle\Rules\RulesService;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\Kernel;

class ClientService {

    private $kernel;

    private $entityListService;

    private $rulesService;

    private $inputDataFileLocation;

    public function __construct(Kernel $kernel, EntityListService $entityListService, RulesService $rulesService, $inputDataFileLocation) {
        $this->kernel                   = $kernel;
        $this->entityListService        = $entityListService;
        $this->rulesService             = $rulesService;
        $this->inputDataFileLocation    = $inputDataFileLocation;
    }

    /**
     * @param OutputInterface $output
     */
    public function outputTransactions(OutputInterface $output)
    {
        /** @var Shipment       $shipment */
        /** @var RuleAbstract   $rule */

        $providerList = $this->entityListService->getProviderList();

        $textFileService = new TextFileService($this->kernel, $this->inputDataFileLocation);

        while (($line = $textFileService->next())) {
            $shipment = new Shipment();
            try {
                $shipment->fromString($line, $providerList);

                $shipment = $this->rulesService->applyAllRules($shipment);

                $output->writeln($line
                    . TextFileService::FILE_LINE_DELIMITER
                    . $shipment->getPrice()
                    . TextFileService::FILE_LINE_DELIMITER
                    . (($shipment->getDiscount() > 0) ? $shipment->getDiscount() : '-'));

            } catch (StringFormatException $sfe) {
                $output->writeln($line .' Ignored');
            } catch (PackageSizeException $pse) {
                $output->writeln($line .' Ignored');
            }
        }
    }
} 