var store_parent_performanceExcelReports = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','budget_year','card_number','first_name','middle_name','last_name','sex','date_of_employment','status','last_position','branch','branch_district','budget_year','q1','q2','q1q290','behavioural1','semi_annual_one','q3','q4','q3q490','behavioural2','semi_annual_two','annual','q1_training1','q1_training2','q1_training3','q2_training1','q2_training2','q2_training3','q3_training1','q3_training2','q3_training3','q4_training1','q4_training2','q4_training3','q1_technical_plan_status','q1_technical_result_status','q1_technical_comment','q2_technical_plan_status','q2_technical_result_status','q2_technical_comment','q2_behavioural_result_status','q2_behavioural_comment','q3_technical_plan_status','q3_technical_result_status','q3_technical_comment','q4_technical_plan_status','q4_technical_result_status','q4_technical_comment','q4_behavioural_result_status','q4_behavioural_comment','report_status','report_time'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceExcelReports', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentPerformanceExcelReport() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceExcelReports', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_performanceExcelReport_data = response.responseText;
			
			eval(parent_performanceExcelReport_data);
			
			PerformanceExcelReportAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceExcelReport add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentPerformanceExcelReport(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceExcelReports', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_performanceExcelReport_data = response.responseText;
			
			eval(parent_performanceExcelReport_data);
			
			PerformanceExcelReportEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceExcelReport edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPerformanceExcelReport(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceExcelReports', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var performanceExcelReport_data = response.responseText;

			eval(performanceExcelReport_data);

			PerformanceExcelReportViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceExcelReport view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentPerformanceExcelReport(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceExcelReports', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('PerformanceExcelReport(s) successfully deleted!'); ?>');
			RefreshParentPerformanceExcelReportData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceExcelReport to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentPerformanceExcelReportName(value){
	var conditions = '\'PerformanceExcelReport.name LIKE\' => \'%' + value + '%\'';
	store_parent_performanceExcelReports.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentPerformanceExcelReportData() {
	store_parent_performanceExcelReports.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('PerformanceExcelReports'); ?>',
	store: store_parent_performanceExcelReports,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'performanceExcelReportGrid',
	columns: [
		{header:"<?php __('employee'); ?>", dataIndex: 'employee', sortable: true},
		{header:"<?php __('budget_year'); ?>", dataIndex: 'budget_year', sortable: true},
		{header: "<?php __('Card Number'); ?>", dataIndex: 'card_number', sortable: true},
		{header: "<?php __('First Name'); ?>", dataIndex: 'first_name', sortable: true},
		{header: "<?php __('Middle Name'); ?>", dataIndex: 'middle_name', sortable: true},
		{header: "<?php __('Last Name'); ?>", dataIndex: 'last_name', sortable: true},
		{header: "<?php __('Sex'); ?>", dataIndex: 'sex', sortable: true},
		{header: "<?php __('Date Of Employment'); ?>", dataIndex: 'date_of_employment', sortable: true},
		{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
		{header: "<?php __('Last Position'); ?>", dataIndex: 'last_position', sortable: true},
		{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
		{header: "<?php __('Branch District'); ?>", dataIndex: 'branch_district', sortable: true},
		{header: "<?php __('Budget Year'); ?>", dataIndex: 'budget_year', sortable: true},
		{header: "<?php __('Q1'); ?>", dataIndex: 'q1', sortable: true},
		{header: "<?php __('Q2'); ?>", dataIndex: 'q2', sortable: true},
		{header: "<?php __('Q1q290'); ?>", dataIndex: 'q1q290', sortable: true},
		{header: "<?php __('Behavioural1'); ?>", dataIndex: 'behavioural1', sortable: true},
		{header: "<?php __('Semi Annual One'); ?>", dataIndex: 'semi_annual_one', sortable: true},
		{header: "<?php __('Q3'); ?>", dataIndex: 'q3', sortable: true},
		{header: "<?php __('Q4'); ?>", dataIndex: 'q4', sortable: true},
		{header: "<?php __('Q3q490'); ?>", dataIndex: 'q3q490', sortable: true},
		{header: "<?php __('Behavioural2'); ?>", dataIndex: 'behavioural2', sortable: true},
		{header: "<?php __('Semi Annual Two'); ?>", dataIndex: 'semi_annual_two', sortable: true},
		{header: "<?php __('Annual'); ?>", dataIndex: 'annual', sortable: true},
		{header: "<?php __('Q1 Training1'); ?>", dataIndex: 'q1_training1', sortable: true},
		{header: "<?php __('Q1 Training2'); ?>", dataIndex: 'q1_training2', sortable: true},
		{header: "<?php __('Q1 Training3'); ?>", dataIndex: 'q1_training3', sortable: true},
		{header: "<?php __('Q2 Training1'); ?>", dataIndex: 'q2_training1', sortable: true},
		{header: "<?php __('Q2 Training2'); ?>", dataIndex: 'q2_training2', sortable: true},
		{header: "<?php __('Q2 Training3'); ?>", dataIndex: 'q2_training3', sortable: true},
		{header: "<?php __('Q3 Training1'); ?>", dataIndex: 'q3_training1', sortable: true},
		{header: "<?php __('Q3 Training2'); ?>", dataIndex: 'q3_training2', sortable: true},
		{header: "<?php __('Q3 Training3'); ?>", dataIndex: 'q3_training3', sortable: true},
		{header: "<?php __('Q4 Training1'); ?>", dataIndex: 'q4_training1', sortable: true},
		{header: "<?php __('Q4 Training2'); ?>", dataIndex: 'q4_training2', sortable: true},
		{header: "<?php __('Q4 Training3'); ?>", dataIndex: 'q4_training3', sortable: true},
		{header: "<?php __('Q1 Technical Plan Status'); ?>", dataIndex: 'q1_technical_plan_status', sortable: true},
		{header: "<?php __('Q1 Technical Result Status'); ?>", dataIndex: 'q1_technical_result_status', sortable: true},
		{header: "<?php __('Q1 Technical Comment'); ?>", dataIndex: 'q1_technical_comment', sortable: true},
		{header: "<?php __('Q2 Technical Plan Status'); ?>", dataIndex: 'q2_technical_plan_status', sortable: true},
		{header: "<?php __('Q2 Technical Result Status'); ?>", dataIndex: 'q2_technical_result_status', sortable: true},
		{header: "<?php __('Q2 Technical Comment'); ?>", dataIndex: 'q2_technical_comment', sortable: true},
		{header: "<?php __('Q2 Behavioural Result Status'); ?>", dataIndex: 'q2_behavioural_result_status', sortable: true},
		{header: "<?php __('Q2 Behavioural Comment'); ?>", dataIndex: 'q2_behavioural_comment', sortable: true},
		{header: "<?php __('Q3 Technical Plan Status'); ?>", dataIndex: 'q3_technical_plan_status', sortable: true},
		{header: "<?php __('Q3 Technical Result Status'); ?>", dataIndex: 'q3_technical_result_status', sortable: true},
		{header: "<?php __('Q3 Technical Comment'); ?>", dataIndex: 'q3_technical_comment', sortable: true},
		{header: "<?php __('Q4 Technical Plan Status'); ?>", dataIndex: 'q4_technical_plan_status', sortable: true},
		{header: "<?php __('Q4 Technical Result Status'); ?>", dataIndex: 'q4_technical_result_status', sortable: true},
		{header: "<?php __('Q4 Technical Comment'); ?>", dataIndex: 'q4_technical_comment', sortable: true},
		{header: "<?php __('Q4 Behavioural Result Status'); ?>", dataIndex: 'q4_behavioural_result_status', sortable: true},
		{header: "<?php __('Q4 Behavioural Comment'); ?>", dataIndex: 'q4_behavioural_comment', sortable: true},
		{header: "<?php __('Report Status'); ?>", dataIndex: 'report_status', sortable: true},
		{header: "<?php __('Report Time'); ?>", dataIndex: 'report_time', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewPerformanceExcelReport(Ext.getCmp('performanceExcelReportGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add PerformanceExcelReport</b><br />Click here to create a new PerformanceExcelReport'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentPerformanceExcelReport();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-performanceExcelReport',
				tooltip:'<?php __('<b>Edit PerformanceExcelReport</b><br />Click here to modify the selected PerformanceExcelReport'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentPerformanceExcelReport(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-performanceExcelReport',
				tooltip:'<?php __('<b>Delete PerformanceExcelReport(s)</b><br />Click here to remove the selected PerformanceExcelReport(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove PerformanceExcelReport'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentPerformanceExcelReport(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove PerformanceExcelReport'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected PerformanceExcelReport'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentPerformanceExcelReport(sel_ids);
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
				text: '<?php __('View PerformanceExcelReport'); ?>',
				id: 'view-performanceExcelReport2',
				tooltip:'<?php __('<b>View PerformanceExcelReport</b><br />Click here to see details of the selected PerformanceExcelReport'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewPerformanceExcelReport(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_performanceExcelReport_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentPerformanceExcelReportName(Ext.getCmp('parent_performanceExcelReport_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_performanceExcelReport_go_button',
				handler: function(){
					SearchByParentPerformanceExcelReportName(Ext.getCmp('parent_performanceExcelReport_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_performanceExcelReports,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-performanceExcelReport').enable();
	g.getTopToolbar().findById('delete-parent-performanceExcelReport').enable();
        g.getTopToolbar().findById('view-performanceExcelReport2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-performanceExcelReport').disable();
                g.getTopToolbar().findById('view-performanceExcelReport2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-performanceExcelReport').disable();
		g.getTopToolbar().findById('delete-parent-performanceExcelReport').enable();
                g.getTopToolbar().findById('view-performanceExcelReport2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-performanceExcelReport').enable();
		g.getTopToolbar().findById('delete-parent-performanceExcelReport').enable();
                g.getTopToolbar().findById('view-performanceExcelReport2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-performanceExcelReport').disable();
		g.getTopToolbar().findById('delete-parent-performanceExcelReport').disable();
                g.getTopToolbar().findById('view-performanceExcelReport2').disable();
	}
});



var parentPerformanceExcelReportsViewWindow = new Ext.Window({
	title: 'PerformanceExcelReport Under the selected Item',
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
			parentPerformanceExcelReportsViewWindow.close();
		}
	}]
});

store_parent_performanceExcelReports.load({
    params: {
        start: 0,    
        limit: list_size
    }
});