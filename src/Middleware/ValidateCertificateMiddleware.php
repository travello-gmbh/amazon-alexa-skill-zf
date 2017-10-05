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

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TravelloAlexaLibrary\Request\Certificate\CertificateValidator;

/**
 * Class ValidateCertificateMiddleware
 *
 * @package TravelloAlexaZf\Middleware
 */
class ValidateCertificateMiddleware implements MiddlewareInterface
{
    /** @var CertificateValidator */
    private $certificateValidator;

    /**
     * ValidateCertificateMiddleware constructor.
     *
     * @param CertificateValidator $certificateValidator
     */
    public function __construct(CertificateValidator $certificateValidator)
    {
        $this->certificateValidator = $certificateValidator;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $this->certificateValidator->validate();

        return $delegate->process($request);
    }
}
