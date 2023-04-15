<?php

namespace App\Models;

use App\Filters\QueryFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['subject', 'description', 'start_date', 'due_date', 'status', 'priority'];

    public function notes()
    {
        return $this->hasMany(Note::class, 'tasks_id');
    }

    public function scopeFilter($builder, QueryFilters $filters)
    {
        return $filters->apply($builder);
    }
}
