<?php
/**
 * Zend Framework Library for Amazon Alexa Skills
 *
 * @author     Ralf Eggert <ralf@travello.audio>
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/travello-gmbh/amazon-alexa-skill-zf
 * @link       https://www.travello.audio/
 *
 */

namespace TravelloAlexaZf\Intent;

use Interop\Container\ContainerInterface;
use TravelloAlexaLibrary\Configuration\SkillConfiguration;
use TravelloAlexaLibrary\Configuration\SkillConfigurationInterface;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class IntentManagerFactory
 *
 * @package TravelloAlexaZf\Intent
 */
class IntentManagerFactory implements FactoryInterface
{
    /**
     * @var string
     */
    protected $configKey = null;

    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return IntentManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var SkillConfigurationInterface $skillConfiguration */
        $skillConfiguration = $container->get(SkillConfiguration::class);

        $intentConfig = $skillConfiguration->getIntents();

        $manager = new IntentManager($container);

        if (!empty($intentConfig)) {
            (new Config($intentConfig))->configureServiceManager($manager);
        }

        return $manager;
    }
}
