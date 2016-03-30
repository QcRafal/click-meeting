<?php

namespace ClickMeeting\Tests\Client;

use ClickMeeting\Client\ClientInterface;
use ClickMeeting\Client\CurlClient;

/**
 * Class CurlClientTest
 *
 * @covers  ClickMeeting\Client\CurlClient
 */
class CurlClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CurlClient
     */
    private $curlClient;

    /**
     *
     */
    public function setUp()
    {
        $this->curlClient = new CurlClient('testApiKey');
    }

    /**
     * It should implement ClientInterface
     */
    public function testInstance()
    {
        static::assertInstanceOf(ClientInterface::class, $this->curlClient);
    }
}
