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
            <div class="col-md-12">
                <section class="files">
                    @if(count($files) > 0)
                        @foreach ($files as $user )
                                <div class="card-file mt-3">
                                    <a class="open_dir" href="/files/{{$user->id}}" data-user_id="{{$user->id}}"><h3>{{$user->email}}</h3></a>
                                    <small>Created at {{$user->created_at}} </small>
                                </div>
                        @endforeach
                    @else
                        <p>Files not found</p>
                    @endif
                </section>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" data-toggle="modal" data-target="#myModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/files/" method="GET">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Директория запаролена</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group ">
                                <label for="password">Введите пароль</label>
                                <input type="password" name="password" class="form-control">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Enter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection


{{-- href="/files/{{$file->user_id}}" --}}
<script>
    window.onload = function() {
        const $open_dir = document.querySelectorAll(".open_dir");
        const $myModal = document.querySelector('[data-target="#myModal"]');
        for (const key in $open_dir) {
            if ($open_dir.hasOwnProperty(key)) {
                const element = $open_dir[key];
                element.addEventListener('click', () => {
                    event.preventDefault();
                    if({{Auth::user()->id}} == element.dataset.user_id)
                        window.location.href = "files/"+ element.dataset.user_id;
                    else{
                        $myModal.classList.toggle('modal');
                        $myModal.querySelector('form').action += element.dataset.user_id;
                    }
                })

            }
        }
    }

</script>

