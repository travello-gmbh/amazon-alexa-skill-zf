<?php
/**
 * PHP Library for Amazon Alexa Skills
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/travello-gmbh/amazon-alexa-skill-library
 * @link       https://www.travello.de/
 *
 */

namespace TravelloAlexaZf;

use TravelloAlexaLibrary\Request\Certificate\CertificateLoader;
use TravelloAlexaLibrary\Request\Certificate\CertificateValidatorFactory;
use TravelloAlexaZf\Middleware\InjectAlexaRequestMiddleware;
use TravelloAlexaZf\Middleware\InjectAlexaRequestMiddlewareFactory;
use TravelloAlexaZf\Middleware\InjectCertificateValidatorMiddleware;
use TravelloAlexaZf\Middleware\InjectCertificateValidatorMiddlewareFactory;
use TravelloAlexaZf\Request\Certificate\CertificateLoaderFactory;
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
                    CertificateLoader::class =>
                        CertificateLoaderFactory::class,

                    CertificateValidatorFactory::class =>
                        InvokableFactory::class,

                    InjectAlexaRequestMiddleware::class =>
                        InjectAlexaRequestMiddlewareFactory::class,

                    InjectCertificateValidatorMiddleware::class =>
                        InjectCertificateValidatorMiddlewareFactory::class,
                ],
            ],
        ];
    }
}
