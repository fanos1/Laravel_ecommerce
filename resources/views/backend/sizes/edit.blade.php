@extends('master-admin')
@section('title',	'Single size edit')

@section('content')

<div class="container">
     <div class="col-12">

            <form class="form-horizontal" method="post">

                @foreach ($errors->all() as $error)
                    <h3 class="alert alert-danger">{{ $error }}</h3>
                @endforeach

                @if (session('status'))
                    <h3 class="alert alert-success">
                        {{ session('status') }}
                    </h3>
                @endif

                <input type="hidden" name="_token" value="{!! csrf_token() !!}">

                <fieldset>
                    <legend>Edit product</legend>
                    <div class="form-group">
                        <label for="size" class="col-lg-2 control-label">Size</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="title" name="s_name" value="{!! $size->s_name !!}">
                        </div>
                    </div>               				

                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
</div>
@endsection

