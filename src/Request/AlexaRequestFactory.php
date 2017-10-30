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

namespace TravelloAlexaZf\Request;

use Exception;
use Interop\Container\ContainerInterface;
use TravelloAlexaLibrary\Request\AlexaRequest;
use TravelloAlexaLibrary\Request\RequestType\RequestTypeFactory;
use Zend\Diactoros\ServerRequestFactory;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class AlexaRequestFactory
 *
 * @package TravelloAlexaZf\Request
 */
class AlexaRequestFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return AlexaRequest
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $serverRequest = ServerRequestFactory::fromGlobals();

        if (empty($serverRequest->getBody()->getContents())) {
            return null;
        }

        if (!$this->isJson($serverRequest->getBody()->getContents())) {
            return null;
        }

        try {
            /** @var AlexaRequest $alexaRequest */
            $alexaRequest = RequestTypeFactory::createFromData(
                $serverRequest->getBody()->getContents()
            );
        } catch (Exception $e) {
            return null;
        }

        return $alexaRequest;
    }

    /**
     * @param $string
     *
     * @return bool
     */
    private function isJson($string) {
        json_decode($string);

        return (json_last_error() == JSON_ERROR_NONE);
    }
}
