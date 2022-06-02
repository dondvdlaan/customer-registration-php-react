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
?>