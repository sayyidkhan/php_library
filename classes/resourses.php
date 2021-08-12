<?php

class Resources {
    private $isbn; // int
    private $book_no; //int
    private $title; // string
    private $author; // string
    private $publisher; // string
    private $status; // string
    private $r_cost; // double
    private $e_cost; // double

    function __construct(
        $isbn,
        $book_no,
        $title,
        $author,
        $publisher,
        $status,
        $r_cost,
        $e_cost
    ) {
    $this->isbn = $isbn;
    $this->book_no = $book_no;
    $this->title = $title;
    $this->author = $author;
    $this->publisher = $publisher;
    $this->status = $status;
    $this->r_cost = $r_cost;
    $this->e_cost = $e_cost;
    }
    
    //dynamic getters and setters
    function __get($name) { return $this->$name; } 
    function __set($name, $value) { $this->$name = $value; }

    public static function init($sql_array) {
        $instance = null;
        try {
            //regular cost
            $rCost = intval($sql_array['r_cost']);
            $rCost = number_format($rCost,2);
            //extended cost
            $eCost = intval($sql_array['e_cost']);
            $eCost = number_format($eCost,2); 

            $instance = new self(
            $sql_array['isbn'],
            $sql_array['book_no'],
            $sql_array['title'],
            $sql_array['author'],
            $sql_array['publisher'],
            $sql_array['status'],
            $rCost,
            $eCost
            );
        }
        catch (Exception $e) {
            $instance = null;
        }
        return $instance;
    }


}

?>