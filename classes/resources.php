<?php

class Resources {
    private $bookid; // int
    private $bookno; //int
    private $isbn; // string
    private $title; // string
    private $author; // string
    private $publisher; // string
    private $type;
    private $status; // string
    private $rcost; // double
    private $ecost; // double
    private $startdate; //date
    private $enddate; //date
    private $extenddate; //date

    function __construct(
        $bookid,
        $bookno,
        $isbn,
        $title,
        $author,
        $publisher,
        $type,
        $status,
        $rcost,
        $ecost,
        $startdate,
        $enddate,
        $extenddate
    ) {
    $this->bookid = $bookid;
    $this->bookno = $bookno;
    $this->isbn = $isbn;
    $this->title = $title;
    $this->author = $author;
    $this->publisher = $publisher;
    $this->type = $type;
    $this->status = $status;
    $this->rcost = $rcost;
    $this->ecost = $ecost;
    $this->ecost = $ecost;
    $this->startdate = $startdate;
    $this->enddate = $enddate;
    $this->extenddate = $extenddate;

    }
    
    //dynamic getters and setters
    function __get($name) { return $this->$name; } 
    function __set($name, $value) { $this->$name = $value; }

    public static function init($sql_array) {
        $instance = null;
        try {
            $instance = new self(
            $sql_array['bookid'],
            $sql_array['bookno'],
            $sql_array['isbn'],
            $sql_array['title'],
            $sql_array['author'],
            $sql_array['publisher'],
            $sql_array['type'],
            $sql_array['status'],
            $sql_array['rcost'],
            $sql_array['ecost'],
            $sql_array['startdate'],
            $sql_array['enddate'],
            $sql_array['extenddate']
            );
        }
        catch (Exception $e) {
            $instance = null;
        }
        return $instance;
    }


}

?>