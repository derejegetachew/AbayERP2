var store_parent_reportGroups = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','parent_report_group','name','lft','rght'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'reportGroups', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentReportGroup() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reportGroups', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_reportGroup_data = response.responseText;
			
			eval(parent_reportGroup_data);
			
			ReportGroupAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the reportGroup add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentReportGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reportGroups', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_reportGroup_data = response.responseText;
			
			eval(parent_reportGroup_data);
			
			ReportGroupEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the reportGroup edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewReportGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reportGroups', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var reportGroup_data = response.responseText;

			eval(reportGroup_data);

			ReportGroupViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the reportGroup view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewReportGroupReportGroups(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'childReportGroups', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_childReportGroups_data = response.responseText;

			eval(parent_childReportGroups_data);

			parentReportGroupsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewReportGroupReports(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_reports_data = response.responseText;

			eval(parent_reports_data);

			parentReportsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentReportGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reportGroups', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ReportGroup(s) successfully deleted!'); ?>');
			RefreshParentReportGroupData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the reportGroup to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentReportGroupName(value){
	var conditions = '\'ReportGroup.name LIKE\' => \'%' + value + '%\'';
	store_parent_reportGroups.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentReportGroupData() {
	store_parent_reportGroups.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('ReportGroups'); ?>',
	store: store_parent_reportGroups,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'reportGroupGrid',
	columns: [
		{header:"<?php __('parent_report_group'); ?>", dataIndex: 'parent_report_group', sortable: true},
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Lft'); ?>", dataIndex: 'lft', sortable: true},
		{header: "<?php __('Rght'); ?>", dataIndex: 'rght', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewReportGroup(Ext.getCmp('reportGroupGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add ReportGroup</b><br />Click here to create a new ReportGroup'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentReportGroup();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-reportGroup',
				tooltip:'<?php __('<b>Edit ReportGroup</b><br />Click here to modify the selected ReportGroup'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentReportGroup(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-reportGroup',
				tooltip:'<?php __('<b>Delete ReportGroup(s)</b><br />Click here to remove the selected ReportGroup(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove ReportGroup'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentReportGroup(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove ReportGroup'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected ReportGroup'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentReportGroup(sel_ids);
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
				text: '<?php __('View ReportGroup'); ?>',
				id: 'view-reportGroup2',
				tooltip:'<?php __('<b>View ReportGroup</b><br />Click here to see details of the selected ReportGroup'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewReportGroup(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Report Groups'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewReportGroupReportGroups(sel.data.id);
							};
						}
					}
, {
						text: '<?php __('View Reports'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewReportGroupReports(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_reportGroup_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentReportGroupName(Ext.getCmp('parent_reportGroup_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_reportGroup_go_button',
				handler: function(){
					SearchByParentReportGroupName(Ext.getCmp('parent_reportGroup_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_reportGroups,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-reportGroup').enable();
	g.getTopToolbar().findById('delete-parent-reportGroup').enable();
        g.getTopToolbar().findById('view-reportGroup2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-reportGroup').disable();
                g.getTopToolbar().findById('view-reportGroup2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-reportGroup').disable();
		g.getTopToolbar().findById('delete-parent-reportGroup').enable();
                g.getTopToolbar().findById('view-reportGroup2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-reportGroup').enable();
		g.getTopToolbar().findById('delete-parent-reportGroup').enable();
                g.getTopToolbar().findById('view-reportGroup2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-reportGroup').disable();
		g.getTopToolbar().findById('delete-parent-reportGroup').disable();
                g.getTopToolbar().findById('view-reportGroup2').disable();
	}
});



var parentReportGroupsViewWindow = new Ext.Window({
	title: 'ReportGroup Under the selected Item',
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
			parentReportGroupsViewWindow.close();
		}
	}]
});

store_parent_reportGroups.load({
    params: {
        start: 0,    
        limit: list_size
    }
});