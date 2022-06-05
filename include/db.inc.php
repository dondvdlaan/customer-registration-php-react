<?php
				/**
				*
				*	Will connect to database by way of PDO
				*	Configuration and log in data come from config file
				*
				*	@param [String $dbname=DB_NAME]			Name of DB to be connected
				*	@return Object							DB-Connection objekt
				*/
				function dbConnect($dbname=DB_NAME) {
					
					// Because of security reasons we are not using static
					// static $PDO;
					
					// Establish new DB connection, when none is in place
					if( !isset($PDO) ) {
if(DEBUG_DB)		echo "<p class='debugDb'>📑 <b>Line " . __LINE__ . ":</b> Versuche mit der DB '<b>$dbname</b>' zu verbinden... <i>(" . basename(__FILE__) . ")</i></p>\r\n";					

						// EXCEPTION-HANDLING 
						// Establishing DB-connection
						try {
							
							// $PDO = new PDO("mysql:host=localhost; dbname=blog; charset=utf8mb4", "root", "");

							$PDO = new PDO(DB_SYSTEM . ":host=" . DB_HOST . "; dbname=$dbname; charset=utf8mb4", DB_USER, DB_PWD);
						
						// Error message is caught here					
						} catch(PDOException $error) {
							// Print error message
if(DEBUG_DB)			echo "<p class='error'><b>Line " . __LINE__ . ":</b> <i>FAILURE: " . $error->GetMessage() . " </i> <i>(" . basename(__FILE__) . ")</i></p>\r\n";
							// Terminate operation
							exit;
						}
						// In case of no error
if(DEBUG_DB)		echo "<p class='debugDb ok'><b>Line " . __LINE__ . ":</b> Succesfully connected with '<b>$dbname</b>' <i>(" . basename(__FILE__) . ")</i></p>\r\n";
						
					} else {
if(DEBUG_DB)		echo "<p class='debugDb hint'>📑 <b>Line " . __LINE__ . ":</b> A DB Connection is aleady in place. <i>(" . basename(__FILE__) . ")</i></p>\r\n";					
						
					}

					// Return DB Connection Object
					return $PDO;
				}
				
				
#******************************************************************************************************#
/**
				*
				*	Retrieves separate tables
				*
				*	@param [String $tableNmae]			Name of Dtable to be retrieved
				*	@return Object						Table as objekt
				*/
				function retrieveTable($sql, $params) {
					
if(DEBUG_V)			echo " Line " . __LINE__ . "\$tableName : $tableName (" . basename(__FILE__) . ")";

					#********** DB OPERATION **********#
											
					// Schritt 1 DB: DB-Verbindung herstellen
					$PDO = dbConnect(DB_NAME);

					#********** SELECT TABLES **********#
if(DEBUG)		echo "Line " . __LINE__ . "Lese Nr. Jos aus DB aus... <i>(" . basename(__FILE__) . ")";

					// $sql 		= 'SELECT * FROM jobs
					// 				INNER JOIN companies USING(compID)';
							
					// $params 	= array();

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
if(DEBUG_V)			print_r($jobs);					

					// Zählen, wieviele Datensätze zurückgeliefert wurden
					$rowCount = $PDOStatement->rowCount();
if(DEBUG_V)			echo "Line " . __LINE__ . "\$rowCount: $rowCount (" . basename(__FILE__) . ")";
					
					// Reply to customer
					$myJSON = json_encode($jobs);
					// echo $myJSON;

					// DB-Verbindung beenden
					unset($PDO);

					// Return Table
					return $myJSON;
				}
				
				
#******************************************************************************************************#

?>