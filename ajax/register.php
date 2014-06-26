<?php

require('/home/vagrant/git_repos/conf2014/lib/validate.php');
require('/home/vagrant/git_repos/conf2014/controllers/registration.php');

if (isset($_POST['full_name'])) {
    $fields = array(
        array('field_name'=>'full_name',      'required'=>true,   'type'=>'string'),
        array('field_name'=>'dob',            'required'=>true,   'type'=>'date'),
        array('field_name'=>'email',          'required'=>true,   'type'=>'email'),
        array('field_name'=>'mobile',         'required'=>true,   'type'=>'numeric'),
        array('field_name'=>'gender',         'required'=>true,   'type'=>'radio',     'defaults'=>array('m', 'f')),
        array('field_name'=>'entry_type',     'required'=>true,   'type'=>'radio',     'defaults'=>array('entry', 'half_entry', 'full_entry', 'sponsor', 'pe_entry')),
        array('field_name'=>'entry_location', 'required'=>true,   'type'=>'radio',     'defaults'=>array('pe', 'ct', 'not sure')),
        array('field_name'=>'meals',          'required'=>false,  'type'=>'checkbox',  'defaults'=>array('sabbath', 'sunday', 'monday')),
        array('field_name'=>'accomodation',   'required'=>false,  'type'=>'radio',     'defaults'=>array('yes', 'no')),
        array('field_name'=>'payment',        'required'=>true,   'type'=>'radio',     'defaults'=>array('eft', 'deposit', 'cheque')),
        array('field_name'=>'newsletters',    'required'=>false,  'type'=>'checkbox',  'defaults'=>array('monthly', 'conf_updates'))
    );
    $validate = new Validate($_POST, $fields);
    $cleaned_data = $validate->valid();
    if ($cleaned_data) {
        $register = new Registration($cleaned_data);
        if ($register->createRegistration()){
            echo json_encode(array('success'=>'true'));
        }
        else {
            echo json_encode(array('success'=>'false'));
        }
        exit();
    }
    header("HTTP/1.1 200 AMEN say no no!!", TRUE, 200);
    echo json_encode($validate->get_error_messages());
    exit();
    
}
?>
