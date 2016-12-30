<?php

namespace Dao;
use PDO;
use Models\Constants;


class TaskDao {
    
    private $dsn = 'mysql:dbname=queue;host=127.0.0.1';
    private $user = 'root';
    private $password = 'champ';
    
    
    public function addTask($funcId,$param) {
        try {
            $db = new PDO($this->dsn,$this->user,$this->password);
            $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 
            $insertQuery = "insert into Task (func_id,param,activityTime) values (:func_id,:param,NOW())";
            $insertPrepQuery = $db->prepare($insertQuery);
            $insertPrepQuery->bindValue(":func_id",$funcId,PDO::PARAM_INT);
            $insertPrepQuery->bindValue(":param",$param,PDO::PARAM_STR);
            $insertPrepQuery->execute();
            $id = $db->lastInsertId();
        } catch(\PDOException $ex) {
            //catch Excepiton
            echo $ex->getMessage();die;
        }
        return $id;
    }
    
    public function updateTaskState($taskId,$state) {
        try{
            $db = new PDO($this->dsn,$this->user,$this->password);
            $updateQuery = "update Task set processingState = :processingState where task_id = :taskId";
            $updatePrepQuery = $db->prepare($updateQuery);
            $updatePrepQuery->bindValue(":processingState",$state,PDO::PARAM_INT);
            $updatePrepQuery->bindValue(":taskId",$taskId,PDO::PARAM_INT);
            $updatePrepQuery->execute();
            $rowCount = $updatePrepQuery->rowCount();
        } catch (Exception $ex) {
            //catch Exception
        }
        return $rowCount;
    }
    
    public function fetchTask() {
        try {
            $db = new PDO($this->dsn,$this->user,$this->password);
            $fetchTask = "select task_id,func_id,param from Task where processingState = :processingState order by task_id asc limit 1";
            $fetchTaskPrep = $db->prepare($fetchTask);
            $fetchTaskPrep->bindValue(":processingState",  Constants::PROCESS_UNPROCESSED,PDO::PARAM_INT);
            $fetchTaskPrep->execute();
            $taskData = $fetchTaskPrep->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            //catch Exception
        }
        return $taskData;
    }
}

