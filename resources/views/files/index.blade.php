@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="d-flex justify-content-between align-items-baseline">
                    <h1>File System</h1>
                    <a class="btn btn-success" href="/files/create">Create Directory</a>
                </nav>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <aside class="sidebar-file ">
                    <p>Sort Card</p>
                    <hr>
                </aside>
            </div>
            <div class="col-md-9">
                <section class="files">
                    @if(count($files) > 0)
                        @foreach ($files as $file)
                            <div class="card-file">
                                <div>
                                    <a href="/files/{{$file->id}}"><h3>{{$file->title}}</h3></a>
                                    <small>Created at {{$file->created_at}} by {{$file->user->name}}</small>
                                </div>
                                <div>
                                    <!--<a href="/files/{{$file->id}}/edit" class="btn btn-primary">Edit</a>
                                    {!!Form::open(['action' => ['FilesController@destroy', $file->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                        {{Form::hidden('_method', 'DELETE')}}
                                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                    {!!Form::close()!!}-->
                                </div>
                            </div>
                        @endforeach
                        {{$files->links()}}
                    @else
                        <p>Files not found</p>
                    @endif
                </section>
            </div>
        </div>
    </div>
@endsection

