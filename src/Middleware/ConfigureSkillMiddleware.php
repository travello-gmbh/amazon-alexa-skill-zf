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
use TravelloAlexaLibrary\Configuration\SkillConfiguration;
use Zend\Expressive\Router\RouteResult;

/**
 * Class ConfigureSkillMiddleware
 *
 * @package TravelloAlexaZf\Middleware
 */
class ConfigureSkillMiddleware implements MiddlewareInterface
{
    /** @var array */
    private $config;

    /** @var SkillConfiguration */
    private $skillConfiguration;

    /**
     * ConfigureSkillMiddleware constructor.
     *
     * @param array              $config
     * @param SkillConfiguration $skillConfiguration
     */
    public function __construct(array $config, SkillConfiguration $skillConfiguration)
    {
        $this->config             = $config;
        $this->skillConfiguration = $skillConfiguration;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        /** @var RouteResult $result */
        $result = $request->getAttribute(RouteResult::class);

        $matchedParams = $result->getMatchedParams();

        if (isset($matchedParams['skillName'])) {
            $skillName = $matchedParams['skillName'];

            $this->skillConfiguration->setName($skillName);

            if (isset($this->config['skills'])) {
                $this->skillConfiguration->setConfig($this->config['skills'][$skillName]);
            }
        }

        return $delegate->process($request);
    }
}
