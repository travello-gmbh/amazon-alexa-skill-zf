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

use Exception;
use TravelloAlexaLibrary\Application\AlexaApplicationInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use TravelloAlexaLibrary\Request\Exception\BadRequest;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class SkillAction
 *
 * @package TravelloAlexaZf\Action
 */
class SkillAction implements ServerMiddlewareInterface
{
    /** @var AlexaApplicationInterface */
    private $alexaApplication;

    /**
     * SkillAction constructor.
     *
     * @param AlexaApplicationInterface $alexaApplication
     */
    public function __construct(AlexaApplicationInterface $alexaApplication)
    {
        $this->alexaApplication = $alexaApplication;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return mixed
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        try {
            $data = $this->alexaApplication->execute();

            return new JsonResponse($data, 200);
        } catch (BadRequest $e) {
            $data = ['error' => $e->getMessage()];

            return new JsonResponse($data, 400);
        } catch (Exception $e) {
            $data = ['error' => 'unexpected error'];

            return new JsonResponse($data, 400);
        }
    }
}
