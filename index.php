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

#********** LOGIN CONFIGURATION **********#
$errorLogin 					= NULL;
$loggedIn                       = false;
$userID                         = NULL;
#***************************************************************************************#

#***************************************************************************************#
                				
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

					
					} // END GET Verzweigung
				} // END URL PARAMETERS

				#********** PREVIEW POST ARRAY **********#

if(DEBUG_V_P)	echo "Line " . __LINE__ . "(" . basename(__FILE__) . ")";					
if(DEBUG_V_P)	print_r($_POST);

                #****************************************#
				
				// Schritt 1 FORM: Prüfen, ob Formular abgeschickt wurde
				// if( isset($_POST['newJob']) ) {
				$request_body = file_get_contents('php://input');
    			$data = json_decode($request_body, true);
				
				if( isset($data) ) {
if(DEBUG)		echo "Line " . __LINE__ . "Formular 'Job' wurde abgeschickt. (" . basename(__FILE__) . ")";										

				// Schritt 2 FORM: Werte auslesen, entschärfen, DEBUG-Ausgabe
if(DEBUG)		echo "Line " . __LINE__ . " Werte auslesen und entschärfen... (" . basename(__FILE__) . ")";
					
				$compID 			= cleanString( $data['compID'] );
				$jobTitle 			= cleanString( $data['jobTitle'] );
				$jobDescription		= cleanString( $data['jobDescription'] );
				$jobDetails			= cleanString( $data['jobDetails'] );
				$jobStatus			= cleanString( $data['jobStatus'] );
					
if(DEBUG_V_P)		echo "Line " . __LINE__ . "\$compID: $compID (" . basename(__FILE__) . ")";
					wh_log("Line " . __LINE__ . "\$compID: $compID (" . basename(__FILE__) . ")");
if(DEBUG_V_P)		echo "Line " . __LINE__ . "\$jobTitle: $jobTitle (" . basename(__FILE__) . ")n";
					wh_log("Line " . __LINE__ . "\$jobTitle: $jobTitle (" . basename(__FILE__) . ")");

if(DEBUG_V_P)		echo "Line " . __LINE__ . "\$jobDescription: $jobDescription (" . basename(__FILE__) . ")";
					wh_log("Line " . __LINE__ . "\$jobDescription: $jobDescription(" . basename(__FILE__) . ")");

if(DEBUG_V_P)		echo "Line " . __LINE__ . "\$jobDetails: $jobDetails (" . basename(__FILE__) . ")";
					wh_log("Line " . __LINE__ . "\$jobDetails: $jobDetails(" . basename(__FILE__) . ")");

if(DEBUG_V_P)		echo "Line " . __LINE__ . "\$jobStatus: $jobStatus (" . basename(__FILE__) . ")";
					wh_log("Line " . __LINE__ . "\$jobStatus: $jobStatus (" . basename(__FILE__) . ")");


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
if(DEBUG_V_P)	echo "Line " . __LINE__ . "\$returnValue : $returnValue (" . basename(__FILE__) . ")";
				
				wh_log("retunvalue: " . $returnValue);
				// // Reply to customer
				// echo $companies;
					// } // END POST Verzweigung
				}	// END POST ARRAY 			
?>