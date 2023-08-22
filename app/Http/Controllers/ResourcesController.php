<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Resources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ResourcesController extends Controller
{
    /**
     * Show resources from project.
     * @param  int  $project_id
     * @return \Illuminate\Http\Response
     */
    public function index($project_id) {
        return Resources::where('project_id', $project_id)->get();
    }

    /**
     * Create Resource
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'resource' => 'required',
            'project_id' => 'required'
        ]);
        
        $url = Storage::putFile('/public/resources', $request->file('resource'));
        $resource = ['url' => $url, 'project_id' => $request->project_id];

        return Resources::create($resource);
    }

    /**
     * Display the requested resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Resources::find($id);
    }

    /**
     * Delete resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $resource = Resources::find($id); 

        //If requested resource not in database, abort
        if(!$resource) {
            abort(404, 'Resource not found');
        }

        $project = Project::find($resource->project_id);

        // If auth user is not owner of project, abort
        if($project->user_id != Auth::id()) {
            abort(403, 'Unauthorized Action');
        }
        
        //Delete from storage
        if($resource->url && Storage::exists($resource->url)) {
            Storage::delete($resource->url);
        } 

        return response($resource->delete(), 200);
    }

}
