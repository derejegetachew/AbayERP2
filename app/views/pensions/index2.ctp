var store_parent_pensions = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','pf_staff','pf_company','pen_staff','pen_company','payroll'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'pensions', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentPension() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'pensions', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_pension_data = response.responseText;
			
			eval(parent_pension_data);
			
			PensionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the pension add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentPension(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'pensions', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_pension_data = response.responseText;
			
			eval(parent_pension_data);
			
			PensionEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the pension edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPension(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'pensions', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var pension_data = response.responseText;

			eval(pension_data);

			PensionViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the pension view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentPension(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'pensions', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Pension(s) successfully deleted!'); ?>');
			RefreshParentPensionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the pension to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentPensionName(value){
	var conditions = '\'Pension.name LIKE\' => \'%' + value + '%\'';
	store_parent_pensions.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentPensionData() {
	store_parent_pensions.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Pensions'); ?>',
	store: store_parent_pensions,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'pensionGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Pf Staff'); ?>", dataIndex: 'pf_staff', sortable: true},
		{header: "<?php __('Pf Company'); ?>", dataIndex: 'pf_company', sortable: true},
		{header: "<?php __('Pen Staff'); ?>", dataIndex: 'pen_staff', sortable: true},
		{header: "<?php __('Pen Company'); ?>", dataIndex: 'pen_company', sortable: true},
		{header:"<?php __('payroll'); ?>", dataIndex: 'payroll', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewPension(Ext.getCmp('pensionGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Pension</b><br />Click here to create a new Pension'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentPension();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-pension',
				tooltip:'<?php __('<b>Edit Pension</b><br />Click here to modify the selected Pension'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentPension(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-pension',
				tooltip:'<?php __('<b>Delete Pension(s)</b><br />Click here to remove the selected Pension(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Pension'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentPension(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Pension'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Pension'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentPension(sel_ids);
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
				text: '<?php __('View Pension'); ?>',
				id: 'view-pension2',
				tooltip:'<?php __('<b>View Pension</b><br />Click here to see details of the selected Pension'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewPension(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_pension_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentPensionName(Ext.getCmp('parent_pension_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_pension_go_button',
				handler: function(){
					SearchByParentPensionName(Ext.getCmp('parent_pension_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_pensions,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-pension').enable();
	g.getTopToolbar().findById('delete-parent-pension').enable();
        g.getTopToolbar().findById('view-pension2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-pension').disable();
                g.getTopToolbar().findById('view-pension2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-pension').disable();
		g.getTopToolbar().findById('delete-parent-pension').enable();
                g.getTopToolbar().findById('view-pension2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-pension').enable();
		g.getTopToolbar().findById('delete-parent-pension').enable();
                g.getTopToolbar().findById('view-pension2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-pension').disable();
		g.getTopToolbar().findById('delete-parent-pension').disable();
                g.getTopToolbar().findById('view-pension2').disable();
	}
});



var parentPensionsViewWindow = new Ext.Window({
	title: 'Pension Under the selected Item',
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
			parentPensionsViewWindow.close();
		}
	}]
});

store_parent_pensions.load({
    params: {
        start: 0,    
        limit: list_size
    }
});