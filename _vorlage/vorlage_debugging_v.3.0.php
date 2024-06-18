<?php
#********************************************************************************************#


				#********************************************#
				#********** EINFACHE DEBUGAUSGABEN **********#
				#********************************************#

				#********** Ein Vorgang wird gestartet: **********#
if(DEBUG)	echo "<p class='debug'>📑 <b>Line " . __LINE__ . "</b>: Vorgang XY wird gestartet... <i>(" . basename(__FILE__) . ")</i></p>\n";
				
				
#********************************************************************************************#


				#********************************************#
				#********** ERFOLGS-/FEHLERMELDUNG **********#
				#********************************************#

				#********** Debug-Ausgabe für Fehlerfall: **********#
if(DEBUG)	echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: Inhalt der Fehlermeldung! <i>(" . basename(__FILE__) . ")</i></p>\n";				
		
		
				#********** Debug-Ausgabe für Erfolgsfall: **********#
if(DEBUG)	echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Inhalt der Erfolgsmeldung. <i>(" . basename(__FILE__) . ")</i></p>\n";				
				
				
				#********** Debug-Ausgabe für Hinweis: **********#
if(DEBUG)	echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Inhalt des Hinweises. <i>(" . basename(__FILE__) . ")</i></p>\n";				
				
		
#********************************************************************************************#
		
				
				#*********************************************#
				#********** VARIABLENWERTE AUSGEBEN **********#
				#*********************************************#
								
				#********** SIMPLE DATENTYPEN (STRING, INTEGER, FLOAT, BOOLEAN) **********#
if(DEBUG_V)	echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$variable: $variable <i>(" . basename(__FILE__) . ")</i></p>\n";
								
				
				#********** KOMPLEXE DATENTYPEN (ARRAYS, OBJEKTE) **********#
if(DEBUG_A)	echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$arrayName <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
if(DEBUG_A)	print_r($array);					
if(DEBUG_A)	echo "</pre>";

if(DEBUG_O)	echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$objectName <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
if(DEBUG_O)	print_r($object);					
if(DEBUG_O)	echo "</pre>";


#********************************************************************************************#


				#***********************************************#
				#********** URL-PARAMETERVERARBEITUNG **********#
				#***********************************************#
				
				// Schritt 1 URL: Prüfen, ob URL-Parameter übergeben wurde				
				if( isset($_GET['urlParametername']) === true ) {
if(DEBUG)		echo "<p class='debug'>🧻 <b>Line " . __LINE__ . "</b>: URL-Parameter 'Parametername' wurde übergeben. <i>(" . basename(__FILE__) . ")</i></p>\n";										
				}
				

#********************************************************************************************#


				#******************************************#
				#********** FORMULARVERARBEITUNG **********#
				#******************************************#
				
				// Schritt 1 FORM: Prüfen, ob Formular abgeschickt wurde				
				if( isset($_POST['hiddenFieldName']) === true ) {
if(DEBUG)		echo "<p class='debug'>🧻 <b>Line " . __LINE__ . "</b>: Formular 'Formularname' wurde abgeschickt. <i>(" . basename(__FILE__) . ")</i></p>\n";										
				}
				

#********************************************************************************************#


				#***************************************************************#
				#********** DEBUG-AUSGABE FÜR PDO PREPARED STATEMENTS **********#
				#***************************************************************#
				
				// Schritt 3 DB: Prepared Statements
				try {
					// Prepare: SQL-Statement vorbereiten
					$PDOStatement = $PDO->prepare($sql);
					
					// Execute: SQL-Statement ausführen und ggf. Platzhalter füllen
					$PDOStatement->execute($placeholders);
					// showQuery($PDOStatement);
					
				} catch(PDOException $error) {
if(DEBUG) 		echo "<p class='debug db err'><b>Line " . __LINE__ . "</b>: ERROR: " . $error->GetMessage() . "<i>(" . basename(__FILE__) . ")</i></p>\n";										
				}	
				

#********************************************************************************************#


				#********************************#
				#********** FUNKTIONEN **********#
				#********************************#
				
				#********** Die Funktion meldet sich bei Aufruf mit Namen und ggf. Parameterwerten **********#
				function functionName() {
if(DEBUG_F)		echo "<p class='debug functionName'>🌀<b>Line " . __LINE__ . "</b>: Aufruf " . __FUNCTION__ . "() <i>(" . basename(__FILE__) . ")</i></p>\n";
				}
				
				
#********************************************************************************************#
				

				#*****************************#
				#********** KLASSEN **********#
				#*****************************#
				
				#********** CONSTRUCTOR **********#
				public function __construct() {
if(DEBUG_CC)	echo "<p class='debug class'>🛠 <b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "()  (<i>" . basename(__FILE__) . "</i>)</p>\n";						
						
if(DEBUG_CC)	echo "<pre class='debug class value'><b>Line " . __LINE__ .  "</b> | " . __METHOD__ . "(): <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
if(DEBUG_CC)	print_r($this);					
if(DEBUG_CC)	echo "</pre>";	
				}
				
				
				#********** DESTRUCTOR **********#
				public function __destruct() {
if(DEBUG_CC)	echo "<p class='debug class'>☠️  <b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "()  (<i>" . basename(__FILE__) . "</i>)</p>\n";						
				}
										
					
				#********** METHODEN **********#
				public function methodName($parameter) {
if(DEBUG_C)		echo "<p class='debug class'>🌀 <b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "() (<i>" . basename(__FILE__) . "</i>)</p>\n";


if(DEBUG_C)		echo "<p class='debug class'><b>Line " . __LINE__ .  "</b> | " . __METHOD__ . "(): Meldung... (<i>" . basename(__FILE__) . "</i>)</p>\n";
				}
								
				
#********************************************************************************************#
?>