@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <a href="/files" class="btn btn-default">Go Back</a>
            <hr>
            <h1>Upload Files</h1>

        </div>
        <div class="row">
                {!! Form::open(['action' => 'FilesController@store', 'method' => 'POST',  'enctype' => 'multipart/form-data', 'files' => true]) !!}
                    <div class="form-group">
                        {{Form::label('title', 'Title')}}
                        {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
                    </div>
                    <div class="form-group">
                        {{Form::file('files_path[]', ['multiple'])}}
                    </div>
                    {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
                {!! Form::close() !!}
        </div>
    </div>
@endsection