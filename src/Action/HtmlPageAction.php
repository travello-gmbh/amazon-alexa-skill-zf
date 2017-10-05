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

namespace TravelloAlexaZf\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router\RouteResult;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class HtmlPageAction
 *
 * @package TravelloAlexaZf\Action
 */
class HtmlPageAction implements ServerMiddlewareInterface
{
    /** @var  TemplateRendererInterface */
    private $template;

    /**
     * HtmlPageAction constructor.
     *
     * @param TemplateRendererInterface $template
     */
    public function __construct(TemplateRendererInterface $template)
    {
        $this->template = $template;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return mixed
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        /** @var RouteResult $routeResult */
        $routeResult = $request->getAttribute(RouteResult::class);

        $template = $routeResult->getMatchedParams()['template'];

        return new HtmlResponse(
            $this->template->render($template, [])
        );
    }
}
