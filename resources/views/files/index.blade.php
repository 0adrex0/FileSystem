@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="d-flex justify-content-between align-items-baseline">
                    <h1>File System</h1>
                    <a class="btn btn-success" href="/files/create"><div class="glyphicon glyphicon-plus"></div> Add File</a>
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
                        @foreach ($files as $file )
                         <div class="card-file">
                                <div>
                                    <a href="/files/{{$file->user_id}}"><h3>{{$file->user->email}}</h3></a>
                                    <small>Created at {{$file->created_at}} </small>
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

