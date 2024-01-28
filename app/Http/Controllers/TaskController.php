<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('user_filter:Task,user_id,tasks');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::all();
        return view("tasks.index", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $fields = $request->validated();
        $newTask = new Task($fields);
        $newTask->user_id = Auth::user()->id;
        $newTask->save();
        $newTask->categories()->sync($fields["categories"]);

        return to_route("task.index")->with("success", "Task saved successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
        return view("tasks.show", compact("task"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
        $categories = Category::all();
        return view("tasks.edit", compact("task", "categories"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
        $fields = $request->validated();
        $task->update($fields);
        $task->categories()->sync($fields["categories"]);

        return to_route("task.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
        $task->delete();

        return to_route("task.index")->with("success", "Task remove successfully!");
    }
}
