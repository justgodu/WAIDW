<?php

class Dbh{
    private $servername;
    private $dbusername;
    private $dbpassword;
    private $dbname; 

    
    protected function connect(){
        $this->servername = "127.0.0.1";
        $this->dbusername = "root";
        $this->dbpassword = "";
        $this->dbname = "loginsystem";

        $conn = new mysqli($this->servername, $this->dbusername, $this->dbpassword, $this->dbname)or die("Oops can't connect to database");

        return $conn;
    }

}