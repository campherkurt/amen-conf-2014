<?php

class Registration {
    
    private $post_data;
    private $db;
    private $insert_query;
    private $query_template;

    function __construct($post_data) {
       $this->post_data = $post_data;
       $this->setInsertQuery();
       $this->db = new mysqli("localhost", "root", "root", "amenconf");
       if ($this->db->connect_errno) {
           echo "An error has occurred. Our team has been notified and are investigating the problem. Thank you."; //$mysqli->connect_error;
       }
        
    }    

    function createRegistration() {
       $res = $this->insertUserRegistration();
       return $res;
    }

    private function setInsertQuery() {
        $this->query_template = <<<EOD
            INSERT INTO registration (
                full_name, 
                dob, 
                email, 
                mobile, 
                gender, 
                entry_type, 
                entry_location, 
                meals, 
                accomodation, 
                payment, 
                newsletters, 
                submission_date)
            values (
               '{$this->post_data['full_name']}',
               '{$this->post_data['dob']}',
               '{$this->post_data['email']}',
               '{$this->post_data['mobile']}',
               '{$this->post_data['gender']}',
               '{$this->post_data['entry_type']}',
               '{$this->post_data['entry_location']}',
               '{$this->post_data['meals']}',
               '{$this->post_data['accomodation']}',
               '{$this->post_data['payment']}',
               '{$this->post_data['newsletters']}',
               now());
EOD;
    
    }

    private function insertUserRegistration() {
       $res = $this->db->query($this->query_template);
       if ($this->db->insert_id) {
           return true;    
       }

       
        
    } 

}


?>
