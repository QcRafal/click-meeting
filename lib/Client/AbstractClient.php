<?php

namespace ClickMeeting\Client;

/**
 * Class AbstractClient
 *
 * @package ClickMeeting\Client
 */
abstract class AbstractClient implements ClientInterface
{
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
     *
     * @throws \Exception
     * @return string|array
     */
    abstract protected function sendRequest(
        $method,
        $path,
        array $params = [],
        $formatResponse = true,
        $isUploadFile = false
    );

    protected function isFormatValid($format)
    {
        return in_array($format, self::$formats, true);
    }

    public function getConferences($status = 'active', $page = 1)
    {
        return $this->sendRequest(
            'GET',
            sprintf('conferences/%s?page=%s', $status, $page)
        );
    }

    public function getConference($conferenceRoomId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('conferences/%s', $conferenceRoomId)
        );
    }

    public function addConference(array $params)
    {
        return $this->sendRequest(
            'POST',
            'conferences',
            $params
        );
    }

    public function editConference($conferenceRoomId, array $params)
    {
        return $this->sendRequest(
            'PUT',
            sprintf('conferences/%s', $conferenceRoomId),
            $params
        );
    }

    public function deleteConference($conferenceRoomId)
    {
        return $this->sendRequest('DELETE', sprintf('conferences/%s', $conferenceRoomId));
    }

    public function createAutologinUrl($conferenceRoomId, array $params)
    {
        return $this->sendRequest(
            'POST',
            sprintf('conferences/%s/room/autologin_hash', $conferenceRoomId),
            $params
        );
    }

    public function sendEmailInvitations($conferenceRoomId, array $params, $lang = 'en')
    {
        return $this->sendRequest(
            'POST',
            sprintf('conferences/%s/invitation/email/%s', $conferenceRoomId, $lang),
            $params
        );
    }

    public function getConferenceSkins()
    {
        return $this->sendRequest(
            'GET',
            'conferences/skins'
        );
    }

    public function createTokens($conferenceRoomId, array $params)
    {
        return $this->sendRequest(
            'POST',
            sprintf('conferences/%s/tokens', $conferenceRoomId),
            $params
        );
    }

    public function getTokens($conferenceRoomId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('conferences/%s/tokens', $conferenceRoomId)
        );
    }

    public function getSessions($conferenceRoomId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('conferences/%s/sessions', $conferenceRoomId)
        );
    }

    public function getSession($conferenceRoomId, $sessionId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('conferences/%s/sessions/%s', $conferenceRoomId, $sessionId)
        );
    }

    public function getSessionAttendees($conferenceRoomId, $sessionId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('conferences/%s/sessions/%s/attendees', $conferenceRoomId, $sessionId)
        );
    }

    public function createSessionPDF($conferenceRoomId, $sessionId, $lang = 'en')
    {
        return $this->sendRequest(
            'GET',
            sprintf('conferences/%s/sessions/%s/generate-pdf/%s', $conferenceRoomId, $sessionId, $lang)
        );
    }

    public function addContact(array $params)
    {
        return $this->sendRequest(
            'POST',
            'contacts',
            $params
        );
    }

    public function getTimeZoneList()
    {
        return $this->sendRequest(
            'GET',
            'time_zone_list'
        );
    }

    public function getTimeZoneListByCountry($country)
    {
        return $this->sendRequest(
            'GET',
            sprintf('time_zone_list/$d', $country)
        );
    }

    public function getPhoneGatewayList()
    {
        return $this->sendRequest(
            'GET',
            'phone_gateways'
        );
    }

    public function addRegistration($conferenceRoomId, array $params)
    {
        return $this->sendRequest(
            'POST',
            sprintf('conferences/%s/registration', $conferenceRoomId),
            $params
        );
    }

    public function getRegistrations($conferenceRoomId, $status = 'all')
    {
        return $this->sendRequest(
            'GET',
            sprintf('conferences/%s/registrations/%s', $conferenceRoomId, $status)
        );
    }

    public function getSessionRegistrations($conferenceRoomId, $sessionId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('conferences/%s/sessions/%s/registrations', $conferenceRoomId, $sessionId)
        );
    }

    public function getFiles()
    {
        return $this->sendRequest(
            'GET',
            'file-library'
        );
    }

    public function getFilesByConference($conferenceRoomId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('file-library/conferences/%s', $conferenceRoomId)
        );
    }

    public function getFile($fileId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('file-library/%s', $fileId)
        );
    }

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

    public function getFileContent($fileId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('file-library/%s/download', $fileId)
        );
    }

    public function deleteFile($fileId)
    {
        return $this->sendRequest(
            'DELETE',
            sprintf('file-library/%s', $fileId)
        );
    }

    public function getRecordings($conferenceRoomId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('conferences/%s/recordings', $conferenceRoomId)
        );
    }

    public function deleteRecordings($conferenceRoomId)
    {
        return $this->sendRequest(
            'DELETE',
            sprintf('conferences/%s/recordings', $conferenceRoomId)
        );
    }

    public function deleteRecording($conferenceRoomId, $recordingId)
    {
        return $this->sendRequest(
            'DELETE',
            sprintf('conferences/%s/recordings/%s', $conferenceRoomId, $recordingId)
        );
    }

    public function getChats()
    {
        return $this->sendRequest(
            'GET',
            'chats'
        );
    }

    public function getChatsBySession($sessionId)
    {
        return $this->sendRequest(
            'GET',
            sprintf('chats/%s', $sessionId)
        );
    }

    public function ping()
    {
        return $this->sendRequest(
            'GET',
            'ping'
        );
    }
}
