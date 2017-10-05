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
use TravelloAlexaLibrary\Request\AlexaRequest;

/**
 * Class CheckApplicationMiddleware
 *
 * @package TravelloAlexaZf\Middleware
 */
class CheckApplicationMiddleware implements MiddlewareInterface
{
    /** @var string */
    private $applicationId;

    /** @var AlexaRequest */
    private $alexaRequest;

    /**
     * CheckApplicationMiddleware constructor.
     *
     * @param string       $applicationId
     * @param AlexaRequest $alexaRequest
     */
    public function __construct($applicationId, AlexaRequest $alexaRequest)
    {
        $this->applicationId = $applicationId;
        $this->alexaRequest  = $alexaRequest;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $this->alexaRequest->checkApplication($this->applicationId);

        return $delegate->process($request);
    }
}
