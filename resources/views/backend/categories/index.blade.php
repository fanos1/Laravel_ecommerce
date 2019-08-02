@extends('master-admin')
@section('title',	'All Category')

@section('content')

<div class="container">
   <div class="col-12">
         <div class="panel-heading">
            <h2> All Category </h2>
         </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if ($categories->isEmpty())
                <p> There is no page.</p>
            @else
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Content</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $categ)
                        <tr>
                            <td>{!! $categ->id !!}</td>
                            <td>
                                <a href="{!! action('Admin\CategoriesController@edit', $categ->id) !!}">    
                                    {!!  $categ->title !!} 
                                </a>
                            </td>                
                            <td>
                                {!! \Illuminate\Support\Str::words($categ->content, 10,'...') !!}
                            </td>
                       
                            <!-- <td>{!! $categ->status ? 'Pending' : 'Answered' !!}</td> -->
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
      </div>
</div>
@endsection

