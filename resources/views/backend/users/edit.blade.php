@extends('master')

@section('title', 'Edit users')

@section('content')
   
   <div	class="container col-md-8 col-md-offset-2">
		<div class="well well bs-component">

			<form	class="form-horizontal"	method="post">
				@foreach($errors->all() as $error)
					<p	class="alert alert-danger">{{ $error }}</p>
				@endforeach

				@if	(session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif

				{!!	csrf_field() !!}

				<fieldset>
					<legend>Edit	user</legend>
					<div class="form-group">
						<label for="name"	class="col-lg-2	control-label">Name</label>
						<div class="col-lg-10">
						<input	type="text"	class="form-control" id="name"	placeholder="Name"	name="name" 
							value="{{ $user->name }}" />
						</div>
					</div>

					<div class="form-group">
						<label	for="email"	class="col-lg-2	control-label">Email</label>
						<div class="col-lg-10">
							<input	type="email" class="form-control" placeholder="Email" name="email" 
							value="{{ $user->email }}" />
						</div>
					</div>
					<div class="form-group">
						<label	for="select"	class="col-lg-2	control-label">Role</label>
						<div class="col-lg-10">
							<select	class="form-control" id="role" name="role[]" multiple>
								@foreach($roles as $role)
									<option	value="{!!	$role->name	!!}" 
										@if(in_array($role->name, $selectedRoles)) selected="selected"	@endif>
										{!! $role->name !!}
									</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group">
						<label	for="password"	class="col-lg-2	control-label">Password</label>
						<div class="col-lg-10">
							<input	type="password"	class="form-control" name="password">
						</div>
					</div>

					<div class="form-group">
						<label	for="password"	class="col-lg-2	control-label">Confirm	password</label>
						<div class="col-lg-10">
							<input	type="password"	class="form-control" name="password_confirmation">
						</div>
					</div>
						<button	type="submit"	class="btn	btn-primary">Submit</button>
				</fieldset>
			</form>

		</div>
	</div>		

@endsection