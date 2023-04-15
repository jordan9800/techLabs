<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

class TaskFilters extends QueryFilters
{
    /**
     * Filter by popularity.
     *
     * @param  string $order
     * @return Builder
     */
    public function priority_order($order = 'desc')
    {
        $priorities = ['High', 'Medium', 'Low'];

        if ($order === "asc") {
            $priorities = array_reverse($priorities);
        }
        $priorityString = implode('","', $priorities);

        return $this->builder->orderByRaw('FIELD(priority, "' . $priorityString . '")');
    }

    /**
     * Filter by priority.
     *
     * @param  string $level
     * @return Builder
     */
    public function priority($level)
    {
        if(in_array($level, ['High', 'Medium', 'Low'])) {
            return $this->builder->where('priority', $level);
        }
    }

    /**
     * Filter by priority.
     *
     * @param  string $level
     * @return Builder
     */
    public function status($level)
    {
        if(in_array($level, ['New', 'Incomplete', 'Complete'])) {
            return $this->builder->where('status', $level);
        }
    }

    /**
     * Filter by due date.
     *
     * @param  string $date
     * @return Builder
     */
    public function due_date($date)
    {
        return $this->builder->where('due_date', '<=', $date);
    }

    public function note($count = 1)
    {
        return $this->builder->Has('notes', '>=', $count);
    }

}