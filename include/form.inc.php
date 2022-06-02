<?php
#********************************************************************************************#
				/**
				*	Replaces potential dangerous tokens (< > " ' &) of a forwarded String
				*	with HTML-entities and removes all Whitespaces before and after the String.
				*	An empty String is replaced by NULL
				*
				*	@param	String	$value			Forwarded String
				*
				*	@return	NULL|String				NULL at empty String | Neutralised and cleaned String
				*
				*/
				function cleanString($value) {
if(DEBUG_F)		echo "<p class='debugCleanString'>🌀 <b>Line " . __LINE__ . "</b>: Calling " . __FUNCTION__ . "('$value') <i>(" . basename(__FILE__) . ")</i></p>\n";	
					
					/*
						trim() removes before and after the String(not unside) 
						all so-called Whitespaces(empty spaces, tabs, CR)
					*/
					$value = trim($value);
					
					$value = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8', false);
					
					/*
						Empty String is converted in NULL 
					*/
					if( $value === '' ) {
						$value = NULL;
					}
					
					return $value;
				}
				

#********************************************************************************************#
				/**
				* 	Checks forwarded String on minium- and maxium length, as well optionally on
				*	empty String.
				*	Error is generated in case of empty String or unvalid length
				*
				*	@param	String		$value							forwarded String
				*	@param	Bool		$mandatory=true					toggle mandatory field	
				*	@param	Integer		$minLength=INPUT_MIN_LENGTH		minimum length to be checked								
				*	@param	Integer		$maxLength=INPUT_MAX_LENGTH		maximum length to be checked								
				*
				*	@return	String|NULL									error message | else NULL
				*
				*/
				function checkInputString($value, $mandatory=true, $minLength=INPUT_MIN_LENGTH, $maxLength=INPUT_MAX_LENGTH) {
if(DEBUG_F)		echo "<p class='debugCheckInputString'>🌀 <b>Line " . __LINE__ . "</b>: Aufruf " . __FUNCTION__ . "('$value' | [$minLength | $maxLength] | mandatory: $mandatory) <i>(" . basename(__FILE__) . ")</i></p>\n";	
					
					// Constants
					$ERROR_MANDATORY_FIELD = 'This is a mandatory field!';
					$ERROR_MINIMUM_LENGTH  = 'Shall hava a minimum length of %d characters!';
					$ERROR_MAXIMUM_LENGTH  = 'Shall hava a maximum length of %d characters!';

					/*
						Variable is false when: empty String, Integer 0. Float 0.0, NULL, empty array or false
						Exception: (!) Null ('0') are false, '00' is true.
					*/
					// Optional (when $mandatory===true): Check empty String or NULL
					#********** MANDATORY CHECK **********#
					if( $mandatory === true AND ($value === '' OR $value === NULL) ) {  // $value === NULL muss ergänzt werden, wenn cleanString() auf NULL-Rückgabe umgestellt wird.
						// error case
						return $ERROR_MANDATORY_FIELD;
						
					
					#********** MINIMUM LENGTH CHECK **********#
					} elseif( mb_strlen($value) < $minLength ) {
						// error case
						return sprintf($ERROR_MINIMUM_LENGTH, $minLength);
						
						
					#********** MAXIMUM LENGTH CHECK **********#
					} elseif( mb_strlen($value) > $maxLength ) {
						// error case
						return sprintf($ERROR_MAXIMUM_LENGTH, $maxLength);
						
					
					#********** STRING IS VALID **********#
					} else {
						// success case
						return NULL;
					}				
				}

#********************************************************************************************#
				/**
				*	Checks forwarded String on empty String and maximum length and whether
				*	Email is valid.
				*	Error message is generated in each case.
				*
				*	@param	String	$value							forwarded String
				*	@param	Bool	$mandatory=true					mandatory field	
				*	@param	Integer	$maxLength=INPUT_MAX_LENGTH		maximum length to be checked
				*
				*	@return	String|NULL								error message | else NULL
				*
				*/
				function validateEmail($value, $mandatory=true, $minLength=INPUT_MIN_LENGTH, $maxLength=INPUT_MAX_LENGTH) {
if(DEBUG_F)		echo "<p class='debugValidateEmail'>🌀 <b>Line " . __LINE__ . "</b>: Aufruf " . __FUNCTION__ . "('$value' | [$minLength | $maxLength] | mandatory: $mandatory) <i>(" . basename(__FILE__) . ")</i></p>\n";	
					
					// Constants
					$ERROR_EMAIL_FIELD = 'This is not a valid Email';
					
					#********** VALIDATE MANDATORY AND MAXIMUM LENGTH **********#
					// Checks on empty String and length
					if( $error = checkInputString($value, $mandatory, $minLength, $maxLength) ) {
						// error case
						return $error;
						
					
					#********** VALIDATE EMAIL ADDRESS **********#
					} elseif( filter_var($value, FILTER_VALIDATE_EMAIL) === false ) {
						// error case
						return $ERROR_EMAIL_FIELD;
					
					
					#********** STRING IS VALID EMAIL ADDRESS **********#
					} else {
						// success case
						return NULL;
					}
				}

#********************************************************************************************#
				/**
				*	Validates an Image stored on the server, generates a unique file name,
				*	a secure file extension and moves the Image in a specified target directory.
				*	The MIME-Type, the Image size in pixel as well as the determined file size,
				*	all read from the file header,  are validated.
				*	The file header is also checked for plausibility.
				*
				*	@param	String	$fileTemp											The temporary path to the uploaded image in the quarantine directory
				*	@param	Integer	$imageMaxWidth=IMAGE_MAX_WIDTH						The maximum allowed image width in pixels
				*	@param	Integer	$imageMaxHeight=IMAGE_MAX_HEIGHT					The maximum allowed image height in pixels
				*	@param	Integer	$imageMaxSize=IMAGE_MAX_SIZE						The maximum allowed file size in Bytes
				*	@param	String	$imageUploadPath=IMAGE_UPLOAD_PATH					Target directory
				*	@param	Array	$imageAllowedMimeTypes=IMAGE_ALLOWED_MIME_TYPES		Whitelist of the permitted MIME types with the associated file extensions
				*	@param	Integer	$imageMinSize=IMAGE_MIN_SIZE						The munimum allowed file size in Bytes
				*
				*	@return	Array		{'imagePath'	=>	String|NULL, 				If successful, the path to the file in the target directory | error case NULL
				*							 'imageError'	=>	String|NULL}			success case NULL | error case error message
				*
				*/
				function imageUpload( $fileTemp,
											 $imageMaxWidth				= IMAGE_MAX_WIDTH,
											 $imageMaxHeight			= IMAGE_MAX_HEIGHT,
											 $imageMaxSize				= IMAGE_MAX_SIZE,
											 $imageUploadPath			= IMAGE_UPLOAD_PATH,
											 $imageAllowedMimeTypes		= IMAGE_ALLOWED_MIME_TYPES,
											 $imageMinSize				= IMAGE_MIN_SIZE
											) {
if(DEBUG_F)		echo "<p class='debugImageUpload'>🌀 <b>Line " . __LINE__ . "</b>: Calling " . __FUNCTION__ . "('$fileTemp') <i>(" . basename(__FILE__) . ")</i></p>\n";	
					
					// Constants
					$ERROR_MALICIOUS_SCRIPT = 'This is potential malicious script!';
					$ERROR_MIME_TYPE = 'This is not a valid Image type!';
					$ERROR_IMAGE_WIDTH = 'Image width maximum is %s px';
					$ERROR_IMAGE_HEIGHT = 'Image heigth maximum is %s px';
					$ERROR_IMAGE_SIZE = 'Image size may not surpass %d kB';
					
					#***************************************************************************#
					#********** GATHER INFORMATION FOR IMAGE FILE FROM FILE HEADER *************#
					#***************************************************************************#
					
					/**
					 *	Funktion getimagesize() reads the File header from an Image file and
					 *	returns, in case of valid MIME Type ('image/...'), a mixed array.
					 *
					 *	[0] 				Image width in PX 
					 *	[1] 				Image height in PX 
					 *	[3] 				A prepared String for the HTML <img>-Tag(width="480" height="532")
					 *	['bits']			Number of Bits per channel 
					 *	['channels']		Color channels(also for colour model: RGB=3, CMYK=4 )
					 *	['mime'] 			MIME Type
					 *
					 *	For invalid MIME Type (no 'image/...'), getimagesize() returns false
					*/
					$imageDataArray = getimagesize($fileTemp);
/*					
if(DEBUG_V)		echo "<pre class='debugImageUpload value'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
if(DEBUG_V)		print_r($imageDataArray);					
if(DEBUG_V)		echo "</pre>";
*/					
					
					#********** CHECK FOR VALID MIME TYPE **********#
					if( $imageDataArray === false ) {
						// error case (MIME TYPE is not valid)

						// Reset all Image variables
						$imageWidth = $imageHeight = $imageMimeType = $fileSize = NULL;

					#********** FETCH FILE INFOS **********#
					} elseif( is_array($imageDataArray) === true ) {
						// success case (MIME TYPE is valid)
						
						$imageWidth 	= $imageDataArray[0];			// image width in px via getimagesize()
						$imageHeight 	= $imageDataArray[1];			// image height in px via getimagesize()
						$imageMimeType	= $imageDataArray['mime'];		// image mime type via getimagesize()
						$fileSize		= filesize($fileTemp);			// image size in bytes via filesize()
					}
if(DEBUG_V)		echo "<p class='debugImageUpload value'><b>Line " . __LINE__ . "</b>: \$imageWidth: $imageWidth px <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debugImageUpload value'><b>Line " . __LINE__ . "</b>: \$imageHeight: $imageHeight px <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debugImageUpload value'><b>Line " . __LINE__ . "</b>: \$imageMimeType: $imageMimeType <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)		echo "<p class='debugImageUpload value'><b>Line " . __LINE__ . "</b>: \$fileSize: " . round($fileSize/1024, 2) . " kB <i>(" . basename(__FILE__) . ")</i></p>\n";
					
					#**************************************#
					#********** IMAGE VALIDATION **********#
					#**************************************#
					
					// Whitelist with allowed MIME TYPES and file extensions
					   $imageAllowedMimeTypes = array('image/jpg' => '.jpg', 'image/jpeg' => '.jpg', 'image/png' => '.png', 'image/gif' => '.gif');
					
					/*
						Since malicious code is often only a few lines long, a too small
						File size is suspicious per se. Usable image files start at
						about 1kB file size (about 80-100 bytes for icons).
						In addition, it is immediately checked whether a hacker might have manipulated the MIME type
						in the file header. Images always have a size indication
						in pixels that are sometimes forgotten by the hacker.
						If the image size specifications have no value, a manipulated 
						file header is assumed.
					*/
					#********** CHECK IF FILE HEADER IS PLAUSIBLE **********#
					if( $fileSize < $imageMinSize OR $imageWidth === NULL OR $imageHeight === NULL OR $imageMimeType === NULL ) {
						// error case 1: Potential suspicious file header
						$errorMessage = $ERROR_MALICIOUS_SCRIPT;
						
					#********** CHECK FOR VALID MIME TYPE **********#
					} elseif( in_array($imageMimeType, array_keys($imageAllowedMimeTypes), true) === false ) {
						// error case 2: MIME TYPE not allowed
						$errorMessage = $ERROR_MIME_TYPE;
					
					
					#********** VALIDATE IMAGE WIDTH **********#
					} elseif( $imageWidth > $imageMaxWidth ) {
						// error case 3: Image width too big
						$errorMessage = sprintf($ERROR_IMAGE_WIDTH, $imageMaxWidth);
					
					
					#********** VALIDATE IMAGE HEIGHT **********#
					} elseif( $imageHeight > $imageMaxHeight ) {
						// error case 4: Image height too big
						$errorMessage = sprintf($ERROR_IMAGE_HEIGHT, $imageMaxHeight);
						
					#********** VALIDATE FILE SIZE **********#	
					} elseif( $fileSize > $imageMaxSize ) {
						// error case 5: Image size too big
						$errorMessage = sprintf($ERROR_IMAGE_SIZE, $imageMaxSize/1024);
						
					
					#********** ALL CHECKS ARE PASSED **********#
					} else {
						// Erfolgsfall
						$errorMessage = NULL;
					}
					
					#*************************************************#
					
					
					#********** FINAL IMAGE VALIDATION **********#
					if( $errorMessage !== NULL ) {
						// Fehlerfall
if(DEBUG_F)			echo "<p class='debugImageUpload err'><b>Line " . __LINE__ . "</b>: $errorMessage <i>(" . basename(__FILE__) . ")</i></p>\n";				
						
						/*
							Da die Verzweigung im Fehlerfall an dieser Stelle verlassen wird, die Variable
							$fileTarget aber fester Bestandteil des Return-Wertes ist, muss sie an dieser 
							Stelle initialisiert werden, da sie ansonsten nicht existiert.
						*/
						// Initialize $fileTarget
						$fileTarget = NULL;
						
					} else {
						// Erfolgsfall
if(DEBUG_F)			echo "<p class='debugImageUpload ok'><b>Line " . __LINE__ . "</b>: Die Bildvalidierung ergab keinen Fehler. <i>(" . basename(__FILE__) . ")</i></p>\n";				
						
						
						#**********************************************************#
						#********** PREPARE IMAGE FOR PERSISTANT STORING **********#
						#**********************************************************#
						
						/*
							Da der Dateiname selbst Schadcode in Form von ungültigen oder versteckten Zeichen,
							doppelte Dateiendungen (dateiname.exe.jpg) etc. beinhalten kann, darüberhinaus ohnehin 
							sämtliche, nicht in einer URL erlaubten Sonderzeichen und Umlaute entfernt werden müssten 
							sollte der Dateiname aus Sicherheitsgründen komplett neu generiert werden.
							
							Hierbei muss außerdem bedacht werden, dass die jeweils generierten Dateinamen unique
							sein müssen, damit die Dateien sich bei gleichem Dateinamen nicht gegenseitig überschreiben.
						*/
						
						#********** GENERATE UNIQUE FILE NAME **********#
						/*
							- 	mt_rand() stellt die verbesserte Version der Funktion rand() dar und generiert 
								Zufallszahlen mit einer gleichmäßigeren Verteilung über das Wertesprektrum. Ohne zusätzliche
								Parameter werden Zahlenwerte zwischen 0 und dem höchstmöglichem von mt_rand() verarbeitbaren 
								Zahlenwert erzeugt.							
							- 	str_shuffle mischt die Zeichen eines übergebenen Strings zufällig durcheinander.
							- 	microtime() liefert einen Timestamp mit Millionstel Sekunden zurück (z.B. '0.57914300 163433596'),
								aus dem für eine URL-konforme Darstellung der Dezimaltrenner und das Leerzeichen entfernt werden.
						*/
						$fileName = mt_rand() . '_' . str_shuffle('abcdefghijklmnopqrstuvwxyz_-0123456789') . '_' . str_replace( array('.', ' '), '', microtime());
						
						
						#********** GENERATE FILE EXTENSION **********#
						/*
							Aus Sicherheitsgründen wird nicht die ursprüngliche Dateinamenerweiterung aus dem
							Dateinamen verwendet, sondern eine vorgenerierte Dateiendung aus dem Array der 
							erlaubten MIME Types.
							Die Dateiendung wird anhand des ausgelesenen MIME Types [key] ausgewählt.
						*/
						$fileExtension = $imageAllowedMimeTypes[$imageMimeType];
						
						
						#********** GENERATE FILE TARGET **********#
						/*
							Endgültigen Speicherpfad auf dem Server generieren:
							destinationPath/fileName + fileExtension
						*/
						$fileTarget = $imageUploadPath . $fileName . $fileExtension;						
					
					
if(DEBUG_V)			echo "<p class='debugImageUpload value'><b>Line " . __LINE__ . "</b>: \$fileTarget: <i>'$fileTarget'</i> <i>(" . basename(__FILE__) . ")</i></p>\n";
if(DEBUG_V)			echo "<p class='debugImageUpload value'><b>Line " . __LINE__ . "</b>: Länge des Pfades: " . strlen($fileTarget) . " <i>(" . basename(__FILE__) . ")</i></p>\n";
					
						#*************************************************#
						
						
						#*****************************************************#
						#********** MOVE IMAGE TO FINAL DESTINATION **********#
						#*****************************************************#
						
						/*
							move_uploaded_file() verschiebt eine hochgeladene Datei an einen 
							neuen Speicherort und benennt die Datei um
						*/
						if( move_uploaded_file($fileTemp, $fileTarget) === false ) {
							// Fehlerfall
if(DEBUG_F)				echo "<p class='debugImageUpload err'><b>Line " . __LINE__ . "</b>: FEHLER beim Verschieben der Datei von '$fileTemp' nach '$fileTarget'! <i>(" . basename(__FILE__) . ")</i></p>\n";				
							$errorMessage = 'Beim Speichern des Bildes ist ein Fehler aufgetreten! Bitte versuchen Sie es später noch einmal.';
							
							// Lösche $fileTarget
							$fileTarget = NULL;
							
						} else {
							// Erfolgsfall
if(DEBUG_F)				echo "<p class='debugImageUpload ok'><b>Line " . __LINE__ . "</b>: Datei erfolgreich von <i>'$fileTemp'</i> nach <i>'$fileTarget'</i> verschoben. <i>(" . basename(__FILE__) . ")</i></p>\n";				
						
						} // MOVE IMAGE TO FINAL DESTINATION END					
						#*************************************************#
					
					} // FINAL IMAGE VALIDATION END
					
					#*************************************************#
					
					#********** RETURN ARRAY CONTAINING EITHER IMAGE PATH OR ERROR MESSAGE **********#
					return array( 'imagePath' => $fileTarget, 'imageError' => $errorMessage );
					
					#*************************************************#
					
				}
#********************************************************************************************#
?>


















