<?php
/**
 * Created by PhpStorm.
 * User: Donatas
 * Date: 15.9.22
 * Time: 10.38
 */

namespace AppBundle\Rules;


use AppBundle\Entity\Shipment;
use AppBundle\Service\ConfigService;
use Symfony\Component\DependencyInjection\ContainerAware;

class RulesService extends ContainerAware{

    /**
     * @var \AppBundle\Service\ConfigService
     */
    private $configService;

    /**
     * @var array
     */
    private $ruleList = [];

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    /**
     * @return RuleAbstract[]
     */
    public function getRules()
    {
        /** @var RuleAbstract $rule */

        if (empty($this->ruleList)) {
            foreach ($this->configService->getRules() as $ruleName => $options) {
                $ruleClass = '\\'.__NAMESPACE__.'\\'.$ruleName;
                $rule = new $ruleClass($options);
                $rule->setContainer($this->container);
                $this->ruleList[] = $rule;
            }
        }

        return $this->ruleList;
    }

    /**
     * @param Shipment $shipment
     *
     * @return Shipment
     */
    public function applyAllRules(Shipment $shipment){
        /** @var RuleAbstract $rule */
        foreach($this->getRules() as $rule){
            $shipment = $rule->applyRule($shipment);
        }

        return $shipment;
    }
} 