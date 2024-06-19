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

            $newCategoryName = NULL;
            $errorNewCategoryName = NULL;

            $addCategoryUserMessage = NULL;




# ==================================================================================================


            #╔═════════════════════════════════════════════════╗
            #║																	║
            #║          ---| SECURE PAGE ACCESS |---           ║
            #║																	║
            #╚═════════════════════════════════════════════════╝

				//══════════----> PREPARE SESSSION <----═════════

				session_name('wwwblogprojektmahboubede');

            //══════════----> START SESSION <----═════════
            session_start();


if(DEBUG_A)	echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$_SESSION <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
if(DEBUG_A)	print_r($_SESSION);					
if(DEBUG_A)	echo "</pre>";


            //══════════----> CHECK FOR VALID LOGIN <----═════════


            if(isset($_SESSION['ID']) === false OR $_SESSION['IPAddress'] !== $_SERVER['SERVER_ADDR'] ) {
if(DEBUG)      echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Error: Login validation is currently not possible! <i>(" . basename(__FILE__) . ")</i></p>\n";


               //══════════----> DENY PAGE ACCESS <----═════════
               session_destroy();

               //══════════----> REDIRECT TO INDEX PAGE <----═════════
               header('LOCATION: ./');

               //----> Terminate script execution as a security fallback
               exit(); 


            } else {
if(DEBUG)      echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Login has been successfully validated. <i>(" . basename(__FILE__) . ")</i></p>\n";

               //----> Generate a new session ID on every page refresh to enhance security
               session_regenerate_id(true); 


               //══════════----> SHOW USER FIRSTNAME AND LASTNAME IN HEADER <----═════════

               $userID = $_SESSION['ID'];

               //══════════----> FETCH USER DATA FROM DB <----═════════
               #╔═════════════════════════════════════════════════════╗
               #║																	    ║
               #║           ---| DATABASE OPERATIONS |----            ║
               #║																	    ║
               #╚═════════════════════════════════════════════════════╝

if(DEBUG)	   echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Fetch user data from DB...<i>(" . basename(__FILE__) . ")</i></p>\n";

               //══════════----> DB-Step-1 : Connet to DB <----═════════
               $PDO = dbConnect('blogprojekt');

               //══════════----> DB-Step-2 : Create SQL-Statement and Placeholder-Array <----═════════
               $sql = 'SELECT userFirstName, userLastName FROM users
                        WHERE userID = :userID';

               $placeholders = array('userID' => $userID);


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

			      //══════════----> DB-Step-4 : Daten proccess <----═════════
					// Get user data from DB
					$userInfos     = $PDOStatement->fetch(PDO::FETCH_ASSOC);

               $userFirstName = $userInfos['userFirstName'];
               $userLastName  = $userInfos['userLastName'];

               //══════════----> CLOSE DB CONNECTION <----═════════ 
               dbClose($PDO, $PDOStatement);

// if(DEBUG_A)		echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$userInfos <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_A)		print_r($userInfos);					
// if(DEBUG_A)		echo "</pre>";


            } // CHECK FOR VALID LOGIN END


# ==================================================================================================


            #╔═══════════════════════════════════════════════════════╗
            #║																		   ║
            #║        ---| LOGOUT PROCESS-URL PARAMETER |---         ║
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

               if( $action === 'logout') {

                  //══════════----> URL-STEP-4 : Data Processing <----═════════ 
if(DEBUG)	      echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Logout process start...<i>(" . basename(__FILE__) . ")</i></p>\n";

                  // ----> 1. Delete session data
                  session_destroy();

                  // ----> 2. Redirect user to index page
                  header('LOCATION: ./');

                  exit();

               } // Branch based on the permitted value END

            } // LOGOUT PROCESS-URL PARAMETER


# ==================================================================================================


            #╔═══════════════════════════════════════════════════════╗
            #║																	      ║
            #║          ---| NEW CATEGORY FORM PROCESS |---          ║
            #║																	      ║
            #╚═══════════════════════════════════════════════════════╝


				//══════════----> POST ARRAY PREVIEW <----═════════

// if(DEBUG_A)	echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$_POST <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_A)	print_r($_POST);					
// if(DEBUG_A)	echo "</pre>";

				//══════════----> FORM-STEP-1 : Check if the form has been submitted <----═════════
            if(isset($_POST['formType']) && $_POST['formType'] === 'newCategory') {
if(DEBUG)	   echo "<p class='debug'><b>Line " . __LINE__ . "</b>: New category form ist submitted... <i>(" . basename(__FILE__) . ")</i></p>\n";

				   //══════════----> FORM-STEP-2 : Reading, defusing and debugging the passed form values <----═════════ 
if(DEBUG)	   echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Values are reading, sanitizing...<i>(" . basename(__FILE__) . ")</i></p>\n";


               $newCategoryName = sanitizeString($_POST['newCategoryName']);
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$newCategoryName: $newCategoryName <i>(" . basename(__FILE__) . ")</i></p>\n";


				   //══════════----> FORM-STEP-3 : Validating the form values <----═════════
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>:Field values are being validated...<i>(" . basename(__FILE__) . ")</i></p>\n";

               //---->[x] FORM-STEP-3-a : Formally validate field values
               //---->[x] FORM-STEP-3-b : Display error message in the form
               //---->[x] FORM-STEP-3-c : Pre-assignment of form fields
               $errorNewCategoryName = validateInputString($newCategoryName , minLength:3);

				   //══════════----> FORM-STEP-3-d : FINAL FORM VALIDATION <----═════════
//					---->If successful, proceed to STEP 4; if not, the processing is aborted 
               if($errorNewCategoryName !== NULL) {
if(DEBUG)	      echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Error: There are still errors in the form! <i>(" . basename(__FILE__) . ")</i></p>\n";				


               } else {
if(DEBUG)	      echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: The form is formally error-free. <i>(" . basename(__FILE__) . ")</i></p>\n";				
                  
			         //══════════----> FORM-STEP-4 : Form values proccessing <----═════════

                  #╔═════════════════════════════════════════════════════╗
                  #║																	    ║
                  #║           ---| DATABASE OPERATIONS |----            ║
                  #║																	    ║
                  #╚═════════════════════════════════════════════════════╝


if(DEBUG)	      echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Database operations start...<i>(" . basename(__FILE__) . ")</i></p>\n";

			         //══════════----> DB-Step-1 : Connet to DB <----═════════
                  $PDO = dbConnect('blogprojekt');

			         //══════════----> DB-Step-2 : Create SQL-Statement and Placeholder-Array <----═════════
                  $sql = 'SELECT COUNT(catLabel) FROM categories
                           WHERE catLabel = :newCategoryName';

                  $placeholders = array( 'newCategoryName' => $newCategoryName );


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

                  //══════════----> CHECK IF THE CATEGORY ALREADY EXISTS IN DB <----═════════
if(DEBUG)	      echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Check if category already exists in DB...<i>(" . basename(__FILE__) . ")</i></p>\n";

                  $count = $PDOStatement->fetchColumn();
if(DEBUG_V)		   echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$count: $count <i>(" . basename(__FILE__) . ")</i></p>\n";

                  if($count !== 0) {
                     // if the category already exists in the database
if(DEBUG)	         echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Error: This category is already in the database! <i>(" . basename(__FILE__) . ")</i></p>\n";				
                     $errorNewCategoryName = 'This category already exists.';

                  } else {
                     // if the category does not exist in the database
if(DEBUG)	         echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: This category is NOT already in the database.. <i>(" . basename(__FILE__) . ")</i></p>\n";				

			            //══════════----> SAVE NEW CATEGORY INTO DB <----═════════
if(DEBUG)	         echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Save new Category in DB...<i>(" . basename(__FILE__) . ")</i></p>\n";



			            //══════════----> DB-Step-2 : Create SQL-Statement and Placeholder-Array <----═════════
                     $sql = 'INSERT INTO categories(catLabel)
                              VALUES(:newCategoryName)';

                     $placeholders = array( 'newCategoryName' => $newCategoryName );


			            //══════════----> DB-Step-3 : Prepared Statements <----═════════
                     try {
                     // Prepare: SQL-Statement vorbereiten
                     $PDOStatement = $PDO->prepare($sql);

                     // Execute: SQL-Statement ausführen und ggf. Platzhalter füllen
                     $PDOStatement->execute($placeholders);
                     // showQuery($PDOStatement);

                     } catch(PDOException $error) {
if(DEBUG) 		         echo "<p class='debug db err'><b>Line " . __LINE__ . "</b>: ERROR: " . $error->GetMessage() . "<i>(" . basename(__FILE__) . ")</i></p>\n";										
                     }

			            //══════════----> DB-Step-4 : Daten proccess <----═════════

			            //══════════----> CHECK IF CATEGORY HAS BEEN SUCCESSFULLY SAVED IN DB <----═════════
                     $rowCount = $PDOStatement->rowCount();
if(DEBUG_V)		      echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$rowCount: $rowCount <i>(" . basename(__FILE__) . ")</i></p>\n";
                     
                     if( $rowCount !== 1) {
if(DEBUG)	            echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Error: Failed to save the category in the database! <i>(" . basename(__FILE__) . ")</i></p>\n";				

                        $addCategoryUserMessage = "An error occurred while saving the category. Please try again later.";
                        //TODO: dbClose($PDO, $PDOStatement);?

                     } else {
                        // Display the ID of the last inserted record after saving the category to the DB.
                        $newCategoryID = $PDO->lastInsertID();

if(DEBUG)	            echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: The category $newCategoryName with ID $newCategoryID has been successfully saved. <i>(" . basename(__FILE__) . ")</i></p>\n";				
                        
                        $addCategoryUserMessage="The category $newCategoryName has been successfully saved.";

                     } // CHECK IF CATEGORY HAS BEEN SUCCESSFULLY SAVED IN DB END

			            //══════════----> CLOSE DB CONNECTION <----═════════ 
if(DEBUG)	         echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Close the DB connection...<i>(" . basename(__FILE__) . ")</i></p>\n";

                     //TODO: dbClose($PDO, $PDOStatement); 


			            //══════════----> EMPTY CATEGORY FORM FIELD  <----═════════                      
                     $newCategoryName = NULL ; 

                     //TODO : Wo soll ich addCategoryUserMessage leer machen?

                  } // CHECK IF THE CATEGORY ALREADY EXISTS IN DB END

               } // Step-3-d FORM: FINAL FORM VALIDATION END   
   
            }	// NEW CATEGORY FORM PROCESS END


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
            $sql = 'SELECT * FROM categories';

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

            $categoriesArray= $PDOStatement->fetchALL(PDO::FETCH_ASSOC);

// if(DEBUG_A)	echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$categoriesArray <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_A)	print_r($categoriesArray);					
// if(DEBUG_A)	echo "</pre>";


# ==================================================================================================
#				╔═════════════════════════════════════════════════════╗
#				║																	   ║
#				║        ---| NEW POST BLOG FORM PROCESS |----        ║
#				║																	   ║
#				╚═════════════════════════════════════════════════════╝


#				══════════----> POST ARRAY PREVIEW <----═════════

// if(DEBUG_A)	echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$_POST <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_A)	print_r($_POST);					
// if(DEBUG_A)	echo "</pre>";

#				══════════----> STEP-1 FORM: Check if the form has been submitted <----═════════
            if(isset($_POST['formType']) && $_POST['formType'] === 'newPost') {
if(DEBUG)	   echo "<p class='debug'><b>Line " . __LINE__ . "</b>: New post form ist submitted... <i>(" . basename(__FILE__) . ")</i></p>\n";

#				══════════----> STEP-2 FORM: Reading, defusing and debugging the passed form values <----═════════ 
if(DEBUG)	   echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Values are reading, sanitizing...<i>(" . basename(__FILE__) . ")</i></p>\n";


               // $value = sanitizeString($_POST['value']);
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$value: $value <i>(" . basename(__FILE__) . ")</i></p>\n";


#				══════════----> STEP-3 FORM: Validating the form values <----═════════
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>:Field values are being validated...<i>(" . basename(__FILE__) . ")</i></p>\n";
            }
// 			   ---->[x] STEP-3-a FORM: Formally validate field values
//					---->[x] STEP-3-b FORM: Display error message in the form
//					---->[x] STEP-3-c FORM: Pre-assignment of form fields
               // $errorvalue = validateInputString($value , minLength:3);
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
			<div class="dashboard-header" >

            <div class="greeting">
               <p>Welcome Back <b><?= $userFirstName ?> <?= $userLastName ?> !</b></p>
            </div>

				<ul class="nav">
					<li class="nav-item"><a class="nav-link" href="?action=logout">Logout</a></li>
					<li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
				</ul>


			</div>
			<!-- ---------- MENU END ----------- -->

      </header>
      <!-- ---------- HEADER END ----------- -->


      <!-- ========== CONTENT START ========== -->
      <main class="container">


         <h1 class="intro-title">______ PHP PROJECT BLOG - DASHBOARD ______</h1>

         <!-- ========== SHOW USER SUCCESS MESSAGE START ========== -->
         <div class="message-wrapper">

            <h3 class="post-message"></h3>
            <h3 class="cat-message "><?= $addCategoryUserMessage ?></h3>

         </div>
         <!-- ---------- SHOW USER SUCCESS MESSAGE END ----------- -->
         
         

         <section class="row">

            <!-- ========== NEW BLOG SIDEBAR START ========== -->
            <div class="col-lg-8">

               <!-- Form title -->
               <div class="section-title new-post-header">
                  <h5>New Post</h5>
               </div>

               <!-- ========== NEW BLOG FORM START ========== -->  
               <div class="box new-post">
                  
                  <form action="" method="post" enctype="multipart/form-data" >

                     <!-- Hidden input to differentiate this form submission from new category from -->
                     <input type="hidden" name="formType" value="newPost">

                     <!-- Category selection -->
                     <select name="categorySelection" class="cat-selection">

                        <?php foreach( $categoriesArray AS $category) : ?>
                           <option value="<?= $category['catID'] ?>" <?php if($categorySelection == $category['catLabel']) echo 'selected' ?> ><?= $category['catLabel'] ?></option>

                        <?php endforeach ?>

                     </select>

                     <!-- Headline -->
                     <div class="textbox">
                        <input type="text" name="postHeadline" id="headline" placeholder="" autocomplete="off">
                        <label for="headline">Enter headline here</label>
                     </div>

                     
                     <fieldset class="img-upload-wrapper">
                        <legend>&nbsp;Featured Image&nbsp;</legend>

                        <div class="upload">
                           <!-- Image Upload -->  
                           <input type="file" name="postImage" id="postImage" placeholder="Upload an image" autocomplete="off">

                           <!-- Image alignment -->
                           <select name="imageAlignment" class="img-align-selection">
                              <option value="alignLeft">align left</option>
                              <option value="alignRight">align right</option>
                           </select>

                        </div>
                     </fieldset>

                     <!-- Textarea -->
                     <textarea name="postContent" placeholder="Write your blog post here ..."></textarea>
                     

                     <!-- Submit button -->
                     <button type="submit" class="publish-submit" >Publish</button>

                  </form>                  
               </div>
               <!-- ---------- NEW BLOG FORM END ----------- -->

            </div>
            <!-- ---------- NEW BLOG SIDEBAR END ----------- -->





            <!-- ========== NEW CATEGORY SIDEBAR START ========== -->
            <div class="col-lg-4">

               <!-- Form title -->
               <div class="section-title">
                  <h5>Create new category</h5>
               </div>

               <!-- ========== NEW CATEGORY FORM START ========== -->
               <div class="box new-cat-container">

                  <form action="" method="post">

                     <!-- Hidden input to differentiate this form submission from new blog from -->                   
                     <input type="hidden" name="formType" value="newCategory">

                     
                     <div class="textbox">
                        <input type="text" value="<?= $newCategoryName ?>" name="newCategoryName" id="newCategoryName" placeholder="" autocomplete="off">
                        <label for="newCategoryName">Enter category name</label>
                     </div>
                     
                     <!-- Show error to user -->
                     <p class="error-msg"><?= $errorNewCategoryName ?></p>

                     <!-- Submit button -->
                     <button type="submit" class="category-submit" >Create</button>

                  </form>
               </div>
               <!-- ---------- NEW CATEGORY FORM END ----------- -->


            </div>
            <!-- ---------- NEW CATEGORY SIDEBAR END ----------- -->

         </section>

      </main>		
      <!-- ---------- CONTENT END ----------- -->
		
		
		
		
		
	</body>
	
</html>