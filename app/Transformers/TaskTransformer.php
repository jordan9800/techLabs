<?php

namespace App\Transformers;


use App\Transformers\BaseTransformer;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\NoteTransformer;

class TaskTransformer extends BaseTransformer
{
    public function transform(Model $task, $relations = [], $includeExtras = false)
    {
        $data = [
			'id'            => $task->id,
			'subject' 	    => $task->subject,
			'description'   => $task->description,
            'start_date' 	=> $task->start_date,
            'due_date' 	    => $task->due_date,
            'status' 	    => $task->status,
            'priority' 	    => $task->priority,
		];

		foreach($relations as $relation) {

			if(method_exists($this, $relation)) {
				$data[$relation] = $this->{$relation}($task, $includeExtras);
			}
		}

		return $data;
    }

	/**
	 * @param $task
	 * @param $includeExtras
	 * @return collection
	 */
	public function notes($task, $includeExtras)
	{
		$transformer = new NoteTransformer();

		$notes = $task->notes()->get();

		return $transformer->transformCollection($notes, [], $includeExtras=false);
	}

}
