<?php

class config {
    private $hostName = "localhost";
    private $userName = "root";
    private $password = "";
    private $databaseName = "real_project";
    private $connected;

    public function __construct() {
        $this->connected = new mysqli($this->hostName, $this->userName, $this->password, $this->databaseName);

        // if($this->connected->connect_error){
        //     die("Connected failed: " . $this->connected->connect_error);
        // }
        // echo "Connected Successfully";
    }
    
    //insert - update - delete
    public function runDML(string $query) : bool{
        $result = $this->connected->query($query);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    //selects
    public function runDQL(string $query)  {
        $result = $this->connected->query($query);
        if($result->num_rows > 0){
            return $result;
        }else{
            return [];
        }
    }
    
}
// $connection_test = new config;