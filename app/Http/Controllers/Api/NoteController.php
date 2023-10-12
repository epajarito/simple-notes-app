<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Note\IndexRequest;
use App\Http\Requests\Api\Note\StoreRequest;
use App\Http\Requests\Api\Note\UpdateRequest;
use App\Http\Resources\Api\Note\NoteCollection;
use App\Http\Resources\Api\Note\NoteResource;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NoteController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
//        $notes = Note::query()
//            ->whereBelongsTo(auth()->user())
//            ->latest()
//            ->paginate();

        $notes = Note::allowedSorts(['title','content']);



        return NoteCollection::make(
            $notes->paginate(
                $perPage = request('page.size', 15),
                $columns = ['*'],
                $pageName = 'page[number]',
                $page = request('page.number', 1)
            )->appends(request()->only('sort', 'page.size'))
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $note = Note::create($request->validated());

        return new NoteResource($note);
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
//        $this->authorize('view', $note);
        return new NoteResource($note);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Note $note)
    {
//        $this->authorize('update', $note);
        $note->update($request->validated());

        return new NoteResource($note);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
//        $this->authorize('delete', $note);
        $note->delete();

        return response()->noContent();
    }
}
