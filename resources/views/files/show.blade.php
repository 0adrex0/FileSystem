@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <a href="/files" class="btn btn-default">Go Back</a>
        </div>
        <div class="row">        
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
                    @foreach ($files as $key => $file)
                        <tr>
                            <td scope="col">{{$key+1}}</td>
                            <td scope="col">{{$file->title}}</td>
                            <td scope="col">{{gmdate("H:i:s",Storage::lastModified($file->files_path))}}</td>
                            <td scope="col"></td>
                            <td scope="col">{{$file->created_at}}</td>
                            <td scope="col">
                                @if(!Auth::guest())
                                    @if(Auth::user()->id == $file->user_id)
                                        <a href="/files/{{$file->id}}/edit" class="btn btn-default">Edit</a>
                                        {!!Form::open(['action' => ['FilesController@destroy', $file->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::submit('Delete Directory', ['class' => 'btn btn-danger'])}}
                                        {!!Form::close()!!}
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            <hr>
            
        
        </div>
    </div>
@endsection

