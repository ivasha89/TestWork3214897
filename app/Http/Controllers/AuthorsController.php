<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Author;
use App\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::orderBy('last_name', 'asc')->paginate(20);
        return view('public/authors/index')
            ->withauthors($authors);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('public/authors/edit')
            ->withauthor(null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        /*$types = implode(',',$request->types);
        $request['type'] = $types;*/
        $author = Author::create($request->all());
        $file = $request->file('photo');
        if (isset($file)) {
            $fileName = SpaController::nameReplace($file->getClientOriginalName());
            Storage::disk('public')->putFileAs("/authors/$author->id", $file, $fileName);
            $author->update([
                'photo' => "/teachers/" . $author->id . '/' . $fileName
            ]);
        }

        return redirect('/authors')->withErrors('Автор '. $author->full_name .' сохранен', 'message');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $authors = Author::all();
        $authorJournals = [];
        $i = 0;
        $journals = Journal::all();
        foreach ($journals as $journal) {
            $authorIds = explode(',',$journal->authors);
            foreach ($authorIds as $authorId) {
                if ($id == $authorId) {
                    $authorJournalsId[$i] = $journal->id;
                    $i++;
                }
            }
        }
        $authorJournals = Journal::whereIn('id',$authorJournalsId)->orderBy('relise_date', 'desc')->paginate(10);
        return view('public/journals/index')
            ->withjournals($authorJournals)
            ->withauthors($authors);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $types = [
            'junior' => [
                'name' => 'Начальная школа',
                'ind' => 0
            ],
            'middle' => [
                'name' => 'Средняя школа',
                'ind' => 0
            ],
            'senior' => [
                'name' => 'Старшая школа',
                'ind' => 0
            ],
        ];
        try {
            $author = Author::findOrFail($id);
            /*$author['types'] = explode(',',$teacher->type);
            foreach ($author['types'] as $type) {
                foreach ($types as $key => $item) {
                    if ($type == $key) {
                        $types[$key]['ind'] = 1;
                    }
                }
            }
            unset($teacher->type);*/
        }
        catch (\Throwable $exception) {
            $author = $exception;
        }

        return view('public/authors/edit')
            ->withtypes($types)
            ->withauthor($author);
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
            $author = Author::findOrFail($id);
            /*$types = implode(',',$request->types);
            $request['type'] = $types;
            $file = $request->file('photo');
            if (isset($file)) {
                Storage::disk('public')->delete($teacher->photo);
                $fileName = SpaController::nameReplace($file->getClientOriginalName());
                Storage::disk('public')->putFileAs("/teachers/$teacher->id", $file, $fileName);
                $teacher->update([
                    'photo' => "/teachers/" . $teacher->id . '/' . $fileName
                ]);
            }*/
            $author->update($request->except('photo'));

            return redirect('/authors')->withErrors('Автор '. $author->full_name .' сохранен', 'message');
        }
        catch (\Throwable $exception) {
            return redirect('/authors')->withErrors(is_object($exception) ? $exception->getMessage() : $exception,'error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        try {
            $author = Author::findOrFail($id);
            //Storage::deleteDirectory("public/teachers/$teacher->id");
            $author->delete();
            $response = 'Автор ' . $author->full_name . ' Удален';
            return redirect('/authors')->withErrors($response, 'message');
        }
        catch (\Throwable $exception) {
            $response = $exception;
            return redirect('/authors')->withErrors($response, 'error');
        }
    }
}
