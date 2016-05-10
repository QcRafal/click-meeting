<?php

namespace ClickMeeting\Client;

/**
 * Class AbstractClient
 *
 * @package ClickMeeting\Client
 */
abstract class AbstractClient implements ClientInterface
{
    /**
     *
     */
    const CLICK_MEETING_API_URL = 'https://api.clickmeeting.com/v1/';
    /**
     * @var string
     */
    protected $url;
    /**
     * @var string
     */
    protected $apiKey;
    /**
     * @var string
     */
    protected $format;
    /**
     * @var array
     */
    protected static $formats = ['json', 'xml', 'js', 'printr'];

    /**
     * AbstractClient constructor.
     *
     * @param string $apiKey
     * @param string $url
     * @param string $format
     */
    public function __construct($apiKey, $url = null, $format = 'json')
    {
        $this->url = $url ?: self::CLICK_MEETING_API_URL;
        $this->apiKey = $apiKey;

        if ($this->isFormatValid($format)) {
            $this->format = $format;
        }
    }

    /**
     * @param string $method
     * @param string $path
     * @param array  $params
     * @param bool   $formatResponse
     * @param bool   $isUploadFile
     *
     * @return string|array
     */
    abstract protected function sendRequest(
        $method,
        $path,
        array $params = [],
        $formatResponse = true,
        $isUploadFile = false
    );

    /**
     * @param $format
     *
     * @return bool
     */
    protected function isFormatValid($format)
    {
        return in_array($format, self::$formats, true);
    }

    /**
     * @param string $status
     * @param int    $page
     *
     * @return array|string
     */
    public function getConferences($status = 'active', $page = 1)
    {
        return $this->sendRequest(
            'GET',
            sprintf('conferences/%s?page=%s', $status, $page)
        );
    }

    /**
     * @param int $conferenceRoomId
     *
     * @return array|string
     */
    public function getConference($conferenceRoomId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('conferences/%s', $conferenceRoomId)
        );
    }

    /**
     * @param array $params
     *
     * @return array|string
     */
    public function addConference(array $params)
    {
        return $this->sendRequest(
            'POST',
            'conferences',
            $params
        );
    }

    /**
     * @param int   $conferenceRoomId
     * @param array $params
     *
     * @return array|string
     */
    public function editConference($conferenceRoomId, array $params)
    {
        return $this->sendRequest(
            'PUT',
            sprintf('conferences/%s', $conferenceRoomId),
            $params
        );
    }

    /**
     * @param int $conferenceRoomId
     *
     * @return array|string
     */
    public function deleteConference($conferenceRoomId)
    {
        return $this->sendRequest('DELETE', sprintf('conferences/%s', $conferenceRoomId));
    }

    /**
     * @param int   $conferenceRoomId
     * @param array $params
     *
     * @return array|string
     */
    public function createAutologinUrl($conferenceRoomId, array $params)
    {
        return $this->sendRequest(
            'POST',
            sprintf('conferences/%s/room/autologin_hash', $conferenceRoomId),
            $params
        );
    }

    /**
     * @param int    $conferenceRoomId
     * @param array  $params
     * @param string $lang
     *
     * @return array|string
     */
    public function sendEmailInvitations($conferenceRoomId, array $params, $lang = 'en')
    {
        return $this->sendRequest(
            'POST',
            sprintf('conferences/%s/invitation/email/%s', $conferenceRoomId, $lang),
            $params
        );
    }

    /**
     * @return array|string
     */
    public function getConferenceSkins()
    {
        return $this->sendRequest(
            'GET',
            'conferences/skins'
        );
    }

    /**
     * @param int   $conferenceRoomId
     * @param array $params
     *
     * @return array|string
     */
    public function createTokens($conferenceRoomId, array $params)
    {
        return $this->sendRequest(
            'POST',
            sprintf('conferences/%s/tokens', $conferenceRoomId),
            $params
        );
    }

    /**
     * @param int $conferenceRoomId
     *
     * @return array|string
     */
    public function getTokens($conferenceRoomId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('conferences/%s/tokens', $conferenceRoomId)
        );
    }

    /**
     * @param int $conferenceRoomId
     *
     * @return array|string
     */
    public function getSessions($conferenceRoomId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('conferences/%s/sessions', $conferenceRoomId)
        );
    }

    /**
     * @param int $conferenceRoomId
     * @param int $sessionId
     *
     * @return array|string
     */
    public function getSession($conferenceRoomId, $sessionId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('conferences/%s/sessions/%s', $conferenceRoomId, $sessionId)
        );
    }

    /**
     * @param int $conferenceRoomId
     * @param int $sessionId
     *
     * @return array|string
     */
    public function getSessionAttendees($conferenceRoomId, $sessionId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('conferences/%s/sessions/%s/attendees', $conferenceRoomId, $sessionId)
        );
    }

    /**
     * @param int    $conferenceRoomId
     * @param int    $sessionId
     * @param string $lang
     *
     * @return array|string
     */
    public function createSessionPDF($conferenceRoomId, $sessionId, $lang = 'en')
    {
        return $this->sendRequest(
            'GET',
            sprintf('conferences/%s/sessions/%s/generate-pdf/%s', $conferenceRoomId, $sessionId, $lang)
        );
    }

    /**
     * @param array $params
     *
     * @return array|string
     */
    public function addContact(array $params)
    {
        return $this->sendRequest(
            'POST',
            'contacts',
            $params
        );
    }

    /**
     * @return array|string
     */
    public function getTimeZoneList()
    {
        return $this->sendRequest(
            'GET',
            'time_zone_list'
        );
    }

    /**
     * @param $country
     *
     * @return array|string
     */
    public function getTimeZoneListByCountry($country)
    {
        return $this->sendRequest(
            'GET',
            sprintf('time_zone_list/$d', $country)
        );
    }

    /**
     * @return array|string
     */
    public function getPhoneGatewayList()
    {
        return $this->sendRequest(
            'GET',
            'phone_gateways'
        );
    }

    /**
     * @param int   $conferenceRoomId
     * @param array $params
     *
     * @return array|string
     */
    public function addRegistration($conferenceRoomId, array $params)
    {
        return $this->sendRequest(
            'POST',
            sprintf('conferences/%s/registration', $conferenceRoomId),
            $params
        );
    }

    /**
     * @param int    $conferenceRoomId
     * @param string $status
     *
     * @return array|string
     */
    public function getRegistrations($conferenceRoomId, $status = 'all')
    {
        return $this->sendRequest(
            'GET',
            sprintf('conferences/%s/registrations/%s', $conferenceRoomId, $status)
        );
    }

    /**
     * @param int $conferenceRoomId
     * @param int $sessionId
     *
     * @return array|string
     */
    public function getSessionRegistrations($conferenceRoomId, $sessionId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('conferences/%s/sessions/%s/registrations', $conferenceRoomId, $sessionId)
        );
    }

    /**
     * @return array|string
     */
    public function getFiles()
    {
        return $this->sendRequest(
            'GET',
            'file-library'
        );
    }

    /**
     * @param int $conferenceRoomId
     *
     * @return array|string
     */
    public function getFilesByConference($conferenceRoomId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('file-library/conferences/%s', $conferenceRoomId)
        );
    }

    /**
     * @param $fileId
     *
     * @return array|string
     */
    public function getFile($fileId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('file-library/%s', $fileId)
        );
    }

    /**
     * @param $filePath
     *
     * @return array|string
     */
    public function addFile($filePath)
    {
        return $this->sendRequest(
            'POST',
            'file-library',
            ['uploaded' => '@'.$filePath],
            true,
            true
        );
    }

    /**
     * @param $fileId
     *
     * @return array|string
     */
    public function getFileContent($fileId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('file-library/%s/download', $fileId)
        );
    }

    /**
     * @param $fileId
     *
     * @return array|string
     */
    public function deleteFile($fileId)
    {
        return $this->sendRequest(
            'DELETE',
            sprintf('file-library/%s', $fileId)
        );
    }

    /**
     * @param int $conferenceRoomId
     *
     * @return array|string
     */
    public function getRecordings($conferenceRoomId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('conferences/%s/recordings', $conferenceRoomId)
        );
    }

    /**
     * @param int $conferenceRoomId
     *
     * @return array|string
     */
    public function deleteRecordings($conferenceRoomId)
    {
        return $this->sendRequest(
            'DELETE',
            sprintf('conferences/%s/recordings', $conferenceRoomId)
        );
    }

    /**
     * @param int $conferenceRoomId
     * @param     $recordingId
     *
     * @return array|string
     */
    public function deleteRecording($conferenceRoomId, $recordingId)
    {
        return $this->sendRequest(
            'DELETE',
            sprintf('conferences/%s/recordings/%s', $conferenceRoomId, $recordingId)
        );
    }

    /**
     * @return array|string
     */
    public function getChats()
    {
        return $this->sendRequest(
            'GET',
            'chats'
        );
    }

    /**
     * @param int $sessionId
     *
     * @return array|string
     */
    public function getChatsBySession($sessionId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('chats/%s', $sessionId)
        );
    }

    /**
     * @return array|string
     */
    public function ping()
    {
        return $this->sendRequest(
            'GET',
            'ping'
        );
    }
}
