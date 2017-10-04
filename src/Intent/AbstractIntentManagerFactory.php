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
use Zend\ServiceManager\Config;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class IntentManagerFactory
 *
 * @package Hello\Intent
 */
abstract class IntentManagerFactory implements FactoryInterface
{
    protected $configKey = null;

    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return AbstractIntentManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $manager = new $requestedName($container);

        $config = $container->has('config') ? $container->get('config') : [];
        $config = isset($config[$this->configKey]) ? $config[$this->configKey] : [];

        if (!empty($config)) {
            (new Config($config))->configureServiceManager($manager);
        }

        return $manager;
    }
}
