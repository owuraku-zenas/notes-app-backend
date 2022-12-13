<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoteController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try {
            $notes = Note::all();

            return $this->sendResponse($notes, "Notes Retrieved Successfully");
        } catch (Exception $exception) {
            return $this->sendError($exception->getMessage(), $exception, 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {

            $validator = Validator::make($request->all(), [
                'title' => 'required|string|unique:notes',
                'description' => 'required',
            ]);

            if ($validator->fails()) {

                return $this->sendError("Invalid Field", $validator->errors(), 400);
            }
            $note = new Note;
            $note->title = $request->title;
            $note->description = $request->description;
            $note->save();

            return $this->sendResponse($note, "Note" . $note->id . "Updated Successfully");
        } catch (Exception $errors) {

            return $this->sendError($errors->getMessage(), $errors, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        //
        try {
            return $this->sendResponse($note, "Note" . $note->id . "Retrieved Successfully");
        } catch (Exception $exception) {

            return $this->sendError($exception->getMessage(), $exception, 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        //
        try {
            if ($request->title != $note->title) {
                # code...
                $validator = Validator::make($request->all(), [
                    'title' => 'required|string|unique:notes',
                    'description' => 'required',
                ]);

                if ($validator->fails()) {

                    return $this->sendError("Invalid Field", $validator->errors(), 400);
                }
            }

            $note->title = $request->title;
            $note->description = $request->description;
            $note->save();

            return $this->sendResponse($note, "Note" . $note->id . "Updated Successfully");
        } catch (Exception $errors) {

            return $this->sendError($errors->getMessage(), $errors, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        //
        try {
            $note->delete();
            return $this->sendResponse($note, "Note" . $note->id . "Deleted Successfully");
        } catch (Exception $exception) {

            return $this->sendError($exception->getMessage(), $exception, 500);
        }
    }
}
