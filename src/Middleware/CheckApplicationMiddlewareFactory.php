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

namespace TravelloAlexaZf\Middleware;

use Interop\Container\ContainerInterface;
use TravelloAlexaLibrary\Request\AlexaRequest;
use TravelloAlexaLibrary\Configuration\SkillConfiguration;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class CheckApplicationMiddlewareFactory
 *
 * @package TravelloAlexaZf\Middleware
 */
class CheckApplicationMiddlewareFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return CheckApplicationMiddleware
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var AlexaRequest $alexaRequest */
        $alexaRequest = $container->get(AlexaRequest::class);

        if ($alexaRequest) {
            /** @var SkillConfiguration $skillConfiguration */
            $skillConfiguration = $container->get(SkillConfiguration::class);

            $applicationId = $skillConfiguration->getApplicationId();
        } else {
            $applicationId = null;
        }

        return new CheckApplicationMiddleware($applicationId, $alexaRequest);
    }
}
