var store_parent_reports = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','type','rows','SQL','PHP','report_group','output','before_html','after_html','column_group'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentReport() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_report_data = response.responseText;
			
			eval(parent_report_data);
			
			ReportAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the report add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentReport(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_report_data = response.responseText;
			
			eval(parent_report_data);
			
			ReportEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the report edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewReport(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var report_data = response.responseText;

			eval(report_data);

			ReportViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the report view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewReportReportFields(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reportFields', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_reportFields_data = response.responseText;

			eval(parent_reportFields_data);

			parentReportFieldsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewReportPayrolls(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'payrolls', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_payrolls_data = response.responseText;

			eval(parent_payrolls_data);

			parentPayrollsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentReport(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Report(s) successfully deleted!'); ?>');
			RefreshParentReportData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the report to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentReportName(value){
	var conditions = '\'Report.name LIKE\' => \'%' + value + '%\'';
	store_parent_reports.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentReportData() {
	store_parent_reports.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Reports'); ?>',
	store: store_parent_reports,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'reportGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
		{header: "<?php __('Rows'); ?>", dataIndex: 'rows', sortable: true},
		{header: "<?php __('SQL'); ?>", dataIndex: 'SQL', sortable: true},
		{header: "<?php __('PHP'); ?>", dataIndex: 'PHP', sortable: true},
		{header:"<?php __('report_group'); ?>", dataIndex: 'report_group', sortable: true},
		{header: "<?php __('Output'); ?>", dataIndex: 'output', sortable: true},
		{header: "<?php __('Before Html'); ?>", dataIndex: 'before_html', sortable: true},
		{header: "<?php __('After Html'); ?>", dataIndex: 'after_html', sortable: true},
		{header: "<?php __('Column Group'); ?>", dataIndex: 'column_group', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewReport(Ext.getCmp('reportGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Report</b><br />Click here to create a new Report'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentReport();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-report',
				tooltip:'<?php __('<b>Edit Report</b><br />Click here to modify the selected Report'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentReport(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-report',
				tooltip:'<?php __('<b>Delete Report(s)</b><br />Click here to remove the selected Report(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Report'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentReport(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Report'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Report'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentReport(sel_ids);
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
				text: '<?php __('View Report'); ?>',
				id: 'view-report2',
				tooltip:'<?php __('<b>View Report</b><br />Click here to see details of the selected Report'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewReport(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Report Fields'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewReportReportFields(sel.data.id);
							};
						}
					}
, {
						text: '<?php __('View Payrolls'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewReportPayrolls(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_report_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentReportName(Ext.getCmp('parent_report_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_report_go_button',
				handler: function(){
					SearchByParentReportName(Ext.getCmp('parent_report_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_reports,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-report').enable();
	g.getTopToolbar().findById('delete-parent-report').enable();
        g.getTopToolbar().findById('view-report2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-report').disable();
                g.getTopToolbar().findById('view-report2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-report').disable();
		g.getTopToolbar().findById('delete-parent-report').enable();
                g.getTopToolbar().findById('view-report2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-report').enable();
		g.getTopToolbar().findById('delete-parent-report').enable();
                g.getTopToolbar().findById('view-report2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-report').disable();
		g.getTopToolbar().findById('delete-parent-report').disable();
                g.getTopToolbar().findById('view-report2').disable();
	}
});



var parentReportsViewWindow = new Ext.Window({
	title: 'Report Under the selected Item',
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
			parentReportsViewWindow.close();
		}
	}]
});

store_parent_reports.load({
    params: {
        start: 0,    
        limit: list_size
    }
});