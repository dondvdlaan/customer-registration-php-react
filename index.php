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

					} // END Verzweigung
				} // END URL PARAMETERS
				
?>