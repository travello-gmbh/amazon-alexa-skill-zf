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

namespace TravelloAlexaZf\Application;

use Interop\Container\ContainerInterface;
use TravelloAlexaLibrary\Application\AlexaApplication;
use TravelloAlexaLibrary\Configuration\SkillConfiguration;
use TravelloAlexaLibrary\Request\AlexaRequest;
use TravelloAlexaLibrary\Response\AlexaResponse;
use TravelloAlexaZf\Intent\IntentManager;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class AlexaApplicationFactory
 *
 * @package TravelloAlexaZf\Application
 */
class AlexaApplicationFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null|null    $options
     *
     * @return AlexaApplication
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ): AlexaApplication {
        $alexaRequest       = $container->get(AlexaRequest::class);
        $alexaResponse      = $container->get(AlexaResponse::class);
        $intentManager      = $container->get(IntentManager::class);

        /** @var AlexaApplication $alexaApplication */
        $alexaApplication = new $requestedName(
            $alexaRequest, $alexaResponse, $intentManager
        );

        return $alexaApplication;
    }
}
