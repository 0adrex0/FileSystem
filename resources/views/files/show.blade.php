@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <a href="/files" class="btn btn-default">Go Back</a>
        </div>
        <div class="row">
            <h1>{{$file->title}}</h1>            

            <hr>
            <small>Created at {{$file->created_at}} by {{$file->user->name}}</small>
            @if(!Auth::guest())
                @if(Auth::user()->id == $file->user_id)
                    <hr>
                    <a href="/files/{{$file->id}}/edit" class="btn btn-default">Edit</a>
                    {!!Form::open(['action' => ['FilesController@destroy', $file->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-danger    '])}}
                    {!!Form::close()!!}
                @endif
            @endif
        </div>
    </div>
@endsection

