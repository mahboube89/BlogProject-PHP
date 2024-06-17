<?php

# ══════════════════════════════════════════════════════════════════════════════════════════════════

#					╔═════════════════════════════════════════════════════╗
#					║																		║
#					║			---| PAGE CONFIGURATION |---				║
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
			<div class="dashboard-header" >

            <div class="greeting">
               <p>Welcome Back <b>Peter Peterson</b></p>
            </div>

				<ul class="nav">
					<li class="nav-item"><a class="nav-link" href="#">Logout</a></li>
					<li class="nav-item"><a class="nav-link" href="#">Home</a></li>
				</ul>


			</div>
			<!-- ---------- MENU END ----------- -->

      </header>
      <!-- ---------- HEADER END ----------- -->


      <!-- ========== CONTENT START ========== -->
      <main class="container">


         <h1 class="intro-title">______ PHP PROJECT BLOG - DASHBOARD ______</h1>

         <section class="row">

            <!-- ========== NEW BLOG POST START ========== -->
            <div class="col-lg-8">

               <!-- Form title -->
               <div class="section-title new-post-header">
                  <h5>New Post</h5>
               </div>

               <!-- ========== NEW BLOG FORM START ========== -->  
               <div class="box new-post">
                  
                  <form action="" method="post" >

                     <!-- Hidden input to differentiate this form submission from new category from -->
                     <input type="hidden" name="newPostForm">

                     <!-- Category selection -->
                     <select name="" id="" class="cat-selection">
                        <option value="">Cat-1</option>
                        <option value="">Cat-2</option>
                        <option value="">Cat-3</option>
                     </select>

                     <!-- Headline -->
                     <div class="textbox">
                        <input type="text" name="headline" id="headline" placeholder="" autocomplete="off">
                        <label for="headline">Headline</label>
                     </div>

                     
                     <fieldset class="img-upload-wrapper">
                        <legend>&nbsp;Featured Image&nbsp;</legend>

                        <div class="upload">
                           <!-- Image Upload -->  
                           <input type="file" name="imageUpload" id="headline" placeholder="" autocomplete="off">

                           <!-- Image alignment -->
                           <select name="" id="" class="img-align-selection">
                              <option value="">align left</option>
                              <option value="">align right</option>
                           </select>

                        </div>
                     </fieldset>

                     <!-- Textarea -->
                     <textarea name="" id="" placeholder="Write here ... "></textarea>
                     

                     <!-- Submit button -->
                     <button class="publish-submit" >Publish</button>

                  </form>                  
               </div>
               <!-- ---------- NEW BLOG FORM END ----------- -->

            </div>
            <!-- ---------- NEW BLOG POST END ----------- -->





            <!-- ========== NEW CATEGORY FORM START ========== -->
            <div class="col-lg-4">
               <div class="section-title">
                  <h5>Create new category</h5>
               </div>
               <div class="box new-cat-container">
                  <form action="" method="post">
                     <!-- Hidden input to differentiate this form submission from new blog from -->
                   
                     <input type="hidden" name="newCategoryForm">

                     <div class="textbox">
                        <input type="text" name="category" id="category" placeholder="" autocomplete="off">
                        <label for="category">Category name</label>
                     </div>

                     <!-- Submit button -->
                     <button class="category-submit" >Create</button>

                  </form>
               </div>


            </div>
            <!-- ---------- NEW CATEGORY FORM END ----------- -->

         </section>

      </main>		
      <!-- ---------- CONTENT END ----------- -->
		
		
		
		
		
	</body>
	
</html>