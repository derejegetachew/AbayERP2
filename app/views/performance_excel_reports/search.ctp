var currentlyToggled = '';
var toggleHandler = function(btn, pressed){
	var clickedButton = btn.getText();
	currentlyToggled = clickedButton;
}

var ParamStore = new Ext.data.ArrayStore({ fields: ['value', 'text']});

function AddParameter(field, value){
	if(!validateInput(currentlyToggled,field,value)){
		Ext.Msg.alert('Invalid Input','Your Input is Invalid');
		return;
	}
	if(currentlyToggled == "IN"){
		row = [[field, '"' + field + '" => array( ' + InsertQuotations(value) + ' )' ]];
	}
	else if(currentlyToggled == "BETWEEN"){
		row = [[field, 'array(' + field + '" BETWEEN ? AND ?" => array( ' + InsertQuotations(value) + ' ))']];
	}
	else if(currentlyToggled == "LIKE"){
		row = [[field, '\'' + field + ' LIKE\' => \'%' + value + '%\'']];
	}
	else if(currentlyToggled == "="){
		row = [[field, '\'' + field + '\' => \'' + value + '\'']];
	}
	else
		row = [[ field , "'" + field + ' ' + currentlyToggled + '\' => ' + InsertQuotations(value) ]];
	ParamStore.loadData(row,true);
	ParamStore.reload();
	Ext.getCmp('param_view').doLayout();
}

function validateInput(operation, field, value) {
	if(operation == '' || field == '' || value == '')
		return 0;
	return 1;
}

function InsertQuotations(value) {
	var quotedString = '';
	var values = value.split(',');
	for( i = 0; i < values.length; i++){
		if(i > 0)
			quotedString += ', ';
		quotedString += "'" + values[i].trim() + "'";
	}
	return quotedString;
}

function RemoveParameters(records){
		ParamStore.remove(records);
		ParamStore.reload();
}

function GroupParameters(records, operation){
	if(records.length < 2)
		return 0;
	var finalParameter = '\'' + operation + '\' => array (';
	for(i = 0; i < records.length; i++){
		if(i > 0)
			finalParameter += ', ';
		finalParameter += ' array( ' + records[i].get('text') + ' ) ';
	}
	finalParameter += ')';
	row = [[1, finalParameter]];
	ParamStore.remove(records);
	ParamStore.loadData(row,true);
	ParamStore.reload();
	Ext.getCmp('param_view').doLayout();
	return 1;
}
function finalGrouping(records){
	var conditionsParameter = '';
	for(i = 0; i < records.length; i++){
			if(conditionsParameter == ''){
				conditionsParameter += 'array( ' + records[i].get('text') + ' )';
			}
			else
				conditionsParameter += ', array( ' + records[i].get('text') + ' )';
	}
	return conditionsParameter;
}
var SearchField = new Ext.form.ComboBox({
	name: 'searchField',
	fieldLabel: '<?php __('Field'); ?>',
	anchor: '100%',
	editable: false,
	triggerAction: 'all',
	typeAhead: true,
	store: new Ext.data.ArrayStore({
		fields: ['value_field', 'display_field'],
		data: [
			['Employee.name', '<?php __('Employee'); ?>']
,			['BudgetYear.name', '<?php __('BudgetYear'); ?>']
,			['PerformanceExcelReport.card_number', '<?php __('Card Number'); ?>']
,			['PerformanceExcelReport.first_name', '<?php __('First Name'); ?>']
,			['PerformanceExcelReport.middle_name', '<?php __('Middle Name'); ?>']
,			['PerformanceExcelReport.last_name', '<?php __('Last Name'); ?>']
,			['PerformanceExcelReport.sex', '<?php __('Sex'); ?>']
,			['PerformanceExcelReport.date_of_employment', '<?php __('Date Of Employment'); ?>']
,			['PerformanceExcelReport.status', '<?php __('Status'); ?>']
,			['PerformanceExcelReport.last_position', '<?php __('Last Position'); ?>']
,			['PerformanceExcelReport.branch', '<?php __('Branch'); ?>']
,			['PerformanceExcelReport.branch_district', '<?php __('Branch District'); ?>']
,			['PerformanceExcelReport.budget_year', '<?php __('Budget Year'); ?>']
,			['PerformanceExcelReport.q1', '<?php __('Q1'); ?>']
,			['PerformanceExcelReport.q2', '<?php __('Q2'); ?>']
,			['PerformanceExcelReport.q1q290', '<?php __('Q1q290'); ?>']
,			['PerformanceExcelReport.behavioural1', '<?php __('Behavioural1'); ?>']
,			['PerformanceExcelReport.semi_annual_one', '<?php __('Semi Annual One'); ?>']
,			['PerformanceExcelReport.q3', '<?php __('Q3'); ?>']
,			['PerformanceExcelReport.q4', '<?php __('Q4'); ?>']
,			['PerformanceExcelReport.q3q490', '<?php __('Q3q490'); ?>']
,			['PerformanceExcelReport.behavioural2', '<?php __('Behavioural2'); ?>']
,			['PerformanceExcelReport.semi_annual_two', '<?php __('Semi Annual Two'); ?>']
,			['PerformanceExcelReport.annual', '<?php __('Annual'); ?>']
,			['PerformanceExcelReport.q1_training1', '<?php __('Q1 Training1'); ?>']
,			['PerformanceExcelReport.q1_training2', '<?php __('Q1 Training2'); ?>']
,			['PerformanceExcelReport.q1_training3', '<?php __('Q1 Training3'); ?>']
,			['PerformanceExcelReport.q2_training1', '<?php __('Q2 Training1'); ?>']
,			['PerformanceExcelReport.q2_training2', '<?php __('Q2 Training2'); ?>']
,			['PerformanceExcelReport.q2_training3', '<?php __('Q2 Training3'); ?>']
,			['PerformanceExcelReport.q3_training1', '<?php __('Q3 Training1'); ?>']
,			['PerformanceExcelReport.q3_training2', '<?php __('Q3 Training2'); ?>']
,			['PerformanceExcelReport.q3_training3', '<?php __('Q3 Training3'); ?>']
,			['PerformanceExcelReport.q4_training1', '<?php __('Q4 Training1'); ?>']
,			['PerformanceExcelReport.q4_training2', '<?php __('Q4 Training2'); ?>']
,			['PerformanceExcelReport.q4_training3', '<?php __('Q4 Training3'); ?>']
,			['PerformanceExcelReport.q1_technical_plan_status', '<?php __('Q1 Technical Plan Status'); ?>']
,			['PerformanceExcelReport.q1_technical_result_status', '<?php __('Q1 Technical Result Status'); ?>']
,			['PerformanceExcelReport.q1_technical_comment', '<?php __('Q1 Technical Comment'); ?>']
,			['PerformanceExcelReport.q2_technical_plan_status', '<?php __('Q2 Technical Plan Status'); ?>']
,			['PerformanceExcelReport.q2_technical_result_status', '<?php __('Q2 Technical Result Status'); ?>']
,			['PerformanceExcelReport.q2_technical_comment', '<?php __('Q2 Technical Comment'); ?>']
,			['PerformanceExcelReport.q2_behavioural_result_status', '<?php __('Q2 Behavioural Result Status'); ?>']
,			['PerformanceExcelReport.q2_behavioural_comment', '<?php __('Q2 Behavioural Comment'); ?>']
,			['PerformanceExcelReport.q3_technical_plan_status', '<?php __('Q3 Technical Plan Status'); ?>']
,			['PerformanceExcelReport.q3_technical_result_status', '<?php __('Q3 Technical Result Status'); ?>']
,			['PerformanceExcelReport.q3_technical_comment', '<?php __('Q3 Technical Comment'); ?>']
,			['PerformanceExcelReport.q4_technical_plan_status', '<?php __('Q4 Technical Plan Status'); ?>']
,			['PerformanceExcelReport.q4_technical_result_status', '<?php __('Q4 Technical Result Status'); ?>']
,			['PerformanceExcelReport.q4_technical_comment', '<?php __('Q4 Technical Comment'); ?>']
,			['PerformanceExcelReport.q4_behavioural_result_status', '<?php __('Q4 Behavioural Result Status'); ?>']
,			['PerformanceExcelReport.q4_behavioural_comment', '<?php __('Q4 Behavioural Comment'); ?>']
,			['PerformanceExcelReport.report_status', '<?php __('Report Status'); ?>']
,			['PerformanceExcelReport.report_time', '<?php __('Report Time'); ?>']
		]
	}),
	mode: 'local',
	displayField: 'display_field',
	valueField: 'value_field'
});

var SearchValue = new Ext.form.TextField({
	id: 'Search_Value',
	fieldLabel: '<?php __('Value'); ?>',
	anchor: '100%'
});

var performanceExcelReportSearchForm = new Ext.form.FormPanel({
	baseCls: 'x-plain',
	labelWidth: 55,
	url: '<?php echo $this->Html->url(array('controller' => 'performanceExcelReports', 'action' => 'search')); ?>',
	defaultType: 'textfield',

	items: [
		{
			xtype: 'fieldset',
			title: '<?php __('Search Parameters'); ?>',
			anchor: '100%, 45%',
			defaultType: 'textfield',
			buttonAlign: 'right',
			items: [
				SearchField,
				{
					xtype: 'toolbar',
					columns: 9,
					defaults: {
						width: '50',
						enableToggle: true,
						toggleGroup : 'btnGroup',
						toggleHandler: toggleHandler
					},
					items: [
						{
							text: '=',
							tooltip: '<?php __('Equal To'); ?>'
						},
						{
							text: '\<\>',
							tooltip: '<?php __('Is Not Equal To'); ?>'
						},
						{
							text: '\<',
							tooltip: '<?php __('Less Than'); ?>'
						},
						{
							text: '\>',
							tooltip: '<?php __('Greater Than'); ?>'
						},
						{
							text: '\<=',
							tooltip: '<?php __('Less Than Or Equal To'); ?>'
						},
						{
							text: '\>=',
							tooltip: '<?php __('Greater Than Or Equal To'); ?>'
						},
						{
							text: 'LIKE',
							tooltip: '<?php __('Like This'); ?>'
						},
						{
							text: 'IN',
							tooltip: '<?php __('Is In This List (Like: a,b,c,...)'); ?>'
						},
						{
							text: 'BETWEEN',
							tooltip: '<?php __('Is Between These Two Values(Like: a,b)'); ?>'
						}
					]
				},
				SearchValue
			],
			buttons : [
				{
					text: '<?php __('Add Parameter'); ?>',
					handler: function(){
						AddParameter(SearchField.getValue(),SearchValue.getValue());
					}
				}
			]
		},{
			xtype: 'fieldset',
			anchor: '100%, 45%',
			title: '<?php __('Edit Parameters'); ?>',
			labelWidth: 0,
			layout: 'hbox',
			items: [{
				xtype: 'panel',
				width: 375,
				height: 110,
				layout: 'fit',
				items: {
						xtype: 'listview',
						id: 'param_view',
						autoScroll: true,
						store: ParamStore,
						multiSelect: true,
						hideHeaders: true,
						columns: [
							{
								header: 'value',
								dataIndex: 'text'
							}
						]
				}
			},
			{
				xtype: 'buttongroup',
				columns: 1,
				height: 100,
				border: false,
				width: 125,
				frame: true,
				iconCls: 'add32',
				items: [
					{
						xtype: 'button',
						text: '<?php __('Remove Parameter'); ?>',
						width: 110,
						handler: function(){
							var selectedRecords = Ext.getCmp('param_view').getSelectedRecords();
							if(selectedRecords.length == 0)
								Ext.Msg.alert('<?php __('Invalid Input'); ?>', '<?php __('You have to select at least one record'); ?>');
							else
								RemoveParameters(selectedRecords);
						}
					},
					{
						xtype: 'button',
						width: 110,
						text: 'AND',
						handler: function(){
							var result = GroupParameters(Ext.getCmp('param_view').getSelectedRecords(), 'AND');
							if(!result)
								Ext.Msg.alert('<?php __('Invalid Input'); ?>','<?php __('You have to select 2 or more records'); ?>');
						}
					},
					{
						xtype: 'button',
						width: 110,
						text: 'OR',
						handler: function(){
							var result = GroupParameters(Ext.getCmp('param_view').getSelectedRecords(), 'OR');
							if(!result)
								Ext.Msg.alert('<?php __('Invalid Input'); ?>','<?php __('You have to select 2 or more records'); ?>');
						}
					}
				]
			}]
		},
		
		{
			xtype: 'button',
			text: '<?php __('Search'); ?>',
			handler: function(){
				if(ParamStore.getCount() == 0)
					Ext.Msg.alert('<?php __('Invalid Input'); ?>','<?php __('Please input at least one search parameter'); ?>');
				else{
					performanceExcelReportSearchWindow.close();
					var conditions = finalGrouping(ParamStore.getRange());
					store_performanceExcelReports.reload({
						  params: {
								start: 0,
								limit: list_size,
								conditions: conditions
						   }
					});
				}
			}
		}
	]
});

var performanceExcelReportSearchWindow = new Ext.Window({
	title: '<?php __('Search PerformanceExcelReport'); ?>',
	modal: true,
	items: performanceExcelReportSearchForm,
	resizable: false,
	width: 550,
	height: 400,
	bodyStyle: 'padding: 5px;',
	layout: 'fit',
	plain: true
});