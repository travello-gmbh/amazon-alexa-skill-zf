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
use TravelloAlexaLibrary\Intent\AbstractIntent;
use TravelloAlexaLibrary\Intent\IntentInterface;
use TravelloAlexaLibrary\Request\AlexaRequest;
use TravelloAlexaLibrary\Response\AlexaResponse;
use TravelloAlexaLibrary\TextHelper\TextHelper;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class AbstractIntentFactory
 *
 * @package TravelloAlexaZf\Intent
 */
class AbstractIntentFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return IntentInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var SkillConfiguration $skillConfiguration */
        $skillConfiguration = $container->get(SkillConfiguration::class);

        /** @var AlexaRequest $alexaRequest */
        $alexaRequest = $container->get(AlexaRequest::class);

        /** @var AlexaResponse $alexaResponse */
        $alexaResponse = $container->get(AlexaResponse::class);

        /** @var TextHelper $textHelper */
        $textHelper = $container->get($skillConfiguration->getTextHelperClass());

        /** @var AbstractIntent $intent */
        $intent = new $requestedName($alexaRequest, $alexaResponse, $textHelper, $skillConfiguration);

        return $intent;
    }
}
