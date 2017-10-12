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
use TravelloAlexaLibrary\TextHelper\TextHelperInterface;

/**
 * Class SetLocaleMiddleware
 *
 * @package TravelloAlexaZf\Middleware
 */
class SetLocaleMiddleware implements MiddlewareInterface
{
    /** @var TextHelperInterface */
    private $textHelper;

    /** @var  AlexaRequest */
    private $alexaRequest;

    /**
     * SetLocaleMiddleware constructor.
     *
     * @param TextHelperInterface $textHelper
     * @param AlexaRequest        $alexaRequest
     */
    public function __construct(TextHelperInterface $textHelper = null, AlexaRequest $alexaRequest = null)
    {
        $this->textHelper   = $textHelper;
        $this->alexaRequest = $alexaRequest;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        if ($this->alexaRequest) {
            $locale = $this->alexaRequest->getRequest()->getLocale();

            $this->textHelper->setLocale($locale);
        }

        return $delegate->process($request);
    }
}
