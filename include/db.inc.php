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
				*	Operations on tables
				*
				*	@param [String $sql]			SQL statement
				*	@param [String $params]			params array
				* 	@param [String $select]			true=> record(s) retrieval
				*									false=> Insert/Update/delete
				*	@return Object					Selection as objekt
				*/
				function retrieveTable($sql, $params, $select=true) {
				
				// Constans and Variables	
				$records = NULL;

				wh_log("sql$ " . $sql);
				wh_log("params in function: " . implode(",", $params));

					#********** DB OPERATION **********#
											
					// Schritt 1 DB: DB-Verbindung herstellen
					$PDO = dbConnect(DB_NAME);

					#********** DB Operations **********#
					wh_log( "Line " . __LINE__ . " Operation on DB <i>(" . basename(__FILE__) . ")");

					// Schritt 2 DB: SQL-Statement vorbereiten
					$PDOStatement = $PDO->prepare($sql);
											
					// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
					try {	
					$PDOStatement->execute($params);						
					} catch(PDOException $error) {
					wh_log( "Line " . __LINE__ . ": FEHLER: " . $error->GetMessage() . "(" . basename(__FILE__) . ")");										
					$dbError = 'Fehler beim Zugriff auf die Datenbank!';
					
					wh_log("$dbError " . $dbError);
					}

					// Schritt 4 DB: Daten weiterverarbeiten
					if($select) $records = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);

					// Zählen, wieviele Datensätze zurückgeliefert wurden
					$rowCount = $PDOStatement->rowCount();
					wh_log("Line " . __LINE__ . " \$rowCount: $rowCount (" . basename(__FILE__) . ")");

					// Reply to customer
					$myJSON = json_encode($records);
					// echo $myJSON;

					// DB-Verbindung beenden
					unset($PDO);

					// Return Table
					return $myJSON;
				}
				
				
#******************************************************************************************************#

				/*
				*	Update / Insert company
				*
				*	@param [String $data]			Company Data 
				*	@return none					Table as objekt
				*/
				function updateOrInsertCompany($data){
				wh_log("Line " . __LINE__ . " function updateOrInsertCompany (" . basename(__FILE__) . ")");

				// Schritt 2 FORM: Werte auslesen, entschärfen, DEBUG-Ausgabe
				wh_log("Line " . __LINE__ . " Werte auslesen und entschärfen... (" . basename(__FILE__) . ")");
					
				$compID 			= cleanString( $data['compID'] );
				$compName 			= cleanString( $data['compName'] );
				$compStatus			= cleanString( $data['compStatus'] );
				$compType			= cleanString( $data['compType'] );
				$isEdit 			= cleanString( $data['isEdit'] );

				wh_log("Line " . __LINE__ . " \$compID: $compID (" . basename(__FILE__) . ")");
				wh_log("Line " . __LINE__ . " \$compName: $compName (" . basename(__FILE__) . ")");
				wh_log("Line " . __LINE__ . " \$compType: $compType (" . basename(__FILE__) . ")");
				wh_log("Line " . __LINE__ . " \$compStatus: $compStatus (" . basename(__FILE__) . ")");

					// Schritt 3 URL: Verzweigung
										
					#********** INSERT newCompany **********#
					if(!$isEdit) {
					wh_log("isEdit false");
				

				#********** Prepare SQL statement **********#
				
				$sql 		= 'INSERT INTO companies(compName, compStatus, compType)
				 				VALUES (:ph_compName, :ph_compStatus, :ph_compType)';
				
				$params 	= array('ph_compName' => $compName,
									'ph_compType' => $compType,
									'ph_compStatus' => $compStatus,
									);

				wh_log("params before function: " . implode(" ,", $params));

				// Insert new Company
				$returnValue = retrieveTable($sql, $params);
if(DEBUG_V_P)	wh_log( "Line " . __LINE__ . "\$returnValue : $returnValue (" . basename(__FILE__) . ")");
				
				
				// Reply to customer
				// echo $companies;  -- not used

				#********** UPDATE Job **********#
				}elseif($isEdit) {
					wh_log("isEdit true");

				// Schritt 2 FORM: Werte auslesen, entschärfen, DEBUG-Ausgabe

				// $jobID 			= cleanString( $data['jobID'] );
				
				// #********** Prepare SQL statement **********#

				// $sql 		= 'UPDATE jobs
				// 			SET jobTitle=:ph_jobTitle , jobDescription=:ph_jobDescription, jobDetails=:ph_jobDetails, jobStatus=:ph_jobStatus, compID=:ph_compID
				//  			WHERE jobID = :ph_jobID';
				
				// $params 	= array('ph_jobID' => $jobID,
				// 					'ph_jobTitle' => $jobTitle,
				// 					'ph_jobDescription' => $jobDescription,
				// 					'ph_jobDetails' =>  $jobDetails,
				// 					'ph_jobStatus' => $jobStatus,
				// 					'ph_compID' =>  $compID
				// 					);

				wh_log("params before function: " . implode(" ,", $params));

				// Update job
				$returnValue = retrieveTable($sql, $params, $select = false);
if(DEBUG_V_P)	wh_log( "Line " . __LINE__ . "\$returnValue : $returnValue (" . basename(__FILE__) . ")");
				
				// // Reply to customer
				// echo $companies -- not used

					} // END isEdit Verzweigung
				} // END function
?>