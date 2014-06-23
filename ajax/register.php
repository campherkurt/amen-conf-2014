<?php

require('/home/vagrant/git_repos/conf2014/lib/validate.php');
require('/home/vagrant/git_repos/conf2014/controllers/registration.php');

if (isset($_POST['full_name'])) {
    $fields = array(
        array('field_name'=>'full_name',      'required'=>true,   'type'=>'string'),
        array('field_name'=>'dob',            'required'=>true,   'type'=>'date'),
        array('field_name'=>'email',          'required'=>true,   'type'=>'email'),
        array('field_name'=>'mobile',         'required'=>true,   'type'=>'numeric'),
        array('field_name'=>'gender',         'required'=>true,   'type'=>'specific', 'defaults'=>array('m', 'f')),
        array('field_name'=>'entry_type',     'required'=>true,   'type'=>'specific', 'defaults'=>array('entry', 'half_entry', 'full_entry', 'sponsor')),
        array('field_name'=>'entry_location', 'required'=>true,   'type'=>'specific', 'defaults'=>array('pe', 'ct', 'not sure')),
        array('field_name'=>'meals',          'required'=>false,  'type'=>'checkbox', 'defaults'=>array('sabbath', 'sunday', 'monday')),
        array('field_name'=>'accomodation',   'required'=>false,  'type'=>'specific', 'defaults'=>array('yes', 'no')),
        array('field_name'=>'payment',        'required'=>true,   'type'=>'specific', 'defaults'=>array('eft', 'deposit', 'cheque')),
        array('field_name'=>'newsletter',     'required'=>false,  'type'=>'checkbox', 'defaults'=>array('monthly', 'conf_updates'))
    );
    $validate = new Validate($_POST, $fields);

    if ($validate->valid()) {
        $register = new Registration();
        $register->createRegistration();
        echo json_encode(array('success'=>'true'));
        exit();
    }
    header("HTTP/1.1 200 AMEN say no no!!", TRUE, 200);
    echo json_encode($validate->get_error_messages());
    exit();
    
}
?>
