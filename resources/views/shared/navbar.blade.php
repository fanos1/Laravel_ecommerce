<div class="container">	
	<div class="col-12" style="text-align: center;">
	
		@if(Auth::check())
			<a href="/users/logout">Logout</a>
			@role('manager')
				<a href="/admin" title="login to admin">Admin</a>
			@endrole
		@else
			<a href="/users/register">Register</a>
			<a href="/users/login">Login</a>
		@endif
		
	</div>
</div>




<!-- hidden on mobile -->
<div id="desktop-nav">
	<nav class="container" id="top">
		<div class="col-12">
			<ul>
				<?php
					/* 
					$pages = App\Page::where('menu_id', '=', 1)->get(); // 1 is for TOP NAVBAR
					foreach ($pages as $key => $page) {
						// echo "<h3>".$key . "::". $page."</h3>";
						echo "<h3>". $page->title ."</h3>";
					}
					exit();
					*/
				?>
				<li><a href="/" title="home page">Home</a></li>
				<li><a href="/cart" title="home page">Cart</a></li>
				<li><a href="/shop" title="shop page">Shop</a></li>
				<?php 
				/* 
				@foreach(App\Page::all() as $page)
				
					@if($page->slug == 'home')					
						<!-- <li><a href="/" title="home page">Home</a></li> -->
					@else
						<li>
							<a href="{!! action('BlogController@show', $page->slug) !!}" title="{!! $page->slug !!}">
								{!! $page->title !!}
							</a>
						</li>
					@endif			
					
				@endforeach
				*/
				?>
			</ul>
		</div>
	</nav>
	
</div>
