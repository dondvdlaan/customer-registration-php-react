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


					#********** DB OPERATION **********#
											
					// Schritt 1 DB: DB-Verbindung herstellen
					$PDO = dbConnect(DB_NAME);

					#********** DB Operations **********#
					wh_log("Line " . __LINE__ . " Operation on DB (" . basename(__FILE__) . ")");
					wh_log("Line " . __LINE__ . " \$sql: " . $sql . " (" . basename(__FILE__) . ")");

					// Schritt 2 DB: SQL-Statement vorbereiten
					$PDOStatement = $PDO->prepare($sql);
											
					// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
					wh_log("Line " . __LINE__ . " \$params: " . implode(",", $params). " (" . basename(__FILE__) . ")");

					try {	
					$PDOStatement->execute($params);						
					} catch(PDOException $error) {
					wh_log( "Line " . __LINE__ . ": FEHLER: " . $error->GetMessage() . "(" . basename(__FILE__) . ")");										
					$dbError = 'Fehler beim Zugriff auf die Datenbank!';
					
					wh_log("$dbError " . $dbError);
					}

					// Schritt 4 DB: Daten weiterverarbeiten Records retrieval
					if($select) $records = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);

					// Zählen, wieviele Datensätze zurückgeliefert wurden
					$rowCount = $PDOStatement->rowCount();
					wh_log("Line " . __LINE__ . " \$rowCount: $rowCount (" . basename(__FILE__) . ")");

					// Reply to customer
					$myJSON = json_encode($records);

					// DB-Verbindung beenden
					unset($PDO);
					
					// echo $myJSON;
					return $myJSON;

				} // END function
				
				
#******************************************************************************************************#

				/*
				*	Update / Insert company
				*
				*	@param [String $data]			Company Data 
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
				
				$sql 		= 'INSERT INTO companies(	compName, 
														compStatus, 
														compType)
				 				VALUES (:ph_compName,
										:ph_compStatus, 
										:ph_compType)';
				
				$params 	= array('ph_compName' 	=> $compName,
									'ph_compType' 	=> $compType,
									'ph_compStatus' => $compStatus,
									);

				wh_log("params before function: " . implode(" ,", $params));

				// Insert new Company
				$returnValue = retrieveTable($sql, $params);
				wh_log("Line " . __LINE__ . "\$returnValue : $returnValue (" . basename(__FILE__) . ")");
				

				#********** UPDATE Company **********#
				}elseif($isEdit) {
					wh_log("isEdit true");

				// Schritt 2 FORM: Werte auslesen, entschärfen, DEBUG-Ausgabe
				$compID 			= cleanString( $data['compID'] );
				wh_log("Line " . __LINE__ . " \$compID : $compID (" . basename(__FILE__) . ")");
				
				// #********** Prepare SQL statement **********#

				$sql 		= 'UPDATE companies
							SET compName   =:ph_compName , 
								compType   =:ph_compType, 
								compStatus =:ph_compStatus
				 			WHERE compID = :ph_compID';
				
				$params 	= array('ph_compID'     => $compID,
									'ph_compName'   => $compName,
									'ph_compType'   => $compType,
									'ph_compStatus' => $compStatus,
									);

				wh_log("Line " . __LINE__ . " Params: " . implode(" ,", $params). basename(__FILE__) . ")");

				// Update job
				$returnValue = retrieveTable($sql, $params, $select = false);
				wh_log( "Line " . __LINE__ . " \$returnValue : $returnValue (" . basename(__FILE__) . ")");
				

					} // END isEdit Verzweigung
				} // END function

#******************************************************************************************************#

				/*
				*	Update / Insert Job
				*
				*	@param [String $data]			Job Data 
				*/
				function updateOrInsertJob($data){
				wh_log("Line " . __LINE__ . " function updateOrInsertJob (" . basename(__FILE__) . ")");
	
				// Schritt 2 FORM: Werte auslesen, entschärfen, DEBUG-Ausgabe
				wh_log("Line " . __LINE__ . " Werte auslesen und entschärfen... (" . basename(__FILE__) . ")");
		
				$compID 			= cleanString( $data['compID'] );
				$jobTitle 			= cleanString( $data['jobTitle'] );
				$jobDescription		= cleanString( $data['jobDescription'] );
				$jobDetails			= cleanString( $data['jobDetails'] );
				$jobStatus			= cleanString( $data['jobStatus'] );
				$isEdit 			= cleanString( $data['isEdit'] );

				wh_log("Line " . __LINE__ . " \$compID: $compID (" . basename(__FILE__) . ")");
				wh_log("Line " . __LINE__ . " \$jobTitle: $jobTitle (" . basename(__FILE__) . ")");
				wh_log("Line " . __LINE__ . " \$jobDescription: $jobDescription(" . basename(__FILE__) . ")");
				wh_log("Line " . __LINE__ . " \$jobDetails: $jobDetails(" . basename(__FILE__) . ")");
				wh_log("Line " . __LINE__ . " \$jobStatus: $jobStatus (" . basename(__FILE__) . ")");

				// Schritt 3 URL: Verzweigung
										
				#********** INSERT newJob **********#
				if(!$isEdit) {
				wh_log("isEdit false");
				

				#********** Prepare SQL statement **********#
				
				$sql 		= 'INSERT INTO jobs(jobTitle, 
												jobDescription, 
												jobDetails, 
												jobStatus, 
												compID)
				 			VALUES (:ph_jobTitle, 
									:ph_jobDescription, 
									:ph_jobDetails, 
									:ph_jobStatus, 
									:ph_compID)';
				
				$params 	= array('ph_jobTitle' 		=> $jobTitle,
									'ph_jobDescription' => $jobDescription,
									'ph_jobDetails' 	=> $jobDetails,
									'ph_jobStatus' 		=> $jobStatus,
									'ph_compID' 		=> $compID
									);

				wh_log("Line " . __LINE__ . " Params: " . implode(" ,", $params). " (" . basename(__FILE__) . ")");

				// Insert new job
				$returnValue = retrieveTable($sql, $params);
				wh_log( "Line " . __LINE__ . " \$returnValue : $returnValue (" . basename(__FILE__) . ")");
				

				#********** UPDATE Job **********#
				}elseif($isEdit) {
					wh_log("isEdit true");

				// Schritt 2 FORM: Werte auslesen, entschärfen, DEBUG-Ausgabe

				$jobID 			= cleanString( $data['jobID'] );
				
				#********** Prepare SQL statement **********#

				$sql 		= 'UPDATE jobs
							SET jobTitle		=	:ph_jobTitle, 
								jobDescription	=	:ph_jobDescription, 
								jobDetails		=	:ph_jobDetails, 
								jobStatus		=	:ph_jobStatus, 
								compID			=	:ph_compID
				 			WHERE jobID = :ph_jobID';
				
				$params 	= array('ph_jobID' 			=> $jobID,
									'ph_jobTitle' 		=> $jobTitle,
									'ph_jobDescription' => $jobDescription,
									'ph_jobDetails' 	=> $jobDetails,
									'ph_jobStatus' 		=> $jobStatus,
									'ph_compID' 		=> $compID
									);

				wh_log("Line " . __LINE__ . " Params: " . implode(" ,", $params). " (" . basename(__FILE__) . ")");

				// Update job
				$returnValue = retrieveTable($sql, $params, $select = false);
				wh_log( "Line " . __LINE__ . " \$returnValue : $returnValue (" . basename(__FILE__) . ")");
				
					} // END isEdit Verzweigung
				} // END function

#******************************************************************************************************#

				/*
				*	Update / Insert Employee
				*
				*	@param [String $data]			Employee Data 
				*/
				function updateOrInsertEmployee($data){
					wh_log("Line " . __LINE__ . " function updateOrInsertEmployee (" . basename(__FILE__) . ")");
		
					// Schritt 2 FORM: Werte auslesen, entschärfen, DEBUG-Ausgabe
					wh_log("Line " . __LINE__ . " Werte auslesen und entschärfen... (" . basename(__FILE__) . ")");
			
					$emplID 			= cleanString( $data['emplID'] );
					$emplFirstName		= cleanString( $data['emplFirstName'] );
					$emplLastName		= cleanString( $data['emplLastName'] );
					$emplTel			= cleanString( $data['emplTel'] );
					$emplEmail			= cleanString( $data['emplEmail'] );
					$compID				= cleanString( $data['compID'] );

					$isEdit 			= cleanString( $data['isEdit'] );
	
					wh_log("Line " . __LINE__ . " \$emplID: $emplID (" . basename(__FILE__) . ")");
					wh_log("Line " . __LINE__ . " \$emplFirstName: $emplFirstName (" . basename(__FILE__) . ")");
					wh_log("Line " . __LINE__ . " \$emplLastName: $emplLastName (" . basename(__FILE__) . ")");
					wh_log("Line " . __LINE__ . " \$emplTel: $emplTel (" . basename(__FILE__) . ")");
					wh_log("Line " . __LINE__ . " \$emplEmail: $emplEmail (" . basename(__FILE__) . ")");
					wh_log("Line " . __LINE__ . " \$compID: $compID (" . basename(__FILE__) . ")");
	
					// Schritt 3 URL: Verzweigung
											
					#********** INSERT new Employee **********#
					if(!$isEdit) {
					wh_log("isEdit false");
					
	
					#********** Prepare SQL statement **********#
					
					$sql 		= ' INSERT INTO employees(	emplFirstName, 
															emplLastName,
															emplEmail,
															emplTel,
															compID)
								 	VALUES (:ph_emplFirstName, 
											:ph_emplLastName,
											:ph_emplEmail,
											:ph_emplTel,
											:ph_compID
											)';
					
					$params 	= array(
										'ph_emplFirstName' 	=> $emplFirstName,
										'ph_emplLastName' 	=> $emplLastName,
										'ph_emplEmail' 		=> $emplEmail,
										'ph_emplTel' 		=> $emplTel,
										'ph_compID' 		=> $compID
										);
	
					wh_log("Line " . __LINE__ . " Params: " . implode(" ,", $params). " (" . basename(__FILE__) . ")");
	
					// Insert new employee
					$returnValue = retrieveTable($sql, $params);
					wh_log( "Line " . __LINE__ . " \$returnValue : $returnValue (" . basename(__FILE__) . ")");
					
	
					#********** UPDATE Job **********#
					}elseif($isEdit) {
						wh_log("isEdit true");
	
					// Schritt 2 FORM: Werte auslesen, entschärfen, DEBUG-Ausgabe
	
					$emplID 	= cleanString( $data['emplID'] );
					
					#********** Prepare SQL statement **********#
	
					$sql 		= ' UPDATE employees
	 								SET emplFirstName	=	:ph_emplFirstName,
									 	emplLastName	=	:ph_emplLastName,
										emplTel			=	:ph_emplTel,
										emplEmail		=	:ph_emplEmail
									WHERE emplID = :ph_emplID';
					
					$params 	= array('ph_emplID' 		=> $emplID,
										'ph_emplFirstName'	=> $emplFirstName,
										'ph_emplLastName'	=> $emplLastName,
										'ph_emplTel'		=> $emplTel,
										'ph_emplEmail'		=> $emplEmail										
										);
	
					wh_log("Line " . __LINE__ . " Params: " . implode(" ,", $params). " (" . basename(__FILE__) . ")");
	
					// Update Employee
					$returnValue = retrieveTable($sql, $params, $select = false);
					wh_log( "Line " . __LINE__ . " \$returnValue : $returnValue (" . basename(__FILE__) . ")");
					
						} // END isEdit Verzweigung
					} // END function
?>