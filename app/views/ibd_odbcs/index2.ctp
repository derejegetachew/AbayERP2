var store_parent_ibdOdbcs = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','Exporter_Name','payment_term','Doc_Ref','Permit_No','NBE_Permit_no','Branch_Name','ODBC_DD','Destination','Single_Ent','currency_type','doc_permitt_amount','value_date','proceed_amount','rate','lcy','Deduction'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOdbcs', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentIbdOdbc() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOdbcs', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_ibdOdbc_data = response.responseText;
			
			eval(parent_ibdOdbc_data);
			
			IbdOdbcAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdOdbc add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentIbdOdbc(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOdbcs', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_ibdOdbc_data = response.responseText;
			
			eval(parent_ibdOdbc_data);
			
			IbdOdbcEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdOdbc edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewIbdOdbc(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOdbcs', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var ibdOdbc_data = response.responseText;

			eval(ibdOdbc_data);

			IbdOdbcViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdOdbc view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentIbdOdbc(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOdbcs', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('IbdOdbc(s) successfully deleted!'); ?>');
			RefreshParentIbdOdbcData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdOdbc to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentIbdOdbcName(value){
	var conditions = '\'IbdOdbc.name LIKE\' => \'%' + value + '%\'';
	store_parent_ibdOdbcs.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentIbdOdbcData() {
	store_parent_ibdOdbcs.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('IbdOdbcs'); ?>',
	store: store_parent_ibdOdbcs,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'ibdOdbcGrid',
	columns: [
		{header: "<?php __('Exporter Name'); ?>", dataIndex: 'Exporter_Name', sortable: true},
		{header:"<?php __('payment_term'); ?>", dataIndex: 'payment_term', sortable: true},
		{header: "<?php __('Doc Ref'); ?>", dataIndex: 'Doc_Ref', sortable: true},
		{header: "<?php __('Permit No'); ?>", dataIndex: 'Permit_No', sortable: true},
		{header: "<?php __('NBE Permit No'); ?>", dataIndex: 'NBE_Permit_no', sortable: true},
		{header: "<?php __('Branch Name'); ?>", dataIndex: 'Branch_Name', sortable: true},
		{header: "<?php __('ODBC DD'); ?>", dataIndex: 'ODBC_DD', sortable: true},
		{header: "<?php __('Destination'); ?>", dataIndex: 'Destination', sortable: true},
		{header: "<?php __('Single Ent'); ?>", dataIndex: 'Single_Ent', sortable: true},
		{header:"<?php __('currency_type'); ?>", dataIndex: 'currency_type', sortable: true},
		{header: "<?php __('Doc Permitt Amount'); ?>", dataIndex: 'doc_permitt_amount', sortable: true},
		{header: "<?php __('Value Date'); ?>", dataIndex: 'value_date', sortable: true},
		{header: "<?php __('Proceed Amount'); ?>", dataIndex: 'proceed_amount', sortable: true},
		{header: "<?php __('Rate'); ?>", dataIndex: 'rate', sortable: true},
		{header: "<?php __('Lcy'); ?>", dataIndex: 'lcy', sortable: true},
		{header: "<?php __('Deduction'); ?>", dataIndex: 'Deduction', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewIbdOdbc(Ext.getCmp('ibdOdbcGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add IbdOdbc</b><br />Click here to create a new IbdOdbc'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentIbdOdbc();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-ibdOdbc',
				tooltip:'<?php __('<b>Edit IbdOdbc</b><br />Click here to modify the selected IbdOdbc'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentIbdOdbc(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-ibdOdbc',
				tooltip:'<?php __('<b>Delete IbdOdbc(s)</b><br />Click here to remove the selected IbdOdbc(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove IbdOdbc'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentIbdOdbc(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove IbdOdbc'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected IbdOdbc'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentIbdOdbc(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			}, ' ','-',' ', {
				xtype: 'tbsplit',
				text: '<?php __('View IbdOdbc'); ?>',
				id: 'view-ibdOdbc2',
				tooltip:'<?php __('<b>View IbdOdbc</b><br />Click here to see details of the selected IbdOdbc'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewIbdOdbc(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_ibdOdbc_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentIbdOdbcName(Ext.getCmp('parent_ibdOdbc_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_ibdOdbc_go_button',
				handler: function(){
					SearchByParentIbdOdbcName(Ext.getCmp('parent_ibdOdbc_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_ibdOdbcs,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-ibdOdbc').enable();
	g.getTopToolbar().findById('delete-parent-ibdOdbc').enable();
        g.getTopToolbar().findById('view-ibdOdbc2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-ibdOdbc').disable();
                g.getTopToolbar().findById('view-ibdOdbc2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-ibdOdbc').disable();
		g.getTopToolbar().findById('delete-parent-ibdOdbc').enable();
                g.getTopToolbar().findById('view-ibdOdbc2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-ibdOdbc').enable();
		g.getTopToolbar().findById('delete-parent-ibdOdbc').enable();
                g.getTopToolbar().findById('view-ibdOdbc2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-ibdOdbc').disable();
		g.getTopToolbar().findById('delete-parent-ibdOdbc').disable();
                g.getTopToolbar().findById('view-ibdOdbc2').disable();
	}
});



var parentIbdOdbcsViewWindow = new Ext.Window({
	title: 'IbdOdbc Under the selected Item',
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
		g
	],

	buttons: [{
		text: 'Close',
		handler: function(btn){
			parentIbdOdbcsViewWindow.close();
		}
	}]
});

store_parent_ibdOdbcs.load({
    params: {
        start: 0,    
        limit: list_size
    }
});