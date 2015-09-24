<?php
/**
 * Created by PhpStorm.
 * User: Donatas
 * Date: 15.9.18
 * Time: 13.46
 */

namespace AppBundle\Service;


use Psr\Log\InvalidArgumentException;
use Symfony\Component\HttpKernel\Kernel;

class ConfigService
{
    private $config;

    /**
     * @param Kernel $kernel
     * @param string $configFileLocation
     *
     * @throws \Exception
     */
    public function __construct(Kernel $kernel, $configFileLocation)
    {
        $config_file = $kernel->locateResource($configFileLocation);
        $this->config = json_decode(file_get_contents($config_file));
    }

    /**
     * @return \stdClass
     */
    public function getRules()
    {
        return $this->config->appliedRules;
    }
} 