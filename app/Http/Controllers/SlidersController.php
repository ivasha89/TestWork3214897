<?php

namespace App\Http\Controllers;

use App\Http\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SlidersController extends Controller
{
    protected $rules = [
        'title' => 'required|string|min:3',
        'button_name' => 'required|string|min:3',
        'link' => 'required|string',
        'banner' => 'required'
    ];

    public function __construct()
    {
        $this->middleware('permission:edit public info');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::orderBy('created_at', 'desc')->paginate(10);
        $published = Slider::where('published', 1)->get()->count();
        $unpublished = Slider::where('published', 0)->get()->count();
        return view('publicAdmin/sliders/index')
            ->withpublished($published)
            ->withunpublished($unpublished)
            ->withsliders($sliders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('publicAdmin/sliders/edit')
            ->withslider(null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate($this->rules);
        $slider = Slider::create($request->all());
        $file = $request->file('banner');
        if (isset($file)) {
            $fileName = SpaController::nameReplace($file->getClientOriginalName());
            Storage::disk('public')->putFileAs("/sliders/$slider->id", $file, $fileName);
            $slider->update([
                'banner' => "/sliders/" . $slider->id . '/' . $fileName
            ]);
        }

        return redirect('editor/sliders')->withErrors('Слайдер '. $slider->title .' сохранен', 'message');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $slider = Slider::findOrFail($id);
        }
        catch (\Throwable $exception) {
            $slider = $exception;
        }

        return view('publicAdmin/sliders/edit')
            ->withslider($slider);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $slider = Slider::findOrFail($id);
            $rules = $this->rules;
            array_pop($rules);
            $request->validate($rules);
            $file = $request->file('banner');
            if (isset($file)) {
                Storage::disk('public')->delete($slider->banner);
                $fileName = SpaController::nameReplace($file->getClientOriginalName());
                Storage::disk('public')->putFileAs("/sliders/$slider->id", $file, $fileName);
                $slider->update([
                    'banner' => "/sliders/" . $slider->id . '/' . $fileName
                ]);
            }
            $slider->update($request->except('banner'));

            return redirect('editor/sliders')->withErrors('Слайдер '. $slider->title .' сохранен', 'message');
        }
        catch (\Throwable $exception) {
            return redirect('editor/sliders')->withErrors(is_object($exception) ? $exception->getMessage() : $exception,'error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $slider = Slider::findOrFail($id);
            Storage::deleteDirectory("public/sliders/$slider->id");
            $slider->delete();
            $response = 'Слайдер ' . $slider->title . ' Удален';
            return redirect('editor/sliders')->withErrors($response, 'message');
        }
        catch (\Throwable $exception) {
            $response = $exception;
            return redirect('editor/sliders')->withErrors($response, 'error');
        }
    }

    public function publish($id) {
        try {
            $slider = Slider::findOrFail($id);
            if ($slider->published) {
                $slider->published = 0;
                $slider->save();
                $answer = 'Слайдер '. $slider->title . ' больше не активен';
            }
            else {
                $slider->published = 1;
                $slider->save();
                $answer = 'Слайдер '. $slider->title . ' опубликован';
            }
            return redirect('editor/sliders')->withErrors($answer, 'message');
        }
        catch (\Throwable $exception) {
            $response = $exception;
            return redirect('editor/sliders')->withErrors($response, 'error');
        }
    }
}
