<?php
#******************************************************************************************************#


				#**********************************#
				#********** DATABASE INC **********#
				#**********************************#


#******************************************************************************************************#


				/**
				*
				*	Stellt eine Verbindung zu einer Datenbank mittels PDO her
				*	Die Konfiguration und Zugangsdaten erfolgen über eine externe Konfigurationsdatei
				*
				*	@param [String $dbname=DB_NAME]		Name der zu verbindenden Datenbank
				*
				*	@return Object								DB-Verbindungsobjekt
				*
				*/
				function dbConnect($DBName=DB_NAME) {
				
if(DEBUG_DB)	echo "<p class='debug db'><b>Line " . __LINE__ .  "</b> | " . __METHOD__ . "(): Versuche mit der DB '<b>$DBName</b>' zu verbinden... <i>(" . basename(__FILE__) . ")</i></p>\r\n";					

					// EXCEPTION-HANDLING (Umgang mit Fehlern)
					// Versuche, eine DB-Verbindung aufzubauen
					try {
						// wirft, falls fehlgeschlagen, eine Fehlermeldung "in den leeren Raum"
						
						// $PDO = new PDO("mysql:host=localhost; dbname=market; charset=utf8mb4", "root", "");
						$PDO = new PDO(DB_SYSTEM . ":host=" . DB_HOST . "; dbname=$DBName; charset=utf8mb4", DB_USER, DB_PWD);
						/*
							DB-Stream so einstellen, dass die DB Zahlenwerte wie Integer und Float als echten 
							Number-Datentyp zurückliefert (funktioniert nur im Zusammenhang mit Prepared Statements).
						*/
						$PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
						$PDO->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
						
						
					// falls eine Fehlermeldung geworfen wurde, wird sie hier aufgefangen					
					} catch(PDOException $error) {
						// Ausgabe der Fehlermeldung
if(DEBUG_DB)		echo "<p class='debug db err'><b>Line " . __LINE__ .  "</b> | " . __METHOD__ . "(): <i>FEHLER: " . $error->GetMessage() . " </i> <i>(" . basename(__FILE__) . ")</i></p>\r\n";
						// Skript abbrechen
						exit;
					}
					// Falls das Skript nicht abgebrochen wurde (kein Fehler), geht es hier weiter
if(DEBUG_DB)	echo "<p class='debug db ok'><b>Line " . __LINE__ .  "</b> | " . __METHOD__ . "(): Erfolgreich mit der DB '<b>$DBName</b>' verbunden. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
						

					// DB-Verbindungsobjekt zurückgeben
					return $PDO;
				}
				
				
#******************************************************************************************************#

				
				/**
				*
				*	Closes an active DB connection and sends a debug message
				*
				*	@param	PDO	&$PDO							Reference of given argument PDO object
				*	@param	PDO	&$PDOStatement=NULL		Reference of given argument PDOStatement object
				*
				*	return void
				*/
				
				/*
					Wegen des unterschiedlichen Scopes innerhalb von Funktionen
					müssen die PDO-Objekte $PDO und $PDOStatement referenziert werden.
					Nur so wirkt sich das Überschreiben der Variablen auch auf die sich 
					im global scope befindenden Objekte aus.
					
					Wird die DB-Operation innerhalb einer Funktion/Methode durchgeführt,
					steht beim Aufruf von dbClose() von außerhalb der Funktion/Methode
					ggf. kein PDOStatement-Objekt mehr zur Verfügung, da dieses dem local
					scope unterliegt und entsprechend beim Verlassen der Funktion/Methode
					bereits gelöscht wurde.
					Daher muss die Referenzierung von $PDOStatement optional erfolgen.
				*/
				function dbClose(&$PDO, &$PDOStatement=NULL) {					
if(DEBUG_DB)	echo "<p class='debug db'>🌀 <b>Line  " . __LINE__ .  "</b>: Aufruf " . __FUNCTION__ . "() <i>(" . basename(__FILE__) . ")</i></p>\r\n";
					
					/*
						Um die aktive DB-Verbindung zu beenden, müssen die referenzierten
						Objekte $PDO und $PDOStatement mit NULL überschrieben werden.
						Löschen mittels unset() reicht aus einerFunktion heraus nicht aus.
					*/
					$PDO = $PDOStatement = NULL;
				}


#******************************************************************************************************#