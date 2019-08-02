@extends('master-admin')
@section('title',	'All Sizes')

@section('content')

<div class="container">
   <div class="col-12">
         <div class="panel-heading">
            <h2> All Sizes </h2>
         </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if ($sizes->isEmpty())
                <p> There is no Sizes.</p>
            @else
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Size Name</th>            
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sizes as $prod)
                        <tr>
                            <td>{!! $prod->id !!}</td>
                            <td>
                                <a href="{!! action('Admin\SizesController@edit', $prod->id) !!}">{!! $prod->s_name !!} </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
      </div>
</div>
@endsection

