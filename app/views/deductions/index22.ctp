var store_parent_deductions = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','Measurement','amount','grade','start_date','end_date'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'deductions', 'action' => 'list_data2', $parent_id)); ?>'	})
});


function AddParentDeduction() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'deductions', 'action' => 'add2', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_deduction_data = response.responseText;
			
			eval(parent_deduction_data);
			
			DeductionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the deduction add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentDeduction(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'deductions', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_deduction_data = response.responseText;
			
			eval(parent_deduction_data);
			
			DeductionEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the deduction edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewDeduction(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'deductions', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var deduction_data = response.responseText;

			eval(deduction_data);

			DeductionViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the deduction view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentDeduction(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'deductions', 'action' => 'remove')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Deduction(s) successfully deleted!'); ?>');
			RefreshParentDeductionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the deduction to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentDeductionName(value){
	var conditions = '\'Deduction.name LIKE\' => \'%' + value + '%\'';
	store_parent_deductions.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentDeductionData() {
	store_parent_deductions.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Deductions'); ?>',
	store: store_parent_deductions,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'deductionGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Measurement'); ?>", dataIndex: 'Measurement', sortable: true},
		{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true},
		{header: "<?php __('Start Date'); ?>", dataIndex: 'start_date', sortable: true},
		{header: "<?php __('End Date'); ?>", dataIndex: 'end_date', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewDeduction(Ext.getCmp('deductionGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Deduction</b><br />Click here to create a new Deduction'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentDeduction();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-deduction',
				tooltip:'<?php __('<b>Edit Deduction</b><br />Click here to modify the selected Deduction'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentDeduction(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-deduction',
				tooltip:'<?php __('<b>Delete Deduction(s)</b><br />Click here to remove the selected Deduction(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Deduction'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentDeduction(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Deduction'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Deduction'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentDeduction(sel_ids);
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
				text: '<?php __('View Deduction'); ?>',
				id: 'view-deduction2',
				tooltip:'<?php __('<b>View Deduction</b><br />Click here to see details of the selected Deduction'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewDeduction(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_deduction_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentDeductionName(Ext.getCmp('parent_deduction_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_deduction_go_button',
				handler: function(){
					SearchByParentDeductionName(Ext.getCmp('parent_deduction_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_deductions,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-deduction').enable();
	g.getTopToolbar().findById('delete-parent-deduction').enable();
        g.getTopToolbar().findById('view-deduction2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-deduction').disable();
                g.getTopToolbar().findById('view-deduction2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-deduction').disable();
		g.getTopToolbar().findById('delete-parent-deduction').enable();
                g.getTopToolbar().findById('view-deduction2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-deduction').enable();
		g.getTopToolbar().findById('delete-parent-deduction').enable();
                g.getTopToolbar().findById('view-deduction2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-deduction').disable();
		g.getTopToolbar().findById('delete-parent-deduction').disable();
                g.getTopToolbar().findById('view-deduction2').disable();
	}
});



var parentDeductionsViewWindow = new Ext.Window({
	title: 'Deduction Under the selected Item',
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
			parentDeductionsViewWindow.close();
		}
	}]
});

store_parent_deductions.load({
    params: {
        start: 0,    
        limit: list_size
    }
});