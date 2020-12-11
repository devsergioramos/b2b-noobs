<?php
class Category{

    private $conn;

    private $table = "categories";

    public $id;
    public $reference;
    public $name;
    public $createdAt; 
    public $updatedAt;

    public function __construct($conn){
        $this->conn = $conn;
    }
    //C
    public function create(){}
    //R
    public function read(){}
    //U
    public function update(){}
    //D
    public function delete(){}    
}