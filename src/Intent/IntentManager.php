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

namespace TravelloAlexaZf\Intent;

use TravelloAlexaLibrary\Intent\AudioPlayer\PlaybackFinishedIntent;
use TravelloAlexaLibrary\Intent\AudioPlayer\PlaybackNearlyFinishedIntent;
use TravelloAlexaLibrary\Intent\AudioPlayer\PlaybackStartedIntent;
use TravelloAlexaLibrary\Intent\AudioPlayer\PlaybackStoppedIntent;
use TravelloAlexaLibrary\Intent\CancelIntent;
use TravelloAlexaLibrary\Intent\HelpIntent;
use TravelloAlexaLibrary\Intent\IntentInterface;
use TravelloAlexaLibrary\Intent\LaunchIntent;
use TravelloAlexaLibrary\Intent\StopIntent;
use TravelloAlexaLibrary\Intent\System\ExceptionEncountered;
use TravelloAlexaLibrary\Request\RequestType\LaunchRequestType;
use TravelloAlexaLibrary\Request\RequestType\SessionEndedRequestType;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception\InvalidServiceException;

/**
 * Class IntentManager
 *
 * @package TravelloAlexaZf\Intent
 */
class IntentManager extends AbstractPluginManager
{
    /**
     * @var array
     */
    protected $aliases
        = [
            LaunchRequestType::NAME            => LaunchIntent::class,
            SessionEndedRequestType::NAME      => StopIntent::class,
            HelpIntent::NAME                   => HelpIntent::class,
            StopIntent::NAME                   => StopIntent::class,
            CancelIntent::NAME                 => CancelIntent::class,
            PlaybackFinishedIntent::NAME       => PlaybackFinishedIntent::class,
            PlaybackNearlyFinishedIntent::NAME => PlaybackNearlyFinishedIntent::class,
            PlaybackStartedIntent::NAME        => PlaybackStartedIntent::class,
            PlaybackStoppedIntent::NAME        => PlaybackStoppedIntent::class,
            ExceptionEncountered::NAME         => ExceptionEncountered::class,
        ];

    protected $factories
        = [
            LaunchIntent::class                 => AbstractIntentFactory::class,
            HelpIntent::class                   => AbstractIntentFactory::class,
            StopIntent::class                   => AbstractIntentFactory::class,
            CancelIntent::class                 => AbstractIntentFactory::class,
            PlaybackFinishedIntent::class       => AbstractIntentFactory::class,
            PlaybackNearlyFinishedIntent::class => AbstractIntentFactory::class,
            PlaybackStartedIntent::class        => AbstractIntentFactory::class,
            PlaybackStoppedIntent::class        => AbstractIntentFactory::class,
            ExceptionEncountered::class         => AbstractIntentFactory::class,
        ];

    /**
     * Validate the plugin is of the expected type (v3).
     *
     * Validates against callables and HelperInterface implementations.
     *
     * @param mixed $instance
     *
     * @throws InvalidServiceException
     */
    public function validate($instance)
    {
        if (!is_callable($instance) && !$instance instanceof IntentInterface) {
            throw new InvalidServiceException(
                sprintf(
                    '%s can only create instances of %s and/or callables; %s is invalid',
                    get_class($this),
                    IntentInterface::class,
                    (is_object($instance) ? get_class($instance) : gettype($instance))
                )
            );
        }
    }
}
