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

namespace TravelloAlexaZf\Action;

use Interop\Container\ContainerInterface;
use TravelloAlexaLibrary\Configuration\SkillConfiguration;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class SkillActionFactory
 *
 * @package TravelloAlexaZf\Action
 */
class SkillActionFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null|null    $options
     *
     * @return SkillAction
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): SkillAction
    {
        /** @var SkillConfiguration $skillConfiguration */
        $skillConfiguration = $container->get(SkillConfiguration::class);

        $alexaApplication = $container->get($skillConfiguration->getApplicationClass());

        return new SkillAction($alexaApplication);
    }
}
