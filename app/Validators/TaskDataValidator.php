<?php

namespace Validators;
use Services\TaskService;

class TaskDataValidator {
    
    public function validateAddTaskData($func_id) {
        if(is_numeric($func_id)) {
            return true;
        } else{
            return 'Invalid Func_Id';
        }
    }
    
    public function validateUpdateTaskData($task_id) {
        if(is_numeric($task_id)) {
            $taskService = new TaskService();
            return true;
        } else {
            return 'Invalid Task_Id';
        }
    }
}

