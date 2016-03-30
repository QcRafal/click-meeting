<?php

namespace ClickMeeting\Client;

use GuzzleHttp\Client as HttpClient;

/**
 * Class GuzzleClient
 *
 * @package ClickMeeting\Client
 */
class GuzzleClient extends AbstractClient
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $guzzleClient;

    public function __construct($apiKey, $url = null, $format = 'json', HttpClient $client = null)
    {
        if (!class_exists('GuzzleHttp\Client')) {
            throw new \Exception('require guzzlehttp/guzzle to use this class');
        }
        parent::__construct($apiKey, $url, $format);

        $this->guzzleClient = $client ?: new HttpClient(
            [
                'base_uri' => $this->url,
                'timeout'  => '8.0',
                'headers'  => [
                    'X-Api-Key' => $this->apiKey,
                ],
            ]
        );
    }

    public function setGuzzleClient(HttpClient $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    protected function sendRequest(
        $method,
        $path,
        array $params = [],
        $formatResponse = true,
        $isUploadFile = false
    ) {

        $response = $this->guzzleClient->request(
            $method,
            $path,
            [
                'body' => $params,
            ]
        );

//        $httpCode = $response->getStatusCode();
//        if (!in_array($httpCode, [200, 201], true)) {
//            throw $this->createResponseException($response, $httpCode);
//        }

        $responseBody = (string) $response->getBody();

        if ('json' === $this->format && true === $formatResponse) {
            $responseBody = json_decode($responseBody);
        }

        return $responseBody;
    }
}
