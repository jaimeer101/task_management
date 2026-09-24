<?php

namespace App\Http\Controllers;

use App\Enum\TaskStatus;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use AuthorizesRequests;
    public function index()
    {
        
        return Inertia::render('Task/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = collect(TaskStatus::cases())->map(fn($status) => [
            'value' => $status->value,
            'label' => $status->label(),
        ]);
        $data = [
            "statuses" => $statuses, 
        ];
        if (auth()->user()->hasRole('admin')) {
            $data['users'] = User::select('id', 'name')->get();
            $data['selectedUser'] = auth()->user()->id;
        }

        return Inertia::render('Task/Form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        Task::create($request->validated());
        return redirect()->route('task.create')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        $statuses = collect(TaskStatus::cases())->map(fn($status) => [
            'value' => $status->value,
            'label' => $status->label(),
        ]);
        $data = [
            "statuses" => $statuses, 
            "task" => $task
        ];
        if (auth()->user()->hasRole('admin')) {
            $data['users'] = User::select('id', 'name')->get();
        }
        return Inertia::render('Task/Form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);
        $task->update($request->validated());
        return redirect()->route('task.edit', ["task" => $task->id])->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
