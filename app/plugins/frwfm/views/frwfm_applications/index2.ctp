var store_parent_frwfmApplications = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','branch','user','status','order','date','location','mobile_phone','email','amount','currency','expiry_date','license','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentFrwfmApplication() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_frwfmApplication_data = response.responseText;
			
			eval(parent_frwfmApplication_data);
			
			FrwfmApplicationAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentFrwfmApplication(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_frwfmApplication_data = response.responseText;
			
			eval(parent_frwfmApplication_data);
			
			FrwfmApplicationEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFrwfmApplication(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var frwfmApplication_data = response.responseText;

			eval(frwfmApplication_data);

			FrwfmApplicationViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFrwfmApplicationFrwfmDocuments(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmDocuments', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_frwfmDocuments_data = response.responseText;

			eval(parent_frwfmDocuments_data);

			parentFrwfmDocumentsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFrwfmApplicationFrwfmEvents(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmEvents', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_frwfmEvents_data = response.responseText;

			eval(parent_frwfmEvents_data);

			parentFrwfmEventsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentFrwfmApplication(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FrwfmApplication(s) successfully deleted!'); ?>');
			RefreshParentFrwfmApplicationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentFrwfmApplicationName(value){
	var conditions = '\'FrwfmApplication.name LIKE\' => \'%' + value + '%\'';
	store_parent_frwfmApplications.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentFrwfmApplicationData() {
	store_parent_frwfmApplications.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('FrwfmApplications'); ?>',
	store: store_parent_frwfmApplications,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'frwfmApplicationGrid',
	columns: [
		{header:"<?php __('branch'); ?>", dataIndex: 'branch', sortable: true},
		{header:"<?php __('user'); ?>", dataIndex: 'user', sortable: true},
		{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
		{header: "<?php __('Order'); ?>", dataIndex: 'order', sortable: true},
		{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true},
		{header:"<?php __('location'); ?>", dataIndex: 'location', sortable: true},
		{header: "<?php __('Mobile Phone'); ?>", dataIndex: 'mobile_phone', sortable: true},
		{header: "<?php __('Email'); ?>", dataIndex: 'email', sortable: true},
		{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true},
		{header: "<?php __('Currency'); ?>", dataIndex: 'currency', sortable: true},
		{header: "<?php __('Expiry Date'); ?>", dataIndex: 'expiry_date', sortable: true},
		{header: "<?php __('License'); ?>", dataIndex: 'license', sortable: true},
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
            ViewFrwfmApplication(Ext.getCmp('frwfmApplicationGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add FrwfmApplication</b><br />Click here to create a new FrwfmApplication'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentFrwfmApplication();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-frwfmApplication',
				tooltip:'<?php __('<b>Edit FrwfmApplication</b><br />Click here to modify the selected FrwfmApplication'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentFrwfmApplication(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-frwfmApplication',
				tooltip:'<?php __('<b>Delete FrwfmApplication(s)</b><br />Click here to remove the selected FrwfmApplication(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove FrwfmApplication'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentFrwfmApplication(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove FrwfmApplication'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected FrwfmApplication'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentFrwfmApplication(sel_ids);
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
				text: '<?php __('View FrwfmApplication'); ?>',
				id: 'view-frwfmApplication2',
				tooltip:'<?php __('<b>View FrwfmApplication</b><br />Click here to see details of the selected FrwfmApplication'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewFrwfmApplication(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Frwfm Documents'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewFrwfmApplicationFrwfmDocuments(sel.data.id);
							};
						}
					}
, {
						text: '<?php __('View Frwfm Events'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewFrwfmApplicationFrwfmEvents(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_frwfmApplication_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentFrwfmApplicationName(Ext.getCmp('parent_frwfmApplication_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_frwfmApplication_go_button',
				handler: function(){
					SearchByParentFrwfmApplicationName(Ext.getCmp('parent_frwfmApplication_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_frwfmApplications,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-frwfmApplication').enable();
	g.getTopToolbar().findById('delete-parent-frwfmApplication').enable();
        g.getTopToolbar().findById('view-frwfmApplication2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-frwfmApplication').disable();
                g.getTopToolbar().findById('view-frwfmApplication2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-frwfmApplication').disable();
		g.getTopToolbar().findById('delete-parent-frwfmApplication').enable();
                g.getTopToolbar().findById('view-frwfmApplication2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-frwfmApplication').enable();
		g.getTopToolbar().findById('delete-parent-frwfmApplication').enable();
                g.getTopToolbar().findById('view-frwfmApplication2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-frwfmApplication').disable();
		g.getTopToolbar().findById('delete-parent-frwfmApplication').disable();
                g.getTopToolbar().findById('view-frwfmApplication2').disable();
	}
});



var parentFrwfmApplicationsViewWindow = new Ext.Window({
	title: 'FrwfmApplication Under the selected Item',
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
			parentFrwfmApplicationsViewWindow.close();
		}
	}]
});

store_parent_frwfmApplications.load({
    params: {
        start: 0,    
        limit: list_size
    }
});