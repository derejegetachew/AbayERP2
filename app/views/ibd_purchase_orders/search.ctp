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
			['IbdPurchaseOrder.PURCHASE_ORDER_ISSUE_DATE', '<?php __('PURCHASE ORDER ISSUE DATE'); ?>']
,			['IbdPurchaseOrder.NAME_OF_IMPORTER', '<?php __('NAME OF IMPORTER'); ?>']
,			['IbdPurchaseOrder.PURCHASE_ORDER_NO', '<?php __('PURCHASE ORDER NO'); ?>']
,			['IbdPurchaseOrder.currency_id', '<?php __('Currency Id'); ?>']
,			['IbdPurchaseOrder.FCY_AMOUNT', '<?php __('FCY AMOUNT'); ?>']
,			['IbdPurchaseOrder.RATE', '<?php __('RATE'); ?>']
,			['IbdPurchaseOrder.CAD_PAYABLE_IN_BIRR', '<?php __('CAD PAYABLE IN BIRR'); ?>']
,			['IbdPurchaseOrder.ITEM_DESCRIPTION_OF_GOODS', '<?php __('ITEM DESCRIPTION OF GOODS'); ?>']
,			['IbdPurchaseOrder.DRAWER_NAME', '<?php __('DRAWER NAME'); ?>']
,			['IbdPurchaseOrder.MINUTE_NO', '<?php __('MINUTE NO'); ?>']
,			['IbdPurchaseOrder.FCY_APPROVAL_DATE', '<?php __('FCY APPROVAL DATE'); ?>']
,			['IbdPurchaseOrder.FCY_APPROVAL_INTIAL_ORDER_NO', '<?php __('FCY APPROVAL INTIAL ORDER NO'); ?>']
,			['IbdPurchaseOrder.FROM_THEIR_FCY_ACCOUNT', '<?php __('FROM THEIR FCY ACCOUNT'); ?>']
,			['IbdPurchaseOrder.SETT_DATE', '<?php __('SETT DATE'); ?>']
,			['IbdPurchaseOrder.SETT_FCY_AMOUNT', '<?php __('SETT FCY AMOUNT'); ?>']
,			['IbdPurchaseOrder.SETT_PO_ISSUE_DATE_RATE', '<?php __('SETT PO ISSUE DATE RATE'); ?>']
,			['IbdPurchaseOrder.SETT_CAD_PAYABLE', '<?php __('SETT CAD PAYABLE'); ?>']
,			['IbdPurchaseOrder.IBC_NO', '<?php __('IBC NO'); ?>']
,			['IbdPurchaseOrder.REM_FCY_AMOUNT', '<?php __('REM FCY AMOUNT'); ?>']
,			['IbdPurchaseOrder.REM_CAD_PAYABLE_IN_BIRR', '<?php __('REM CAD PAYABLE IN BIRR'); ?>']
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

var ibdPurchaseOrderSearchForm = new Ext.form.FormPanel({
	baseCls: 'x-plain',
	labelWidth: 55,
	url: '<?php echo $this->Html->url(array('controller' => 'ibdPurchaseOrders', 'action' => 'search')); ?>',
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
				export_all=false;
					ibdPurchaseOrderSearchWindow.close();
					var conditions = finalGrouping(ParamStore.getRange());
					store_ibdPurchaseOrders.reload({
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

var ibdPurchaseOrderSearchWindow = new Ext.Window({
	title: '<?php __('Search IbdPurchaseOrder'); ?>',
	modal: true,
	items: ibdPurchaseOrderSearchForm,
	resizable: false,
	width: 550,
	height: 400,
	bodyStyle: 'padding: 5px;',
	layout: 'fit',
	plain: true
});