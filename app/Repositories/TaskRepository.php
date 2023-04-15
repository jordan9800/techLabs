<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\BaseRepository;

/**
 * Created just to show a small demo of repository pattern
 */
class TaskRepository extends BaseRepository
{
    /**
     * TaskRepository Constructor.
     * 
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        parent::__construct($task);
    }
}