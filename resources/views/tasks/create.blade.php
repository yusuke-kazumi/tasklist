@extends('layouts.app')

@section('content')

  <h1>タスクリスト新規作成ページ</h1>

        {!! Form::model($task, ['route' => 'tasks.store']) !!}

        {!! Form::label('status', 'ステータス:') !!}
        {!! Form::text('status') !!}

        {!! Form::label('content', 'タスク:') !!}
        {!! Form::text('content') !!}
 
       {!! Form::submit('投稿') !!}

    {!! Form::close() !!}

@endsection

