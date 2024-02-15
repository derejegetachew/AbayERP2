		<?php
			$this->ExtForm->create('Mine');
			$this->ExtForm->defineFieldFunctions();
		?>


var currentlyToggled = '';
var toggleHandler = function(btn, pressed){
	var clickedButton = btn.getText();
	currentlyToggled = clickedButton;
}

 var distincts = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            fields: [
                 'distinct'		
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'mines', 'action' => 'distinct')).'?table='.$data['table'].'&field='.$data['field']; ?>'
	}),	
        sortInfo:{field: 'full_name', direction: "ASC"}
    });
distincts.load({
            params: {
                start: 0
            }
        });

		var MineEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			defaultType: 'textfield',

			items: [
				{
                        xtype: 'combo',
 			store : distincts,
                        name: 'data[distincts]',
                        emptyText: 'All',
                        id: 'inpval',
                        name: 'data[distincts]',
                        displayField : 'distinct',
                        valueField : 'distinct',
                        fieldLabel: 'Value',
                        mode: 'local',
                        disableKeyFilter : true,
                        emptyText: '',
                        editable: true,
                        triggerAction: 'all',
                        hideTrigger:true,
                        width:255
                                    },
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
					]}			]
		});
		
		var CritAddWindow = new Ext.Window({
			title: '<?php __('Add Criteria'); ?>',
			width: 490,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: MineEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					MineEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Mine.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(MineEditWindow.collapsed)
						MineEditWindow.expand(true);
					else
						MineEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Add'); ?>',
				handler: function(btn){
if(currentlyToggled=='')
currentlyToggled='LIKE';
var varstr='table'+seltab+'field'+selfil+'.push(["'+currentlyToggled+' \''+Ext.getCmp('inpval').getValue()+'\'"]);';
eval(varstr);
criteriastore.loadData(eval('table'+seltab+'field'+selfil));
var tbind=tabcheck.indexOf(String(data[seltab]));
if(tbind==-1){
tabcheck.push(String(data[seltab]));
store.loadData(data);}
var strck=eval('field'+seltab+'['+selfil+']');
var tmpind=eval('fieldcheck'+seltab).indexOf(String(strck));
if(tmpind==-1){
var exstr='fieldcheck'+seltab+'.push(String(field'+seltab+'['+selfil+']));';
eval(exstr);
fieldstore.loadData(eval('field'+seltab));
}
CritAddWindow.close();				
				}
			},{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					CritAddWindow.close();
				}
			}]
		});
