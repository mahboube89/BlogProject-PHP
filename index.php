<?php

# ══════════════════════════════════════════════════════════════════════════════════════════════════

            #╔═════════════════════════════════════════════════╗
            #║																	║
            #║          ---| PAGE CONFIGURATION |---           ║
            #║																	║
            #╚═════════════════════════════════════════════════╝

				require_once('./include/config.inc.php');
				require_once('./include/form.inc.php');
				require_once('./include/db.inc.php');




# ==================================================================================================



            #╔═══════════════════════════════════════════════════════╗
            #║																		   ║
            #║          ---| VARIABLEN INITIALISIEREN |---           ║
            #║																		   ║
            #╚═══════════════════════════════════════════════════════╝


				//══════════----> VARIABLEN INITIALISIEREN <----═════════

				// $errorUserEmail	= NULL;
				// $errorPassword		= NULL;

				$loginError			= NULL;				

# ==================================================================================================


            #╔═══════════════════════════════════════════════════════╗
            #║																	      ║
            #║          ---| LOGIN FORM PROCESS |---          ║
            #║																	      ║
            #╚═══════════════════════════════════════════════════════╝


				//══════════----> POST ARRAY PREVIEW <----═════════

if(DEBUG_A)	echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$_POST <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
if(DEBUG_A)	print_r($_POST);					
if(DEBUG_A)	echo "</pre>";


				//══════════----> FORM-STEP-1 : Check if the form has been submitted <----═════════
				if(isset($_POST['formType']) && $_POST['formType'] === 'loginForm') {
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Login form ist submitted...<i>(" . basename(__FILE__) . ")</i></p>\n";


					//══════════----> FORM-STEP-2 : Reading, defusing and debugging the passed form values <----═════════ 
if(DEBUG)	   echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Values are reading, sanitizing...<i>(" . basename(__FILE__) . ")</i></p>\n";

					$userEmail	= sanitizeString($_POST['f1']);
					$password 	= sanitizeString($_POST['f2']);

if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$userEmail: $userEmail <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$password: $password <i>(" . basename(__FILE__) . ")</i></p>\n";


					//══════════----> FORM-STEP-3 : Validating the form values <----═════════
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>:Field values are being validated...<i>(" . basename(__FILE__) . ")</i></p>\n";

					//---->[x] FORM-STEP-3-a : Formally validate field values
					//---->[x] FORM-STEP-3-b : Display detailed error messages in the debugger and a general error message to the user.
					//---->[-] FORM-STEP-3-c : Pre-assignment of form fields (Not for Login form)

					$errorUserEmail = validateEmail($userEmail);
					$errorPassword = validateInputString($password, minLength:4);

if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$errorUserEmail: $errorUserEmail <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$errorPassword: $errorPassword <i>(" . basename(__FILE__) . ")</i></p>\n";


					//══════════----> FORM-STEP-3-d : FINAL FORM VALIDATION <----═════════
					//---->If successful, proceed to FORM-STEP 4; if not, the processing is aborted
					if( $errorUserEmail !== NULL OR $errorPassword !== NULL) {
if(DEBUG)	      echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Error: There are still errors in the form! <i>(" . basename(__FILE__) . ")</i></p>\n";				

						$loginError= "The email or password you entered is incorrect. Please try again.";

					} else {
if(DEBUG)	      echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: The form is formally error-free. <i>(" . basename(__FILE__) . ")</i></p>\n";				

			         //══════════----> FORM-STEP-4 : Form values proccessing <----═════════
			         //══════════----> FETCH USER DATA FROM DB <----═════════
                  #╔═════════════════════════════════════════════════════╗
                  #║																	    ║
                  #║           ---| DATABASE OPERATIONS |----            ║
                  #║																	    ║
                  #╚═════════════════════════════════════════════════════╝						
if(DEBUG)	      echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Database operations start...<i>(" . basename(__FILE__) . ")</i></p>\n";


			         //══════════----> DB-Step-1 : Connet to DB <----═════════
                  $PDO = dbConnect('blogprojekt');

			         //══════════----> DB-Step-2 : Create SQL-Statement and Placeholder-Array <----═════════
                  $sql = 'SELECT userPassword FROM users
									WHERE userEmail = :userEmail';

                  $placeholders = array( 'userEmail' => $userEmail );


			         //══════════----> DB-Step-3 : Prepared Statements <----═════════
                  try {
                     // Prepare: SQL-Statement vorbereiten
                     $PDOStatement = $PDO->prepare($sql);
                     
                     // Execute: SQL-Statement ausführen und ggf. Platzhalter füllen
                     $PDOStatement->execute($placeholders);
                     // showQuery($PDOStatement);
                     
                  } catch(PDOException $error) {
if(DEBUG) 		      echo "<p class='debug db err'><b>Line " . __LINE__ . "</b>: ERROR: " . $error->GetMessage() . "<i>(" . basename(__FILE__) . ")</i></p>\n";										
				      }

			         //══════════----> DB-Step-4 : Daten proccess <----═════════
						// Get user data from DB
						$userInfos = $PDOStatement->fetch(PDO::FETCH_ASSOC);


			         //══════════----> CLOSE DB CONNECTION <----═════════ 
if(DEBUG)	      echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Close the DB connection...<i>(" . basename(__FILE__) . ")</i></p>\n";

                  dbClose($PDO, $PDOStatement);

						//══════════----> DISPLAY USER DATA ARRAY <----═════════
if(DEBUG_A)			echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$userInfos <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
if(DEBUG_A)			print_r($userInfos);					
if(DEBUG_A)			echo "</pre>";


						//══════════----> 1.EMAIL VALIDATE <----═════════

if(DEBUG)	      echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Email validation start...<i>(" . basename(__FILE__) . ")</i></p>\n";

						// if userInfos array empty is , returns false
						if( $userInfos === false ) {
if(DEBUG)	      	echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Error: Email '$userEmail' not found in database.! <i>(" . basename(__FILE__) . ")</i></p>\n";

							$loginError= "The email or password you entered is incorrect. Please try again.";

						} else {
if(DEBUG)	      	echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Email '$userEmail' found in database. <i>(" . basename(__FILE__) . ")</i></p>\n";				
							


							//══════════----> 2.PASSWORD VALIDATE <----═════════
if(DEBUG)	      	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Password validation start...<i>(" . basename(__FILE__) . ")</i></p>\n";

							if (password_verify( $password, $userInfos['userPassword']) === false ) {

if(DEBUG)	      		echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Error: Incorrect password for '$userEmail'! <i>(" . basename(__FILE__) . ")</i></p>\n";

								$loginError= "The email or password you entered is incorrect. Please try again.";

							} else {
if(DEBUG)	      		echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Password for '$userEmail' verified successfully. <i>(" . basename(__FILE__) . ")</i></p>\n";

								//══════════----> LOGIN PROCESS START... <----═════════
if(DEBUG)	      		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Starting login process after validation...<i>(" . basename(__FILE__) . ")</i></p>\n";


								//══════════----> REDIRECT TO DASHBOARD PAGE <----═════════
								// header('LOCATION: ./dashboard.php');
								//══════════----> DON'T SHOW LOGIN FORM <----═════════

							} // PASSWORD VALIDATE END

						} // EMAIL VALIDATE END

					} // FINAL FORM VALIDATION END

				} // LOGIN FORM PROCESS END




# ══════════════════════════════════════════════════════════════════════════════════════════════════
?>

<!doctype html>

<html>
	
	<head>	
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">		
		<title>PHP Blog Projekt</title>
		
		<link rel="stylesheet" href="./css/debug.css">
		<link rel="stylesheet" href="./css/main.css">
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
				
				<form class="form" action="" method="POST">

					<!-- Hidden input to differentiate from -->
					<input type="hidden" name="formType" value="loginForm">

					<!-- Email input box -->
					<div class="textbox">
						<input type="text" name="f1" id="email" placeholder="" >
						<label for="email">Enter your email</label>
					</div>

					<!-- Password input box -->
					<div class="textbox">
						<input type="password" name="f2" id="password" placeholder="" >
						<label for="password">Enter your password</label>
					</div>

					<!-- Submit button for the form -->
					<button type="submit" class="login-submit" >LOGIN</button>

				</form>

				<!-- Placeholder for error messages -->
				<span class="login-error"><?= $loginError ?></span>

			</div>
			<!-- ---------- LOGIN FORM END ----------- -->
		
		</header>
		<!-- ---------- HEADER END ----------- -->
		
		<a href="dashboard.php">Dashboard</a>

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