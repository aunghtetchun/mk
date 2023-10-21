<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Models\Project;
use App\Models\Photo;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects=Project::all();
        return view('project.index',compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $project = new Project();
        $project->title = $request->title;
        $project->description = $request->description;
        $project->is_pinpost = $request->has('is_pinpost') ? true : false;
        $project->save(); 
        
        if ($request->hasFile('images')) {
            $photos = [];
            foreach ($request->file('images') as $image) {
                $newName = uniqid() . "_project." . $image->getClientOriginalExtension();
                $image_resize = Image::make($image);
                $image_resize->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $image_resize->save(storage_path('app/public/project/' . $newName));
        
                $photos[] = new Photo(['url' => $newName]);
            }
            $project->photos()->saveMany($photos); 
        }
        

        return redirect()->route('project.index')->with('success', 'Project created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('project.edit',compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->title = $request->title;
        $project->description = $request->description;
        $project->is_pinpost = $request->has('is_pinpost') ? true : false;
        $project->update(); 
        return redirect()->route('project.index')->with('success', 'Project updated cessfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('project.index')->with('success', 'Project deleted successfully');
    }
}
