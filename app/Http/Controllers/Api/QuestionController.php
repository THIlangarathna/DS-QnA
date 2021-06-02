<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Answer;
use App\Question;
use DB;
class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $quetions = Question::where('user_id', '=', $user_id)->get();

        return response()->json(
            [
            'user' => $user,
            'questions' => $quetions,
            ]);
    }
    public function all()
    {
        $questions = DB::table('questions')
        ->join('users', 'questions.user_id', '=', 'users.id')
        ->select('questions.id','questions.title','questions.description','questions.category','questions.created_at','users.name')
        ->orderBy('questions.id', 'DESC')
        ->get();

        return response()->json(
            [
            'questions' => $questions,
            ]);
    }

    public function showquestion($id)
    {
        $question = Question::find($id);
        $user_id = $question->user_id;
        $user = User::find($user_id);
        $answers = DB::table('answers')
        ->join('users', 'answers.user_id', '=', 'users.id')
        ->where('answers.question_id','=',$id)
        ->select('answers.id','answers.answer','answers.created_at','users.name','users.img')
        ->orderBy('id', 'DESC')
        ->get();
        

        return response()->json(
            [
            'user' => $user,
            'question' => $question,
            'answers' => $answers,
            ]);
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
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category' => ['required', 'string', 'max:255'],
        ]);

        $id = auth()->user()->id;

        $question = new Question;
        $question -> user_id = $id;
        $question -> title = $request['title'];
        $question -> description = $request['content'];
        $question -> category = $request['category'];

        $question->save();

        return response()->json(
            [
            'Status'=> 'Success!',
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
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $question = Question::find($id);
        // $my_answer = Answer::where('user_id', '=', $user_id)->where('question_id','=',$id)->get();
        // $answer = answer::where('user_id', '!=', $user_id)->orWhereNull('user_id')->get();
        // $others_answer = Answer::where('user_id', '!=', $user_id)->where('question_id','=',$id)->get();
	
	$my_answer = DB::table('answers')
        ->join('users', 'answers.user_id', '=', 'users.id')
        ->where('answers.question_id',$id)
	->where('answers.user_id',$user_id)
        ->select('answers.id','answers.answer','answers.created_at','users.name','users.img')
        ->orderBy('id', 'DESC')
        ->get();

        $others_answer = DB::table('answers')
        ->join('users', 'answers.user_id', '=', 'users.id')
        ->where('answers.question_id',$id)
	->where('answers.user_id','!=',$user_id)
        ->select('answers.id','answers.answer','answers.created_at','users.name','users.img')
        ->orderBy('id', 'DESC')
        ->get();

        return response()->json(
            [
            'user' => $user,
            'question' => $question,
            'my_answer' => $my_answer,
            'others_answer' => $others_answer,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $question = Question::find($id);

        return response()->json(
            [
            'user' => $user,
            'question' => $question,
            ]);
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
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category' => ['required', 'string', 'max:255'],
        ]);
        $question = Question::find($id);
        $question -> title = $request['title'];
        $question -> description = $request['content'];
        $question -> category = $request['category'];
        $question->save();


        return response()->json(
        [
        'Status'=> 'Question Updated.',
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
        $question = Question::find($id);
        $question ->delete();
        
        return response()->json(
        [
        'Status'=> 'Question Deleted!',
        ]);
    }
}

