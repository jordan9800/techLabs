<?php

namespace App\Transformers;


use App\Transformers\BaseTransformer;
use Illuminate\Database\Eloquent\Model;

class NoteTransformer extends BaseTransformer
{
    public function transform(Model $note, $relations = [], $includeExtras = false)
    {
        $data = [
			'id'         => $note->id,
            'subject'    => $note->subject,
            'note'       => $note->note,
		];

        $extras = [
            'attachments'  => $note->attachments ? json_decode($note->attachments, true) : null,
		];

		if($includeExtras) {
			return  array_merge($data,$extras);
		}

		return $data;
        
    }
}
