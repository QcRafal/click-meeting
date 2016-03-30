<?php

namespace ClickMeeting\Tests\Client;

use ClickMeeting\Client\ClientInterface;
use ClickMeeting\Client\GuzzleClient;

/**
 * Class GuzzleClient
 *
 * @covers  ClickMeeting\Client\CurlClient
 */
class GuzzleClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GuzzleClient
     */
    private $guzzleClient;

    /**
     *
     */
    public function setUp()
    {
        $this->guzzleClient = new GuzzleClient('testApiKey');
    }

    /**
     * It should implement ClientInterface
     */
    public function testInstance()
    {
        static::assertInstanceOf(ClientInterface::class, $this->guzzleClient);
    }

    public function testGetConferences()
    {
        $conferences = $this->guzzleClient->getConferences();
    }
}
