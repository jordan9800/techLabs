<?php

namespace App\Http\Controllers;

use App\Filters\TaskFilters;
use App\Http\Requests\TaskCreateRequest;
use App\Models\Task;
use App\Repositories\NoteRepository;
use App\Repositories\TaskRepository;
use App\Transformers\TaskTransformer;

class TaskController extends Controller
{
    public $taskTransformer;
    public $taskRepository;
    public $noteRepository;

    public function __construct (
        TaskTransformer $taskTransformer, 
        TaskRepository $taskRepository,
        NoteRepository $noteRepository)
    {
        $this->taskTransformer = $taskTransformer;
        $this->taskRepository  = $taskRepository;
        $this->noteRepository  = $noteRepository;
    }

    public function index (TaskFilters $filters)
    {
        $perPage = isset($request['per_page']) ? (int) $request['per_page'] : 20;
        $tasks = Task::filter($filters)->withCount('notes')
                    ->orderBy('notes_count', 'desc')
                    ->orderByRaw("FIELD(priority, \"High\", \"Medium\", \"Low\")")
                    ->paginate($perPage);

        return $this->taskTransformer->transformPaginationList($tasks, ['notes']);
    }

    /**
     * Create a new task along with multiple notes.
     * 
     * @param TaskCreateRequest $request
     * @return mixed
     */
    public function store (TaskCreateRequest $request)
    {
        $fields = $request->all();
        $taskParams = [
            'subject'       => $fields['subject'],
            'description'   => isset($fields['description']) ? $fields['description'] : null,
            'start_date'    => $fields['start_date'],
            'due_date'      => $fields['due_date'],
            'status'        => isset($fields['status']) ? $fields['status'] : null,
            'priority'      => isset($fields['priority']) ? $fields['priority'] : null
        ];
        $task = $this->taskRepository->create($taskParams);

        $this->createNotes($fields['notes'], $task->id);

        return response(['message' => 'Task with notes created successfully!'], 201);
    }

    /**
     * Create a notes for newly created task.
     * 
     * @param array $notes
     * @param int $taskId
     * 
     * @return void
     */
    protected function createNotes (array $notes, int $taskId)
    {
        $attach = [];

        foreach($notes as $note) {
            $noteParam = [
                'tasks_id' => $taskId,
                'subject'  => $note['subject'],
                'note'     => $note['note']
            ];

            if( isset($note['attachments'])) {

                foreach($note['attachments'] as $attachment) {
                    $path = $attachment->store('/attachments/resource', ['disk' =>   'my_attachments']);
                    array_push($attach, $path);
                }
                $noteParam['attachments'] = json_encode($attach);
            }
            $this->noteRepository->create($noteParam);
        }
    }
}