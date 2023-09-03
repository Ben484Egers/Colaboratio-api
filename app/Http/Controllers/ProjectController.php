<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    // Show all projects
    public function index() {
        return Project::all();
    }

    //Create Project
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', Rule::unique('projects', 'name')],
            'description' => 'required',
            'user_id' => 'required',
            'completed' => 'required'
        ]);

        $project = Project::create($request->all());
        return $project;
    }

    /**
     * Show the requested project.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Project::find($id);
    }

    /**
     * Update a project.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::find($id);

        //If logged in user is not owner of project, Abort.
        if($project->user_id != Auth::id()){
            return abort(403, 'Unauthorized Action');
        }

        $project->update($request->all());
        return $project;
    }

    /**
     * Delete a project.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);

        if($project->user_id != Auth::id()){
            return abort(403, 'Unauthorized Action');
        }
        return response(Project::destroy($id), 200);
    }

     /**
     * Search for a term
     * @param  string  $term
     * @return \Illuminate\Http\Response
     */
    public function search($term)
    {
        return Project::where('name', 'like', '%'.$term.'%')->orWhere('description', 'like', '%'.$term.'%')->get();
    }
    
}
