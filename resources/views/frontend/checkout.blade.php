@extends('master')
@section('title', 'Checkout view')
@section('content')

    <div class="container col-md-8 col-md-offset-2">
        

        <div class="well well bs-component">
            <form class="form-horizontal" method="post" action="/checkout">

                @foreach($errors->all() as $error)
                    <p class="alert alert-danger">{{ $error }}</p>
                @endforeach

                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <input type="hidden" name="_token" value="{!! csrf_token() !!}">

                <fieldset>
                    <legend>Customer</legend>
                    <div class="form-group">
                        <label for="email" class="sr-only">email name</label>
                        <div class="col-lg-12">
                            <input type="text" class="form-control" name="email" placeholder="Email" aria-describedby="emailHelp">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email or any other info.</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="first name" class="sr-only">first name</label>
                        <div class="col-lg-12">
                            <input type="text" class="form-control" name="f_name" placeholder="First Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last name" class="sr-only">last name</label>
                        <div class="col-lg-12">
                            <input type="text" class="form-control" name="l_name" placeholder="Last Name">
                        </div>
                    </div>         
                    <div class="form-group">
                        <label for="address" class="sr-only">Address</label>
                        <div class="col-lg-12">
                            <input type="text" class="form-control" name="address1" placeholder="35 Oxford St">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="city" class="sr-only">City</label>
                        <div class="col-lg-12">
                            <input type="text" class="form-control" name="city" placeholder="London">
                        </div>
                    </div>   
                    <div class="form-group">
                        <label for="postcode" class="sr-only">Postcode</label>
                        <div class="col-lg-12">
                            <input type="text" class="form-control" name="post_code" placeholder="N15 5UE">
                        </div>
                    </div>  
                    <div class="form-group">
                        <label for="phone" class="sr-only">Telephone</label>
                        <div class="col-lg-12">
                            <input type="text" class="form-control" name="phone" placeholder="Telephone">
                        </div>
                    </div>                  
                 
                    <div class="form-group">
                        <div class="col-lg-12">
                        <button type="submit" class="btn btn-success">To Billing</button>                        
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

@endsection
