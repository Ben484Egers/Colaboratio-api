<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Show all tasks of a user
    public function index() {
        
        $tasks = Task::where('user_id', Auth::id())->get();
        return $tasks;
    }
    //Show all tasks
    public function all() {
        return Task::all();
    }

    /**
     * Show all tasks of the requested project.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function projectTasks($id) {
        return Task::where('project_id', $id)->get();
    }

    //Create task
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'project_id' => 'required',
            'completed' => 'required',
        ]);
        
        //Set owner to authenticated user
        $request->request->add(['assigned_by_id' => Auth::id()]);

        return Task::create($request->all());
    }

    /**
     * Show the requested task.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Task::find($id);
    }

    /**
     * Update task.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        //If logged in user is not person responsible or owner of task, Abort.
        if($task->user_id != Auth::id() && $task->assigned_by_id != Auth::id()){
            return abort(403, 'Unauthorized Action');
        }

        $task->update($request->all());
        return $task;
    }

    /**
     * Delete task
     * @param  int  $id
     */
    // * @return \Illuminate\Http\Response
    public function destroy($id)
    {
        $task = Task::find($id);
        //If logged in user is not person responsible or owner of task, Abort.
        if($task->user_id != Auth::id() || $task->assigned_by_id != Auth::id()){
            return abort(403, 'Unauthorized Action');
        }
        return Task::destroy($id);
    }

    /**
     * Search for a term
     *
     * @param  string  $term
     * @return \Illuminate\Http\Response
     */
    public function search($term)
    {
        $tasks = Task::where('name', 'like', '%'.$term.'%')->orWhere('description', 'like', '%'.$term.'%')->get();
                
        return $tasks;
    }
    
}
