var store_parent_ormsLossDatas = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','branch','orms_risk_category','created_by','approved_by','occured_from','occured_to','discovered_date','event','description','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsLossDatas', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentOrmsLossData() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsLossDatas', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_ormsLossData_data = response.responseText;
			
			eval(parent_ormsLossData_data);
			
			OrmsLossDataAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ormsLossData add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentOrmsLossData(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsLossDatas', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_ormsLossData_data = response.responseText;
			
			eval(parent_ormsLossData_data);
			
			OrmsLossDataEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ormsLossData edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewOrmsLossData(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsLossDatas', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var ormsLossData_data = response.responseText;

			eval(ormsLossData_data);

			OrmsLossDataViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ormsLossData view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentOrmsLossData(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsLossDatas', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('OrmsLossData(s) successfully deleted!'); ?>');
			RefreshParentOrmsLossDataData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ormsLossData to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentOrmsLossDataName(value){
	var conditions = '\'OrmsLossData.name LIKE\' => \'%' + value + '%\'';
	store_parent_ormsLossDatas.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentOrmsLossDataData() {
	store_parent_ormsLossDatas.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('OrmsLossDatas'); ?>',
	store: store_parent_ormsLossDatas,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'ormsLossDataGrid',
	columns: [
		{header:"<?php __('branch'); ?>", dataIndex: 'branch', sortable: true},
		{header:"<?php __('orms_risk_category'); ?>", dataIndex: 'orms_risk_category', sortable: true},
		{header: "<?php __('Created By'); ?>", dataIndex: 'created_by', sortable: true},
		{header: "<?php __('Approved By'); ?>", dataIndex: 'approved_by', sortable: true},
		{header: "<?php __('Occured From'); ?>", dataIndex: 'occured_from', sortable: true},
		{header: "<?php __('Occured To'); ?>", dataIndex: 'occured_to', sortable: true},
		{header: "<?php __('Discovered Date'); ?>", dataIndex: 'discovered_date', sortable: true},
		{header: "<?php __('Event'); ?>", dataIndex: 'event', sortable: true},
		{header: "<?php __('Description'); ?>", dataIndex: 'description', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
		{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewOrmsLossData(Ext.getCmp('ormsLossDataGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add OrmsLossData</b><br />Click here to create a new OrmsLossData'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentOrmsLossData();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-ormsLossData',
				tooltip:'<?php __('<b>Edit OrmsLossData</b><br />Click here to modify the selected OrmsLossData'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentOrmsLossData(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-ormsLossData',
				tooltip:'<?php __('<b>Delete OrmsLossData(s)</b><br />Click here to remove the selected OrmsLossData(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove OrmsLossData'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentOrmsLossData(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove OrmsLossData'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected OrmsLossData'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentOrmsLossData(sel_ids);
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
				text: '<?php __('View OrmsLossData'); ?>',
				id: 'view-ormsLossData2',
				tooltip:'<?php __('<b>View OrmsLossData</b><br />Click here to see details of the selected OrmsLossData'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewOrmsLossData(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_ormsLossData_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentOrmsLossDataName(Ext.getCmp('parent_ormsLossData_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_ormsLossData_go_button',
				handler: function(){
					SearchByParentOrmsLossDataName(Ext.getCmp('parent_ormsLossData_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_ormsLossDatas,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-ormsLossData').enable();
	g.getTopToolbar().findById('delete-parent-ormsLossData').enable();
        g.getTopToolbar().findById('view-ormsLossData2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-ormsLossData').disable();
                g.getTopToolbar().findById('view-ormsLossData2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-ormsLossData').disable();
		g.getTopToolbar().findById('delete-parent-ormsLossData').enable();
                g.getTopToolbar().findById('view-ormsLossData2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-ormsLossData').enable();
		g.getTopToolbar().findById('delete-parent-ormsLossData').enable();
                g.getTopToolbar().findById('view-ormsLossData2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-ormsLossData').disable();
		g.getTopToolbar().findById('delete-parent-ormsLossData').disable();
                g.getTopToolbar().findById('view-ormsLossData2').disable();
	}
});



var parentOrmsLossDatasViewWindow = new Ext.Window({
	title: 'OrmsLossData Under the selected Item',
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
			parentOrmsLossDatasViewWindow.close();
		}
	}]
});

store_parent_ormsLossDatas.load({
    params: {
        start: 0,    
        limit: list_size
    }
});