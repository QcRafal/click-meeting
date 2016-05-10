<?php

namespace ClickMeeting\Client;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

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

    /**
     * GuzzleClient constructor.
     *
     * @param string               $apiKey
     * @param string               $url
     * @param string               $format
     * @param ClientInterface|null $client
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($apiKey, $url = null, $format = 'json', ClientInterface $client = null)
    {
        if (!class_exists('GuzzleHttp\Client')) {
            throw new \InvalidArgumentException('require guzzlehttp/guzzle to use this class');
        }

        parent::__construct($apiKey, $url, $format);

        $this->guzzleClient = $client ?: new Client(
            [
                'base_uri' => $this->url,
                'timeout'  => '8.0',
                'headers'  => [
                    'X-Api-Key' => $this->apiKey,
                ],
                'debug'    => true,
            ]
        );
    }

    /**
     * @param ClientInterface $guzzleClient
     */
    public function setGuzzleClient(ClientInterface $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @return array
     */
    public static function getFormats()
    {
        return self::$formats;
    }

    /**
     * @param array $formats
     */
    public static function setFormats($formats)
    {
        self::$formats = $formats;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param string $method
     * @param string $path
     * @param array  $params
     * @param bool   $formatResponse
     * @param bool   $isUploadFile
     *
     * @return mixed|string
     */
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
