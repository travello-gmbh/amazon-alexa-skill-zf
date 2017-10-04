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
use TravelloAlexaLibrary\Request\Certificate\CertificateValidator;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ValidateCertificateMiddlewareFactory
 *
 * @package TravelloAlexaZf\Middleware
 */
class ValidateCertificateMiddlewareFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return ValidateCertificateMiddleware
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $certificateValidator = $container->get(CertificateValidator::class);

        return new ValidateCertificateMiddleware($certificateValidator);
    }
}
