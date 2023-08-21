<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;

class CompleteTaskController extends Controller
{

    public function __invoke(Task $task)
    {
        $task->update(['completed_at' => $task->completed_at ? null : now()]);
        return redirect()->route('admin.tasks.index')->with('success', 'Task Updated Successfully');
    }
}
