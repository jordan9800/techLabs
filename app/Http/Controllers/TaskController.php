<?php

namespace App\Http\Controllers;

use App\Filters\TaskFilters;
use App\Http\Requests\TaskCreateRequest;
use App\Models\Note;
use App\Models\Task;
use App\Transformers\TaskTransformer;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public $taskTransformer;

    public function __construct(TaskTransformer $taskTransformer)
    {
        $this->taskTransformer = $taskTransformer;
    }

    public function index(TaskFilters $filters)
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
    public function store(TaskCreateRequest $request)
    {
        $fields = $request->all();

        $task               = new Task();
        $task->subject      = $fields['subject'];
        $task->description  = isset($fields['description']) ? $fields['description'] : null;
        $task->start_date   = $fields['start_date'];
        $task->due_date     = $fields['due_date'];
        $task->status       = isset($fields['status']) ? $fields['status'] : null;
        $task->priority     = isset($fields['priority']) ? $fields['priority'] : null;
        $task->save();

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
    protected function createNotes(array $notes, int $taskId)
    {
        $attach = [];

        foreach($notes as $note) {
            $newNote = new Note();
            $newNote->tasks_id = $taskId;
            $newNote->subject = $note['subject'];

            if( isset($note['attachments'])) {

                foreach($note['attachments'] as $attachment) {
                    $path = $attachment->store('/attachments/resource', ['disk' =>   'my_attachments']);
                    array_push($attach, $path);
                }
                $newNote->attachments = json_encode($attach);
            }
            $newNote->note = $note['note'];
            $newNote->save();
        }
    }
}