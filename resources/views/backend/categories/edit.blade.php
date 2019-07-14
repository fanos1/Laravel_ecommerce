@extends('master')
@section('title',	'Single category')

@section('content')

<div class="container">
     <div class="col-12">

            <form class="form-horizontal" method="post" enctype="multipart/form-data">

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
                    <legend>Edit category</legend>
                    <div class="form-group">
                        <label for="title" class="col-lg-2 control-label">Title</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="title" name="title" value="{!! $category->title !!}">
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="slug" class="col-lg-2 control-label">Slug</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="slug" name="slug" value="{!! $category->slug !!}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content" class="col-lg-2 control-label">Content</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" rows="3" id="content" 
                            name="content">{!! $category->content !!}</textarea>
                        </div>
                    </div>
                    
                     <div class="form-group">                      
                        <input type="file" name="img" />
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

