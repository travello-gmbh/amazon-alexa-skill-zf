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

namespace TravelloAlexaZf;

use TravelloAlexaLibrary\Request\AlexaRequest;
use TravelloAlexaLibrary\Request\Certificate\CertificateLoader;
use TravelloAlexaLibrary\Request\Certificate\CertificateValidator;
use TravelloAlexaLibrary\Request\Certificate\CertificateValidatorFactory as TravelloCertificateValidatorFactory;
use TravelloAlexaLibrary\Response\AlexaResponse;
use TravelloAlexaZf\Middleware\LogAlexaRequestMiddleware;
use TravelloAlexaZf\Middleware\LogAlexaRequestMiddlewareFactory;
use TravelloAlexaZf\Request\AlexaRequestFactory;
use TravelloAlexaZf\Request\Certificate\CertificateLoaderFactory;
use TravelloAlexaZf\Request\Certificate\CertificateValidatorFactory;
use Zend\ServiceManager\Factory\InvokableFactory;

/**
 * Class ConfigProvider
 *
 * @package TravelloAlexaLibrary
 */
class ConfigProvider
{
    /**
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                'factories' => [
                    AlexaRequest::class  => AlexaRequestFactory::class,
                    AlexaResponse::class => InvokableFactory::class,

                    CertificateLoader::class                   => CertificateLoaderFactory::class,
                    TravelloCertificateValidatorFactory::class => InvokableFactory::class,
                    CertificateValidator::class                => CertificateValidatorFactory::class,

                    LogAlexaRequestMiddleware::class => LogAlexaRequestMiddlewareFactory::class,
                ],
            ],
        ];
    }
}
