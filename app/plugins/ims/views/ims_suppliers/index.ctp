
var store_suppliers = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','address','tin','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ims_suppliers', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"}
	//groupField: 'address'
});


function AddSupplier() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ims_suppliers', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var supplier_data = response.responseText;
			
			eval(supplier_data);
			
			SupplierAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the supplier add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditSupplier(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ims_suppliers', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var supplier_data = response.responseText;
			
			eval(supplier_data);
			
			SupplierEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the supplier edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewSupplier(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ims_suppliers', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var supplier_data = response.responseText;

            eval(supplier_data);

            SupplierViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the supplier view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentGrns(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_grns_data = response.responseText;

            eval(parent_grns_data);

            parentGrnsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteSupplier(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ims_suppliers', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			var obj = JSON.parse(response.responseText);
			if(obj.success == "false"){
				Ext.Msg.alert('<?php __('Error'); ?>', obj.errormsg);
			} else if(obj.success == "true"){
				Ext.Msg.alert('<?php __('Success'); ?>', obj.msg);
				RefreshSupplierData();
			}
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the supplier add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchSupplier(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ims_suppliers', 'action' => 'search')); ?>',
		success: function(response, opts){
			var supplier_data = response.responseText;

			eval(supplier_data);

			supplierSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the supplier search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchBySupplierName(value){
	var conditions = '\'ImsSupplier.name LIKE\' => \'%' + value + '%\'';
	store_suppliers.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshSupplierData() {
	store_suppliers.reload();
}


if(center_panel.find('id', 'supplier-tab') != "") {
	var p = center_panel.findById('supplier-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Suppliers'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'supplier-tab',
		xtype: 'grid',
		store: store_suppliers,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Address'); ?>", dataIndex: 'address', sortable: true},
			{header: "<?php __('TIN Number'); ?>", dataIndex: 'tin', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Suppliers" : "Supplier"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewSupplier(Ext.getCmp('supplier-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Suppliers</b><br />Click here to create a new Supplier'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddSupplier();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-supplier',
					tooltip:'<?php __('<b>Edit Suppliers</b><br />Click here to modify the selected Supplier'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditSupplier(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-supplier',
					tooltip:'<?php __('<b>Delete Suppliers(s)</b><br />Click here to remove the selected Supplier(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Supplier'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteSupplier(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Supplier'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Suppliers'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteSupplier(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View Supplier'); ?>',
					id: 'view-supplier',
					tooltip:'<?php __('<b>View Supplier</b><br />Click here to see details of the selected Supplier'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewSupplier(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Grns'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentGrns(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'supplier_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchBySupplierName(Ext.getCmp('supplier_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'supplier_go_button',
					handler: function(){
						SearchBySupplierName(Ext.getCmp('supplier_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchSupplier();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_suppliers,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-supplier').enable();
		p.getTopToolbar().findById('delete-supplier').enable();
		p.getTopToolbar().findById('view-supplier').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-supplier').disable();
			p.getTopToolbar().findById('view-supplier').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-supplier').disable();
			p.getTopToolbar().findById('view-supplier').disable();
			p.getTopToolbar().findById('delete-supplier').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-supplier').enable();
			p.getTopToolbar().findById('view-supplier').enable();
			p.getTopToolbar().findById('delete-supplier').enable();
		}
		else{
			p.getTopToolbar().findById('edit-supplier').disable();
			p.getTopToolbar().findById('view-supplier').disable();
			p.getTopToolbar().findById('delete-supplier').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_suppliers.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
