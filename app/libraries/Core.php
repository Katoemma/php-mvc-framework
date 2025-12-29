<?php 

/*
 * App Core Class
 * Creates URL & loads core controller
 * URL FORMAT - /controller/method/params
 */

class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
        //print_r($this->getUrl());

        $url = $this->getUrl();


        //look in controllers for the first array value
        if(!empty($url) && file_exists(filename: '../app/controllers/'. ucwords( $url[0]) . '.php')){
            //if exists,make the value, the current controller
            $this->currentController = ucwords( $url[0]);

            //unset 0 index since it is already used/processed, therefore we remove it
            unset($url[0]);
        }

        //require the controller
        require_once '../app/controllers/'. $this->currentController .'.php';

        //instatiate controller class
        $this->currentController = new $this->currentController();

        //check for the second part for URL
        if(isset($url[1])){

            print_r($url);
            
            if(method_exists($this->currentController, $url[1])){
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        // Get params
        $this->params = $url ? array_values($url) : [];

        // call a callback with array of parrams

        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl(){
        if(isset($_GET['url'])){
            $url = rtrim(string: $_GET['url'],characters: '/');
            $url = filter_var(value: $url, filter: FILTER_SANITIZE_URL);
            $url = explode(separator: '/', string: $url);
            return $url;
        }
    }



}