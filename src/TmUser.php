<?php

namespace TM30\TmUser;


class TmUser {

    protected $guzzleService;
    protected $client_id;
    protected $client_secret;
    protected $base_url;
    protected $token;

    public function __construct()
    {
        $this->guzzleService = new GuzzleService();
        $this->client_id = config('tmuserservice.tmuser.client_id');
        $this->client_secret = config('tmuserservice.tmuser.client_secret');
        $this->base_url = config('tmuserservice.tmuser.base_url');
        $this->token = request()->bearerToken() ?? '';
    }

    public static function make() {
        return new static;
    }

    public function getClientHeader() {
        return [
            'Accept' => 'application/json',
            'client_id' => $this->client_id ?? '',
            'client_secret' => $this->client_secret ?? '',
            'Authorization' => ($this->token) ? 'Bearer '. $this->token : ''
        ];
    }

    /***
     * Audits
     */
    public function audits() {
        $url = $this->base_url.'/audits';
        $data = [

        ];
        return $this->guzzleService->postRequest($url, $data);
    }

    public function updateAudit() {
        $url = $this->base_url.'/audits';
        $data = [

        ];
        return $this->guzzleService->postRequest($url, $data);
    }

    /**
     * Authetication
     *
     * @return void
     */
    public function createPassword($payload) {
        $url = $this->base_url.'/auths/password/create';
        return $this->guzzleService->postRequest($url, $payload, $this->getClientHeader());
    }
    
    public function login(array $payload) {
        $url = $this->base_url.'/auths/login';
        return $this->guzzleService->postRequest($url, $payload , $this->getClientHeader());
    }

    public function resetPassword($params) {
        $url = $this->base_url.'/auths/reset/password';
        return $this->guzzleService->getRequest($url, $params);
    }

    public function user() {
        $url = $this->base_url.'/auths/me';
        return $this->guzzleService->getRequest($url, [], $this->getClientHeader());
    }

    public function refreshToken($data = []) {
        $url = $this->base_url.'/auths/token/refresh';
        return $this->guzzleService->postRequest($url, $data, $this->getClientHeader());
    }

    public function sendVerificationEmail($params) {
        $url = $this->base_url.'/auths/verification/email/resend';
        return $this->guzzleService->getRequest($url, $params, $this->getClientHeader());
    }


    /***
     * Users
     */
    public function create(array $payload) {
        $url = $url = $this->base_url.'/users';
        return $this->guzzleService->postRequest($url, $payload, $this->getClientHeader());
    }

    public function updateUser(array $payload) {
        $user_id = $payload['user_id'];
        $url = $this->base_url.'/users/'.$user_id;
        return $this->guzzleService->putRequest($url, $payload, $this->getClientHeader());
    }

    public function fetchAllUsers($params = []) {
        $url = $this->base_url.'/users';
        
        return $this->guzzleService->getRequest($url, $params,  $this->getClientHeader());
    }

    public function findUser($payload){
        $user_id = $payload['user_id'];
        $url = $this->base_url.'/users/'.$user_id;
        return $this->guzzleService->getRequest($url, $payload, $this->getClientHeader());
    }

    public function createRole() {
        $url = $this->base_url.'/roles/create';
        $data = [

        ];
        return $this->guzzleService->postRequest($url, $data);
    }

    public function getRoles() {
        $url = $this->base_url.'/roles';
        $params = [

        ];
        return $this->guzzleService->getRequest($url, $params);
    }
}
