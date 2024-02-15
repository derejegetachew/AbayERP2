<?php

class PayrollReport extends AppModel {

    var $name = 'PayrollReport';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $validate = array(
        'date' => array(
            'date' => array(
                'rule' => array('date'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        )
    );
    var $belongsTo = array(
        'Payroll' => array(
            'className' => 'Payroll',
            'foreignKey' => 'payroll_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'BudgetYear' => array(
            'className' => 'BudgetYear',
            'foreignKey' => 'budget_year_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Maker' => array(
            'className' => 'User',
            'foreignKey' => 'maker_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Checker' => array(
            'className' => 'User',
            'foreignKey' => 'checker_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    var $hasMany = array(
        'BkBenefit' => array(
            'className' => 'BkBenefit',
            'foreignKey' => 'payroll_report_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'BkDeduction' => array(
            'className' => 'BkDeduction',
            'foreignKey' => 'payroll_report_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'BkLoan' => array(
            'className' => 'BkLoan',
            'foreignKey' => 'payroll_report_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'BkPayroll' => array(
            'className' => 'BkPayroll',
            'foreignKey' => 'payroll_report_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'BkPension' => array(
            'className' => 'BkPension',
            'foreignKey' => 'payroll_report_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'BkPrice' => array(
            'className' => 'BkPrice',
            'foreignKey' => 'payroll_report_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'BkTaxrule' => array(
            'className' => 'BkTaxrule',
            'foreignKey' => 'payroll_report_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

}

?>