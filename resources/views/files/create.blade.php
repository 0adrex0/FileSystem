@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <a href="{{ URL::previous() ?? '/files' }}" class="btn btn-default">Go Back</a>
            <hr>
            <h1>Upload Files</h1>

        </div>
        <div class="row">
            <form action="/files" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control", placeholder="Title">
                </div>
                <div class="form-group">
                    <input type="file" name="files_path[]" multiple="true">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection



