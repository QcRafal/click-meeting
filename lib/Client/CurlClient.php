<?php

namespace ClickMeeting\Client;

/**
 * Class CurlClient
 *
 * @package ClickMeeting\Client
 */
class CurlClient extends AbstractClient
{
    protected $curlOptions = [
        CURLOPT_CONNECTTIMEOUT => 8,
        CURLOPT_TIMEOUT        => 8,
    ];

    protected function sendRequest(
        $method,
        $path,
        array $params = [],
        $formatResponse = true,
        $isUploadFile = false
    ) {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, sprintf('%s.%s', $this->url.$path, $this->format));
        $headers = ['X-Api-Key:'.$this->apiKey];

        if (true === $isUploadFile) {
            $headers[] = 'Content-type: multipart/form-data';
        }

        switch ($method) {
            case 'GET':
                curl_setopt($curl, CURLOPT_HTTPGET, true);
                break;
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, true);
                $headers[] = 'Expect:';
                break;
            case 'PUT':
                if (0 === count($params)) {
                    $headers[] = 'Content-Length: 0';
                }
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
                break;
            default:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        if (!in_array($method, ['GET', 'DELETE'], true) && 0 !== count($params)) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $isUploadFile ? $params : http_build_query($params));
        }

        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt_array($curl, $this->curlOptions);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (!in_array($httpCode, [200, 201], true)) {
            throw $this->createResponseException($response, $httpCode);
        }

        if (0 !== curl_errno($curl)) {
            throw $this->createCurlException($curl);
        }

        curl_close($curl);

        if ('json' === $this->format && true === $formatResponse) {
            $response = json_decode($response);
        }

        return $response;
    }

    protected function createResponseException($response, $httpCode)
    {
        return new \Exception($response, $httpCode);
    }

    protected function createCurlException($curl)
    {
        return new \Exception('Unable to connect to '.$this->url.' Error: '.curl_error($curl));
    }
}
