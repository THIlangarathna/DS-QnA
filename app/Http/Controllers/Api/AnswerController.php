<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Question;
use App\Answer;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function storeimg(Request $request)
    {
        $imgurl = request('upload')->store('uploads','s3');
        $function_number = $request['CKEditorFuncNum'];
        $message = '';
        $url = "https://ds-bucket-final.s3.ap-south-1.amazonaws.com/$imgurl";
        return "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message');</script>";
    }

    public function img(Request $request)
    {
        $imagePath = request('img')->store('uploads','public');

        return response()->json(
        [
        'url'=> $imagePath,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'content' => ['required', 'string', 'max:255'],
        ]);

        $id = auth()->user()->id;

        $answer = new answer;
        $answer -> user_id = $id;
        $answer -> question_id = $request['question_id'];
        $answer -> answer = $request['content'];

        $answer->save();

        return response()->json(
            [
            'Status'=> 'answer Added!',
            ]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'content' => ['required', 'string', 'max:255'],
        ]);

        $answer = Answer::find($id);
        $answer -> answer = $request['content'];

        $answer->save();

        return response()->json(
            [
            'Status'=> 'answer Updated!',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $answer = Answer::find($id);

        $answer->delete();

        return response()->json(
            [
            'Status'=> 'answer Deleted!',
            ]);
    }
}
