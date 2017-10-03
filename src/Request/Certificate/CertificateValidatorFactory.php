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

namespace TravelloAlexaZf\Request\Certificate;

use Interop\Container\ContainerInterface;
use TravelloAlexaLibrary\Request\AlexaRequest;
use TravelloAlexaLibrary\Request\Certificate\CertificateLoader;
use TravelloAlexaLibrary\Request\Certificate\CertificateValidator;
use TravelloAlexaLibrary\Request\Certificate\CertificateValidatorFactory as TravelloCertificateValidatorFactory;
use Zend\Diactoros\ServerRequestFactory;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class CertificateValidatorFactory
 *
 * @package TravelloAlexaZf\Request\Certificate
 */
class CertificateValidatorFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return CertificateValidator
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $serverRequest = ServerRequestFactory::fromGlobals();

        $certificateValidatorFactory = new TravelloCertificateValidatorFactory();

        $alexaRequest      = $container->get(AlexaRequest::class);
        $certificateLoader = $container->get(CertificateLoader::class);

        $config = $container->get('config');

        $flag = true;

        if (isset($config['travello_alexa'])) {
            if (isset($config['travello_alexa']['validate_signature'])) {
                $flag = $config['travello_alexa']['validate_signature'];
            }
        }

        /** @var CertificateValidator $certificateValidator */
        $certificateValidator = $certificateValidatorFactory->create(
            $serverRequest->getHeader('signaturecertchainurl')[0],
            $serverRequest->getHeader('signature')[0],
            $alexaRequest,
            $certificateLoader,
            $flag
        );

        return $certificateValidator;
    }
}
