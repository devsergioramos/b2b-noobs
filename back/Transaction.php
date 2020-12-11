<?php
class Transaction{

    // Connection instance
    private $connection;

    // table name
    private $table_name = "Transaction";

    // table columns
    public $id;
    public $comment;
    public $price;
    public $quantity;
    public $reason;
    public $createdAt; 
    public $updatedAt;
    public $product_id;

    public function __construct($connection){
        $this->connection = $connection;
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