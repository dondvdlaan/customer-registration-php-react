<?php
#***************************************************************************************#
                ob_start(); // Work-around startsession Problem 12 Apr 2022
				#****************************************#
				#********** PAGE CONFIGURATION **********#
				#****************************************#
				
				require_once('./include/config.inc.php');
				require_once('./include/form.inc.php');
				require_once('./include/db.inc.php');
				// require_once('./include/cors.php');


				#******************************************#
				#********** INITIALIZE VARIABLES **********#
				#******************************************#
				
                $category                       = NULL;
                #********** LOGIN CONFIGURATION **********#
				$errorLogin 					= NULL;
				$loggedIn                       = false;
                $userID                         = NULL;
#***************************************************************************************#
				#********** PROCESS URL PARAMETERS **********#
				
				// Allow REACT to contact
				header('Access-Control-Allow-Origin: http://localhost:3000');
				print_r($_GET);
				// $user = $_GET['name'];
				// echo ("Hello from server: $user");
				
				#********** PREVIEW GET ARRAY **********#
// if(DEBUG_V)	echo "<pre class='debug value'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_V)	print_r($_GET);					
// if(DEBUG_V)	echo "</pre>";
// 				#****************************************#

// 				// Schritt 1 URL: Prüfen, ob URL-Parameter übergeben wurde
// 				if( isset($_GET['action']) ) {
// if(DEBUG)		    echo "<p class='debug'>🧻 <b>Line " . __LINE__ . "</b>: URL-Parameter 'action' wurde übergeben. <i>(" . basename(__FILE__) . ")</i></p>\n";										
										
// 					// Schritt 2 URL: Werte auslesen, entschärfen, DEBUG-Ausgabe
// 						$action = cleanString($_GET['action']);
// if(DEBUG_V)		    echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$action: $action <i>(" . basename(__FILE__) . ")</i></p>\n";
										
// 					// Schritt 3 URL: Verzweigung
										
// 					#********** SET CATEGORY **********#
// 					if( $action === 'selectCategory'){
// if(DEBUG)			echo "<p class='debug'>📑 <b>Line " . __LINE__ . "</b>: Auswerten Kategorie... <i>(" . basename(__FILE__) . ")</i></p>\n";
						
// 						// Schritt 2 URL: Werte auslesen, entschärfen, DEBUG-Ausgabe
// 						$category = cleanString($_GET['category']);
// if(DEBUG_V)		    echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$category: $category <i>(" . basename(__FILE__) . ")</i></p>\n";
					
// 					} // END Verzweigung
// 				} // END URL PARAMETERS

// 				// Schritt 4 DB: Daten weiterverarbeiten

// 				#**********************************************************************************************#

// 				#********** FETCH BLOGS  **********#
// 				#********** DB OPERATION **********#
											
// 				// Schritt 1 DB: DB-Verbindung herstellen
// 				$PDO = dbConnect(DB_NAME);
											
// 				#********** SELECT TABLES **********#
// if(DEBUG)		echo "<p class='debug'>📑 <b>Line " . __LINE__ . "</b>: Lese Blogs aus DB aus... <i>(" . basename(__FILE__) . ")</i></p>\n";

// 				if(isset($category)){
// if(DEBUG)		    echo "<p class='debug'>🧻 <b>Line " . __LINE__ . "</b>: Überprüfen ob Blogs per $category sortiert werden müssen. <i>(" . basename(__FILE__) . ")</i></p>\n";										

// 				$sql 		= 'SELECT blogHeadline, blogContent, blogDate, catLabel,
// 										userFirstName, userLastName, userCity, 
// 										blogImagePath, blogImageAlignment, blogDate
// 							FROM blogs
// 							INNER JOIN users USING(userID)
// 							INNER JOIN categories USING(catID)
// 							WHERE catLabel = :ph_category
// 							ORDER BY blogDate DESC; 
// 							';
											
// 				$params 	= array('ph_category' => $category);

// 				}else{ // Alle Blogs ausgeben

// 					$sql 		= 'SELECT blogHeadline, blogContent, blogDate, catLabel,
// 										userFirstName, userLastName, userCity, 
// 										blogImagePath, blogImageAlignment, blogDate
// 								FROM blogs
// 								INNER JOIN users USING(userID)
// 								INNER JOIN categories USING(catID)
// 								ORDER BY blogDate DESC;
// 								';
												
// 					$params 	= array();
// 				} // END Überprüfung Kategorie
											
// 				// Schritt 2 DB: SQL-Statement vorbereiten
// 				$PDOStatement = $PDO->prepare($sql);
											
// 				// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
// 				try {	
// 					$PDOStatement->execute($params);						
// 				} catch(PDOException $error) {
// if(DEBUG)			echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: " . $error->GetMessage() . "<i>(" . basename(__FILE__) . ")</i></p>\n";										
// 					$dbError = 'Fehler beim Zugriff auf die Datenbank!';
// 				}

// 				// Schritt 4 DB: Daten weiterverarbeiten
// 				$blogs = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);

// if(DEBUG_V)			echo "<pre class='debug value'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_V)			print_r($blogs);					
// if(DEBUG_V)			echo "</pre>";
														
// 				// Zählen, wieviele Datensätze zurückgeliefert wurden
// 					$rowCount = $PDOStatement->rowCount();
// if(DEBUG_V)			echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$rowCount: $rowCount <i>(" . basename(__FILE__) . ")</i></p>\n";
					
// 					// DB-Verbindung beenden
// 					unset($PDO);

// 				#********************************************************************************************

// 				#********** PROCESS FORM LOGIN **********#

// 				#********** PREVIEW POST ARRAY **********#

// if(DEBUG_V)	echo "<pre class='debug value'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_V)	print_r($_POST);					
// if(DEBUG_V)	echo "</pre>";

// 				#****************************************#

// 				// Schritt 1 FORM: Prüfen, ob Formular abgeschickt wurde
// 				if( isset($_POST['formLogin']) ) {
// if(DEBUG)		echo "<p class='debug'>🧻 <b>Line " . __LINE__ . "</b>: Formular 'Login' wurde abgeschickt. <i>(" . basename(__FILE__) . ")</i></p>\n";										
										
// 				// Schritt 2 FORM: Werte auslesen, entschärfen, DEBUG-Ausgabe
// if(DEBUG)		echo "<p class='debug'>📑 <b>Line " . __LINE__ . "</b>: Werte auslesen und entschärfen... <i>(" . basename(__FILE__) . ")</i></p>\n";
					
// 				$email 	    = cleanString( $_POST['email'] );
// 				$password 	= cleanString( $_POST['password'] );
// if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$email: $email <i>(" . basename(__FILE__) . ")</i></p>\n";
// if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$password: $password <i>(" . basename(__FILE__) . ")</i></p>\n";
										
// 				// Schritt 3 FORM: Feldvalidierung
// if(DEBUG)		echo "<p class='debug'>📑 <b>Line " . __LINE__ . "</b>: Feldwerte werden validiert... <i>(" . basename(__FILE__) . ")</i></p>\n";
										
// 				$errorEmail 	= validateEmail($email, minLength:4, maxLength:20);
// 				$errorPassword = checkInputString($password, minLength:4);
// if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$errorEmail: $errorEmail <i>(" . basename(__FILE__) . ")</i></p>\n";
// if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$errorPassword: $errorPassword <i>(" . basename(__FILE__) . ")</i></p>\n";
										
										
// 				#********** FINAL FORM VALIDATION **********#
// 				if( $errorEmail !== NULL OR $errorPassword !== NULL ) {
// 					// Fehlerfall
// if(DEBUG)			echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Das Formular enthält noch Fehler! <i>(" . basename(__FILE__) . ")</i></p>\n";				
											
// 					// NEUTRALE Fehlermeldung für User ausgeben
// 					$errorLogin = 'Die Logindaten sind ungültig!';
											
// 				} else {
// 					// Erfolgsfall
// if(DEBUG)			echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Das Formular ist formal fehlerfrei. <i>(" . basename(__FILE__) . ")</i></p>\n";				
											
// 				// Schritt 4 FORM: Daten weiterverarbeiten
											
											
// 					#********** VALIDATE LOGIN **********#

// 					#********** DB OPERATION **********#
											
// 					// Schritt 1 DB: DB-Verbindung herstellen
// 					$PDO = dbConnect(DB_NAME);
											
// 					#********** FETCH USER EMAIL FROM DATABSE BY USER EMAIL **********#
// if(DEBUG)			echo "<p class='debug'>📑 <b>Line " . __LINE__ . "</b>: Lese Userdaten zum empfangenen Email aus... <i>(" . basename(__FILE__) . ")</i></p>\n";
											
// 					$sql 		= 'SELECT userPassword, userEmail, userID 
// 									FROM users
// 									WHERE userEmail = :ph_email';
											
// 					$params 	= array( 'ph_email' => $email );
											
// 					// Schritt 2 DB: SQL-Statement vorbereiten
// 					$PDOStatement = $PDO->prepare($sql);
											
// 					// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
// 						try {	
// 							$PDOStatement->execute($params);						
// 						} catch(PDOException $error) {
// if(DEBUG)				echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: " . $error->GetMessage() . "<i>(" . basename(__FILE__) . ")</i></p>\n";										
// 							$dbError = 'Fehler beim Zugriff auf die Datenbank!';
// 						}
												
// 					// Schritt 4 DB: Daten weiterverarbeiten
// 					/*
// 					$PDOStatement->fetch() liefert den ersten gefundenen Datensatz in Form 
// 					eines eindimensionalen Arrays zurück und merkt sich, welcher Datensatz
// 					zuletzt zurückgeliefert wurde
// 											*/
// 					$row = $PDOStatement->fetch(PDO::FETCH_ASSOC);
											
// if(DEBUG_V)			echo "<pre class='debug value'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_V)			print_r($row);					
// if(DEBUG_V)			echo "</pre>";
// 					#********** 1. VALIDATE EMAIL **********#
// 					if( $row === false ) {
// 						// Fehlerfall
// if(DEBUG)				echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Der Email '$email' existiert nicht in der Datenbank! <i>(" . basename(__FILE__) . ")</i></p>\n";				
												
// 						// NEUTRALE Fehlermeldung für User ausgeben
// 						$errorLogin = 'Die Logindaten sind ungültig!';
												
// 					} else {
// 						// Erfolgsfall
// if(DEBUG)				echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Der Email '$email' wurde in der Datenbank gefunden. <i>(" . basename(__FILE__) . ")</i></p>\n";				
												
// 					#********** 2. VALIDATE PASSWORD **********#
// 					if( password_verify($password, $row['userPassword']) === false ) {
// 						// Fehlerfall
// if(DEBUG)				echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Das Passwort stimmt NICHT mit dem Passwort aus der Datenbank überein! <i>(" . basename(__FILE__) . ")</i></p>\n";				
													
// 						// NEUTRALE Fehlermeldung für User ausgeben
// 						$errorLogin = 'Die Logindaten sind ungültig!';
												
// 					} else {
// 						// Erfolgsfall
// if(DEBUG)				echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Das Passwort stimmt mit dem Passwort aus der Datenbank überein. <i>(" . basename(__FILE__) . ")</i></p>\n";				
													
// 						#********** 4. PROCESS LOGIN **********#
// if(DEBUG)				echo "<p class='debug'>📑 <b>Line " . __LINE__ . "</b>: Login wird durchgeführt... <i>(" . basename(__FILE__) . ")</i></p>\n";
														
// 						#********** PREPARE SESSION **********#
// 						// Der Sessionname sollte den Domainnamen der Webseite (ohne www., .com, .de etc.) enthalten
// 						session_name('blog');
														
// 						#********** START SESSION **********#
// 						/*
// 						Schlägt das Starten der Session fehl, gibt session_start() false zurück
// 						Keine Session = Kein Login
// 						*/
// 						if( session_start() === false ) {
// 							// Fehlerfall                                    
// if(DEBUG)					echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER beim Starten der Session! <i>(" . basename(__FILE__) . ")</i></p>\n";				
														
// 						} else {
// 							// Erfolgsfall
// if(DEBUG)					echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Session erfolgreich gestartet. <i>(" . basename(__FILE__) . ")</i></p>\n";				
															
															
// 							#********** SAVE USER DATA INTO SESSION **********#
				
// 							$_SESSION['ip_address']	= $_SERVER['REMOTE_ADDR'];
// 							$_SESSION['userID'] 	= $row['userID'];
// 							// Log Out und Navbar freigeben
							
// 							#********** REDIRECT TO dashboard.php **********#
// 							header('LOCATION: dashboard.php');
															
// 								} // PROCESS LOGIN END
					
// 							} // VALIDATE PASSWORD END
					
// 						} // VALIDATE EMAIL END
																	
// 					} // FINAL FORM VALIDATION END
					
// 					// DB-Verbindung beenden
// 					unset($PDO);
// 				} // PROCESS FORM LOGIN END
// 				#********************************************************************************************



// 				#*******************************************************************************************#                    
// 					#********** FETCH CATEGORIES FOR SELECT FIELD **********#

// 					#********** DB OPERATION **********#
											
// 					// Schritt 1 DB: DB-Verbindung herstellen
// 					$PDO = dbConnect(DB_NAME);
											
// 					#********** SELECT ALL CATEGORIES **********#
// if(DEBUG)			echo "<p class='debug'>📑 <b>Line " . __LINE__ . "</b>: Lese Kategorie für Select Field aus... <i>(" . basename(__FILE__) . ")</i></p>\n";
											
// 					$sql 		= 'SELECT catLabel
// 									FROM categories';
											
// 					$params 	= array();
											
// 					// Schritt 2 DB: SQL-Statement vorbereiten
// 					$PDOStatement = $PDO->prepare($sql);
											
// 					// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
// 					try {	
// 						$PDOStatement->execute();						
// 					} catch(PDOException $error) {
// if(DEBUG)			echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: " . $error->GetMessage() . "<i>(" . basename(__FILE__) . ")</i></p>\n";										
// 						$dbError = 'Fehler beim Zugriff auf die Datenbank!';
// 					}
												
// 					// Schritt 4 DB: Daten weiterverarbeiten
						
// 					$categories = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);

// if(DEBUG_V)			echo "<pre class='debug value'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_V)			print_r($categories);					
// if(DEBUG_V)			echo "</pre>";
														
// 					// Zählen, wieviele Datensätze zurückgeliefert wurden
// 					$rowCount = $PDOStatement->rowCount();
// if(DEBUG_V)			echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$rowCount: $rowCount <i>(" . basename(__FILE__) . ")</i></p>\n";
					
// 					// DB-Verbindung beenden
// 					unset($PDO);			
						
				#*******************************************************************************************#
				?>
				<!DOCTYPE html>
				<html>
				<head>
				<!-- Google Fonts -->
				<link href="https://fonts.googleapis.com/css?family=Averia+Serif+Libre|Noto+Serif|Tangerine" rel="stylesheet">
				<!-- Styling for public area -->
				<link rel="stylesheet" href="./css/main.css">
				<link rel="stylesheet" href="./css/debug.css">
				<meta charset="UTF-8">

				<title>PHP SERVER OUTPUT</title>
				</head>
				<body>
					<h2>PHP SERVER OUTPUT</h2>
				
				


				</body
?>