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
                'debug' => true,
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
        $options = [
            'headers' => [],
        ];
        if (true === $isUploadFile) {
            $options['multipart'] = true;
        }

        switch ($method) {
            case 'POST':
                $options['form_params'] = $params;
                break;
            case 'PUT':
                if (0 === count($params)) {
                    $options['headers']['Content-Length'] = 0;
                }
                $options['form_params'] = $params;
                break;
        }

        $response = $this->guzzleClient->request(
            $method,
            $path,
            $options
        );

        $responseBody = (string) $response->getBody();

        if ('json' === $this->format && true === $formatResponse) {
            $responseBody = json_decode($responseBody);
        }

        return $responseBody;
    }
}
