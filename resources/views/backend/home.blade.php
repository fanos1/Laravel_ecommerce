@extends('master')

@section('title', 'Admin Control Panel')

@section('content')
   
   <div	class="container">
		<div class="col-12">
			<h4>Manage users</h4>
			<a href="/admin/users" class="btn btn-primary">All users</a>

			<div>
				<h4>Manage Rolse </h4>
				<a href="/admin/roles" class="btn btn-primary">All Roles</a>
				<a href="/admin/roles/create" class="btn btn-primary">Create A Role</a>
			</div>

			<div>
				<h4>Manage Category </h4>
				<a href="/admin/categories" class="btn btn-primary">All Categories</a>
				<a href="/admin/categories/create" class="btn btn-primary">Create Category</a>
			</div>
			

			<div>
				<h4>Manage Products </h4>
				<a href="/admin/products" class="btn btn-primary">All Products</a>
				<a href="/admin/products/create" class="btn btn-primary">Create Product</a>
			</div>

			<div>
				<h4>Manage Size </h4>
				<a href="/admin/sizes" class="btn btn-primary">All all sizes</a>
				<a href="/admin/sizes/create" class="btn btn-primary">Create Size</a>
			</div>

		</div>	
   </div>		

@endsection