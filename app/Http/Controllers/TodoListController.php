<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TodoListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('List/Index', [
            'tasks' => TodoList::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
        ]);

        TodoList::create([
            'name' => $request->name,
            'status' => false,
        ]);

        return back()->withMessage('Created successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        $todoList = TodoList::find($id);
        $todoList->status = !(bool)$todoList->status;
        $todoList->save();

        return back()->withMessage('Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($task_id)
    {
        $todoList = TodoList::find($task_id);
        $todoList->delete();

        return back()->withMessage('Deleted successfully');
    }
}
