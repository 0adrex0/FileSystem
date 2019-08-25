@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <a href="/files" class="btn btn-default">Go Back</a>
            <hr>
            <h1>Edit Files</h1>

        </div>
        <div class="row">
            <form action="/files/{{$file->id}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">{{$file->title}}</label>
                    <input type="text" name="title" class="form-control", placeholder="Title">
                </div>
                <div class="form-group">
                    <input type="file" name="files_path" multiple="true">
                </div>
                <input type="hidden" name="_method" value="PUT">
                <button type="submit" class="btn btn-primary" >Submit</button>
            </form>
        </div>
    </div>
@endsection
