<?php
#***************************************************************************************#

#****************************************#
#********** PAGE CONFIGURATION **********#
#****************************************#

require_once('./include/config.inc.php');
require_once('./include/form.inc.php');
require_once('./include/db.inc.php');
require_once('./include/cors.php');
require_once('./include/log.php');



#******************************************#
#********** INITIALIZE VARIABLES **********#
#******************************************#
$data							= NULL;

#********** LOGIN CONFIGURATION **********#
$errorLogin 					= NULL;
$loggedIn                       = false;
$userID                         = NULL;
#***************************************************************************************#

#***************************************************************************************#
                				
				#********** PROCESS URL PARAMETERS **********#

				#********** PREVIEW GET ARRAY **********#
if(DEBUG_V_P)	wh_log("Line" . __LINE__ . " (" . basename(__FILE__) . ")");					
if(DEBUG_V_P)	wh_log(print_r($_GET));	
				// wh_log(print_r($_GET));
				#****************************************#

				// Schritt 1 URL: Prüfen, ob URL-Parameter übergeben wurde
				if( isset($_GET['action']) ) {
if(DEBUG_V_P)	wh_log("Line " . __LINE__ . "URL-Parameter 'action' wurde übergeben.(" . basename(__FILE__) . ")");										
										
					// Schritt 2 URL: Werte auslesen, entschärfen, DEBUG-Ausgabe
				$action = cleanString($_GET['action']);
if(DEBUG_V_P)	wh_log("Line " . __LINE__ . "\$action: $action (" . basename(__FILE__) . ")");
										
					// Schritt 3 URL: Verzweigung
										
					#********** FETCH allJobs **********#
					if( $action === 'allJobs'){
if(DEBUG)			echo "<p class='debug'>📑 <b>Line " . __LINE__ . "</b>: Auswerten allJobs... <i>(" . basename(__FILE__) . ")</i></p>\n";
					
					$sql 		= 'SELECT * FROM jobs
								INNER JOIN companies USING(compID)';
				
					$params 	= array();

					// Retriev jobs table
					$jobs = retrieveTable($sql, $params);
if(DEBUG_V)		    echo "Line " . __LINE__ . "\$jobs : $jobs (" . basename(__FILE__) . ")";

					// Reply to customer
					echo $jobs;

					#********** FETCH allCompanies **********#
					}elseif ($action === 'allCompanies'){

					$sql 		= 'SELECT * FROM companies';
								
					$params 	= array();

					// Retrieve companies table
					$companies = retrieveTable($sql, $params);
if(DEBUG_V)		    echo "Line " . __LINE__ . "\$companies : $companies (" . basename(__FILE__) . ")";

					// Reply to customer
					echo $companies;

					#********** FETCH 1 Job per ID **********#
					}elseif ($action === 'job'){

					// Schritt 2 URL: Werte auslesen, entschärfen, DEBUG-Ausgabe
					$jobID = cleanString($_GET['jobID']);
if(DEBUG_V_P)		wh_log("Line " . __LINE__ . "\$jobID: $jobID (" . basename(__FILE__) . ")");

					$sql 		= 'SELECT * FROM jobs
									INNER JOIN companies USING(compID)
									where jobID = :ph_jobID';
								
					$params 	= array('ph_jobID' => $jobID);

					// Retrieve job
					$job = retrieveTable($sql, $params);
if(DEBUG_V_P)		wh_log("Line " . __LINE__ . "\$job : $job (" . basename(__FILE__) . ")");

					// Reply to customer
					echo $job;
if(DEBUG_V_P)		wh_log("Line " . __LINE__ .' job: ' .$job ); 

					
					} // END GET Verzweigung
				} // END URL PARAMETERS

				#********** PREVIEW POST ARRAY **********#

if(DEBUG_V_P)	wh_log("Line " . __LINE__ . " (" . basename(__FILE__) . ")");					
if(DEBUG_V_P)	wh_log($_POST);
			    #****************************************#
				
				// Schritt 1 FORM: Prüfen, ob Formular abgeschickt wurde
				$request_body = file_get_contents('php://input');

    			$data = json_decode($request_body, true);

			
				if( isset($data) ) {
				wh_log( "Line " . __LINE__ . "Formular 'newJob' wurde abgeschickt. (" . basename(__FILE__) . ")");										

				
				// Schritt 2 FORM: Werte auslesen, entschärfen, DEBUG-Ausgabe
if(DEBUG)		echo "Line " . __LINE__ . " Werte auslesen und entschärfen... (" . basename(__FILE__) . ")";
					
				$compID 			= cleanString( $data['compID'] );
				$jobTitle 			= cleanString( $data['jobTitle'] );
				$jobDescription		= cleanString( $data['jobDescription'] );
				$jobDetails			= cleanString( $data['jobDetails'] );
				$jobStatus			= cleanString( $data['jobStatus'] );
				$isEdit 			= cleanString( $data['isEdit'] );

if(DEBUG_V_P)	wh_log("Line " . __LINE__ . "\$compID: $compID (" . basename(__FILE__) . ")");
if(DEBUG_V_P)	wh_log("Line " . __LINE__ . "\$jobTitle: $jobTitle (" . basename(__FILE__) . ")");

if(DEBUG_V_P)	wh_log("Line " . __LINE__ . "\$jobDescription: $jobDescription(" . basename(__FILE__) . ")");

if(DEBUG_V_P)	wh_log("Line " . __LINE__ . "\$jobDetails: $jobDetails(" . basename(__FILE__) . ")");

if(DEBUG_V_P)	wh_log("Line " . __LINE__ . "\$jobStatus: $jobStatus (" . basename(__FILE__) . ")");

					// Schritt 3 URL: Verzweigung
										
					#********** INSERT newJob **********#
					if(!$isEdit) {
					wh_log("isEdit false");
				

				#********** Prepare SQL statement **********#
				// if ($formBlog === 'newJob'){

				// $sql 		= 'INSERT INTO jobs(jobTitle, jobDescription, jobDetails, jobDate, jobStatus, compID)
				// 			VALUES (:ph_jobTitle, :ph_jobDescription, :ph_jobDetails, :ph_jobDate, :ph_jobStatus, :ph_compID)';
				
				$sql 		= 'INSERT INTO jobs(jobTitle, jobDescription, jobDetails, jobStatus, compID)
				 			VALUES (:ph_jobTitle, :ph_jobDescription, :ph_jobDetails, :ph_jobStatus, :ph_compID)';
				
				$params 	= array('ph_jobTitle' => $jobTitle,
									'ph_jobDescription' => $jobDescription,
									'ph_jobDetails' =>  $jobDetails,
									'ph_jobStatus' => $jobStatus,
									'ph_compID' =>  $compID
									);

				wh_log("params before function: " . implode(" ,", $params));

				// Insert new job
				$returnValue = retrieveTable($sql, $params);
if(DEBUG_V_P)	wh_log( "Line " . __LINE__ . "\$returnValue : $returnValue (" . basename(__FILE__) . ")");
				
				// // Reply to customer
				// echo $companies;

				#********** UPDATE Job **********#
				}elseif($isEdit) {
					wh_log("isEdit true");

				// Schritt 2 FORM: Werte auslesen, entschärfen, DEBUG-Ausgabe

				$jobID 			= cleanString( $data['jobID'] );
				
				#********** Prepare SQL statement **********#

				// $sql 		= 'INSERT INTO jobs(jobTitle, jobDescription, jobDetails, jobDate, jobStatus, compID)
				// 			VALUES (:ph_jobTitle, :ph_jobDescription, :ph_jobDetails, :ph_jobDate, :ph_jobStatus, :ph_compID)';
				
				$sql 		= 'UPDATE jobs
							SET jobTitle=:ph_jobTitle , jobDescription=:ph_jobDescription, jobDetails=:ph_jobDetails, jobStatus=:ph_jobStatus, compID=:ph_compID
				 			WHERE jobID = :ph_jobID';
				
				$params 	= array('ph_jobID' => $jobID,
									'ph_jobTitle' => $jobTitle,
									'ph_jobDescription' => $jobDescription,
									'ph_jobDetails' =>  $jobDetails,
									'ph_jobStatus' => $jobStatus,
									'ph_compID' =>  $compID
									);

				wh_log("params before function: " . implode(" ,", $params));

				// Update job
				$returnValue = retrieveTable($sql, $params, $select = false);
if(DEBUG_V_P)	wh_log( "Line " . __LINE__ . "\$returnValue : $returnValue (" . basename(__FILE__) . ")");
				
				// // Reply to customer
				// echo $companies;
					} // END POST Verzweigung
				}	// END POST ARRAY 			
?>