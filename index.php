<?php

# ══════════════════════════════════════════════════════════════════════════════════════════════════

#					╔═════════════════════════════════════════════════════╗
#					║																		║
#					║					---| PAGE CONFIGURATION |---				║
#					║																		║
#					╚═════════════════════════════════════════════════════╝

					require_once('./include/config.inc.php');



# ==================================================================================================



#					╔═════════════════════════════════════════════════════╗
#					║																		║
#					║				---| VARIABLEN INITIALISIEREN |---			║
#					║																		║
#					╚═════════════════════════════════════════════════════╝


# ══════════════════════════════════════════════════════════════════════════════════════════════════
?>

<!doctype html>

<html>
	
	<head>	
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">		
		<title>PHP Blog Projekt</title>
		
		<link rel="stylesheet" href="./css/main.css">
		<link rel="stylesheet" href="./css/debug.css">
	</head>
	

	<body>	
			
		<!-- ========== HEADER START ========== -->		
		<header class="container">
			
			<!-- ========== MENU START ========== -->
			<div class="header-menu hidden" >

				<ul class="nav">
					<li class="nav-item"><a class="nav-link" href="#">Logout</a></li>
					<li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
				</ul>

			</div>
			<!-- ---------- MENU END ----------- -->
		
			<!-- ========== LOGIN FORM START ========== -->
			<div class="login">
				
				<form class="form" action="" method="post">

					<!-- Hidden input to differentiate from -->
					<input type="hidden" name="loginForm">

					<!-- Email input box -->
					<div class="textbox">
						<input type="email" name="email" id="email" placeholder="" autocomplete="off">
						<label for="email">Email</label>
					</div>

					<!-- Password input box -->
					<div class="textbox">
						<input type="password" name="password" id="password" placeholder="" autocomplete="off">
						<label for="password">Password</label>
					</div>

					<!-- Submit button for the form -->
					<button class="login-submit" >LOGIN</button>

				</form>

				<!-- Placeholder for error messages -->
				<span class="login-error">ERROR MESSAGES</span>

			</div>
			<!-- ---------- LOGIN FORM END ----------- -->
		
		</header>
		<!-- ---------- HEADER END ----------- -->
		


		<!-- ========== CONTENT START ========== -->
		<main class="container">

			<h1 class="intro-title">______ PHP PROJECT BLOG ______</h1>
			
			<section class="row">

				<!-- ========== SHOW ALL START ========== -->
				<!-- ---------- SHOW ALL  END ----------- -->


				<!-- ========== BLOG POSTS START ========== -->
					<div class="col-lg-8">
						<div class="blogs-wrapper-header">
								<div class="blog-header-title">
									<h5>Blogs</h5>
								</div>
								<div class="blog-show-all" >
										<a class="show-all-blogs-link" href="#">SHOW ALL</a>
								</div>
						</div>


						<article class="blog-post-container">							

							<h3 class="post-category">Category: ???</h3>

							<h2 class="post-title">BLOG Title</h2>
							<div class="post-infos">
								<p>BY ??? ??? am 24.08.2017 um 12:33 Uhr</p>
							</div>
							<div class="post-content">

								<figure class="post-img right">
									<img src="./css/images/product-01.png" alt=""  >
								</figure>
								
								
								<p class="post-paragraph">
									Lorem ipsum dolor sit 
									amet consectetur, adipisicing 
									elit. Tenetur accusantium amet, 
									culpa exercitationem voluptatem 
									itaque repellat asperiores? Quam r
									ecusandae itaque ipsum beatae conseq
									uuntur? Molestiae non quae cum vero
										totam beatae.
										
										Lorem ipsum dolor sit 
									amet consectetur, adipisicing 
									elit. Tenetur accusantium amet, 
									culpa exercitationem voluptatem 
									itaque repellat asperiores? Quam r
									ecusandae itaque ipsum beatae conseq
									uuntur? Molestiae non quae cum vero
										totam beatae.
										Lorem ipsum dolor sit 
									amet consectetur, adipisicing 
									elit. Tenetur accusantium amet, 
									culpa exercitationem voluptatem 
									itaque repellat asperiores? Quam r
									ecusandae itaque ipsum beatae conseq
									uuntur? Molestiae non quae cum vero
										totam beatae.
									
								</p>

								
								
							</div>

						</article>



						<article class="blog-post-container">
							

							<h3 class="post-category">Category: ???</h3>

							<h2 class="post-title">BLOG Title</h2>
							<div class="post-infos">
								<p>BY ??? ??? am 24.08.2017 um 12:33 Uhr</p>
							</div>
							<div class="post-content">

								<figure class="post-img left">
									<img src="./css/images/product-01.png" alt=""  >
								</figure>
								
								
								<p class="post-paragraph">
									Lorem ipsum dolor sit 
									amet consectetur, adipisicing 
									elit. Tenetur accusantium amet, 
									culpa exercitationem voluptatem 
									itaque repellat asperiores? Quam r
									ecusandae itaque ipsum beatae conseq
									uuntur? Molestiae non quae cum vero
										totam beatae.
										
										Lorem ipsum dolor sit 
									amet consectetur, adipisicing 
									elit. Tenetur accusantium amet, 
									culpa exercitationem voluptatem 
									itaque repellat asperiores? Quam r
									ecusandae itaque ipsum beatae conseq
									uuntur? Molestiae non quae cum vero
										totam beatae.
										Lorem ipsum dolor sit 
									amet consectetur, adipisicing 
									elit. Tenetur accusantium amet, 
									culpa exercitationem voluptatem 
									itaque repellat asperiores? Quam r
									ecusandae itaque ipsum beatae conseq
									uuntur? Molestiae non quae cum vero
										totam beatae.
									
								</p>

									
									
								</div>


							

						</article>



					</div>
				<!-- ---------- BLOGS POSTS END ----------- -->
	
				<!-- ========== CATEGORIES START ========== -->
					<div class="col-lg-4 ">
						<div class="blog-sidebar-category">
							<div class="category-title">
								<h5>Categories</h5>
							</div>

							<ul class="cat-list">
								<li>
									<a class="category" href="#">
										<h5 class="cat-title">Design</h5>
										<h5 class="cat-quantity">12</h5>
									</a>
								</li>
								<li>
									<a class="category" href="#">
										<h5 class="cat-title">Design</h5>
										<h5 class="cat-quantity">12</h5>
									</a>
								</li>
								<li>
									<a class="category" href="#">
										<h5 class="cat-title">Design</h5>
										<h5 class="cat-quantity">12</h5>
									</a>
								</li>
								
								
							</ul>

							
						</div>

					</div>
				<!-- ---------- CATEGORIES END ----------- -->

			</section>
		</main>



		<!-- ---------- CONTENT END ----------- -->

		<!-- ========== FOOTER START ========== -->
		<!-- ---------- FOOTER END ----------- -->
		
		
		
	</body>
	
</html>