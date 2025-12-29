<?php

class Pages{
    public function __construct(){
        
    }

    public function index(){
        echo"This is index Page";
    }

    public function about($id){
        echo"<h1 style='font-size:100px'> this is about page $id</h1>";
    }
}