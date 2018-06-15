<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Task;


class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$tasks = task::all(); いらない説
        
        if (\Auth::check()){
            $user = \Auth::user();
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
               
        return view('tasks.index' , ['tasks' => $tasks,]);
        }
	    else{
        return redirect('login');
	    }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;
        
        if (\Auth::check()) {
            return view('tasks.create', [
                'task' => $task,
            ]);
        } else {
        
            return redirect('/tasks');
    }
}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	 $this->validate($request, [
            'status' => 'required|max:10',
            'content' => 'required|max:191',
    ]);
          
        $task = new Task;
        $task->status = $request->status;   
        $task->content = $request->content;
        
        $user= \Auth::user();
        $task->user_id = $user->id;
        $task->save();

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        if (\Auth::id() === $task->user_id) {
            return view('tasks.show', [
                'task' => $task,
            ]);
        } else {
        
            return redirect('tasks');
    }}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        if (\Auth::check()) {
            return view('tasks.edit', [
                'task' => $task,
            ]);
        } else {
        
            return redirect('tasks');
    }}


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|max:10',   // add
            'content' => 'required|max:191',
        ]);


        $task = Task::find($id);
        $task->status = $request->status;    // add
        $task->content = $request->content;
        $task->save();


        return redirect('/tasks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Task = Task::find($id);
        $Task->delete();

        return redirect('/');
    }
}
