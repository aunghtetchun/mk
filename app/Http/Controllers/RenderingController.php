<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRenderingRequest;
use App\Http\Requests\UpdateRenderingRequest;
use App\Models\Rendering;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class RenderingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $renderings=Rendering::all();
        return view('rendering.index',compact('renderings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rendering.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRenderingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRenderingRequest $request)
    {
        $rendering = new Rendering();
        $rendering->title = $request->title;
        $rendering->description = $request->description;
        $rendering->slug = Str::slug($request->title, '_');
        $image = $request->file('image');
        $image = $request->file('image');
        $newName = uniqid() . "_rendering." . $image->getClientOriginalExtension();
        $image_resize = Image::make($image);
        $image_resize->resize(400, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image_resize->save(storage_path('app/public/rendering/' . $newName));
        $rendering->image = $newName;
        $rendering->save();

        return redirect()->route('rendering.index')->with('success', 'Rendering created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rendering  $rendering
     * @return \Illuminate\Http\Response
     */
    public function show(Rendering $rendering)
    {
        return view('rendering.show', compact('rendering'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rendering  $rendering
     * @return \Illuminate\Http\Response
     */
    public function edit(Rendering $rendering)
    {
        return view('rendering.edit', compact('rendering'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRenderingRequest  $request
     * @param  \App\Models\Rendering  $rendering
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRenderingRequest $request, Rendering $rendering)
    {
        $rendering->title = $request->title;
        $rendering->description = $request->description;
        $rendering->slug = Str::slug($request->title, '_');
        if($request->file('image')){
            $image = $request->file('image');
            $newName = uniqid() . "_rendering." . $image->getClientOriginalExtension();
            $image_resize = Image::make($image);
            $image_resize->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image_resize->save(storage_path('app/public/rendering/' . $newName));
            $rendering->image = $newName;
        }
        $rendering->update();

        return redirect()->route('rendering.index')->with('success', 'Rendering updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rendering  $rendering
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rendering $rendering)
    {
        $rendering->delete();
        return redirect()->route('rendering.index')->with('success', 'Rendering deleted successfully.');
    }
}
