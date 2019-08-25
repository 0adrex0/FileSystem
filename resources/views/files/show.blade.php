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
            <form action="/search"  method="GET" class="d-inline-block">
                @csrf
                <input type="text" name="search">
                <button type="submit" class="btn" >Search</button>
                <input type="hidden" name="userId" value="{{$userId}}">
            </form>
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
                            <td scope="col">{{$file->size}} KB</td>
                            <td scope="col">{{$file->updated_at}}</td>
                            <td scope="col">{{$file->created_at}}</td>
                            <td scope="col">
                                <div class="d-flex justify-content-around align-items-center text-center">
                                    @if(!Auth::guest())
                                        {{-- @if(Auth::user()->id == $file->user_id) --}}
                                            <a href="/files/{{$file->id}}/edit" class="btn btn-outline-dark"><i class="fas fa-edit"></i></a>
                                            <a href="/download/{{$file->id}}" class="btn btn-primary"><i class="fas fa-file-download"></i></a>
                                            <form action="/files/{{$file->id}}"  method="POST" class="d-inline-block">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        {{-- @endif --}}
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            <hr>


        </div>
    </div>
@endsection

