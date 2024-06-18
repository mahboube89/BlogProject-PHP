<?php
#************************************************************************************************#


				#***************************************#
				#********* PAGE CONFIGURATION **********#
				#***************************************#
 
				/*
					include(Pfad zur Datei): Bei Fehler wird das Skript weiter ausgeführt. Problem mit doppelter Einbindung derselben Datei
					require(Pfad zur Datei): Bei Fehler wird das Skript gestoppt. Problem mit doppelter Einbindung derselben Datei
					include_once(Pfad zur Datei): Bei Fehler wird das Skript weiter ausgeführt. Kein Problem mit doppelter Einbindung derselben Datei
					require_once(Pfad zur Datei): Bei Fehler wird das Skript gestoppt. Kein Problem mit doppelter Einbindung derselben Datei
				*/
				require_once('./include/config.inc.php');
				require_once('./include/form.inc.php');


#************************************************************************************************#


				#******************************************#
				#********** INITIALIZE VARIABLES **********#
				#******************************************#
				
				$monthsArray 		= array('01'=>'Januar', '02'=>'Februar', '03'=>'März', '04'=>'April', '05'=>'Mai', '06'=>'Juni', '07'=>'Juli', '08'=>'August', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Dezember');
				
				$title				= NULL;
				$gender				= NULL;
				$firstName			= NULL;
				$lastName			= NULL;
				$email				= NULL;
				$day					= NULL;
				$month				= NULL;
				$year					= NULL;
				$message				= NULL;
				
				$errorTitle 		= NULL;
				$errorGender 		= NULL;
				$errorFirstName 	= NULL;
				$errorLastName 	= NULL;
				$errorEmail			= NULL;
				$errorDay			= NULL;
				$errorMonth			= NULL;
				$errorYear			= NULL;
				$errorMessage	 	= NULL;
				
				$successMessage	= NULL;
				
				$showSupportForm 	= true;
				

#************************************************************************************************#


				#******************************************#
				#********** PROCESS FORM SUPPORT **********#
				#******************************************#
				
				#********** PREVIEW POST ARRAY **********#
/*				
if(DEBUG_A)	echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$_POST <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
if(DEBUG_A)	print_r($_POST);
if(DEBUG_A)	echo "</pre>";
*/
				#****************************************#
				
				
				// Schritt 1 FORM: Prüfen, ob Formular abgeschickt wurde
				/*
					Wurde ein Formular mit einem bestimmten Feldnamen (in unserem Fall das hidden field 'forSupport') abgesendet, 
					enthält das $_POST-Array an dieser Stelle einen entsprechenden Index. Umkehrschluss: Fehlt dieser Index, 
					wurde auch das Formular nicht abgesendet.
				*/	
				/*
					ISSET()-FUNKTION:
					Die Funktion isset() prüft eine Variable/einen Array-Index auf Existenz und auf einen anderen Wert als NULL.
					Trifft beides zu, liefert isset() den Boolean true zurück, ansonsten False.
					Der Sinn von isset() ist explizit die Prüfung auf Existenz. Existiert eine Variable/ein Index nicht, wird 
					keine PHP-Fehlermeldung ausgeworfen.
					Ohne die Verwendung von isset() würde an dieser Stelle bei Nichtexistenz die Fehlermeldung 'Undefined Variable...'
					ausgeworfen werden.
				*/				
				if( isset($_POST['formSupport']) === true ) {
if(DEBUG)		echo "<p class='debug'>🧻 <b>Line " . __LINE__ . "</b>: Formular 'Support' wurde abgeschickt. <i>(" . basename(__FILE__) . ")</i></p>\n";										
					
					
					// Schritt 2 FORM: Werte auslesen, entschärfen, DEBUG-Ausgabe
if(DEBUG)		echo "<p class='debug'>📑 <b>Line " . __LINE__ . "</b>: Werte werden ausgelesen und entschärft... <i>(" . basename(__FILE__) . ")</i></p>\n";
					
					$title 		= sanitizeString($_POST['title']);
					$gender 		= sanitizeString($_POST['gender']);
					$firstName 	= sanitizeString($_POST['firstName']);
					$lastName 	= sanitizeString($_POST['lastName']);
					$email 		= sanitizeString($_POST['email']);
					$day 			= sanitizeString($_POST['day']);
					$month 		= sanitizeString($_POST['month']);
					$year 		= sanitizeString($_POST['year']);
					$message 	= sanitizeString($_POST['message']);
					
					/*
						DEBUGGING:
						1. Ist der Variablenname korrekt geschrieben?
						2. Steht in jeder Variable der korrekte Wert?
					*/
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$title: $title <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$gender: $gender <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$firstName: $firstName <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$lastName: $lastName <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$email: $email <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$day: $day <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$month: $month <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$year: $year <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$message: $message <i>(" . basename(__FILE__) . ")</i></p>\n";
					
					
					// Schritt 3 FORM: Feldvalidierung
if(DEBUG)		echo "<p class='debug'>📑 <b>Line " . __LINE__ . "</b>: Feldwerte werden validiert... <i>(" . basename(__FILE__) . ")</i></p>\n";
					
					/*
						Der 3. Schritt ‚Feldvalidierung‘ besteht seinerseits aus den immer gleichen 4 Schritten:
						1. Feldwerte formal validieren: Sind alle Pflichtfelder ausgefüllt, bewegen sich die 
							Eingaben formal im Rahmen des Erlaubten? Falls nicht, Fehlermeldungen generieren.
							
						2. Fehlermeldung im Formular ausgeben: Idealerweise individuell für jedes einzelne 
							Formularfeld.
							
						3. Feldvorbelegung der Formularfelder: Da das Formular dem User im Fehlerfall erneut 
							angezeigt wird, gehört es zu einer guten Usability, die bereits ausgefüllten 
							Formularfelder mit dem empfangenen Werten vorzubelegen, damit der User nicht alles 
							wieder erneut ausfüllen muss, sondern lediglich seine fehlerhaften Eingaben 
							korrigieren kann.
							
						4. Abschließende Formularprüfung, ob es einen Validierungsfehler gab: Zum Schluss muss 
							das Skript der Seite noch auf das Ergebnis der Feldvalidierung reagieren: Im Fehlerfall 
							wird die Verarbeitung abgebrochen und der User korrigiert seine Eingaben, im Erfolgsfall 
							werden die Formularwerte schließlich weiterverarbeitet.
					*/

					// SONDERFALL TITLE
					if( $title !== 'Herr' AND $title !== 'Frau' AND $title !== '' ) {
						$errorTitle		= 'Fehler!';
					}
					
					// SONDERFALL GENDER
					if( $gender  !== 'männlich' AND $gender  !== 'weiblich' AND $gender !== 'divers' ) {
						$errorGender	= 'Fehler!';
					}

					// $errorFirstName 	= validateInputString($firstName, mandatory:false);
					$errorFirstName 	= validateInputString($firstName);
					$errorLastName 	= validateInputString($lastName);
					$errorEmail 		= validateEmail($email);
					$errorDay 			= validateInputString($day, minLength:2, maxLength:2);
					$errorMonth 		= validateInputString($month, minLength:2, maxLength:2);
					$errorYear 			= validateInputString($year, minLength:4, maxLength:4);
					$errorMessage 		= validateInputString($message, maxLength:5000);
					
					
					#********** FINAL FORM VALIDATION **********#
					if( $errorTitle 		!== NULL OR $errorGender 	!== NULL OR 
						 $errorFirstName 	!== NULL OR $errorLastName !== NULL OR $errorEmail !== NULL OR 
						 $errorDay 			!== NULL OR $errorMonth 	!== NULL OR $errorYear 	!== NULL OR
						 $errorMessage		!== NULL ) {
						// Fehlerfall
if(DEBUG)			echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Das Formular enthält noch Fehler! <i>(" . basename(__FILE__) . ")</i></p>\n";				
						
					} else {
						// Erfolgsfall
if(DEBUG)			echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Das Formular ist formal fehlerfrei. <i>(" . basename(__FILE__) . ")</i></p>\n";				
						
						
						// Schritt 4 FORM: Daten weiterverarbeiten
if(DEBUG)			echo "<p class='debug'>📑 <b>Line " . __LINE__ . "</b>: Formulardaten werden verarbeitet... <i>(" . basename(__FILE__) . ")</i></p>\n";
						
						$successMessage 		= "Hallo <i><b>$title $firstName $lastName</b></i>,<br>
														vielen Dank, wir haben Ihre Daten erhalten.<br>
														<br>
														Nachfolgend noch einmal Ihre Angaben zur Kontrolle:<br>
														<br>
														Ihr Geschlecht ist <i><b>$gender</b></i>.<br>
														Ihr Geburtsdatum ist der <i><b>$day.$month.$year</b></i>.<br>
														Ihre Email-Adresse lautet <i><b>$email</b></i>.<br><br>
														Ihre Nachricht an uns:<br>
														<i><b>$message</b></i>";
						
						
						#********** a) EMPTY FORM DATA **********#
						$title				= NULL;
						$gender				= NULL;
						$firstName			= NULL;
						$lastName			= NULL;
						$email				= NULL;
						$day					= NULL;
						$month				= NULL;
						$year					= NULL;
						$message				= NULL;
						
						
						#********** b) DON'T RENDER FORM AGAIN **********#
						$showSupportForm = false;
						
						
						#********** c) REDIRECT TO NEW PAGE **********#
						/*
							Um zu verhindern, dass mittels F5 dieselben Formulardaten immer wieder 
							übertragen und somit ggf. auch immer wieder in die Datenbank geschrieben 
							werden, sollte an dieser Stelle eine Seitenumleitung stattfinden.
							
							Auf dieser anderen Seite kann dann beispielsweise eine einfache Erfolgsmeldung
							ausgegeben werden.
						*/
						
						
					} // FINAL FORM VALIDATION END

				} // PROCESS FORM SUPPORT END
				

#************************************************************************************************#
?>

<!doctype html>

<html>

	<head>
		<meta charset="utf-8"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Formularverarbeitung mit Feldvalidierung</title>
		<link rel="stylesheet" href="./css/main.css">
		<link rel="stylesheet" href="./css/debug.css">
		
		<style>
			* { margin: 0; padding: 0; }
			body { padding: 50px; font-family: arial; font-size: 14px; }
			h1 { margin: 10px 0px; }
			h2, h3, h4 { color: dodgerblue; margin: 20px 0px }
			p { font-size: 1.1em; }
			
			input, textarea, select, label, fieldset { margin: 10px; padding: 3px; width: 300px; border-radius: 5px; }
			label { font-size: 1.1em; }
			fieldset { width: 400px;  padding: 50px 25px; background-color: whitesmoke; }
			select { width: 235px; }
			select#day { width: 70px; }
			select#month { width: 115px; }
			select#year { width: 80px; }
			input[type="radio"], input[type="checkbox"] { width: 20px; margin: 10px 6px; }
			input[type="submit"] { width: 310px }
			textarea { float: left; font-size: 1.1em;}
			
			.marker { font-size: 1.6em; font-weight: bold;}
			.clearer { clear: both; }
			/* Den Placeholder-Font selbst bestimmen: */
			::-webkit-input-placeholder { font-family: verdana; }
			:-moz-placeholder { font-family: verdana; }
			::-moz-placeholder { font-family: verdana; }
			:-ms-input-placeholder { font-family: verdana; }
		</style>
		
	</head>

	<body>
	
		<h1>Formularverarbeitung mit Feldvalidierung</h1>
		
		<br>
		
		<h2>Formularelemente und ihre Parameter</h2>
		
		<br>
		<hr>
		<br>
		
		<h3>Hidden Field</h3>
		<p>
			Ein Hidden Field kann idealerweise zur eindeutigen Identifizierung eines Formulars dienen.<br>
			Befinden sich auf einer Seite mehrere Formulare (z.B. Loginformular, Newsletteranmeldung,
			Kontaktformular etc.) kann jedes der Formulare über seinen Namen im Hidden Field
			eindeutig identifiziert und individuell verarbeitet werden.<br>
			<br>
			Grundsätzlich sollte jedes Formular über eine eigene Formularverarbeitung verfügen.<br>
			<br>
			Ein weiterer Einsatzzweck des Hidden Fields ist, für den User nicht sichtbar weitere Daten an 
			den Server zu übermitteln. Dies kann beispielsweise die ID des aktuellen Usern sein, oder etwa
			ein Sicherheitstoken, um sicherzustellen, dass das zu verarbeitende Formular auch tatsächlich 
			von der eigenen Webseite stammt, und nicht etwa von einer durch einen Angreifer manipulierten
			externen Seite.
		</p>
		
		<br>
		<hr>
		<br>
		
		<h3>Parameter des &lt;form&gt;-Tags</h3>
		<p>
			Der Parameter 'ACTION' regelt, welche Seite nach Absenden des Formulars aufgerufen wird.
			Ist der Wert von 'action' leer, wird genau die URL aufgerufen, die oben in der URL-Leiste
			des Browsers steht (inkl. evtl. vorhandener URL-Parameter). Soll der Aufruf der Seite
			nach Absenden des Formulars ohne URL-Parameter erfolgen (i.d.R. die bessere Option), muss
			die URL über das 'action'-Attribut überschrieben werden. Also beispielsweise action="seitenname.php".<br>
			<br>
			Praktischerweise sollte eine Formularverarbeitung auf derselben Seite stattfinden, wie das
			Formular notiert ist, damit Rückmeldungen wie Fehlerausgaben oder aber auch die Vorbelegung
			der Formularfelder nicht unnötig verkompliziert werden.<br>
			Sollte die Seite dadurch zu groß bzw. der Code zu unübersichtlich werden, kann die Formular-
			verarbeitung in eine eigene Datei ausgelagert und mittels require_once() in das Hauptdokument
			eingebunden werden. Der ausgelagerte Code verhält sich dann so, als wäre er im selben Dokument
			wie das Formular notiert.<br>
			<br>
			Der zweite Parameter 'METHOD' regelt, auf welchem Weg die Daten aus dem Formular an den Server übergeben
			werden. Hier ist immer 'POST' einzutragen, da die alternative Übertragung mittels 'GET' unsicher und
			von jedem Sitznachbarn mitlesbar ist (besonders problematisch bei der Übertragung von Login-Daten).
		</p>
		
		<br>
		<hr>
		<br>
		
		<h3>Übertragung der jeweiligen Feldwerte an den Server</h3>
		<p>
			Für die einzelnen Formularelemente gilt: Der Name eines Formularelements wird bei 
			der Übertragung der Daten auf den Server zu einem assoziativen Index im POST-Array.
			Über diesen Index kann anschließend der Wert des Feldes gezielt ausgelesen werden.<br>
			<br>
			Der Wert aus dem 'VALUE'-Parameter ist der Wert, der o.g. Index innerhalb des
			POST-Arays als Wert zugeordnet wird.<br>
			<br>
			Bei Eingabefeldern der Typen &lt;input&gt; und &lt;textarea&gt; wird der vom User in das Feld
			eingetragene Wert übermittelt. Bei &lt;input&gt;-Elementen dient der VALUE-Parameter zur
			Vorbelegung des Felden mit einem Wert, beispielsweise nach Absenden des Formulars,
			damit der User im Fehlerfall nicht alle seine Eingaben erneut vornehmen muss.<br>
			<br>
			Eine Ausnahme bildet hierbei die &lt;textarea&gt;, die keinen VALUE-Parameter kennt. Hier
			erfolgt die Feldvorbelegung zwischen den &lt;textarea&gt;...&lt;/textarea&gt; Elementen.
		</p>
		
		<br>
		<hr>
		<br>
		<!-- ------------------ SUCCESS MESSAGE START ----------------- --->
		<p class="success"><?= $successMessage ?></p>
		<!-- ------------------ SUCCESS MESSAGE END ----------------- --->
		<br>
		<hr>
		<br>
		
		<?php if( $showSupportForm === true ): ?>
		
		<!-- ------------------ FORMULAR START ------------------ -->
		<!-- 
			Der Parameter 'ACTION' regelt, welche Seite nach Absenden des Formulars aufgerufen wird.
			Ist der Wert von 'action' leer, wird genau die URL aufgerufen, die oben in der URL-Leiste
			des Browsers steht (inkl. evtl. vorhandener URL-Parameter). Soll der Aufruf der Seite
			nach Absenden des Formulars ohne URL-Parameter erfolgen (i.d.R. die bessere Option), muss
			die URL über das 'action'-Attribut überschrieben werden. Also beispielsweise action="seitenname.php".
			
			Praktischerweise sollte eine Formularverarbeitung auf derselben Seite stattfinden, wie das
			Formular notiert ist, damit Rückmeldungen wie Fehlerausgaben oder aber auch die Vorbelegung
			der Formularfelder nicht unnötig verkompliziert werden.
			Sollte die Seite dadurch zu groß bzw. der Code zu unübersichtlich werden, kann die Formular-
			verarbeitung in eine eigene Datei ausgelagert und mittels require_once() in das Hauptdokument
			eingebunden werden. Der ausgelagerte Code verhält sich dann so, als wäre er im selben Dokument
			wie das Formular notiert.
			
			Der zweite Parameter 'METHOD' regelt, auf welchem Weg die Daten aus dem Formular an den Server übergeben
			werden. Hier ist immer 'POST' einzutragen, da die alternative Übertragung mittels 'GET' unsicher und
			von jedem Sitznachbarn mitlesbar ist (besonders problematisch bei der Übertragung von Login-Daten).
		-->
		<form action="06_formularverarbeitung-feldvalidierung.php" method="POST">
			
			<!-- -------- HIDDEN FIELD -------- -->
			<!--
				Ein Hidden Field kann idealerweise zur eindeutigen Identifizierung eines Formulars dienen.
				Befinden sich auf einer Seite mehrere Formulare (z.B. Loginformular, Newsletteranmeldung,
				Kontaktformular etc.) kann jedes der Formulare über seinen Namen im Hidden Field
				eindeutig identifiziert und individuell verarbeitet werden.
				Grundsätzlich sollte jedes Formular über eine eigene Formularverarbeitung verfügen.
			-->
			<input type="hidden" name="formSupport">
			
			<!--
				ÜBERTRAGUNG DER JEWEILIGEN FELDWERTE AN DEN SERVER:
				Für die jeweiligen Formularelemente gilt: Der Name eines Formularelements wird bei 
				der Übertragung der Daten auf den Server zu einem assoziativen Index im POST-Array.
				Über diesen Index kann der Wert des Feldes gezielt ausgelesen werden.
				
				Der Wert aus dem 'VALUE'-Parameter ist der Wert, der o.g. Index innerhalb des
				POST-Arays als wert zugeordnet wird.
				
				Bei Eingabefeldern der Typen <input> und <textarea> wird der vom User in das Feld
				eingetragene Wert übermittelt. Bei <input>-Elementen dient der VALUE-Parameter zur
				Vorbelegung des Felden mit einem Wert, beispielsweise nach Absenden des Formulars,
				damit der User im Fehlerfall nicht alle seine Eingaben erneut vornehmen muss.

				Eine Ausnahme bildet hierbei die <textarea>, die keinen VALUE-Parameter kennt. Hier
				erfolgt die Feldvorbelegung zwischen den <textarea>...</textarea> Elementen.
			-->
			
			<!-- -------- SINGLE SELECT BOX START -------- -->
			<label>Anrede:</label>
			<select name="title">
				<option value="Herr" <?php if( $title === 'Herr' ) echo 'selected' ?>>Herr</option>
				<option value="Frau" <?php if( $title === 'Frau' ) echo 'selected' ?>>Frau</option>
				<option value="" 		<?php if( $title === '' ) 		echo 'selected' ?>>Ohne Anrede</option>
			</select>
			<!-- -------- SINGLE SELECT BOX END -------- -->
			
			<br>
			<br>
			<br>
			
			<!-- -------- GROUPED RADIO BUTTONS START -------- -->
			<!--
				Bei gruppierten Formularelementen wie Radiobuttons oder Checkboxen müssen alle
				Elemente über den gleichen Namen verfügen.
				Bei Checkboxen muss der Name der einzelnen Elemente einem Array entsprechen:
				hobbies[sport], hobbies[lesen], hobbies[schlafen].
				Die solchermaßen gruppierten Checkboxen werden im $_POST-Array dann tatsächlich
				als Array übertragen.
			-->
			<label>Geschlecht:</label>
			<input type="radio" name="gender" value="männlich" <?php if( $gender === NULL OR $gender === 'männlich' ) 	echo 'checked' ?>>männlich
			<input type="radio" name="gender" value="weiblich" <?php if( $gender === 'weiblich' ) 	echo 'checked' ?>>weiblich
			<input type="radio" name="gender" value="divers" 	<?php if( $gender === 'divers' ) 	echo 'checked' ?>>divers
			<!-- -------- GROUPED RADIO BUTTONS END -------- -->
			
			<br>
			<br>
			
			<!-- -------- INPUT FIELDS START -------- -->
			<label>Vorname: </label><span class="error"><?= $errorFirstName ?></span><br>
			<input type="text" name="firstName" value="<?= $firstName ?>" placeholder="Vorname"><span class="marker">*</span>
			<br>
			<br>
			<label>Nachname: </label><span class="error"><?= $errorLastName ?></span><br>
			<input type="text" name="lastName" value="<?= $lastName ?>" placeholder="Nachname"><span class="marker">*</span>
			<br>
			<br>
			<label>Email-Adresse: </label><span class="error"><?= $errorEmail ?></span><br>
			<input type="text" name="email" value="<?= $email ?>" placeholder="Email"><span class="marker">*</span>
			<br>
			<br>
			<!-- -------- INPUT FIELDS END -------- -->
			
			<!-- -------- SELECT BOXES BIRTHDATE START -------- -->
			<label>Geburtsdatum:</label><br>
			<select id="day" name="day">
			<!-- Kurzschreibweise für <php echo ... ?> = <= ... ?> -->
			<?php for( $i=1; $i<=31; $i++ ): ?>
				<?php
					/*
						sprintf() gibt einen vorformatierten String zurück
						Erster Parameter:
						% = Steuerzeichen (hier soll aufgefüllt werden); 
						0 = Zeichen, mit dem aufgefüllt werden soll
						2 = Anzahl der Zeichen, bis zu der aufgefüllt werden soll
						d = Wert aus Parameter 2 wird als Integer angesehen und als Dezimalwert ausgegeben
						Zweiter Parameter:
						String, der umformatiert werden soll
					*/
					$iFormatted = sprintf('%02d', $i);
				?>
				<?php
					/*
						Um eine Select-Option, die mittels einer Schleife dynamisch mit einem Wert versehen
						wurde, mit dem vom User übermittelten Wert vorzubelegen, muss der übermittelte 
						Wert jeder einzelnen Option mit dem dynamischen Wert aus jedem Schleifendurchlauf
						abgeglichen und in dem Schleifendurchgang, in dem der dynamische Wert den gleichen
						Wert des übermittelten Wertes besitzt, mit dem Zusatzparameter 'selected' versehen
						werden.
					*/
				?>
				<option value="<?= $iFormatted ?>" <?php if( $day === $iFormatted ) echo 'selected' ?>><?= $iFormatted ?></option>
			<?php endfor ?>
			</select>
			
			<select id="month" name="month">
				<?php foreach( $monthsArray AS $index=>$value ): ?>
					<?php
						/*
							Um eine Select-Option, die mittels einer Schleife dynamisch mit einem Wert versehen
							wurde, mit dem vom User übermittelten Wert vorzubelegen, muss der übermittelte 
							Wert jeder einzelnen Option mit dem dynamischen Wert aus jedem Schleifendurchlauf
							abgeglichen und in dem Schleifendurchgang, in dem der dynamische Wert den gleichen
							Wert des übermittelten Wertes besitzt, mit dem Zusatzparameter 'selected' versehen
							werden.
						*/
					?>
					<option value="<?= $index ?>" <?php if( $month === $index ) echo 'selected' ?>><?= $value ?></option>
				<?php endforeach ?>
			</select>
			
			<select id="year" name="year">
				<?php for( $i=date('Y'); $i>=1901; $i-- ): ?>
					<?php
						/*
							Um eine Select-Option, die mittels einer Schleife dynamisch mit einem Wert versehen
							wurde, mit dem vom User übermittelten Wert vorzubelegen, muss der übermittelte 
							Wert jeder einzelnen Option mit dem dynamischen Wert aus jedem Schleifendurchlauf
							abgeglichen und in dem Schleifendurchgang, in dem der dynamische Wert den gleichen
							Wert des übermittelten Wertes besitzt, mit dem Zusatzparameter 'selected' versehen
							werden.
						*/
					?>
					<option value="<?= $i ?>" <?php if( $year == $i ) echo 'selected' ?>><?= $i ?></option>
				<?php endfor ?>
			</select>
			<!-- -------- SELECT BOXES BIRTHDATE END -------- -->
			
			<br>
			<br>
			
			<!-- -------- TEXT AREA START -------- -->
			<label>Ihre Nachricht an uns: </label><span class="error"><?= $errorMessage ?></span><br>
			<!--
				Die Textarea verfügt über kein value-Attribut. Stattdessen erfolgt die Feldvorbelegung
				zwischen <textarea> und </textarea>. Hierbei ist zu beachten, dass die gesamte Textarea
				inkl. Feldvorbelegung hintereinander in einer einzigen Zeile notiert werden muss, da das
				Textarea-Element ansonsten im Quellcode vorhandene Zeilenumbrüche und Tabulatoren darstellt.
			-->
			<textarea class="fleft" name="message" placeholder="Ihre Nachricht an uns..."><?= $message ?></textarea><span class="marker">*</span>
			<div class="clearer"></div>
			<br>
			<!-- -------- TEXT AREA END -------- -->
			
			<br>
			<br>
			
			<!-- -------- SUBMIT BUTTON -------- -->
			<!-- 
				Der Submit-Button sendet die Formulardaten an den Server. Hierbei werden die 
				jeweiligen Feldnamen und ihre Werte als Index=>Value Paar in das System-Array
				'$_POST' geschrieben.
			-->
			<input type="submit" value="Absenden">
		
		</form>
		<!-------------------- FORMULAR END -------------------->
		
		<?php endif ?>
		
		
		
		
		
		
		
		
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		
	</body>

</html>


