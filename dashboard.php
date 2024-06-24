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


            #╔═════════════════════════════════════════════════╗
            #║																	║
            #║          ---| SECURE PAGE ACCESS |---           ║
            #║																	║
            #╚═════════════════════════════════════════════════╝

				//══════════----> PREPARE SESSSION <----═════════

				session_name('wwwblogprojektmahboubede');

            //══════════----> START SESSION <----═════════
            session_start();


// if(DEBUG_A)	echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$_SESSION <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_A)	print_r($_SESSION);					
// if(DEBUG_A)	echo "</pre>";


            //══════════----> CHECK FOR VALID SESSION <----═════════

            // TODO:  first if( session_start() === false) and in else write we the rest code 

            if(isset($_SESSION['ID']) === false OR $_SESSION['IPAddress'] !== $_SERVER['REMOTE_ADDR'] ) {
if(DEBUG)      echo "<p class='debug auth err'><b>Line " . __LINE__ . "</b>: Error: Invslid Session! <i>(" . basename(__FILE__) . ")</i></p>\n";


               //══════════----> DENY PAGE ACCESS <----═════════
               session_destroy();

               //══════════----> REDIRECT TO INDEX PAGE <----═════════
              
               header('LOCATION: index.php');

               //----> Terminate script execution as a security fallback
               exit(); 


            } else {
if(DEBUG)      echo "<p class='debug auth ok'><b>Line " . __LINE__ . "</b>: Identification of the session was successful. <i>(" . basename(__FILE__) . ")</i></p>\n";

               //----> Generate a new session ID on every page refresh to enhance security
               session_regenerate_id(true); 


               //══════════----> SHOW USER FIRSTNAME AND LASTNAME IN HEADER <----═════════
               $userID = $_SESSION['ID'];

            } // CHECK FOR VALID SESSION END


# ==================================================================================================


            #╔═══════════════════════════════════════════════════════╗
            #║																		   ║
            #║          ---| VARIABLEN INITIALISIEREN |---           ║
            #║																		   ║
            #╚═══════════════════════════════════════════════════════╝

            //══════════----> VARIABLEN INITIALISIEREN <----═════════

            //----> Category form section
            $newCategoryName           = NULL;
            $errorNewCategoryName      = NULL;
            $addCategoryUserMessage    = NULL;

            //----> Blog form section
            $validAlignments = ['alignLeft', 'alignRight'];
            $categoryPlaceholder = "Please add a new category via the category form";

            $categorySelection         = NULL;
            $postHeadline              = NULL;
            $imageAlignment            = NULL;
            $imageAlignment            = NULL; 
            $postContent               = NULL;
            $addPostUserMessage        = NULL;

            $errorCategorySelection    = NULL;
            $errorPostHeadline         = NULL;
            $errorImageUpload          = NULL;
            $errorPostContent          = NULL;
            $errorImageAlignment       = NULL;

            //----> User greeting
            $userFirstName             = NULL; 
            $userLastName              = NULL;
            $userAvatarPath            = NULL;


# ==================================================================================================


               #╔═════════════════════════════════════════════════════╗
               #║																	    ║
               #║          ---|FETCH USER DATA FROM DB |----          ║
               #║																	    ║
               #╚═════════════════════════════════════════════════════╝
               //══════════------> DATABASE OPERATIONS <------═════════


if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Fetch user data from DB...<i>(" . basename(__FILE__) . ")</i></p>\n";

            //══════════----> DB-Step-1 : Connet to DB <----═════════
            $PDO = dbConnect('blogprojekt');

            //══════════----> DB-Step-2 : Create SQL-Statement and Placeholder-Array <----═════════
            $sql = 'SELECT userFirstName, userLastName, userAvatarPath FROM users
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

            //══════════----> CHECK IF ANY USER DATA HAS BIN LOADED FROM DB<----═════════

				$rowCount = $PDOStatement->rowCount();

if(DEBUG_V)	echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$rowCount: $rowCount <i>(" . basename(__FILE__) . ")</i></p>\n";
            
            if( $rowCount === 0 ) {
            
if(DEBUG)	echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Error: No user data was loaded! <i>(" . basename(__FILE__) . ")</i></p>\n";
            
            // $errorLoadUser = " No User Data Was Uploaded! ";            
            
            } else {
if(DEBUG)	   echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: User data are successfully loaded. <i>(" . basename(__FILE__) . ")</i></p>\n";				
            
            
               // SAve user data in an array
               $userInfos        = $PDOStatement->fetch(PDO::FETCH_ASSOC);

// if(DEBUG_A)		echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$userInfos <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_A)		print_r($userInfos);					
// if(DEBUG_A)		echo "</pre>";

if(DEBUG)	   echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Fetch user data from DB successfully...<i>(" . basename(__FILE__) . ")</i></p>\n";
                        
                        $userFirstName    = $userInfos['userFirstName'];
                        $userLastName     = $userInfos['userLastName'];
                        $userAvatarPath   = $userInfos['userAvatarPath'];
            
            } // CHECK IF ANY USER DATA HAS BIN LOADED FROM DB END

            //══════════----> CLOSE DB CONNECTION <----═════════ 
            dbClose($PDO, $PDOStatement);


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
            #║       ---| FETCH CATEGORY LABELS FORM DB |---         ║
            #║																	      ║
            #╚═══════════════════════════════════════════════════════╝


            #╔═════════════════════════════════════════════════════╗
            #║           ---| DATABASE OPERATIONS |----            ║
            #╚═════════════════════════════════════════════════════╝
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


            //══════════----> DB-Step-4 : Daten proccess <----═════════
            //----> Save categories in an array
            $categoriesArray= $PDOStatement->fetchALL(PDO::FETCH_ASSOC);

            //══════════----> CLOSE DB CONNECTION <----═════════ 
            dbClose($PDO, $PDOStatement);

// if(DEBUG_A)	echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$categoriesArray <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_A)	print_r($categoriesArray);					
// if(DEBUG_A)	echo "</pre>";


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
               $errorNewCategoryName = validateInputString($newCategoryName , minLength:3 , maxLength:50);

				   //══════════----> FORM-STEP-3-d : FINAL FORM VALIDATION <----═════════
//					---->If successful, proceed to STEP 4; if not, the processing is aborted 
               if($errorNewCategoryName !== NULL) {
if(DEBUG)	      echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Error: There are still errors in the form! <i>(" . basename(__FILE__) . ")</i></p>\n";				


               } else {
if(DEBUG)	      echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: The form is formally error-free. <i>(" . basename(__FILE__) . ")</i></p>\n";				
                  
			         //══════════----> FORM-STEP-4 : Form values proccessing <----═════════

                  #╔═════════════════════════════════════════════════════╗
                  #║           ---| DATABASE OPERATIONS |----            ║
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


                     #╔═════════════════════════════════════════════════════╗
                     #║        ---| SAVE NEW CATEGORY IN DB |----           ║
                     #╚═════════════════════════════════════════════════════╝
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

			            //══════════----> CHECK IF SAVE CATEGORY IN DB WAS SACCESSFUL <----═════════
                     $rowCount = $PDOStatement->rowCount();
if(DEBUG_V)		      echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$rowCount: $rowCount <i>(" . basename(__FILE__) . ")</i></p>\n";
                     
                     if( $rowCount !== 1) {
if(DEBUG)	            echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Error: Failed to save the category in the database! <i>(" . basename(__FILE__) . ")</i></p>\n";				

                        $addCategoryUserMessage = "An error occurred while saving the category. Please try again later.";                        

                     } else {
                        // Display the the last inserted catID
                        $newCategoryID = $PDO->lastInsertID();
                        
                        // $categoriesArray[] = array ( 'catID' => $newCategoryID, 'catLabel' => $newCategoryName );

if(DEBUG)	            echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: The category $newCategoryName with ID $newCategoryID has been successfully saved. <i>(" . basename(__FILE__) . ")</i></p>\n";				
                        
                        $addCategoryUserMessage ="The category $newCategoryName has been successfully saved.";


                        //══════════----> EMPTY CATEGORY FORM FIELD  <----═════════                      
                        $newCategoryName = NULL ; 

                     } // CHECK IF SAVE CATEGORY IN DB WAS SACCESSFUL END
			           			         
                  } // CHECK IF THE CATEGORY ALREADY EXISTS IN DB END

                   //══════════----> CLOSE DB CONNECTION <----═════════ 
                      dbClose($PDO, $PDOStatement); 

               } // Step-3-d FORM: FINAL FORM VALIDATION END   
   
            }	// NEW CATEGORY FORM PROCESS END



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
            if( isset($_POST['formType']) AND $_POST['formType'] === 'newPost' ) {
if(DEBUG)	   echo "<p class='debug'><b>Line " . __LINE__ . "</b>: New post form ist submitted... <i>(" . basename(__FILE__) . ")</i></p>\n";

#				══════════----> STEP-2 FORM: Reading, defusing and debugging the passed form values <----═════════ 
if(DEBUG)	   echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Values are reading, sanitizing...<i>(" . basename(__FILE__) . ")</i></p>\n";


               $categorySelection   = sanitizeString($_POST['categorySelection']);
               $postHeadline        = sanitizeString($_POST['postHeadline']);
               $imageAlignment      = sanitizeString($_POST['imageAlignment']);
               $postContent         = sanitizeString($_POST['postContent']);

if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$categorySelection: $categorySelection <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$postHeadline: $postHeadline <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$imageAlignment: $imageAlignment <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$postContent: $postContent <i>(" . basename(__FILE__) . ")</i></p>\n";


#				══════════----> STEP-3 FORM: Validating the form values <----═════════
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>:Field values are being validated...<i>(" . basename(__FILE__) . ")</i></p>\n";


               //---->[x] STEP-3-a FORM: Formally validate field values
               //---->[x] STEP-3-b FORM: Display error message in the form
               //---->[x] STEP-3-c FORM: Pre-assignment of form fields

               //---> if Category list empty is or is no Category chosen
               if( $categorySelection === $categoryPlaceholder OR !is_numeric( $categorySelection )) {

                  $errorCategorySelection = "Please select a valid category or add a new one.";

               } else {

                  $errorCategorySelection    = validateInputString($categorySelection);

               }

               $errorPostHeadline         = validateInputString( $postHeadline );
               $errorPostContent          = validateInputString( $postContent ,minLength:10, maxLength:20000 );
               

               //══════════----> FORM-STEP-3-d : FINAL FORM VALIDATION FOR REQUIRED FIELDS<----═════════
               if( $errorCategorySelection OR $errorPostHeadline OR $errorPostContent  ) {

if(DEBUG)	      echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Error: There are still errors in the form! <i>(" . basename(__FILE__) . ")</i></p>\n";				

                  
               } else {
if(DEBUG)         echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: No error in required fields. <i>(" . basename(__FILE__) . ")</i></p>\n";				



                  //══════════----> UPLOAD IMAGE PROCESS <----═════════


// if(DEBUG_A)	      echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$_FILES <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_A)	      print_r($_FILES);					
// if(DEBUG_A)	      echo "</pre>";

                  //----> Check if a image is uploaded
                  if( $_FILES['postImagePath']['tmp_name'] === '') {
if(DEBUG)	         echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: No image is uploaded! <i>(" . basename(__FILE__) . ")</i></p>\n";				
                     
                     // If no image is uploaded, set the image alignment on none
                     $imageAlignment = 'none';

                  } else {
if(DEBUG)            echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Image upload is active. <i>(" . basename(__FILE__) . ")</i></p>\n";	

                     $validatedImageResult = validateImageUpload( $_FILES['postImagePath']['tmp_name'] );

// if(DEBUG_A)	         echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$validatedImageResult <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_A)	         print_r($validatedImageResult);					
// if(DEBUG_A)	         echo "</pre>";

                     //----> Validate image uploaded
                     if( $validatedImageResult['imageError'] !== NULL ) {

if(DEBUG)	            echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Error bei upload image: <i> $validatedImageResult[imageError] </i> ! <i>(" . basename(__FILE__) . ")</i></p>\n";	
                        
                        // Show error to user
                        $errorImageUpload = $validatedImageResult['imageError'];

                     } elseif( $validatedImageResult['imagePath'] !== NULL ) {
if(DEBUG)               echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Image has been successfully uploaded in path:'<i>$validatedImageResult[imagePath]</i>' . <i>(" . basename(__FILE__) . ")</i></p>\n";	

                        $postImagePath = $validatedImageResult['imagePath'];

                        //----> Check if a image Alignment is valid

                        if( $imageAlignment !== 'alignLeft' AND $imageAlignment !== 'alignRight' AND $errorImageAlignment !== NULL ) {

if(DEBUG)	               echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Error: Invalid alignment image </i> ! <i>(" . basename(__FILE__) . ")</i></p>\n";

                           $errorImageAlignment = "Invalid image alignment selected.";

                        } // Check if a image Alignment is valid END
                     } // Validate image uploaded

                  } // Check if a image is uploaded END

                  //══════════----> FORM-STEP-3-d : FINAL FORM VALIDATION FOR ALL FIELDS<----═════════
                  if( $errorCategorySelection === NULL AND $errorPostHeadline=== NULL AND $errorPostContent=== NULL AND $errorImageUpload===NULL AND $errorImageAlignment===NULL ) {
                     //══════════----> SAVE NEW POST BLOG INTO DB <----═════════

                     #╔═════════════════════════════════════════════════════╗
                     #║           ---| DATABASE OPERATIONS |----            ║
                     #╚═════════════════════════════════════════════════════╝


if(DEBUG)	         echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Database operations start...<i>(" . basename(__FILE__) . ")</i></p>\n";

                     //══════════----> DB-Step-1 : Connet to DB <----═════════
                     $PDO = dbConnect('blogprojekt');

                     //══════════----> DB-Step-2 : Create SQL-Statement and Placeholder-Array <----═════════
                     $sql = 'INSERT INTO blogs (blogHeadline, blogImagePath, blogImageAlignment, blogContent , catID, userID)
                              VALUES (:blogHeadline, :blogImagePath, :blogImageAlignment, :blogContent , :catID, :userID)';

                     $placeholders = array( 
                                             'blogHeadline'          => $postHeadline,
                                             'blogImagePath'         => $postImagePath,
                                             'blogImageAlignment'    => $imageAlignment,
                                             'blogContent'           => $postContent,
                                             'catID'                 => $categorySelection,
                                             'userID'                => $userID,
                                          );


                     //══════════----> DB-Step-3 : Prepared Statements <----═════════
                     try {
                        // Prepare: SQL-Statement vorbereiten
                        $PDOStatement = $PDO->prepare($sql);
                        
                        // Execute: SQL-Statement ausführen und ggf. Platzhalter füllen
                        $PDOStatement->execute($placeholders);
                        // showQuery($PDOStatement);
                        
                     } catch(PDOException $error) {
if(DEBUG) 		            echo "<p class='debug db err'><b>Line " . __LINE__ . "</b>: ERROR: " . $error->GetMessage() . "<i>(" . basename(__FILE__) . ")</i></p>\n";										
                     }


                     //══════════----> DB-Step-4 : Daten proccess <----═════════

                     //══════════----> CHECK IF NEW POST HAS BEEN SUCCESSFULLY SAVED IN DB <----═════════
                     $rowCount = $PDOStatement->rowCount();
if(DEBUG_V)		      echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$rowCount: $rowCount <i>(" . basename(__FILE__) . ")</i></p>\n";
                        
                     if( $rowCount !== 1) {
if(DEBUG)               echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Error: Failed to save new post in the database! <i>(" . basename(__FILE__) . ")</i></p>\n";				

                        $addPostUserMessage = "An error occurred while saving the post. Please try again later.";
                        

                     } else {
                        // Display the ID of the last inserted record after saving the new blog post to the DB.
                        $newPostID = $PDO->lastInsertID();

if(DEBUG)	            echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: The new Post with ID: $newPostID has been successfully saved. <i>(" . basename(__FILE__) . ")</i></p>\n";				
                           
                        $addPostUserMessage = "The new blog post has been successfully saved.";



                        //══════════----> EMPTY NEW POST FORM FIELD  <----═════════

                        $categorySelection         = NULL;
                        $postHeadline              = NULL;
                        $postImagePath             = NULL;
                        $imageAlignment            = NULL; 
                        $postContent               = NULL;
                        

                        $errorCategorySelection    = NULL;
                        $errorPostHeadline         = NULL;
                        $errorImageUpload          = NULL;
                        $errorPostContent          = NULL;

                     } // CHECK IF NEW POST HAS BEEN SUCCESSFULLY SAVED IN DB END

                     //══════════----> CLOSE DB CONNECTION <----═════════ 
                     dbClose($PDO, $PDOStatement); 

                  } // FINAL FORM VALIDATION FOR ALL FIELDS END   

               } // FORM-STEP-3-d : FINAL FORM VALIDATION FOR REQUIRED FIELDS END

            } // STEP-1 FORM: Check if the form has been submitted END

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

            <!-- User greeting -->
            <div class="greeting">
               <figure class="user-avatar"><img src=<?= $userAvatarPath ?>></figure>
               <p>Welcome Back <b><?= $userFirstName ?> <?= $userLastName ?> !</b></p>
               
            </div>

            <!-- Navigation -->
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

            <?php if( isset($addPostUserMessage)) : ?>

               <!-- If new post blog was saved successfully -->
               <h3 class="post-message"><?= $addPostUserMessage ?></h3>

            <?php elseif(isset($addCategoryUserMessage)) : ?>
               <!-- If new category was saved successfully -->
               <h3 class="cat-message "><?= $addCategoryUserMessage ?></h3> 
               
            <?php endif ?>

         </div>
         <!-- ---------- SHOW USER SUCCESS MESSAGE END ----------- -->
         
         

         <section class="row">

            <!-- ========== NEW BLOG SIDEBAR START ========== -->
            <div class="col-lg-8">

               <!-- New post form title -->
               <div class="section-title new-post-header">
                  <h5>New Post</h5>
               </div>

               <!-- ========== NEW BLOG FORM START ========== -->  
               <div class="box new-post">
                  
                  <form action="" method="post" enctype="multipart/form-data" >

                     <!-- Hidden input to differentiate this form submission from new category from -->
                     <input type="hidden" name="formType" value="newPost">

                     <!--== Category selection start ==-->

                     <!-- Show error bei category selection -->
                     <?php if( isset($errorCategorySelection) ): ?><span> <?= $errorCategorySelection ?></span> <?php endif ?> 

                     <select name="categorySelection" class="cat-selection">

                        <?php if(!empty($categoriesArray)) : ?>

                           <?php foreach( $categoriesArray AS $category) : ?>
                              <option value="<?= $category['catID'] ?>" <?php if($categorySelection == $category['catLabel']) echo 'selected' ?> ><?= $category['catLabel'] ?></option>

                           <?php endforeach ?>

                        <?php else : ?>

                           <option value="<?= $categoryPlaceholder ?>"><?= $categoryPlaceholder ?></option>

                        <?php endif ?>

                     </select>
                     <!---- Category selection end ---->                     

                     <!--== Headline start ==-->
                     <!-- Show error -->
                     <?php if( isset($errorPostHeadline)): ?> <span><?= $errorPostHeadline ?></span> <?php endif ?>

                     <div class="textbox-headline">
                        <label   for="headline">Enter headline here</label>
                        <input type="text" name="postHeadline" id="headline" placeholder="Enter headline here" autocomplete="off" value="<?= $postHeadline ?>" >
                     </div>
                     <!---- Headline end ---->

                     <!--== Image Upload start==-->
                     <!-- Show Error bei Image Upload Process -->
                     <?php if( isset($errorImageUpload)): ?> <span><?= $errorImageUpload ?></span> <?php endif ?>

                     <!-- Show Error bei Image Alignment Process --> 
                     <?php if( isset($errorImageAlignment)): ?> <span><?= $errorImageAlignment ?></span> <?php endif ?>

                     <fieldset class="img-upload-wrapper">
                        <legend>&nbsp;Featured Image&nbsp;</legend>

                        <div class="upload">
                           <!-- Image Upload --> 
                           <input type="file" name="postImagePath" >

                           <!-- Image alignment -->
                           <select name="imageAlignment" >
                              <?php foreach( $validAlignments as $validAlignment ) : ?>
                                 <option value="<?= $validAlignment ?>"  <?php if($imageAlignment == $validAlignment) echo 'selected' ?>><?= $validAlignment ?></option>
                              <?php endforeach ?>
                           
                           </select>

                        </div>
                     </fieldset>
                     <!----Imgage upload end---->

                     <!--== Textarea ==-->
                     <!-- post content Error -->
                     <?php if( isset($errorPostContent)): ?> <span><?= $errorPostContent ?></span> <?php endif ?>
                     <textarea name="postContent" placeholder="Write your blog post here ..." ><?= $postContent ?></textarea>
                     

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
                     <input type="hidden" name="formType" value="newCategory" >

                     
                     <div class="textbox">
                        <input type="text" value="<?= $newCategoryName ?>" name="newCategoryName" id="newCategoryName" placeholder="" class="new-cat-input">
                        <label for="newCategoryName" class="new-cat-label">Enter category name</label>
                     </div>
                     
                     <!-- Show error to user -->
                     <p class="error-msg"><?= $errorNewCategoryName ?></p>

                     <!-- Submit button -->
                     <button type="submit" class="category-submit" >save</button>

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