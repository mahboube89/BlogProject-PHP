<?php
#**********************************************************************************#


				#***********************************#
				#********** DATE TIME INC **********#
				#***********************************#


#**********************************************************************************#

				
				#*****************************************#
				#********** ISO TO EU DATE TIME **********#
				#*****************************************#
				
				/**
				*
				* 	Wandelt ein ISO Datums-/Uhrzeitformat in ein europäisches Datums-/Uhrzeitformat um
				*	und separiert Datum von Uhrzeit (ohne Sekunden)
				*
				* 	@param String $value										Das ISO Datum/Uhrzeit
				*
				* 	@return Array (String "date", String "time")		Das EU-Datum plus die Uhrzeit
				*
				*/
				function isoToEuDateTime($value) {
//if(DEBUG_F)		echo "<p class='debug dateTime'>🌀 <b>Line " . __LINE__ . "</b>: Aufruf " . __FUNCTION__ . "('$value') <i>(" . basename(__FILE__) . ")</i></p>\n";			
					
					if($value) {
						
						// mögliche Übernahmewerte
						// 2018-05-17 14:17:48
						// 2018-05-17
						
						// gewünschte Ausgabewerte
						// 17.05.2018	// 14:17
						// 17.05.2018
						
						// Prüfen, ob $value eine Uhrzeit enthält
						if( strpos($value, " ") ) {
// if(DEBUG_F)			echo "<p class='debug dateTime'><b>Line " . __LINE__ .  "</b> | " . __METHOD__ . "(): \$value enthält eine Uhrzeit. <i>(" . basename(__FILE__) . ")</i></p>\r\n";					

							// Datum und Uhrzeit auftrennen
							$dateTimeArray = explode(" ", $value);
							/*
if(DEBUG_F)				echo "<pre class='debug dateTime'><b>Line " . __LINE__ .  "</b> | " . __METHOD__ . "(): \$dateTimeArray: <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";					
if(DEBUG_F)				print_r($dateTimeArray);					
if(DEBUG_F)				echo "</pre>";
							*/
							
							$date = $dateTimeArray[0];
// if(DEBUG_F)			echo "<p class='debug dateTime'><b>Line " . __LINE__ .  "</b> | " . __METHOD__ . "(): \$date: $date <i>(" . basename(__FILE__) . ")</i></p>\r\n";					
							// Datum in Einzelteile (Tag,Monat,Jahr) zerlegen
							$dateArray 	= explode("-", $date);

							$time = $dateTimeArray[1];
							// Sekunden abschneiden
							$time 		= substr($time, 0, 5);
// if(DEBUG_F)			echo "<p class='debug dateTime'><b>Line " . __LINE__ .  "</b> | " . __METHOD__ . "(): \$time: $time <i>(" . basename(__FILE__) . ")</i></p>\r\n";					

						} else {
// if(DEBUG_F)			echo "<p class='debug dateTime'><b>Line " . __LINE__ .  "</b> | " . __METHOD__ . "(): \$value enthält keine Uhrzeit. <i>(" . basename(__FILE__) . ")</i></p>\r\n";					
							// Datum in Einzelteile (Tag,Monat,Jahr) zerlegen
							$dateArray 	= explode("-", $value);
							$time 		= NULL;
						}
						/*				
if(DEBUG_F)			echo "<pre class='debug dateTime'><b>Line " . __LINE__ .  "</b> | " . __METHOD__ . "(): \$dateTimeArray: <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";					
if(DEBUG_F)			print_r($dateArray);					
if(DEBUG_F)			echo "</pre>";
						*/

						// Datum umformatieren					
						$euDate = "$dateArray[2].$dateArray[1].$dateArray[0]";
// if(DEBUG_F)		echo "<p class='debug dateTime'><b>Line " . __LINE__ .  "</b> | " . __METHOD__ . "(): \$euDate: $euDate <i>(" . basename(__FILE__) . ")</i></p>\r\n";					
																	
					} else {
						
						// NULL-Werte in Array-Indizes schreiben
						$euDate 		= NULL;
						$time 		= NULL;						
					}
					
					// Datum und Uhrzeit getrennt zurückgeben
					return array("date"=>$euDate, "time"=>$time);					
				}


#**********************************************************************************#

				
				#*********************************#
				#********** TO ISO DATE **********#
				#*********************************#
				
				/**
				*
				* 	Wandelt ein EU/US/ISO-Datumsformat in ein ISO-Datumsformat um
				*
				* 	@param String 	Das EU/US/ISO-Datum
				*
				* 	@return String Das ISO-Datum
				*
				*/
				function toIsoDate($value) {
if(DEBUG_F)		echo "<p class='debug dateTime'>🌀 <b>Line " . __LINE__ . "</b>: Aufruf " . __FUNCTION__ . "() <i>(" . basename(__FILE__) . ")</i></p>\n";
					
					if( $value ) {
						// mögliche Übernahmewerte
						// 17.05.2018 | 05/17/2018 | 2018-05-17
						
						// gewünschte Ausgabewerte
						// 2018-05-17
						
						// Übergebenes Datumsformat prüfen
						if( stripos($value, ".") ) {
if(DEBUG_F)				echo "<p class='debug dateTime'><b>Line " . __LINE__ .  "</b> | " . __METHOD__ . "(): Übergebenes Datum ist im EU-Format. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
							
							$dateArray = explode(".", $value);					
							$day 		= $dateArray[0];
							$month 	= $dateArray[1];
							$year 	= $dateArray[2];
							
						} elseif( stripos($value, "/") ) {
if(DEBUG_F)				echo "<p class='debug dateTime'><b>Line " . __LINE__ .  "</b> | " . __METHOD__ . "(): Übergebenes Datum ist im US-Format. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
							
							$dateArray = explode("/", $value);					
							$day 		= $dateArray[1];
							$month 	= $dateArray[0];
							$year 	= $dateArray[2];
							
						} elseif( stripos($value, "-") ) {
if(DEBUG_F)				echo "<p class='debug dateTime'><b>Line " . __LINE__ .  "</b> | " . __METHOD__ . "(): Übergebenes Datum ist im ISO-Format. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
							
							$dateArray = explode("-", $value);
							$day 		= $dateArray[2];
							$month 	= $dateArray[1];
							$year 	= $dateArray[0];						
						}
						
						$isoDate = "$year-$month-$day";
if(DEBUG_F)			echo "<p class='debug dateTime'><b>Line " . __LINE__ .  "</b> | " . __METHOD__ . "(): \$isoDate: $isoDate <i>(" . basename(__FILE__) . ")</i></p>\r\n";
						
						return $isoDate;	
						
					} else {
						return NULL;
					}

				}


#**********************************************************************************#

				
				#***********************************#
				#********** VALIDATE DATE **********#
				#***********************************#
				
				/**
				*
				*	Prüft ein übergebenes ISO/US/EU-Datum auf Gültigkeit
				*
				*	@param String 	$value	- Das zu prüfende ISO/US/EU-Datum
				*
				*	@return Boolean 			- false bei falschem Format oder ungültigem Datum; ansonsten true
				*
				*/
				function validateDate($value) {
if(DEBUG_F)		echo "<p class='debug dateTime'>🌀 <b>Line " . __LINE__ . "</b>: Aufruf " . __FUNCTION__ . "() <i>(" . basename(__FILE__) . ")</i></p>\n";						
					
					$day 		= NULL;
					$month 	= NULL;
					$year 	= NULL;
										
					if( $value ) {
						
						// Datum auseinanderschneiden für checkdate()
					
						// ISO-Format
						if( stripos($value, "-") ) {
							$dateArray = explode("-", $value);
							
							$day 		= $dateArray[2];
							$month 	= $dateArray[1];
							$year 	= $dateArray[0];
						
						// EU-Format
						} elseif( stripos($value, ".") ) {
							$dateArray = explode(".", $value);
							
							$day 		= $dateArray[0];
							$month 	= $dateArray[1];
							$year 	= $dateArray[2];
						
						// US-Format
						} elseif( stripos($value, "/") ) {
							$dateArray = explode("/", $value);
							
							$day 		= $dateArray[1];
							$month 	= $dateArray[0];
							$year 	= $dateArray[2];
						}

if(DEBUG_F)			echo "<pre class='debug dateTime'><b>Line " . __LINE__ .  "</b> | " . __METHOD__ . "(): <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";					
if(DEBUG_F)			print_r($dateArray);					
if(DEBUG_F)			echo "</pre>";						
					}
									
					/*
						Datumsbestandteile auf Vollständigkeit prüfen und 
						Datum auf valides gregorianisches Datum prüfen
					*/
					if( ($day === NULL OR $month === NULL OR $year === NULL) OR checkdate($month, $day, $year) === false ) {
						// Fehlerfall
						return false;
						
					} else {
						// Erfolgsfall
						return true;
					}
					
				}


#**********************************************************************************#