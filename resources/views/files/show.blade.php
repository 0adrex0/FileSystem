@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="/files" class="btn btn-default">Go Back</a>  
                <div class="pull-right">
                        {{$files->links()}}
                </div>
            </div>
        </div>
        <div class="row">        
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">File Name</th>
                    <th scope="col">Extension</th>
                    <th scope="col">Size</th>
                    <th scope="col">Last Modified</th>
                    <th scope="col">Uploaded File</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($files as $key => $file)
                        <tr>
                            <td scope="col">{{$key+1}}</td>
                            <td scope="col">{{$file->title}}</td>
                            <td scope="col">{{$file->extension}}</td>
                            <td scope="col">{{Storage::size($file->files_path)}} KB</td>
                            <td scope="col">{{$file->updated_at}}</td>
                            <td scope="col">{{$file->created_at}}</td>

                            <td scope="col">
                                @if(!Auth::guest())
                                    @if(Auth::user()->id == $file->user_id)
                                        <a href="/files/{{$file->id}}/edit" class="btn btn-default glyphicon glyphicon-edit"></a>
                                        {!!Form::open(['action' => ['FilesController@destroy', $file->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            <button type="submit" class="glyphicon glyphicon-trash btn btn-danger"></button>
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

