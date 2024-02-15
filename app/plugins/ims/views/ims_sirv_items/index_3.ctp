//<script>
var store_parent_imsSirvItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'description','code','measurement','quantity','issued','remark'	,'balance' ,'reserved'<?php 
					/*foreach($stores as $store){ 
						echo ", '".$store['ImsStore']['name']."'";
					}*/?>,'balance_store','reserved_store'
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItems', 'action' => 'list_requisition_items_data', $requisition_id)); ?>'	})
});

var filter_conditions = '';

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
	
function SaveSIRV(){
		var store = c.getForm().findField('store').getValue();
		if(store != ''){
			var records = store_parent_imsSirvItems.data.items, fields = store_parent_imsSirvItems.fields;		
			var param = {};        
			for(var i = 0; i < records.length; i++) {
				for(var j = 0; j < fields.length; j++){
					param[ i + '^' + fields['items'][j]['name']] = Ext.encode(records[i].get(fields['items'][j]['name']));
				}
			}			
			Ext.Ajax.request({
				url: '<?php echo $this->Html->url(array('controller' => 'ims_requisitions', 'action' => 'create_sirv_items', $requisition_id)); ?>/'+store,
				params: param,
				method: 'POST',
				success: function(response, opts){
					store_parent_imsSirvItems.commitChanges();
					RefreshImsRequisitionData();
					var json = eval("(" + response.responseText + ")");
					Ext.Msg.alert('<?php __('Result'); ?>', json.msg);
				},
				failure: function(response, opts){
					var json = eval("(" + response.responseText + ")");
					Ext.Msg.alert('<?php __('Error'); ?>', json.errormsg);
				}
			});
			parentImsSirvItemsViewWindow.close();
		}
    }
	
var measurements = [['Pcs'],['Pkt'],['Pad'],['Kg'],['Roll'],['M'],['Set'],['Ream'],['m<sup>2</sup>']];
var msrstore = new Ext.data.ArrayStore({fields: [ 'value' ], data: measurements });

var itemstore = new Ext.data.ArrayStore({
						sortInfo: { field: "code", direction: "ASC" },
						storeId: 'my_array_store',
						id: 0,
						fields: ['id','name','code'],
						
						data: [
						<?php foreach($results as $result){?>
						['<?php echo $result['id']?>','<?php echo $result['name']?>','<?php echo $result['description']?>'],
						<?php
						}
						?>
						]
						
					});

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
		{header:"<?php __('description'); ?>", dataIndex: 'description', sortable: true},
		{header:"<?php __('Code'); ?>", dataIndex: 'code', sortable: true, editor: { id:'data[code]', xtype: 'combo', store: itemstore, triggerAction: 'all',allowBlank: false, editable: false, valueField: 'code', displayField: 'code', mode: 'local',forceSelection: true,selectOnFocus: true}, align:'left'},		
		{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true, editor: { id:'data[measurement]', xtype: 'combo', store: msrstore, triggerAction: 'all',allowBlank: false, editable: false, valueField: 'value', displayField: 'value', mode: 'local',forceSelection: true,selectOnFocus: true}, align:'left'},
		{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true, align:'left'},
		{header: "<?php __('Issuance'); ?>", dataIndex: 'issued', sortable: true, editor: { id:'data[issued]', xtype: 'numberfield', allowBlank: false }, align:'left'},
		{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true, editor: { id:'data[remark]', xtype: 'textfield', allowBlank: true }, align:'left'},
		{header: "<?php __('Balance'); ?>", dataIndex: 'balance', sortable: true},
		{header: "<?php __('On process'); ?>", dataIndex: 'reserved', sortable: true}
		<?php /*
					foreach($stores as $store){ 
						echo ", {header: \"" . $store['ImsStore']['name'] . "\", dataIndex: '" . $store['ImsStore']['name'] . "', sortable: true}";
					}*/?>,
		{header: "<?php __('Store Balance'); ?>", dataIndex: 'balance_store', sortable: true},
		{header: "<?php __('Store On process'); ?>", dataIndex: 'reserved_store', sortable: true}
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
        labelWidth: 150,
        labelAlign: 'right',
        defaultType: 'textfield',
		items: [
			 {
				xtype: 'combo',
				store: new Ext.data.ArrayStore({
					sortInfo: { field: "name", direction: "ASC" },
					storeId: 'my_array_store',
					id: 0,
					fields: ['id','name'],
					
					data: [
					<?php foreach($stores as $store){?>
					['<?php echo $store['ImsStore']['id']?>','<?php echo $store['ImsStore']['name']?>'],
					<?php
					}
					?>
					]
					
				}),					
				displayField: 'name',
				typeAhead: true,
				hiddenName:'data[ImsStore][id]',
				id: 'store',
				name: 'store',
				mode: 'local',					
				triggerAction: 'all',
				emptyText: 'Select One',
				selectOnFocus:true,
				valueField: 'id',
				fieldLabel: '<span style="color:red;">*</span> Store',
				allowBlank: false,
				editable: true,
				layout: 'form',
				lazyRender: true,
				blankText: 'Your input is invalid.',
				listeners : {
                            select : function(combo, record, index){
								filter_conditions = combo.getValue();
								store_parent_imsSirvItems.setBaseParam('query', filter_conditions);
								
                                store_parent_imsSirvItems.reload({
                                    params: {
                                        start: 0,
                                        limit: list_size,
                                        ims_store_id : combo.getValue()
                                    }
                                });
                            }
                        }
			}]
		});
	
var parentImsSirvItemsViewWindow = new Ext.Window({
	title: 'SIRV Items for the selected Requisition',
	width: 700,
	height:400,
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
			}
	,{
				text: '<?php __('Create & Close'); ?>',
				handler: function(btn){
					SaveSIRV();					
				}
			}
	,{
		text: 'Close',
		handler: function(btn){
			parentImsSirvItemsViewWindow.close();
		}
	}]
});

store_parent_imsSirvItems.setBaseParam('query', filter_conditions);

store_parent_imsSirvItems.load({
    params: {
        start: 0,    
        limit: list_size
    }
});