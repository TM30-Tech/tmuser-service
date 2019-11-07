<?php

namespace TM30\TmUser;


class TmUser {

    protected $guzzleService;
    protected $client_id;
    protected $client_secret;
    protected $base_url;

    public function __construct()
    {
        $this->guzzleService = new GuzzleService();
        $this->client_id = config('tmuserservice.tmuser.client_id');
        $this->client_secret = config('tmuserservice.tmuser.client_secret');
        $this->base_url = config('tmuserservice.tmuser.base_url');
    }

    public static function make() {
        return new static;
    }

    public function getClientHeader($default = null, $authorisation = null) {
        return [
            'Accept' => 'application/json',
            'client_id' => is_null($default) ? $this->client_id : 'default',
            'client_secret' => is_null($default) ? $this->client_secret : 'default',
            'Authorization' => is_null($authorisation) ? '' : 'Bearer '. $authorisation
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
    public function createPassword() {
        $url = $this->base_url.'/auths/password/create';
        $data = [

        ];
        $authorisation = '';
        return $this->guzzleService->postRequest($url, $data, $this->getClientHeader(null, $authorisation));
    }
    
    public function login() {
        $url = $this->base_url.'/auths/login';
        $data = [

        ];

        return $this->guzzleService->postRequest($url, $data , $this->getClientHeader('true'));
    }

    public function resetPassword() {
        $url = $this->base_url.'/auths/reset/password';
        $params = [

        ];
        return $this->guzzleService->getRequest($url, $params);
    }

    public function user() {
        $url = $this->base_url.'/auths/me';
        $params = [

        ];
        $userToken = '';
        return $this->guzzleService->getRequest($url, $params, $this->getClientHeader('true', $userToken));
    }

    public function refreshToken() {
        $url = $this->base_url.'/auths/token/refresh';
        $data = [

        ];
        $userToken = '';
        return $this->guzzleService->postRequest($url, $data, $this->getClientHeader('true', $userToken));
    }

    public function sendVerificationEmail() {
        $url = $this->base_url.'/auths/verification/email/resend';
        $params = [

        ];
        $userToken = '';
        return $this->guzzleService->getRequest($url, $params, $this->getClientHeader(null, $userToken));
      
    }


    /***
     * Users
     */
    public function create() {
        $url = $url = $this->base_url.'/create';
        $data = [

        ];
        return $this->guzzleService->postRequest($url, $data, $this->getClientHeader());
    }

    public function updateUser() {
        $user_id = '';
        $url = $this->base_url.'/users/'.$user_id;
        $data = [

        ];
        return $this->guzzleService->putRequest($url, $data);
        
    }

    public function fetchAllUsers($authorisation) {
        $authorisation = '';
        $url = $this->base_url.'/users';
        $params = [

        ];
        
        return $this->guzzleService->getRequest($url, $params,  $this->getClientHeader(null, $authorisation));
    }

    public function findUser(){
        $user_id = '';
        $url = $this->base_url.'/users/'.$user_id;
        $params = [

        ];
        return $this->guzzleService->getRequest($url, $params);
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