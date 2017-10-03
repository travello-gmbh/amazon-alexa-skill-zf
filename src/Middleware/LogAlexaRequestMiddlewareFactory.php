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
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class LogAlexaRequestMiddlewareFactory
 *
 * @package TravelloAlexaZf\Middleware
 */
class LogAlexaRequestMiddlewareFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null|null    $options
     *
     * @return mixed
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');

        $flag = false;

        if (isset($config['travello_alexa'])) {
            if (isset($config['travello_alexa']['log_requests'])) {
                $flag = $config['travello_alexa']['log_requests'];
            }
        }

        return new LogAlexaRequestMiddleware($flag);
    }
}
