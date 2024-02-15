var store_parent_perrdiemms = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','payroll','days','rate','taxable','date'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'perrdiemms', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentPerrdiemm() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'perrdiemms', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_perrdiemm_data = response.responseText;
			
			eval(parent_perrdiemm_data);
			
			PerrdiemmAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the perrdiemm add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentPerrdiemm(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'perrdiemms', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_perrdiemm_data = response.responseText;
			
			eval(parent_perrdiemm_data);
			
			PerrdiemmEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the perrdiemm edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPerrdiemm(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'perrdiemms', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var perrdiemm_data = response.responseText;

			eval(perrdiemm_data);

			PerrdiemmViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the perrdiemm view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentPerrdiemm(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'perrdiemms', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Perrdiemm(s) successfully deleted!'); ?>');
			RefreshParentPerrdiemmData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the perrdiemm to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentPerrdiemmName(value){
	var conditions = '\'Perrdiemm.name LIKE\' => \'%' + value + '%\'';
	store_parent_perrdiemms.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentPerrdiemmData() {
	store_parent_perrdiemms.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Perdiums'); ?>',
	store: store_parent_perrdiemms,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'perrdiemmGrid',
	columns: [
		{header: "<?php __('Days'); ?>", dataIndex: 'days', sortable: true},
		{header: "<?php __('Rate'); ?>", dataIndex: 'rate', sortable: true},
		{header: "<?php __('Taxable'); ?>", dataIndex: 'taxable', sortable: true},
		{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewPerrdiemm(Ext.getCmp('perrdiemmGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Perrdiemm</b><br />Click here to create a new Perrdiemm'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentPerrdiemm();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-perrdiemm',
				tooltip:'<?php __('<b>Edit Perrdiemm</b><br />Click here to modify the selected Perrdiemm'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentPerrdiemm(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-perrdiemm',
				tooltip:'<?php __('<b>Delete Perrdiemm(s)</b><br />Click here to remove the selected Perrdiemm(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Perrdiemm'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentPerrdiemm(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Perrdiemm'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Perrdiemm'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentPerrdiemm(sel_ids);
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
				text: '<?php __('View Perrdiemm'); ?>',
				id: 'view-perrdiemm2',
				tooltip:'<?php __('<b>View Perrdiemm</b><br />Click here to see details of the selected Perrdiemm'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewPerrdiemm(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_perrdiemm_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentPerrdiemmName(Ext.getCmp('parent_perrdiemm_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_perrdiemm_go_button',
				handler: function(){
					SearchByParentPerrdiemmName(Ext.getCmp('parent_perrdiemm_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_perrdiemms,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-perrdiemm').enable();
	g.getTopToolbar().findById('delete-parent-perrdiemm').enable();
        g.getTopToolbar().findById('view-perrdiemm2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-perrdiemm').disable();
                g.getTopToolbar().findById('view-perrdiemm2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-perrdiemm').disable();
		g.getTopToolbar().findById('delete-parent-perrdiemm').enable();
                g.getTopToolbar().findById('view-perrdiemm2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-perrdiemm').enable();
		g.getTopToolbar().findById('delete-parent-perrdiemm').enable();
                g.getTopToolbar().findById('view-perrdiemm2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-perrdiemm').disable();
		g.getTopToolbar().findById('delete-parent-perrdiemm').disable();
                g.getTopToolbar().findById('view-perrdiemm2').disable();
	}
});



var parentPerrdiemmsViewWindow = new Ext.Window({
	title: 'Perdium Under the selected Item',
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
			parentPerrdiemmsViewWindow.close();
		}
	}]
});

store_parent_perrdiemms.load({
    params: {
        start: 0,    
        limit: list_size
    }
});