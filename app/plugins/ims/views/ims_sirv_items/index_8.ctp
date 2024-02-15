//<script>
var store_parent_imsSirvItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','code','description','measurement','quantity','unit_price','remark','tag','total','return','transfer'
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItems', 'action' => 'list_sirv_items_data2', $sirv_id)); ?>'	})
});


function ViewImsSirvItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItems', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsSirvItem_data = response.responseText;

			eval(imsSirvItem_data);

			ImsSirvItemViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the SIRV Item view form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsSirvItemName(value){
	var conditions = '\'ImsSirvItem.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsSirvItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsSirvItemData() {
	store_parent_imsSirvItems.reload();
}

  var editor = new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	
	function DeleteRow(){		
        var selectedRows = g.getSelectionModel().getSelections();
        
        if(selectedRows.length >0)
            store_parent_imsSirvItems.remove(selectedRows);
        else
            Ext.Msg.alert('Status', 'Please select at least one record to delete!');
	}
	
	function Return(){
		var from_branch = c.getForm().findField('from_branch').getValue();
		var from_user = c.getForm().findField('from_user').getValue();
		var number = c.getForm().findField('number').getValue();
		if(from_branch != '' && from_user != ''){
			var records = store_parent_imsSirvItems.data.items, fields = store_parent_imsSirvItems.fields;		
			var param = {};        
			for(var i = 0; i < records.length; i++) {
				for(var j = 0; j < fields.length; j++){
					param[ i + '^' + fields['items'][j]['name']] = Ext.encode(records[i].get(fields['items'][j]['name']));
				}
			}
         let check=false; 
         for(var i = 0; i < records.length; i++) {
	         if (records[i].data['quantity']<=0){
				check=true;
				break;
			    }
              }
           if(check){
			Ext.Msg.alert('Error ', 'One of your items was returned; please double-check your information and try again.');
			return 0;
		     }
			Ext.getCmp('btnReturn').disable();
			Ext.getCmp('btnReturnTransfer').disable();
			Ext.Ajax.request({
				url: '<?php echo $this->Html->url(array('controller' => 'ims_returns', 'action' => 'add_return', $sirv_id)); ?>/'+from_branch+'/'+from_user+'/'+number,
				params:param,
				method: 'POST',				
				success: function(response, opts){
					store_parent_imsSirvItems.commitChanges();
					//RefreshImsSirvData();
					parentImsSirvItemsViewWindow.close();
					var json = eval("(" + response.responseText + ")");
					Ext.Msg.alert('<?php __('Result'); ?>', json.msg);
				},
				failure: function(response, opts){
					var json = eval("(" + response.responseText + ")");
					Ext.Msg.alert('<?php __('Error'); ?>', json.errormsg);
				}
			});
		} // end of if branch and user empty check
		else{
			Ext.Msg.alert('Error   ', "Please select Owner  of the Item first  ");
			return 0;
		} 
    }

     /** @melkamu new added code for return  */
	 function ReturnTransfer(){
		var from_branch = c.getForm().findField('from_branch').getValue();
		var from_user = c.getForm().findField('from_user').getValue();
		var number = c.getForm().findField('number').getValue();
		if(from_branch != '' && from_user != ''){
			var records = store_parent_imsSirvItems.data.items, fields = store_parent_imsSirvItems.fields;		
			var param = {};        
			for(var i = 0; i < records.length; i++) {
				for(var j = 0; j < fields.length; j++){
					param[ i + '^' + fields['items'][j]['name']] = Ext.encode(records[i].get(fields['items'][j]['name']));
				}
			}
         let check=false; 
         for(var i = 0; i < records.length; i++) {
	         if (records[i].data['transfer']<=0){
				check=true;
				break;
			    }
              }
           if(check){
			Ext.Msg.alert('Error ', 'There is no transfer for One of your items ; please double-check your information and try again.');
			return 0;
		     }
			Ext.getCmp('btnReturn').disable();
			Ext.getCmp('btnReturnTransfer').disable();
		
			Ext.Ajax.request({
				url: '<?php echo $this->Html->url(array('controller' => 'ims_returns', 'action' => 'add_return_transfer', $sirv_id)); ?>/'+from_branch+'/'+from_user+'/'+number,
				params:param,
				method: 'POST',				
				success: function(response, opts){
					store_parent_imsSirvItems.commitChanges();
					//RefreshImsSirvData();
					parentImsSirvItemsViewWindow.close();
					var json = eval("(" + response.responseText + ")");
					Ext.Msg.alert('<?php __('Result'); ?>', json.msg);
				},
				failure: function(response, opts){
					var json = eval("(" + response.responseText + ")");
					Ext.Msg.alert('<?php __('Error'); ?>', json.errormsg);
				}
			});
		} // end of if branch and user empty check
		else{
			Ext.Msg.alert('Error   ', "Please select Owner  of the Item first  ");
			return 0;
		} 
    }

var g = new Ext.grid.GridPanel({
	title: '<?php __('SIRV Items'); ?>',
	store: store_parent_imsSirvItems,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsSirvItemGrid',
	plugins: [editor],
	columns: [
		{header:"<?php __('Id'); ?>", dataIndex: 'id', sortable: true, hidden: true},
		{header:"<?php __('Code'); ?>", dataIndex: 'code', sortable: true},
		{header:"<?php __('description'); ?>", dataIndex: 'description', sortable: true},
		{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
		{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', editor: { id:'data[quantity]', allowBlank: false }, sortable: true},
		{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
		{header: "<?php __('Total'); ?>", dataIndex: 'total', sortable: true},
		{header: "<?php __('Returned'); ?>", dataIndex: 'return', sortable: true},
		{header: "<?php __('Transfered'); ?>", dataIndex: 'transfer', sortable: true},
		{header: "<?php __('Remark'); ?>", dataIndex: 'remark', editor: { id:'data[remark]', allowBlank: true }, sortable: true},
		{header: "<?php __('Tag'); ?>", dataIndex: 'tag', editor: { id:'data[tag]', allowBlank: true, xtype: 'textarea' }, sortable: true, align:'left'},
		  	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            //ViewImsSirvItem(Ext.getCmp('imsSirvItemGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsSirvItems,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	
	if(this.getSelections().length > 1){
		
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		
	}
	else if(this.getSelections().length == 1){
	}
	else{
		
	}
});

var c = new Ext.form.FormPanel({
        baseCls: 'x-plain',
        labelWidth: 100,
        labelAlign: 'right',
		layout:'column',
		items: [{
				columnWidth:.5,
				layout: 'form',				
				defaultType: 'textfield',
                unstyled :true,
				items:[
			 {
				xtype: 'textfield',
				fieldLabel: 'Return Number',
				readOnly: 'true',
				value: '<?php date_default_timezone_set("Africa/Addis_Ababa"); echo date("Ymd").'/'.str_pad(($count + 1), 3,'0',STR_PAD_LEFT)?>',
				id: 'number',
				name: 'number',
			},
			{
				xtype: 'combo',
				store: new Ext.data.ArrayStore({
					sortInfo: { field: "name", direction: "ASC" },
					storeId: 'my_array_store',
					id: 0,
					fields: ['id','name'],
					
					data: [
					<?php foreach($branches as $branch){?>
					['<?php echo $branch['Branch']['id']?>','<?php echo $branch['Branch']['name']?>'],
					<?php
					}
					?>
					]
					
				}),					
				displayField: 'name',
				typeAhead: true,
				hiddenName:'data[ImsReturn][from_branch]',
				id: 'from_branch',
				name: 'from_branch',
				mode: 'local',					
				triggerAction: 'all',
				emptyText: 'Select branch',
				selectOnFocus:true,
				valueField: 'id',
				fieldLabel: '<span style="color:red;">*</span> From Branch',
				allowBlank: false,
				editable: true,
				layout: 'form',
				lazyRender: true,
				blankText: 'Your input is invalid.',
			}
			]
			},{
				columnWidth:.5,
				layout: 'form',				
				defaultType: 'textfield',
                unstyled :true,
				items:[
			 {
				xtype: 'combo',
				store: new Ext.data.ArrayStore({
					sortInfo: { field: "name", direction: "ASC" },
					storeId: 'my_array_store',
					id: 0,
					fields: ['id','name'],
					
					data: [
					<?php foreach($employees as $employee){?>
					['<?php echo $employee['People']['id']?>','<?php echo $employee['People']['first_name'].' '.$employee['People']['middle_name'].' '.$employee['People']['last_name']?>'],
					<?php
					}
					?>
					]
					
				}),					
				displayField: 'name',
				typeAhead: true,
				hiddenName:'data[ImsReturn][from_user]',
				id: 'from_user',
				name: 'from_user',
				mode: 'local',					
				triggerAction: 'all',
				emptyText: 'Select Employee',
				selectOnFocus:true,
				valueField: 'id',
				fieldLabel: '<span style="color:red;">*</span> From Employee',
				allowBlank: false,
				editable: true,
				layout: 'form',
				lazyRender: true,
				blankText: 'Your input is invalid.',
			}
			]
			}
			]
		});

var parentImsSirvItemsViewWindow = new Ext.Window({
	title: 'SIRV Items for return',
	width: 700,
	height:375,
	minWidth: 700,
	minHeight: 400,
	resizable: false,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'center',
        modal: true,
	items: [
		c,
		g
	],

	buttons: [{
				text: '<?php __('Delete Row'); ?>',
				handler: function(btn){
					DeleteRow();
				}
			},
			{
				text: '<?php __('Return'); ?>',
				id:'btnReturn',
				handler: function(btn){
					Return();
					
				}
			}
			,
			{
				text: '<?php __('Return Transferred Item'); ?>',
				id:'btnReturnTransfer',
				handler: function(btn){
					ReturnTransfer();
				}
			}
			,{
				text: 'Close',
				handler: function(btn){
					parentImsSirvItemsViewWindow.close();
				}
			}]
});

store_parent_imsSirvItems.load({
    params: {
        start: 0,    
        limit: list_size
    }
});