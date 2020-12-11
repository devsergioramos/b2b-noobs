<?php

//classe para conexao com banco de dados

class DBClass {

    private $host = "localhost";
    private $user = "root";
    private $password = "<YOUR_DB_PASSWORD>";
    private $database = "<YOUR_DB_NAME>";

    public $conn;

    public function getConn(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->user, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $e){
            echo "Erro: " . $e->getMessage();
        }

        return $this->conn;
    }
}
?>