<?php

namespace App\Repositories;

use App\Models\Note;
use App\Repositories\BaseRepository;

/**
 * Created just to show a small demo of repository pattern
 */
class NoteRepository extends BaseRepository
{
    /**
     * NoteRepository Constructor.
     * 
     * @param Note $task
     */
    public function __construct(Note $note)
    {
        parent::__construct($note);
    }
}