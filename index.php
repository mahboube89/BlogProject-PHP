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
			<div class="header-menu" style="display:none">

				<ul class="nav">
					<li class="nav-item"><a class="nav-link" href="#">Logout</a></li>
					<li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
				</ul>

			</div>
			<!-- ---------- MENU END ----------- -->
		
			<!-- ========== LOGIN FORM START ========== -->
			<div class="login">
				
				<form class="form" action="" method="POST">

					<!-- Hidden input to differentiate this form submission from others -->
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
				<h1>______ PHP BLOG PROJEKT ______</P></h1>

				<!-- ========== SHOW ALL START ========== -->
				<!-- ---------- SHOW ALL  END ----------- -->
	
				<!-- ========== BLOG POSTS START ========== -->
				<!-- ---------- BLOGS POSTS END ----------- -->
	
				<!-- ========== CATEGORIES START ========== -->
				<!-- ---------- CATEGORIES END ----------- -->
			</main>



		<!-- ---------- CONTENT END ----------- -->

		<!-- ========== FOOTER START ========== -->
		<!-- ---------- FOOTER END ----------- -->
		
		
		
	</body>
	
</html>