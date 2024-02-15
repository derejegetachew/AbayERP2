var store_parent_hoPerformancePlans = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','budget_year','employee','quarter','status','comment'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformancePlans', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentHoPerformancePlan() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformancePlans', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_hoPerformancePlan_data = response.responseText;
			
			eval(parent_hoPerformancePlan_data);
			
			HoPerformancePlanAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformancePlan add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentHoPerformancePlan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformancePlans', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_hoPerformancePlan_data = response.responseText;
			
			eval(parent_hoPerformancePlan_data);
			
			HoPerformancePlanEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformancePlan edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewHoPerformancePlan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformancePlans', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var hoPerformancePlan_data = response.responseText;

			eval(hoPerformancePlan_data);

			HoPerformancePlanViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformancePlan view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewHoPerformancePlanHoPerformanceDetails(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformanceDetails', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_hoPerformanceDetails_data = response.responseText;

			eval(parent_hoPerformanceDetails_data);

			parentHoPerformanceDetailsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentHoPerformancePlan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformancePlans', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('HoPerformancePlan(s) successfully deleted!'); ?>');
			RefreshParentHoPerformancePlanData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformancePlan to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentHoPerformancePlanName(value){
	var conditions = '\'HoPerformancePlan.name LIKE\' => \'%' + value + '%\'';
	store_parent_hoPerformancePlans.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentHoPerformancePlanData() {
	store_parent_hoPerformancePlans.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('HoPerformancePlans'); ?>',
	store: store_parent_hoPerformancePlans,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'hoPerformancePlanGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header:"<?php __('budget_year'); ?>", dataIndex: 'budget_year', sortable: true},
		{header:"<?php __('employee'); ?>", dataIndex: 'employee', sortable: true},
		{header: "<?php __('Quarter'); ?>", dataIndex: 'quarter', sortable: true},
		{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
		{header: "<?php __('Comment'); ?>", dataIndex: 'comment', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewHoPerformancePlan(Ext.getCmp('hoPerformancePlanGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add HoPerformancePlan</b><br />Click here to create a new HoPerformancePlan'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentHoPerformancePlan();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-hoPerformancePlan',
				tooltip:'<?php __('<b>Edit HoPerformancePlan</b><br />Click here to modify the selected HoPerformancePlan'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentHoPerformancePlan(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-hoPerformancePlan',
				tooltip:'<?php __('<b>Delete HoPerformancePlan(s)</b><br />Click here to remove the selected HoPerformancePlan(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove HoPerformancePlan'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentHoPerformancePlan(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove HoPerformancePlan'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected HoPerformancePlan'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentHoPerformancePlan(sel_ids);
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
				text: '<?php __('View HoPerformancePlan'); ?>',
				id: 'view-hoPerformancePlan2',
				tooltip:'<?php __('<b>View HoPerformancePlan</b><br />Click here to see details of the selected HoPerformancePlan'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewHoPerformancePlan(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Ho Performance Details'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewHoPerformancePlanHoPerformanceDetails(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_hoPerformancePlan_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentHoPerformancePlanName(Ext.getCmp('parent_hoPerformancePlan_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_hoPerformancePlan_go_button',
				handler: function(){
					SearchByParentHoPerformancePlanName(Ext.getCmp('parent_hoPerformancePlan_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_hoPerformancePlans,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-hoPerformancePlan').enable();
	g.getTopToolbar().findById('delete-parent-hoPerformancePlan').enable();
        g.getTopToolbar().findById('view-hoPerformancePlan2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-hoPerformancePlan').disable();
                g.getTopToolbar().findById('view-hoPerformancePlan2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-hoPerformancePlan').disable();
		g.getTopToolbar().findById('delete-parent-hoPerformancePlan').enable();
                g.getTopToolbar().findById('view-hoPerformancePlan2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-hoPerformancePlan').enable();
		g.getTopToolbar().findById('delete-parent-hoPerformancePlan').enable();
                g.getTopToolbar().findById('view-hoPerformancePlan2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-hoPerformancePlan').disable();
		g.getTopToolbar().findById('delete-parent-hoPerformancePlan').disable();
                g.getTopToolbar().findById('view-hoPerformancePlan2').disable();
	}
});



var parentHoPerformancePlansViewWindow = new Ext.Window({
	title: 'HoPerformancePlan Under the selected Item',
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
			parentHoPerformancePlansViewWindow.close();
		}
	}]
});

store_parent_hoPerformancePlans.load({
    params: {
        start: 0,    
        limit: list_size
    }
});