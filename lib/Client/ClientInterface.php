<?php

namespace ClickMeeting\Client;

/**
 * Interface ClientInterface
 *
 * @package ClickMeeting\Client
 */
interface ClientInterface
{
    /**
     * List of all conferences
     *
     * @param string $status
     * @param int    $page
     *
     * @return mixed
     */
    public function getConferences($status = 'active', $page = 1);

    /**
     * Single conference object
     *
     * @param integer $conferenceRoomId
     *
     * @return mixed
     */
    public function getConference($conferenceRoomId);

    /**
     * Create conference
     *
     * @param array $params
     *
     * @return mixed
     */
    public function addConference(array $params);

    /**
     * Edit conference
     *
     * @param integer $conferenceRoomId
     * @param array   $params
     *
     * @return mixed
     */
    public function editConference($conferenceRoomId, array $params);

    /**
     * Delete conference
     *
     * @param integer $conferenceRoomId
     *
     * @return mixed
     */
    public function deleteConference($conferenceRoomId);

    /**
     * Create
     *
     * @param integer $conferenceRoomId
     * @param array   $params
     *
     * @return mixed
     */
    public function createAutologinUrl($conferenceRoomId, array $params);

    /**
     * @param integer $conferenceRoomId
     * @param array   $params
     * @param string  $lang
     *
     * @return mixed
     */
    public function sendEmailInvitations($conferenceRoomId, array $params, $lang = 'en');

    /**
     * @return mixed
     */
    public function getConferenceSkins();

    /**
     * @param integer $conferenceRoomId
     * @param array   $params
     *
     * @return mixed
     */
    public function createTokens($conferenceRoomId, array $params);

    /**
     * @param integer $conferenceRoomId
     *
     * @return mixed
     */
    public function getTokens($conferenceRoomId);

    /**
     * @param integer $conferenceRoomId
     *
     * @return mixed
     */
    public function getSessions($conferenceRoomId);

    /**
     * @param integer $conferenceRoomId
     * @param integer $sessionId
     *
     * @return mixed
     */
    public function getSession($conferenceRoomId, $sessionId);

    /**
     * @param integer $conferenceRoomId
     * @param integer $sessionId
     *
     * @return mixed
     */
    public function getSessionAttendees($conferenceRoomId, $sessionId);

    /**
     * @param integer $conferenceRoomId
     * @param integer $sessionId
     * @param string  $lang
     *
     * @return mixed
     */
    public function createSessionPDF($conferenceRoomId, $sessionId, $lang = 'en');

    /**
     * @param array $params
     *
     * @return mixed
     */
    public function addContact(array $params);

    /**
     * @return mixed
     */
    public function getTimeZoneList();

    /**
     * @param $country
     *
     * @return mixed
     */
    public function getTimeZoneListByCountry($country);

    /**
     * @return mixed
     */
    public function getPhoneGatewayList();

    /**
     * @param integer $conferenceRoomId
     * @param array   $params
     *
     * @return mixed
     */
    public function addRegistration($conferenceRoomId, array $params);

    /**
     * @param integer $conferenceRoomId
     * @param string  $status
     *
     * @return mixed
     */
    public function getRegistrations($conferenceRoomId, $status = 'all');

    /**
     * @param integer $conferenceRoomId
     * @param integer $sessionId
     *
     * @return mixed
     */
    public function getSessionRegistrations($conferenceRoomId, $sessionId);

    /**
     * @return mixed
     */
    public function getFiles();

    /**
     * @param integer $conferenceRoomId
     *
     * @return mixed
     */
    public function getFilesByConference($conferenceRoomId);

    /**
     * @param $fileId
     *
     * @return mixed
     */
    public function getFile($fileId);

    /**
     * @param $filePath
     *
     * @return mixed
     */
    public function addFile($filePath);

    /**
     * @param $fileId
     *
     * @return mixed
     */
    public function getFileContent($fileId);

    /**
     * @param $fileId
     *
     * @return mixed
     */
    public function deleteFile($fileId);

    /**
     * @param integer $conferenceRoomId
     *
     * @return mixed
     */
    public function getRecordings($conferenceRoomId);

    /**
     * @param integer $conferenceRoomId
     *
     * @return mixed
     */
    public function deleteRecordings($conferenceRoomId);

    /**
     * @param integer $conferenceRoomId
     * @param         $recordingId
     *
     * @return mixed
     */
    public function deleteRecording($conferenceRoomId, $recordingId);

    /**
     * @return mixed
     */
    public function getChats();

    /**
     * @param integer $sessionId
     *
     * @return mixed
     */
    public function getChatsBySession($sessionId);

    /**
     * @return mixed
     */
    public function ping();
}
