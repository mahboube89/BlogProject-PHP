<?php
# ==================================================================================================


#				╔═════════════════════════════════════════════════════╗
#				║																		║
#				║			---| GLOBAL PROJECT CONFIGURATION |---			║
#				║																		║
#				╚═════════════════════════════════════════════════════╝


#				══════════----| DATABASE CONFIGURATION |----═════════				
				define('DB_SYSTEM',							'mysql');
				define('DB_HOST',								'localhost');
				define('DB_NAME',								'blogprojekt');
				define('DB_USER',								'root');
				define('DB_PWD',								'2401'); 

				
#				══════════----| EXTERNAL STRING VALIDATION CONFIGURATION |----═════════				
				define('INPUT_MANDATORY',					true);
				define('INPUT_MAX_LENGTH',					255);
				define('INPUT_MIN_LENGTH',					0);

				
#				══════════----| IMAGE UPLOAD CONFIGURATION |----═════════				
				define('IMAGE_MAX_WIDTH', 					800);
				define('IMAGE_MAX_HEIGHT', 				800);
				define('IMAGE_MAX_SIZE', 					128*1024);
				define('IMAGE_MIN_SIZE', 					1024);
				define('IMAGE_ALLOWED_MIME_TYPES', 		array('image/jpg' => '.jpg', 'image/jpeg' => '.jpg', 'image/png' => '.png', 'image/gif' => '.gif'));

				
#				══════════----| STANDARD PATHS CONFIGURATION |----═════════				
				define('IMAGE_UPLOAD_PATH', 				'./uploads/userImages/');
				define('AVATAR_DUMMY_PATH', 				'../css/images/avatar_dummy.png');

				
#				══════════----| DEBUGGING |----═════════				
				define('DEBUG', 								false);		// DEBUGGING FOR MAIN DOCUMENT
				define('DEBUG_A', 							false);		// DEBUGGING FOR ARRAYS
				define('DEBUG_V', 							false);		// DEBUGGING FOR VALUES
				define('DEBUG_F', 							false);		// DEBUGGING FOR FUNCTIONS
				define('DEBUG_DB', 							false);		// DEBUGGING FOR DB OPERATIONS


# ==================================================================================================
?>