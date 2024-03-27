<?php
include_once "config.php";

class DB
{
    public $db;
    private $sql = null;
    private $res;

    public function __construct(){
        $db=new mysqli(
            Config::DBHOST,
            Config::DBUSER,
            Config::DBPWD,
            Config::DBNAME);
        if($db->connect_error<>0){
            die($db->connect_error);
        }else{
            $this->db=$db;
        }
    }
    public function setSql($sql){
        $this->sql= $sql;
    }
    private function dbQuery(){
        return $this->db->query($this->sql);
    }

    public function getData(){
        $rows =[];
        if(empty($this->sql)){
            die("请先传入sql");
        }
        $this->res = $this->dbQuery();
        if($this->res){
            while($row = $this->res->fetch_assoc()){
                $rows[] =$row;
            }
            return $rows;
        }
        return $this->res;
    }
    public function dbExec(){
        
        if(empty($this->sql)){
            die("请先传入sql");
        }
        $this->res = $this->dbQuery();
        if($this->res){
            return true;
        }
        return false;
    }
    public function getSql(){
        return $this->sql;
    }
    public function getRes(){
        return $this->res;
    }
}