<?php

namespace Services;
use Dao\TaskDao;
use Models\Constants;

class TaskService {
    
    private $taskDao;
    
    public function __construct() {
        $this->taskDao = new TaskDao();
    }
    
    public function addTask($funcId,$param) {
        $taskId =  $this->taskDao->addTask($funcId,$param);
        if($taskId) {
            return "Task ". $taskId." Added";
        }
    }
    
    public function markTaskComplete($taskId) {
        $updatedRowCount = $this->taskDao->updateTaskState($taskId,  Constants::PROCESS_COMPLETE);
        if($updatedRowCount) {
            return "Task Complete";
        } else {
            return "This Task does not exist or already marked complete";
        }
    }
    
    public function fetchAndUpdateTask() {
        $taskData = $this->taskDao->fetchTask();
        if($taskData == false) {
            $response = array('status' => 'Error', 'msg' =>"Unprocessed task does not exist");
        } else{
            $this->taskDao->updateTaskState($taskData['task_id'], Constants::PROCESS_INPROCESS);
            $response = array('status' => 'OK', 'data' => $taskData, 'msg' => 'task '.$taskData['task_id']." is in processing state");
        }
        return $response;
    }
}

