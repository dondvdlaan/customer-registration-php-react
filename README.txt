Freelance job registration PHP REACT

With this application you can register your freelance jobs from offering stage till
order. The jobs are related with a company and contact person.

In this application the Back-End is composed of PHP and the Front-End of REACT with the 
Bootstrap css library.

Set-up:
- Apache2 server at localhost:80(default)
- PHP server to start with $ php - S localhost:8000
- MySQL Database
- REACT at localhost:3000(default), npm install, npm start
- CSS from Bootstrap

The PHP files are located in the root of the application. REACT is placed in fe directory.
PHP is not designed to handle Restfull API's (POST, GET, PUT,etc) and therefor a work-around
has been implemented. For the Insert and Update operations, the command 
"file_get_contents('php://input')" has been used.

For PHP server debugging a log file is implemented(log.php), which starts automatically.

Client side Pagination have been used.

TODO
- Responsive collapse Navbar with React-bootstrap