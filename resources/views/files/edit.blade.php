@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <a href="/files" class="btn btn-default">Go Back</a>
            <hr>
            <h1>Edit Files</h1>

        </div>
        <div class="row">
                {!! Form::open(['action' => ['FilesController@update', $file->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'files' => true]) !!}
                    <div class="form-group">
                        {{Form::label('title', 'Title')}}
                        {{Form::text('title', $file->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
                    </div>
                    <div class="form-group">
                            {{Form::file('files_path')}}
                    </div>
                    {{Form::hidden('_method','PUT')}}
                    {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
                {!! Form::close() !!}
        </div>
    </div>
@endsection