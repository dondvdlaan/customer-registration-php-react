<?php
#***************************************************************************************#

#****************************************#
#********** PAGE CONFIGURATION **********#
#****************************************#

require_once('./include/config.inc.php');
require_once('./include/form.inc.php');
require_once('./include/db.inc.php');
require_once('./include/cors.php');


#******************************************#
#********** INITIALIZE VARIABLES **********#
#******************************************#

#********** LOGIN CONFIGURATION **********#
$errorLogin 					= NULL;
$loggedIn                       = false;
$userID                         = NULL;
#***************************************************************************************#

#***************************************************************************************#
                				
				// $user = $_GET['action'];
				// echo ("Hello from server: $user");

				#********** PROCESS URL PARAMETERS **********#

				#********** PREVIEW GET ARRAY **********#
if(DEBUG_V)	echo "Line" . __LINE__ . "(" . basename(__FILE__) . ")";					
if(DEBUG_V)	print_r($_GET);	

				#****************************************#

				// Schritt 1 URL: Prüfen, ob URL-Parameter übergeben wurde
				if( isset($_GET['action']) ) {
if(DEBUG)			echo "Line " . __LINE__ . "URL-Parameter 'action' wurde übergeben.(" . basename(__FILE__) . ")";										
										
					// Schritt 2 URL: Werte auslesen, entschärfen, DEBUG-Ausgabe
					$action = cleanString($_GET['action']);
if(DEBUG_V)		    echo "Line " . __LINE__ . "\$action: $action (" . basename(__FILE__) . ")";
										
					// Schritt 3 URL: Verzweigung
										
					#********** FETCH allJobs **********#
					if( $action === 'allJobs'){
if(DEBUG)			echo "<p class='debug'>📑 <b>Line " . __LINE__ . "</b>: Auswerten Kategorie... <i>(" . basename(__FILE__) . ")</i></p>\n";
						
					#********** DB OPERATION **********#
											
					// Schritt 1 DB: DB-Verbindung herstellen
					$PDO = dbConnect(DB_NAME);

					#********** SELECT TABLES **********#
if(DEBUG)		echo "Line " . __LINE__ . "Lese Nr. Jos aus DB aus... <i>(" . basename(__FILE__) . ")";

					$sql 		= 'SELECT *
									FROM jobs';
							
					$params 	= array();

					// Schritt 2 DB: SQL-Statement vorbereiten
					$PDOStatement = $PDO->prepare($sql);
											
					// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
					try {	
					$PDOStatement->execute($params);						
					} catch(PDOException $error) {
if(DEBUG)			echo "Line " . __LINE__ . ": FEHLER: " . $error->GetMessage() . "(" . basename(__FILE__) . ")";										
					$dbError = 'Fehler beim Zugriff auf die Datenbank!';
					}

					// Schritt 4 DB: Daten weiterverarbeiten
					$jobs = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);

if(DEBUG_V)			echo "Line " . __LINE__ . " (" . basename(__FILE__) . ")";					
if(DEBUG_V)			print_r($blogs);					

					// Zählen, wieviele Datensätze zurückgeliefert wurden
					$rowCount = $PDOStatement->rowCount();
if(DEBUG_V)			echo "Line " . __LINE__ . "\$rowCount: $rowCount (" . basename(__FILE__) . ")";
					
					// Reply to customer
					$myJSON = json_encode($jobs);
					echo $myJSON;

					// DB-Verbindung beenden
					unset($PDO);

					} // END Verzweigung
				} // END URL PARAMETERS
				
?>