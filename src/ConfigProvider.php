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

use TravelloAlexaLibrary\Configuration\SkillConfiguration;
use TravelloAlexaLibrary\Request\AlexaRequest;
use TravelloAlexaLibrary\Request\Certificate\CertificateLoader;
use TravelloAlexaLibrary\Request\Certificate\CertificateValidator;
use TravelloAlexaLibrary\Response\AlexaResponse;
use TravelloAlexaLibrary\TextHelper\TextHelper;
use TravelloAlexaZf\Intent\IntentManager;
use TravelloAlexaZf\Intent\IntentManagerFactory;
use TravelloAlexaZf\Middleware\CheckApplicationMiddleware;
use TravelloAlexaZf\Middleware\CheckApplicationMiddlewareFactory;
use TravelloAlexaZf\Middleware\ConfigureSkillMiddleware;
use TravelloAlexaZf\Middleware\ConfigureSkillMiddlewareFactory;
use TravelloAlexaZf\Middleware\LogAlexaRequestMiddleware;
use TravelloAlexaZf\Middleware\LogAlexaRequestMiddlewareFactory;
use TravelloAlexaZf\Middleware\SetLocaleMiddleware;
use TravelloAlexaZf\Middleware\SetLocaleMiddlewareFactory;
use TravelloAlexaZf\Middleware\ValidateCertificateMiddleware;
use TravelloAlexaZf\Middleware\ValidateCertificateMiddlewareFactory;
use TravelloAlexaZf\Request\AlexaRequestFactory;
use TravelloAlexaZf\Request\Certificate\CertificateLoaderFactory;
use TravelloAlexaZf\Request\Certificate\CertificateValidatorFactory;
use TravelloAlexaZf\TextHelper\TextHelperFactory;
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

                    SkillConfiguration::class => InvokableFactory::class,
                    TextHelper::class         => TextHelperFactory::class,
                    IntentManager::class      => IntentManagerFactory::class,

                    CertificateLoader::class    => CertificateLoaderFactory::class,
                    CertificateValidator::class => CertificateValidatorFactory::class,

                    CheckApplicationMiddleware::class    => CheckApplicationMiddlewareFactory::class,
                    ConfigureSkillMiddleware::class      => ConfigureSkillMiddlewareFactory::class,
                    LogAlexaRequestMiddleware::class     => LogAlexaRequestMiddlewareFactory::class,
                    SetLocaleMiddleware::class           => SetLocaleMiddlewareFactory::class,
                    ValidateCertificateMiddleware::class => ValidateCertificateMiddlewareFactory::class,
                ],
            ],
        ];
    }
}
