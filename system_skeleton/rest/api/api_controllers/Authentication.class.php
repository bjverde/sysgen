<?php

namespace api_controllers;

use Tuupola\Middleware\HttpBasicAuthentication;

class Authentication
{
    private $urlChamada = null;
    private $listPath   = array();
    private $listPathIgnore= array();
    private $listUsers     = array();

    public function __construct($urlChamada)
    {
        $this->urlChamada = $urlChamada;
        $this->listPathIgnore[] = $urlChamada.'api';
        $this->listPathIgnore[] = $urlChamada.'sysinfo';
        $this->listUsers['root']= 'teste123';
    }

    public function getUrlbase(){
        return $this->urlChamada;
    }
    public function getArrayPath(){
        $result = array();
        if( empty($this->listPath) ){
            $result[] = $this->getUrlbase().'auth';
        }else{
            $result = $this->listPath;
        }
        return $result;
    }
    public function addPath($path){
        $this->listPath[] = $this->getUrlbase().$path;
    }

    public function getArrayPathIgnore(){
        return $this->listPathIgnore;
    }

    public function addUsers(string $login, string $password){        
        $this->listUsers[$login] = $password;
    }
    public function getListUsers(){
        return $this->listUsers;
    }

    /**
     * Cria um autenticação basica 
     * 
     * https://odan.github.io/slim4-skeleton/security.html
     * https://github.com/tuupola/slim-basic-auth
     * 
     * @return HttpBasicAuthentication
     */
    public function basicAuth(): HttpBasicAuthentication
    {
        return new HttpBasicAuthentication([
             'ignore'=> $this->getArrayPathIgnore()
            ,'path'  => $this->getArrayPath()
            ,"users" => $this->getListUsers()
        ]);
    }
}