<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Policies\TaskPolicy;
use Illuminate\Console\Events\ScheduledTaskSkipped;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$tasks = Task::all();
        $tasks = Task::where('user_id', auth()->user()->id)->get();

        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' =>'required|max:255',
            'description' =>'required|max:255',
            'published_at' => 'date',
            'user_id' => 'exists:users,id',
        ]);

        $task = Task::create($request->only(['title', 'description', 'published_at', 'user_id']));
        return response()->json($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $task->update($request->all());
        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->noContent();
    }
}
