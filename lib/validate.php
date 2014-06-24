<?php

class Validate {
    
    private $error_arr = array('success'=>false, 'error_list'=>array());
    private $post_data = array();
    private $fields_to_check = array();
    private $cleaned_data;

    function __construct(array $post, array $fields_to_check){
        $this->post_data = $post;
        $this->fields_to_check = $fields_to_check;
        $this->run_full_validation();
    }

    function valid() {
        if ($this->error_arr['error_list']) {
            return false;
        }
        return $this->cleaned_data;
    }

    function get_error_messages() {
        return $this->error_arr; 
    }

    
    private function run_full_validation() {
        $this->check_required();
        $this->sanitize_post_data();
        
        
    }

    private function add_error($field_name, $message) {
       $this->error_arr['error_list'][] = array('field_name'=>$field_name, 'message'=>$message); 
    }

    private function check_required() {
        foreach($this->fields_to_check as $check_field){
           $field_name = $check_field['field_name'];
          if ($check_field['required'] === true && empty($this->post_data[$field_name])) {
               $this->add_error($field_name, 'This field is required.');
               //break;
           }
        }
    } 

    private function check_honee_pot() {
        $honee_pot_field = $_POST['address1'];
        if (!empty($honee_pot_field)) {
            $this->add_error("main", "Incorrect field added."); 
        }        
    }

    private function sanitize_post_data() {
        if ($this->error_arr['error_list']) {
            return ;
        }
        $cleaned_post_data = array();
        foreach($this->fields_to_check as $field_check){
            $field_name = $field_check['field_name'];
            if (!isset($this->post_data[$field_name])) {
                $cleaned_post_data[$field_name] = '';
                continue;
            }
            switch ($field_check['type']) {
                case 'string':
                    $cleaned_post_data[$field_name] = mysql_escape_string($this->post_data[$field_name]);
                    break;
                case 'email':
                    $email = FILTER_VAR($this->post_data[$field_name], FILTER_VALIDATE_EMAIL);;
                    if (!$email) {
                        $this->add_error($field_name, "Please enter a valid email address.");
                        return ;
                    }
                    $cleaned_post_data[$field_name] = mysql_escape_string($email);
                    break;
                case 'date':
                    $date = DateTime::createFromFormat('d-m-Y', $this->post_data[$field_name]);
                    if (!$date) {
                        $this->add_error($field_name, "Please enter a valid date. (dd-mm-yyyy)");
                        return ;
                    }
                    $cleaned_post_data[$field_name] = $date->format('Y-m-d H:i:s');
                    break;
                case 'numeric':
                    $value = preg_replace('/[+|\s|-]/', "", $this->post_data[$field_name]);
                    if (!$value) {
                        $this->add_error($field_name, "Please enter a valid number.");
                        return ;
                    }
                    $cleaned_post_data[$field_name] = mysql_escape_string($value);
                    break;
                case 'boolean':
                    $value = is_bool($this->post_data[$field_name]);
                    if (!$value) {
                        $this->add_error($field_name, "Please enter a valid choice.");
                        return ;
                    }
                    $cleaned_post_data[$field_name] = $this->post_data[$field_name] === true ? 1 : 0;
                    break;

                case 'radio':
                    $defaults = $field_check['defaults'];   
                    $value = strtolower($this->post_data[$field_name]);
                    if (!in_array($value, $defaults)) {
                        $this->add_error($field_name, "Please enter a valid choice.");
                        return ;
                    }    
                    $cleaned_post_data[$field_name] = mysql_escape_string($value);
                    break;

                case 'checkbox':
                    $defaults = $field_check['defaults'];   
                    $values = $this->post_data[$field_name];
                    foreach($values as $val){
                        if (!in_array(strtolower($val), $defaults)) {
                            $this->add_error($field_name, "Please enter a valid choice.");
                            return ;
                        }    
                    }
                    $cleaned_post_data[$field_name] = mysql_escape_string(join('|', $values));
                    break;
            }
            
        }        
        $this->cleaned_data = $cleaned_post_data; 
    }

}


?>
