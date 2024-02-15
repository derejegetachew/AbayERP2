var store_parent_ibdInvisiblePermits = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','DATE_OF_ISSUE','NAME_OF_APPLICANT','PERMIT_NO','PURPOSE_OF_PAYMENT','currency_type','FCY_AMOUNT','TT_REFERENCE','RETENTION_A_OR_B','DIASPORA_NRNT','FROM_THEIR_LCY_ACCOUNT','REMARK'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdInvisiblePermits', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentIbdInvisiblePermit() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdInvisiblePermits', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_ibdInvisiblePermit_data = response.responseText;
			
			eval(parent_ibdInvisiblePermit_data);
			
			IbdInvisiblePermitAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdInvisiblePermit add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentIbdInvisiblePermit(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdInvisiblePermits', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_ibdInvisiblePermit_data = response.responseText;
			
			eval(parent_ibdInvisiblePermit_data);
			
			IbdInvisiblePermitEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdInvisiblePermit edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewIbdInvisiblePermit(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdInvisiblePermits', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var ibdInvisiblePermit_data = response.responseText;

			eval(ibdInvisiblePermit_data);

			IbdInvisiblePermitViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdInvisiblePermit view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentIbdInvisiblePermit(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdInvisiblePermits', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('IbdInvisiblePermit(s) successfully deleted!'); ?>');
			RefreshParentIbdInvisiblePermitData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdInvisiblePermit to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentIbdInvisiblePermitName(value){
	var conditions = '\'IbdInvisiblePermit.name LIKE\' => \'%' + value + '%\'';
	store_parent_ibdInvisiblePermits.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentIbdInvisiblePermitData() {
	store_parent_ibdInvisiblePermits.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('IbdInvisiblePermits'); ?>',
	store: store_parent_ibdInvisiblePermits,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'ibdInvisiblePermitGrid',
	columns: [
		{header: "<?php __('DATE OF ISSUE'); ?>", dataIndex: 'DATE_OF_ISSUE', sortable: true},
		{header: "<?php __('NAME OF APPLICANT'); ?>", dataIndex: 'NAME_OF_APPLICANT', sortable: true},
		{header: "<?php __('PERMIT NO'); ?>", dataIndex: 'PERMIT_NO', sortable: true},
		{header: "<?php __('PURPOSE OF PAYMENT'); ?>", dataIndex: 'PURPOSE_OF_PAYMENT', sortable: true},
		{header:"<?php __('currency_type'); ?>", dataIndex: 'currency_type', sortable: true},
		{header: "<?php __('FCY AMOUNT'); ?>", dataIndex: 'FCY_AMOUNT', sortable: true},
		{header: "<?php __('TT REFERENCE'); ?>", dataIndex: 'TT_REFERENCE', sortable: true},
		{header: "<?php __('RETENTION A OR B'); ?>", dataIndex: 'RETENTION_A_OR_B', sortable: true},
		{header: "<?php __('DIASPORA NRNT'); ?>", dataIndex: 'DIASPORA_NRNT', sortable: true},
		{header: "<?php __('FROM THEIR LCY ACCOUNT'); ?>", dataIndex: 'FROM_THEIR_LCY_ACCOUNT', sortable: true},
		{header: "<?php __('REMARK'); ?>", dataIndex: 'REMARK', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewIbdInvisiblePermit(Ext.getCmp('ibdInvisiblePermitGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add IbdInvisiblePermit</b><br />Click here to create a new IbdInvisiblePermit'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentIbdInvisiblePermit();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-ibdInvisiblePermit',
				tooltip:'<?php __('<b>Edit IbdInvisiblePermit</b><br />Click here to modify the selected IbdInvisiblePermit'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentIbdInvisiblePermit(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-ibdInvisiblePermit',
				tooltip:'<?php __('<b>Delete IbdInvisiblePermit(s)</b><br />Click here to remove the selected IbdInvisiblePermit(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove IbdInvisiblePermit'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentIbdInvisiblePermit(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove IbdInvisiblePermit'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected IbdInvisiblePermit'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentIbdInvisiblePermit(sel_ids);
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
				text: '<?php __('View IbdInvisiblePermit'); ?>',
				id: 'view-ibdInvisiblePermit2',
				tooltip:'<?php __('<b>View IbdInvisiblePermit</b><br />Click here to see details of the selected IbdInvisiblePermit'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewIbdInvisiblePermit(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_ibdInvisiblePermit_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentIbdInvisiblePermitName(Ext.getCmp('parent_ibdInvisiblePermit_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_ibdInvisiblePermit_go_button',
				handler: function(){
					SearchByParentIbdInvisiblePermitName(Ext.getCmp('parent_ibdInvisiblePermit_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_ibdInvisiblePermits,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-ibdInvisiblePermit').enable();
	g.getTopToolbar().findById('delete-parent-ibdInvisiblePermit').enable();
        g.getTopToolbar().findById('view-ibdInvisiblePermit2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-ibdInvisiblePermit').disable();
                g.getTopToolbar().findById('view-ibdInvisiblePermit2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-ibdInvisiblePermit').disable();
		g.getTopToolbar().findById('delete-parent-ibdInvisiblePermit').enable();
                g.getTopToolbar().findById('view-ibdInvisiblePermit2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-ibdInvisiblePermit').enable();
		g.getTopToolbar().findById('delete-parent-ibdInvisiblePermit').enable();
                g.getTopToolbar().findById('view-ibdInvisiblePermit2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-ibdInvisiblePermit').disable();
		g.getTopToolbar().findById('delete-parent-ibdInvisiblePermit').disable();
                g.getTopToolbar().findById('view-ibdInvisiblePermit2').disable();
	}
});



var parentIbdInvisiblePermitsViewWindow = new Ext.Window({
	title: 'IbdInvisiblePermit Under the selected Item',
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
			parentIbdInvisiblePermitsViewWindow.close();
		}
	}]
});

store_parent_ibdInvisiblePermits.load({
    params: {
        start: 0,    
        limit: list_size
    }
});