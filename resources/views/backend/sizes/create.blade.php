@extends('master')
@section('title', 'Create A New Size')

@section('content')
    <div class="container col-md-8 col-md-offset-2">
        <div class="well well bs-component">

            <form class="form-horizontal" method="post">

                @foreach ($errors->all() as $error)
                    <p class="alert alert-danger">{{ $error }}</p>
                @endforeach

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <input type="hidden" name="_token" value="{!! csrf_token() !!}">

                <fieldset>
                    <legend>Create a new Szie</legend>
                    <div class="form-group">
                        <label for="size" class="col-lg-2 control-label">Size name</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="s_name" placeholder="Size name" name="s_name">
                        </div>
                    </div>
					
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
@endsection
