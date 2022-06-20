Customer registration PHP REACT

In this application the Back-End is composed of PHP and the Front-End of REACT with the 
Bootstrap css library.

Set-up:
- Apache2 server at localhost:80(default)
- MySQL Database
- REACT at localhost:3000(default)
- CSS from Bootstrap

The PHP files are located in the root of the application. REACT is placed in fe directory.
PHP is not designed to handle Restfull API's (POST, GET, PUT,etc) and therefor a work-around
has been implemented. For the Insert and Update operations, the command 
"file_get_contents('php://input')" has been used.

For PHP server debugging a log file is implemented(log.php), which starts automatically.

Client side Pagination have been used.