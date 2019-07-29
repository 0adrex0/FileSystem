@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <a href="/files/create" class="btn btn-primary"> Create Directory</a>
                    <h3>Your Files Directory</h3>
                    @if(count($files) > 0)
                        <table class="table table-striped">
                            <tr>
                                <th>Directory Name</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach ($files as $file)
                                <tr>
                                    <td>{{$file->title}}</td>
                                    <td>{{$file->created_at}}</td>
                                    <td>{{$file->updated_at}}</td>
                                    <td><a href="/files/{{$file->id}}/edit" class="btn btn-primary">Edit</a></td>
                                    <td>
                                        {!!Form::open(['action' => ['FilesController@destroy', $file->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                        {!!Form::close()!!}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p>You have no directories</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
