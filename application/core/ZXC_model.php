<?php

    interface model {
        public function createObject($array);
        public function convertObjectToArray($object);
    }

    interface object {
        public function setID($id);
        public function getID($id);
    }

    class ZXC_model {

        public $database;

        public function __construct() {
            $this->database = new database($this->tableName, $this->columnIDName);
            foreach($this->usingObjects as $object) {
                require_once(APPPATH . "/objects/{$object}" . EXT);
            }
            foreach($this->usingModels as $model) {
                require_once(APPPATH . "/models/{$model}" . EXT);
            }
        }

    }

    class Database {

        protected $con;
        protected $tableName;
        protected $columnIDName;
        
        function __construct($tableName, $columnIDName) {
            $this->con = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);
            $this->tableName    = $tableName;
            $this->columnIDName = $columnIDName;
        }
        
        public function excute($sql) {
            $rows = array();
            $result = mysqli_query($this->con, $sql);
            
            if(!$result) {
                return NULL;
            }
            while($row = mysqli_fetch_array($result)) {
                $rows[] = $row;
            }
            return $rows;
        }
        
        public function find($id) {
            $tableName = $this->tableName;
            $columnIDName = $this->columnIDName;
            $sql = "select * from $tableName where $columnIDName = $id";
            $rows = $this->excute($sql);
            if(is_null($rows)) {
                return NULL;
            }
            return $rows;
        }
        
        public function fetchAll($where = null) {
            $tableName = $this->tableName;
            $objects = array();
            $sql = "SELECT * FROM $tableName";
            if(!empty($where)) {
                $sql .= " where ".$where;
            }
            $rows = $this->excute($sql);
            if (mysqli_connect_errno()) {
                echo("Can't connect to MySQL Server. Error code: " . mysqli_connect_error());
                return null;
            }
            if(!count($rows)) {
                return $objects;
            }
            return $rows;
        }
        
        public function save($object) {
            $data = $this->convertObjectToArray($object);
            if(is_null($data[$this->columnIDName])) {
                $id = $this->insert($data);
            } else {
                $id = $this->update($data);
            }
            return $id;
        }
        
        public function update($data) {
            $id = $data[$this->columnIDName];
            $str = "";
            foreach($data as $key => $value) {
                if(empty($str)) {
                    if(is_null($value)) {
                        $str = $key."= NULL";
                    } else {
                        $str = $key."= '$value'";
                    }
                } else {
                    if(is_null($value)) {
                        $str .= ",".$key." = NULL";
                    } else {
                        $str .= ",".$key." = '$value'";
                    }
                }
            }
            $sql = "UPDATE $this->tableName SET $str WHERE $this->columnIDName = $id";
            mysqli_query($this->con, $sql);
            if (mysqli_connect_errno()) {
                echo("Can't connect to MySQL Server. Error code: " . mysqli_connect_error());
                return null;
            }
            return $id;
        }
        
        public function insert($data) {
            $str = "";
            foreach($data as $value) {
                if(empty($str)) {
                    if(is_null($value)) {
                        $str = "NULL";
                    } else {
                        $str = "'$value'";
                    }
                } else {
                    if(is_null($value)) {
                        $str .= ",NULL";
                    } else {
                        $str .= ","."'$value'";
                    }
                }
            }
            $sql = "INSERT INTO $this->tableName VALUES($str)";
            mysqli_query($this->con, $sql);
            $id = mysqli_insert_id($this->con);
            if (mysqli_connect_errno()) {
                echo("Can't connect to MySQL Server. Error code: " . mysqli_connect_error());
                return null;
            }
            return $id;
        }
    }