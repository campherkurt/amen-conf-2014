<?php

class Validate {
    
    private $error_arr = array();
    private $post_data = array();
    private $fields_to_check = array();

    function __construct(array $post, array $fields_to_check){
        $this->post_data = $post;
        $this->fields_to_check = $fields_to_check;
        $this->run_full_validation();
    }

    function valid() {
        if ($this->error_arr) {
            return false;
        }
        return true;
    }

    function get_error_messages() {
        return $this->error_arr; 
    }

    
    private function run_full_validation() {
        $this->check_required();
        $this->sanitize_post_data();
        
        
    }

    private function check_required() {
        foreach($this->fields_to_check as $check_field){
           $field_name = $check_field['field_name'];
           if ($check_field['required'] === true && !isset($this->post_data[$field_name])) {
               $this->error_arr[$field_name] = "This field is required.";
               break;
           }
        }
    } 

    private function check_honee_pot() {
        $honee_pot_field = $_POST['address1'];
        if (!empty($honee_pot_field)) {
            $this->error_arr["main"] = "Incorrect field added.";    
        }        
    }

    private function sanitize_post_data() {
        if ($this->error_arr) {
            return ;
        }
        $cleaned_post_data = array();
        foreach($this->fields_to_check as $field_check){
            $field_name = $field_check['field_name'];
            switch ($field_check['type']) {
                case 'string':
                    $cleaned_post_data[$field_name] = htmlentities($this->post_data[$field_name]);
                    break;
                case 'email':
                    $email = FILTER_VAR($this->post_data[$field_name], FILTER_VALIDATE_EMAIL);;
                    if (!$email) {
                        $this->error_arr[$field_name] = "Please enter a valid email address.";
                        return ;
                    }
                    $cleaned_post_data[$field_name] = $email;
                    break;
                case 'date':
                    $date = DateTime::createFromFormat('d-m-Y', $this->post_data[$field_name]);
                    if (!$date) {
                        $this->error_arr[$field_name] = "Please enter a valid date. (dd-mm-yyyy)";
                        return ;
                    }
                    $cleaned_post_data[$field_name] = $date;
                    break;
                case 'numeric':
                    $value = preg_replace('/[+|\s|-]/', "", $this->post_data[$field_name]);
                    if (!$value) {
                        $this->error_arr[$field_name] = "Please enter a valid number.";
                        return ;
                    }
                    $cleaned_post_data[$field_name] = $value;
                    break;
                case 'boolean':
                    $value = is_bool($this->post_data[$field_name]);
                    if (!$value) {
                        $this->error_arr[$field_name] = "Please enter a valid choice.";
                        return ;
                    }
                    $cleaned_post_data[$field_name] = $this->post_data[$field_name] === true ? 1 : 0;
                    break;

                case 'specific':
                    $defaults = $field_check['defaults'];   
                    $values = $this->post_data[$field_name];
                    $values = (strpos($values, ',') > -1) ?  $values_arr = str_split(',', $values) :  $values_arr = array($values);
                    foreach($values as $val){
                        if (!in_array(strtolower($val), $defaults)) {
                            $this->error_arr[$field_name] = "Please enter a valid choice.";
                            break;
                        }    
                    }
            }
            
        }        
        $this->post_data = $cleaned_post_data; 
    }

}


?>
