@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <a href="/files" class="btn btn-default">Go Back</a>
        </div>
        <div class="row">
            <h1>{{$file->title}}</h1>            
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">File Name</th>
                    <th scope="col">Size</th>
                    <th scope="col">Last Modified</th>
                    <th scope="col">Uploaded File</th>
                    <th scope="col">Expansion</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($files_arr as $key => $file_item)
                        <tr>
                            <th scope="row">{{$key}}</th>
                            <td>{{$file_item->file_name}}</td>
                            <td>{{Storage::size($file_item->file_full_path)}} KB</td>
                            <td>{{gmdate("H:i:s",Storage::lastModified($file_item->file_full_path))}}</td>
                            <td>{{gmdate("H:i:s",$file_item->file_time)}}</td>
                            <td>{{$file_item->file_expansion}}</td>
                            <td>
                                <a href="#" class="btn btn-success glyphicon glyphicon-file"></a>
                                <a href="#" class="btn btn-primary glyphicon glyphicon-cloud-download"></a>
                                <a href="#" class="btn btn-danger glyphicon glyphicon glyphicon-trash"></a>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            <hr>
            <small>Created at {{$file->created_at}} by {{$file->user->name}}</small>
            @if(!Auth::guest())
                @if(Auth::user()->id == $file->user_id)
                    <hr>
                    <a href="/files/{{$file->id}}/edit" class="btn btn-default">Edit</a>
                    {!!Form::open(['action' => ['FilesController@destroy', $file->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete Directory', ['class' => 'btn btn-danger'])}}
                    {!!Form::close()!!}
                @endif
            @endif
        </div>
    </div>
@endsection

