<?php

use Services\TaskService;
use Validators\TaskDataValidator;

/**
 * This method adds task to the queue
 */
$app->post('/task/add', function() use ($app){
    
    $taskService = new TaskService();
    $taskValidator = new TaskDataValidator();
    
    $funcId = $app->request->post('func_id');
    $param = $app->request->post('param');
    $validatorResponse = $taskValidator->validateAddTaskData($funcId);
    if($validatorResponse === true){
        $response = $taskService->addTask($funcId,$param);
    } else {
        $response = $validatorResponse;
    }
    echo $response;
    
});

/**
 * This method sets task as complete
 */
$app->post('/task/complete', function() use ($app){
    
    $taskService = new TaskService();
    $taskId = $app->request->post('task_id');
    $taskValidator = new TaskDataValidator();
    $validatorResponse = $taskValidator->validateUpdateTaskData($taskId);
    if($validatorResponse === true) {
        $response = $taskService->markTaskComplete($taskId);
    } else {
        $response = $validatorResponse;
    }
    echo $response;
    
});

$app->get('/task/fetch', function() {
   
    $taskService = new TaskService();
    $response = $taskService->fetchAndUpdateTask();
    print_r($response);die;
});