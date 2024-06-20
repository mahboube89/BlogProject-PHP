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
				require_once('./include/dateTime.inc.php');

# ==================================================================================================


            #╔═════════════════════════════════════════════════╗
            #║																	║
            #║          ---| SECURE PAGE ACCESS |---           ║
            #║																	║
            #╚═════════════════════════════════════════════════╝

if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Session start...<i>(" . basename(__FILE__) . ")</i></p>\n";

				//══════════----> PREPARE SESSSION <----═════════

				session_name('wwwblogprojektmahboubede');

            //══════════----> START SESSION <----═════════
            session_start();


// if(DEBUG_A)	echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$_SESSION <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_A)	print_r($_SESSION);					
// if(DEBUG_A)	echo "</pre>";


            //══════════----> CHECK FOR VALID LOGIN <----═════════


            if( isset($_SESSION['ID']) === false OR $_SESSION['IPAddress'] !== $_SERVER['REMOTE_ADDR'] ) {
					

// if(DEBUG)      echo "<p class='debug auth err'><b>Line " . __LINE__ . "</b>: Error: Invalid Session! <i>(" . basename(__FILE__) . ")</i></p>\n";


               //══════════----> DENY PAGE ACCESS <----═════════
               session_destroy();

            } else {
if(DEBUG)      echo "<p class='debug auth ok'><b>Line " . __LINE__ . "</b>: Identification of the session was successful. <i>(" . basename(__FILE__) . ")</i></p>\n";

               //----> Generate a new session ID on every page refresh to enhance security
               session_regenerate_id(true); 

				}

# ==================================================================================================


            #╔═══════════════════════════════════════════════════════╗
            #║																		   ║
            #║          ---| VARIABLEN INITIALISIEREN |---           ║
            #║																		   ║
            #╚═══════════════════════════════════════════════════════╝


				//══════════----> VARIABLEN INITIALISIEREN <----═════════

				//----> Login form section
				$userEmail			= NULL;
				$password			= NULL;

				$errorUserEmail	= NULL; // validateInputString output
				$errorPassword		= NULL; // validateInputString output

				$loginError			= NULL; // Login errors

				$errorLoadBlog		= NULL; // Error by load blogs
			

# ==================================================================================================


            #╔═══════════════════════════════════════════════════════╗
            #║																	      ║
            #║          ---| LOGIN FORM PROCESS |---          			║
            #║																	      ║
            #╚═══════════════════════════════════════════════════════╝


				//══════════----> POST ARRAY PREVIEW <----═════════

// if(DEBUG_A)	echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$_POST <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_A)	print_r($_POST);					
// if(DEBUG_A)	echo "</pre>";


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
					//---->[x] FORM-STEP-3-b : Display detailed error messages in deug and a general error message to the user.
					//---->[-] FORM-STEP-3-c : Pre-assignment of form fields (Not for Login form)

					$errorUserEmail = validateEmail($userEmail);
					$errorPassword = validateInputString($password, minLength:4);

if(DEBUG_V)		echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: \$errorUserEmail: $errorUserEmail <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: \$errorPassword: $errorPassword <i>(" . basename(__FILE__) . ")</i></p>\n";


					//══════════----> FORM-STEP-3-d : FINAL FORM VALIDATION <----═════════
					//---->If successful, proceed to FORM-STEP 4; if not, the processing is aborted
					if( $errorUserEmail !== NULL OR $errorPassword !== NULL) {
if(DEBUG)	      echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Error: There are still errors in the form! <i>(" . basename(__FILE__) . ")</i></p>\n";				

						$loginError= "The email or password you entered is incorrect. Please try again.";

					} else {
if(DEBUG)	      echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: The form is formally error-free. <i>(" . basename(__FILE__) . ")</i></p>\n";				

			         //══════════----> FORM-STEP-4 : Form values processing <----═════════
			         //══════════----> FETCH USER DATA FROM DB <----═════════
                  #╔═════════════════════════════════════════════════════╗
                  #║           ---| DATABASE OPERATIONS |----            ║
                  #╚═════════════════════════════════════════════════════╝						
if(DEBUG)	      echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Database operations start...<i>(" . basename(__FILE__) . ")</i></p>\n";


			         //══════════----> DB-Step-1 : Connet to DB <----═════════
                  $PDO = dbConnect('blogprojekt');

			         //══════════----> DB-Step-2 : Create SQL-Statement and Placeholder-Array <----═════════
                  $sql = 'SELECT userID, userPassword FROM users
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
                  dbClose($PDO, $PDOStatement);

						//══════════----> DISPLAY USER DATA ARRAY <----═════════
// if(DEBUG_A)			echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$userInfos <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_A)			print_r($userInfos);					
// if(DEBUG_A)			echo "</pre>";


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
								
								//══════════----> PREPARE SESSSION <----═════════

								// session_name('wwwblogprojektmahboubede'); // is already started

								if( session_start() === false) {

if(DEBUG)	      			echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Error: Login is currently not possible! Please check if cookies are enabled in your browser! <i>(" . basename(__FILE__) . ")</i></p>\n";
									
									$loginError = 'Login is not possible! Please check if in your browser are cookies activ!';
									
								} else {

if(DEBUG)	      			echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Session has been successfully started. <i>(" . basename(__FILE__) . ")</i></p>\n";

									//══════════----> SAVE USER DATA INTO SESSION FILE <----═════════
									
									$_SESSION['ID']					= $userInfos['userID'];
									$_SESSION['IPAddress'] 			= $_SERVER['REMOTE_ADDR'];
									$_SESSION['isUserLoggedIn'] 	= true;

// if(DEBUG_A)						echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$_SESSION <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_A)						print_r($_SESSION);					
// if(DEBUG_A)						echo "</pre>";

									//══════════----> REDIRECT TO DASHBOARD PAGE <----═════════
									
									header('LOCATION: dashboard.php');

									exit();							

								} // LOGIN PROCESS AND PREPARE SESSSION EN								

							} // PASSWORD VALIDATE END

						} // EMAIL VALIDATE END

					} // FINAL FORM VALIDATION END

				} // LOGIN FORM PROCESS END

# ==================================================================================================


            #╔═══════════════════════════════════════════════════════╗
            #║																	      ║
            #║       ---| FETCH CATEGORY LABELS FORM DB |---         ║
            #║																	      ║
            #╚═══════════════════════════════════════════════════════╝

			   //══════════----> DATABASE OPERATIONS <----═════════
if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Database operations start...<i>(" . basename(__FILE__) . ")</i></p>\n";

			   //══════════----> DB-Step-1 : Connet to DB <----═════════
            $PDO = dbConnect('blogprojekt');

			   //══════════----> DB-Step-2 : Create SQL-Statement and Placeholder-Array <----═════════

            // $sql = 'SELECT * FROM categories';

				$sql = 	'SELECT c.catID, c.catLabel, COUNT(b.blogID) AS numberOfPosts
							FROM categories c
							LEFT JOIN blogs b ON c.catID = b.catID
							GROUP BY c.catID, c.catLabel;';

            $placeholders = array();


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

				//══════════----> CHECK IF ANY CATEGORY HAS BIN LOADED FROM DB<----═════════

				$rowCount = $PDOStatement->rowCount();

if(DEBUG_V)	echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$rowCount: $rowCount <i>(" . basename(__FILE__) . ")</i></p>\n";

				if( $rowCount === 0 ) {

if(DEBUG)		echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Error: No Category was loaded! <i>(" . basename(__FILE__) . ")</i></p>\n";

					$errorLoadCategory = " No Category Was Uploaded! ";


				} else {
if(DEBUG)		echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: $rowCount categories are successfully loaded. <i>(" . basename(__FILE__) . ")</i></p>\n";				


					$categoriesArray= $PDOStatement->fetchALL(PDO::FETCH_ASSOC);

				} // CHECK IF ANY CATEGORY HAS BIN LOADED FROM DB END

// if(DEBUG_A)	echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$categoriesArray <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_A)	print_r($categoriesArray);					
// if(DEBUG_A)	echo "</pre>";



# ==================================================================================================				

            #╔═══════════════════════════════════════════════════════╗
            #║																		   ║
            #║        	---| URL PARAMETER PROCESSES |---	         ║
            #║																		   ║
            #╚═══════════════════════════════════════════════════════╝

				//══════════----> GET ARRAY PREVIEW <----═════════

// if(DEBUG_A)	echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$_GET <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_A)	print_r($_GET);					
// if(DEBUG_A)	echo "</pre>";


				//══════════----> URL-STEP-1 : Check if the url prameters is passed <----═════════

            if(isset($_GET['action']) === true ) {
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: URL parameter 'action' is passed...<i>(" . basename(__FILE__) . ")</i></p>\n";
														
					
					//══════════----> URL-STEP-2 : Reading, defusing and debugging the passed URL-parameters <----═════════ 
if(DEBUG)	   echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Parameters are reading, sanitizing...<i>(" . basename(__FILE__) . ")</i></p>\n";
										
					$action = sanitizeString($_GET['action']);

if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$action: $action <i>(" . basename(__FILE__) . ")</i></p>\n";
					

					//══════════----> URL-STEP-3 : Branch based on the permitted value of the URL parameter <----═════════
					
					#╔═══════════════════════════════════════════════════════╗
            	#║        			---|LOGOUT PROCESS|---			         ║
            	#╚═══════════════════════════════════════════════════════╝
					if( $action === 'logout') {
				
						//══════════----> URL-STEP-4 : Data Processing <----═════════ 
if(DEBUG)	     			echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Logout process start...<i>(" . basename(__FILE__) . ")</i></p>\n";
		
						// ----> 1. Delete session data
						session_destroy();
		
						// ----> 2. Redirect user to index page
						
						header('LOCATION: ./');
						

if(DEBUG)	      echo "<p class='debug'><b>Line " . __LINE__ . "</b>: User is Logged out...<i>(" . basename(__FILE__) . ")</i></p>\n";

		
						exit();
		
					} // LOGOUT PROCESS END 


					#╔═══════════════════════════════════════════════════════╗
            	#║        		---|BLOGS FILTERING PROCESS|---	         ║
            	#╚═══════════════════════════════════════════════════════╝
					
					if( $action === 'showCategory') {
if(DEBUG)	      echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Show filterd category process start...<i>(" . basename(__FILE__) . ")</i></p>\n";

						$selectedCategory = sanitizeString($_GET['id']);

if(DEBUG_V)			echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$selectedCategory: $selectedCategory <i>(" . basename(__FILE__) . ")</i></p>\n";

						$sql =	'SELECT userFirstName, userLastName, userCity, blogHeadline, blogImagePath, blogImageAlignment, blogContent, blogDate, catLabel
									FROM blogs
									INNER JOIN users USING (userID)
									INNER JOIN categories USING (catID)
									WHERE catID = :catID
									ORDER BY blogDate DESC';

						$placeholders = array( 'catID' => $selectedCategory );

					} // BLOGS FILTERING PROCESS

				} else {

					//----> IF NO GET URL PARAMETER IS PASSED MUSS DISPLAY ALL POSTS 
					$sql =	'SELECT userFirstName, userLastName, userCity, blogHeadline, blogImagePath, blogImageAlignment, blogContent, blogDate, catLabel
								FROM blogs
								INNER JOIN users USING (userID)
								INNER JOIN categories USING (catID)
								ORDER BY blogDate DESC';

					$placeholders = array();

				} 
				

				#╔═════════════════════════════════════════════════════╗
				#║																	    ║
				#║         ---|FETCH BLOG-POSTS FROM DB |----          ║
				#║																	    ║
				#╚═════════════════════════════════════════════════════╝
				//══════════----> DB-Step-1 : Connet to DB <----═════════
				// $PDO = dbConnect('blogprojekt'); //---> is already connected

				//══════════----> DB-Step-2 : Create SQL-Statement and Placeholder-Array <----═════════
				//----> IS IN LINE 469
				// $sql = 'SELECT userFirstName, userLastName, userCity, blogHeadline, blogImagePath, blogImageAlignment, blogContent, blogDate, catLabel
				//          FROM blogs
				//          INNER JOIN users USING (userID)
				//          INNER JOIN categories USING (catID)
				//          ORDER BY blogDate DESC';

				// $placeholders = array();


				//══════════----> DB-Step-3 : Prepared Statements <----═════════
				try {
					// Prepare: SQL-Statement vorbereiten
					$PDOStatement = $PDO->prepare($sql);
					
					// Execute: SQL-Statement ausführen und ggf. Platzhalter füllen
					$PDOStatement->execute($placeholders);
					// showQuery($PDOStatement);
					
				} catch(PDOException $error) {
if(DEBUG)         echo "<p class='debug db err'><b>Line " . __LINE__ . "</b>: ERROR: " . $error->GetMessage() . "<i>(" . basename(__FILE__) . ")</i></p>\n";										
            }


				//══════════----> CHECK IF ANY BLOGS HAS BIN LOADED FROM DB<----═════════

				$rowCount = $PDOStatement->rowCount();

if(DEBUG_V)	echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$rowCount: $rowCount <i>(" . basename(__FILE__) . ")</i></p>\n";

				if( $rowCount === 0 ) {

if(DEBUG)		echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Error: No blog post was loaded! <i>(" . basename(__FILE__) . ")</i></p>\n";

					$errorLoadBlog = " No Blog Post Was Uploaded ";


				} else {
if(DEBUG)		echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: $rowCount blogs are successfully loaded. <i>(" . basename(__FILE__) . ")</i></p>\n";				


            	//══════════----> DB-Step-4 : Daten proccess <----═════════
            	//----> Save blogs in an array
            	$allBlogsArray= $PDOStatement->fetchALL(PDO::FETCH_ASSOC);


// if(DEBUG_A)		echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$allBlogsArray <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_A)		print_r($allBlogsArray);					
// if(DEBUG_A)		echo "</pre>";


				} // CHECK IF ANY BLOGS HAS BIN LOADED END

				//══════════----> CLOSE DB CONNECTION <----═════════ 
				dbClose($PDO, $PDOStatement);

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
			

		
			<!-- ========== LOGIN FORM START ========== -->

			<!-- If user is loggedin is Login form hidden -->
			<?php if( !isset($_SESSION['isUserLoggedIn'])  ) : ?> 
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
					<?php if( isset($loginError)): ?><span class="login-error"><?= $loginError ?></span> <?php endif ?>

				</div>
				<!-- ---------- LOGIN FORM END ----------- -->
			<?php else : ?>

				<!-- ========== MENU START ========== -->						
				<div class="header-menu" >

					<ul class="nav">
						<li class="nav-item"><a class="nav-link" href="?action=logout">Logout</a></li>
						<li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
					</ul>

				</div>
				<!-- ---------- MENU END ----------- -->

			<?php endif ?>
			
		
		</header>
		<!-- ---------- HEADER END ----------- -->
		


		<!-- ========== CONTENT START ========== -->
		<main class="container">

			<h1 class="intro-title">______ PHP PROJECT BLOG ______</h1>
			
			<section class="row">

				<!-- ========== BLOG POSTS START ========== -->
					<div class="col-lg-8">
						<div class="blogs-wrapper-header">
								<div class="blog-header-title">
									<h5>Blogs</h5>
								</div>
								<div class="blog-show-all" >
										<a class="show-all-blogs-link" href="index.php">SHOW ALL</a>
								</div>
						</div>

						<h3><?= $errorLoadBlog ?></h3>

						<?php foreach( $allBlogsArray as $blog) : ?>

							<article class="blog-post-container">

								<!-- Category -->
								<h3 class="post-category">Category: <b><?= $blog['catLabel'] ?></b></h3>

								<!-- Post headline -->
								<h2 class="post-title"><?= $blog['blogHeadline'] ?></h2>

								<!-- Author Infos -->
								<div class="post-infos">
									<p>BY <b><?= $blog['userFirstName'] ?> <?= $blog['userLastName'] ?></b> (<?= $blog['userCity'] ?>) am <?= isoToEuDateTime($blog['blogDate'])['date'] ?> um <?= isoToEuDateTime($blog['blogDate'])['time']?> Uhr</p>
								</div>

								<div class="post-content">

									<!-- Image Upload -->
									<figure class="post-img <?= $blog['blogImageAlignment'] ?>">
									
											<img src="<?= $blog['blogImagePath'] ?>" >
										
									</figure>
											
									<!-- Post Content  -->
									<p class="post-paragraph"><?= nl2br( $blog['blogContent'] , false ) ?></p>									
									
								</div>

							</article>
						<?php endforeach ?>

					</div>
				<!-- ---------- BLOGS POSTS END ----------- -->
	
				<!-- ========== CATEGORIES START ========== -->
					<div class="col-lg-4 ">
						<div class="blog-sidebar-category">

							<div class="category-title">
								<h5>Categories</h5>
							</div>

							<!-- Show error if no Category loaded is -->
							<?php if(isset($errorLoadCategory)) : ?>
								<h3><?= $errorLoadCategory ?></h3>
							
								
							<?php else : ?> 
								<!-- if categories was loaded from db -->
								<ul class="cat-list">

									<?php

										// Identify the currently selected category
									 	$currentCatID = isset($_GET['id']) ? $_GET['id'] : NULL;

									 	foreach( $categoriesArray as $category ) : 

										$isActive = ($category['catID'] == $currentCatID ) ? 'cat-active' : ''; // Highlight the selected category
									 
									?>
										<li>
											<a class="category <?= $isActive ?>" href="?action=showCategory&id=<?= $category['catID'] ?>">
												<h5 class="cat-title"><?= $category['catLabel'] ?></h5>
												<h5 class="cat-quantity"><?= $category['numberOfPosts'] ?></h5>
											</a>
										</li>
									<?php endforeach ?>

								</ul>

							<?php endif ?>

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