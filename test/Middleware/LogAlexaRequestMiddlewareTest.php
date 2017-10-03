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

namespace TravelloAlexaZfTest\Middleware;

use Fig\Http\Message\RequestMethodInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use TravelloAlexaLibrary\Request\AlexaRequest;
use TravelloAlexaLibrary\Request\RequestType\RequestTypeFactory;
use TravelloAlexaZf\Middleware\LogAlexaRequestMiddleware;

/**
 * Class LogAlexaRequestMiddlewareTest
 *
 * @package TravelloAlexaZfTest\Middleware
 */
class LogAlexaRequestMiddlewareTest extends TestCase
{
    /**
     *
     */
    public function testWithGetRequest()
    {
        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);

        /** @var MethodProphecy $getMethod */
        $getMethod = $request->getMethod();
        $getMethod->shouldBeCalled()->willReturn(
            RequestMethodInterface::METHOD_GET
        );

        /** @var ResponseInterface|ObjectProphecy $response */
        $response = $this->prophesize(ResponseInterface::class)->reveal();

        /** @var DelegateInterface|ObjectProphecy $delegate */
        $delegate = $this->prophesize(DelegateInterface::class);
        $delegate->process($request->reveal())->willReturn($response);

        $middleware = new LogAlexaRequestMiddleware();

        $result = $middleware->process($request->reveal(), $delegate->reveal());

        $this->assertSame($response, $result);
    }

    /**
     *
     */
    public function testWithPostRequest()
    {
        $data = [
            'version' => '1.0',
            'session' => [
                'new'         => true,
                'sessionId'   => 'sessionId',
                'application' => [
                    'applicationId' => 'applicationId',
                ],
                'user'        => [
                    'userId' => 'userId',
                ],
            ],
            'request' => [
                'type'      => 'LaunchRequest',
                'requestId' => 'requestId',
                'timestamp' => '2017-01-27T20:29:59Z',
                'locale'    => 'de-DE',
            ],
        ];

        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);

        /** @var MethodProphecy $getMethod */
        $getMethod = $request->getMethod();
        $getMethod->shouldBeCalled()->willReturn(
            RequestMethodInterface::METHOD_POST
        );

        /** @var MethodProphecy|StreamInterface $getHeaderMethod1 */
        $getHeaderMethod1 = $request->getHeaderLine('signaturecertchainurl');
        $getHeaderMethod1->shouldBeCalled()->willReturn(['foo']);

        /** @var ResponseInterface|ObjectProphecy $response */
        $response = $this->prophesize(ResponseInterface::class)->reveal();

        /** @var DelegateInterface|ObjectProphecy $delegate */
        $delegate = $this->prophesize(DelegateInterface::class);
        $delegate->process($request->reveal())->willReturn($response);

        $middleware = new LogAlexaRequestMiddleware();

        $result = $middleware->process($request->reveal(), $delegate->reveal());

        $this->assertEquals($response, $result);
    }
}
