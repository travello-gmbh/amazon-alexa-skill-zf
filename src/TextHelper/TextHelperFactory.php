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

namespace TravelloAlexaZf\TextHelper;

use Interop\Container\ContainerInterface;
use TravelloAlexaLibrary\Configuration\SkillConfiguration;
use TravelloAlexaLibrary\Configuration\SkillConfigurationInterface;
use TravelloAlexaLibrary\TextHelper\TextHelper;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class TextHelperFactory
 *
 * @package TravelloAlexaZf\TextHelper
 */
class TextHelperFactory implements FactoryInterface
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
     * @return TextHelper
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var SkillConfigurationInterface $skillConfiguration */
        $skillConfiguration = $container->get(SkillConfiguration::class);

        $texts = $skillConfiguration->getTexts();

        return new TextHelper($texts);
    }
}
