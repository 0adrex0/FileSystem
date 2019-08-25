@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="/settings" method="POST">
                @csrf
                <div class="form-group">
                    <label for="isPublic">Create public Directory?</label>
                    <input type="checkbox" name="isPublic">
                </div>
                <div class="directory-password d-none">
                    <div class="form-group ">
                        <label for="password">Create public password?</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                </div>
                <div class="form-group ">
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <button type="submit" class="btn btn-success">Save data</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 offset-0">
            <div class="card card-default">
                <div class="card-header">Files table</div>
                <div class="card-body">
                    <a href="/files/create" class="btn btn-primary mb-3"> Add Files</a>
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
                                    <td><a href="/files/{{$file->id}}/edit" class="btn btn-primary"><i class="fas fa-edit"></a></td>
                                    <td>
                                        <form action="/files/{{$file->id}}"  method="POST" class="d-inline-block">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                        </form>
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

<script>
        window.onload = () => {
            let checkbox = document.querySelector('input[name="isPublic"]');
            let hideItems = document.querySelector('.directory-password');
            checkbox.addEventListener('click', () => {
                    hideItems.classList.toggle('d-none');
            })
            console.log(checkbox);
        }

    </script>
