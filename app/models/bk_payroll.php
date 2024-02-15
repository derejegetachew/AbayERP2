<?php

class BkPayroll extends AppModel {

    var $name = 'BkPayroll';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    
    var $validate = array(
        'account_no' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'pf_account_no' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            ));
    
    var $belongsTo = array(
        'Employee' => array(
            'className' => 'Employee',
            'foreignKey' => 'employee_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Payroll' => array(
            'className' => 'Payroll',
            'foreignKey' => 'payroll_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'PayrollReport' => array(
            'className' => 'PayrollReport',
            'foreignKey' => 'payroll_report_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}

?>