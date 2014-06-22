<?php

$mysqli = new mysqli("localhost", "root", "root", "amenconf");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}
$query = <<<EOD
create table registration(
   reg_id INT NOT NULL AUTO_INCREMENT,
   full_name VARCHAR(100) NOT NULL,
   dob date NOT NULL,
   email VARCHAR(100) NOT NULL,
   mobile VARCHAR(20),
   gender VARCHAR(5) NOT NULL,
   entry_type VARCHAR(10) NOT NULL,
   entry_location VARCHAR(20) NOT NULL,
   meals VARCHAR(40),
   accomodation VARCHAR(70),
   payment VARCHAR(15) NOT NULL,
   newsletter_conf BOOLEAN,
   newsletter_monthly BOOLEAN,
   submission_date DATE NOT NULL,
   PRIMARY KEY ( reg_id )
);

EOD;

$res = $mysqli->query($query);



?>
