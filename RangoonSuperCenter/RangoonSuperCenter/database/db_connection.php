<?php

class Connection {
    private $host;
    private $dbname;
    private $user;
    private $pass;

    function __construct( $host, $dbname, $user, $pass ) {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->pass = $pass;
    }

    function getConnection() {
        try {
            $pdo = new PDO( "mysql:host=$this->host;dbname=$this->dbname;", $this->user, $this->pass );
            $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            return $pdo;
        } catch( Exception $e ) {
            echo $e->getMessage();
            return null;
        }
    }
}
?>