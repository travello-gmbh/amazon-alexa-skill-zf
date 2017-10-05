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
use TravelloAlexaLibrary\TextHelper\TextHelper;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class SetLocaleMiddlewareFactory
 *
 * @package TravelloAlexaZf\Middleware
 */
class SetLocaleMiddlewareFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return SetLocaleMiddleware
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $textHelper   = $container->get(TextHelper::class);
        $alexaRequest = $container->get(AlexaRequest::class);

        return new SetLocaleMiddleware($textHelper, $alexaRequest);
    }
}