<?php
/**
 * Created by PhpStorm.
 * User: Donatas
 * Date: 15.9.18
 * Time: 13.46
 */

namespace AppBundle\Service;


use AppBundle\Entity\Package;
use AppBundle\Entity\Provider;
use AppBundle\Entity\ProviderPackage;
use AppBundle\EntityList\ProviderList;
use Symfony\Component\HttpKernel\Kernel;

class EntityListService
{

    /**
     * @var \Symfony\Component\HttpKernel\Kernel
     */
    private $kernel;

    private $providersDataFileLocation;

    public function __construct(Kernel $kernel, $providersDataFileLocation)
    {
        $this->kernel                       = $kernel;
        $this->providersDataFileLocation    = $providersDataFileLocation;

    }

    /**
     * @return ProviderList
     * @throws \Exception
     */
    public function getProviderList()
    {
        $providerList = new ProviderList();

        $textFileService = new TextFileService($this->kernel, $this->providersDataFileLocation);

        while (($line = $textFileService->next()) !== false) {
            $providerData           = explode(TextFileService::FILE_LINE_DELIMITER, $line);
            $providerName           = trim($providerData[0]);
            $packageSize            = trim($providerData[1]);
            $providerPackagePrice   = trim($providerData[2]);

            $package = new Package($packageSize);

            $providerPackage = new ProviderPackage($package, $providerPackagePrice);

            $provider = new Provider($providerName);

            if (!$providerList->getItem($provider->getName())) {
                $providerList->addItem($provider);
            }

            $providerList->getItem($provider->getName())->getProviderPackageList()->addItem($providerPackage);

        }

        return $providerList;
    }
} 