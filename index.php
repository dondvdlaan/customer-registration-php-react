<?php
#***************************************************************************************#

#****************************************#
#********** CONFIGURATION ***************#
#****************************************#

require_once('./include/config.inc.php');
require_once('./include/form.inc.php');
require_once('./include/db.inc.php');
require_once('./include/cors.php');
require_once('./include/log.php');


#******************************************#
#********** INITIALIZE VARIABLES **********#
#******************************************#

#********** LOGIN CONFIGURATION **********#
$errorLogin 					= NULL;
$loggedIn                       = false;
$userID                         = NULL;
#***************************************************************************************#

#***************************************************************************************#
                				
				#********** PROCESS URL PARAMETERS **********#

				wh_log("********** GET ARRAY **********");
				wh_log("Line " . __LINE__ . " (" . basename(__FILE__) . ")");					

				#****************************************#

				// Schritt 1 URL: Prüfen, ob URL-Parameter übergeben wurde
				if( isset($_GET['action']) ) {
				wh_log("Line " . __LINE__ . " URL-Parameter 'action' wurde übergeben.(" . basename(__FILE__) . ")");										
										
				// Schritt 2 URL: Werte auslesen, entschärfen, DEBUG-Ausgabe
				$action = cleanString($_GET['action']);
				wh_log("Line " . __LINE__ . " \$action: $action (" . basename(__FILE__) . ")");
										
				// Schritt 3 URL: Verzweigung
										
				#********** FETCH allJobs **********#
				if( $action === 'allJobs'){
					wh_log("Line " . __LINE__ . " Auswerten allJobs... (" . basename(__FILE__) . ")");
					
					// Prepare SQL statement
					$sql 		= 'SELECT * FROM jobs
								INNER JOIN companies USING(compID)';
				
					$params 	= array();

					// Retrieve jobs table
					$jobs = retrieveTable($sql, $params);
					wh_log("Line " . __LINE__ . " \$jobs : $jobs (" . basename(__FILE__) . ")");

					// Reply to customer
					echo $jobs;


				#********** FETCH allCompanies **********#
				}elseif ($action === 'allCompanies'){
					wh_log("Line " . __LINE__ . " Auswerten allCompanies... (" . basename(__FILE__) . ")");

					// Prepare SQL statement
					$sql 		= 'SELECT * FROM companies';
								
					$params 	= array();

					// Retrieve companies table
					$companies = retrieveTable($sql, $params);
					wh_log("Line " . __LINE__ . " \$companies : $companies (" . basename(__FILE__) . ")");

					// Reply to customer
					echo $companies;


				#********** FETCH 1 Job per ID **********#
				}elseif ($action === 'job'){
					wh_log("Line " . __LINE__ . " Auswerten job... (" . basename(__FILE__) . ")");

					// Schritt 2 URL: Werte auslesen, entschärfen, DEBUG-Ausgabe
					$jobID = cleanString($_GET['jobID']);
					wh_log("Line " . __LINE__ . " \$jobID: $jobID (" . basename(__FILE__) . ")");

					// Prepare SQL statement
					$sql 		= 'SELECT * FROM jobs
									INNER JOIN companies USING(compID)
									where jobID = :ph_jobID';
								
					$params 	= array('ph_jobID' => $jobID);

					// Retrieve job
					$job = retrieveTable($sql, $params);
					wh_log("Line " . __LINE__ . " \$job : $job (" . basename(__FILE__) . ")");

					// Reply to customer
					echo $job;

				#********** FETCH 1 Company per ID **********#
				}elseif ($action === 'company'){
					wh_log("Line " . __LINE__ . " Auswerten company... (" . basename(__FILE__) . ")");

					// Schritt 2 URL: Werte auslesen, entschärfen, DEBUG-Ausgabe
					$compID = cleanString($_GET['compID']);
					wh_log("Line " . __LINE__ . " \$compID: $compID (" . basename(__FILE__) . ")");

					// Prepare SQL statement
					$sql 		= 'SELECT * FROM companies
									where compID = :ph_compID';
								
					$params 	= array('ph_compID' => $compID);

					// Retrieve job
					$comp = retrieveTable($sql, $params);
					wh_log("Line " . __LINE__ . " \$comp : $comp (" . basename(__FILE__) . ")");

					// Reply to customer
					echo $comp;


				#********** DELETE Job per ID **********#
				}elseif ($action === 'delete'){
					wh_log("Line " . __LINE__ . " Delete job chosen... (" . basename(__FILE__) . ")");

					// Schritt 2 URL: Werte auslesen, entschärfen, DEBUG-Ausgabe
					$jobID = cleanString($_GET['jobID']);
					wh_log("Line " . __LINE__ . " \$jobID: $jobID (" . basename(__FILE__) . ")");

					// Prepare SQL statement
					$sql 		= 'DELETE FROM jobs
									where jobID = :ph_jobID';
				
					$params 	= array('ph_jobID' => $jobID);

					// Retrieve job
					$job = retrieveTable($sql, $params, $select=false);
					wh_log("Line " . __LINE__ . " \$job : $job (" . basename(__FILE__) . ")");

					
				#********** DELETE Company per ID **********#
				}elseif ($action === 'deleteCompany'){
					wh_log( "Line " . __LINE__ . " Delete company <i>(" . basename(__FILE__) . ")</i></p>\n");
	
					// Schritt 2 URL: Werte auslesen, entschärfen, DEBUG-Ausgabe
					$compID = cleanString($_GET['compID']);
					wh_log("Line " . __LINE__ . " \$compID: $compID (" . basename(__FILE__) . ")");
	
					// Prepare SQL statement
					$sql 		= 'DELETE FROM companies
										where compID = :ph_compID';
					
					$params 	= array('ph_compID' => $compID);
	
					// Retrieve job
					$comp = retrieveTable($sql, $params, $select=false);
					wh_log("Line " . __LINE__ . " \$comp : $comp (" . basename(__FILE__) . ")");
	
					} // END GET Verzweigung
				} // END URL PARAMETERS

#***************************************************************************************#

				#********** PROCESS POST PARAMETERS **********#

				wh_log("********** POST ARRAY **********");

				wh_log("Line " . __LINE__ . " (" . basename(__FILE__) . ")");					
			    
				#****************************************#
				
				// Instead of $_POST, file_get_contents is used for Insert and Update
				$request_body = file_get_contents('php://input');
    			$data = json_decode($request_body, true);

				// Check if POST data arrived
				if( isset($data) ) {
				wh_log( "Line " . __LINE__ . " POST functions have been received (" . basename(__FILE__) . ")");										

				// Schritt 2 FORM: Werte auslesen, entschärfen, DEBUG-Ausgabe
				$postSelector 			= cleanString( $data['postSelector'] );
				wh_log("Line " . __LINE__ . " \$postSelector: $postSelector (" . basename(__FILE__) . ")");

				// Schritt : POST Verzweigung
										
				#********** UPDATE / ADD Company **********#
				if($postSelector === 'Company') {
				wh_log( "Line " . __LINE__ . " POST $postSelector  has been received (" . basename(__FILE__) . ")");										
				
					updateOrInsertCompany($data);

				#********** UPDATE / ADD Job **********#
				}elseif( $postSelector === 'Job'){
				wh_log( "Line " . __LINE__ . "POST $postSelector has been received (" . basename(__FILE__) . ")");										

					updateOrInsertJob($data);

					} // END POST Verzweigung
				}	// END POST ARRAY 			
?>