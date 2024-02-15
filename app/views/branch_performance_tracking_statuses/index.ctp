
var store_branchPerformanceTrackingStatuses = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','budget_year','quarter','result_status'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackingStatuses', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'employee_id', direction: "ASC"},
	groupField: 'budget_year_id'
});


function AddBranchPerformanceTrackingStatus() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackingStatuses', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var branchPerformanceTrackingStatus_data = response.responseText;
			
			eval(branchPerformanceTrackingStatus_data);
			
			BranchPerformanceTrackingStatusAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceTrackingStatus add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditBranchPerformanceTrackingStatus(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackingStatuses', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var branchPerformanceTrackingStatus_data = response.responseText;
			
			eval(branchPerformanceTrackingStatus_data);
			
			BranchPerformanceTrackingStatusEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceTrackingStatus edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBranchPerformanceTrackingStatus(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackingStatuses', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var branchPerformanceTrackingStatus_data = response.responseText;

            eval(branchPerformanceTrackingStatus_data);

            BranchPerformanceTrackingStatusViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceTrackingStatus view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteBranchPerformanceTrackingStatus(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackingStatuses', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BranchPerformanceTrackingStatus successfully deleted!'); ?>');
			RefreshBranchPerformanceTrackingStatusData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceTrackingStatus add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchBranchPerformanceTrackingStatus(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackingStatuses', 'action' => 'search')); ?>',
		success: function(response, opts){
			var branchPerformanceTrackingStatus_data = response.responseText;

			eval(branchPerformanceTrackingStatus_data);

			branchPerformanceTrackingStatusSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the branchPerformanceTrackingStatus search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByBranchPerformanceTrackingStatusName(value){
	var conditions = '\'BranchPerformanceTrackingStatus.name LIKE\' => \'%' + value + '%\'';
	store_branchPerformanceTrackingStatuses.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshBranchPerformanceTrackingStatusData() {
	store_branchPerformanceTrackingStatuses.reload();
}


if(center_panel.find('id', 'branchPerformanceTrackingStatus-tab') != "") {
	var p = center_panel.findById('branchPerformanceTrackingStatus-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Branch Performance Tracking Statuses'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'branchPerformanceTrackingStatus-tab',
		xtype: 'grid',
		store: store_branchPerformanceTrackingStatuses,
		columns: [
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('BudgetYear'); ?>", dataIndex: 'budget_year', sortable: true},
			{header: "<?php __('Quarter'); ?>", dataIndex: 'quarter', sortable: true},
			{header: "<?php __('Result Status'); ?>", dataIndex: 'result_status', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "BranchPerformanceTrackingStatuses" : "BranchPerformanceTrackingStatus"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewBranchPerformanceTrackingStatus(Ext.getCmp('branchPerformanceTrackingStatus-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add BranchPerformanceTrackingStatuses</b><br />Click here to create a new BranchPerformanceTrackingStatus'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddBranchPerformanceTrackingStatus();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-branchPerformanceTrackingStatus',
					tooltip:'<?php __('<b>Edit BranchPerformanceTrackingStatuses</b><br />Click here to modify the selected BranchPerformanceTrackingStatus'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditBranchPerformanceTrackingStatus(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-branchPerformanceTrackingStatus',
					tooltip:'<?php __('<b>Delete BranchPerformanceTrackingStatuses(s)</b><br />Click here to remove the selected BranchPerformanceTrackingStatus(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove BranchPerformanceTrackingStatus'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteBranchPerformanceTrackingStatus(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove BranchPerformanceTrackingStatus'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected BranchPerformanceTrackingStatuses'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteBranchPerformanceTrackingStatus(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View BranchPerformanceTrackingStatus'); ?>',
					id: 'view-branchPerformanceTrackingStatus',
					tooltip:'<?php __('<b>View BranchPerformanceTrackingStatus</b><br />Click here to see details of the selected BranchPerformanceTrackingStatus'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewBranchPerformanceTrackingStatus(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Employee'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($employees as $item){if($st) echo ",
							";?>['<?php echo $item['Employee']['id']; ?>' ,'<?php echo $item['Employee']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_branchPerformanceTrackingStatuses.reload({
								params: {
									start: 0,
									limit: list_size,
									employee_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'branchPerformanceTrackingStatus_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByBranchPerformanceTrackingStatusName(Ext.getCmp('branchPerformanceTrackingStatus_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'branchPerformanceTrackingStatus_go_button',
					handler: function(){
						SearchByBranchPerformanceTrackingStatusName(Ext.getCmp('branchPerformanceTrackingStatus_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchBranchPerformanceTrackingStatus();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_branchPerformanceTrackingStatuses,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-branchPerformanceTrackingStatus').enable();
		p.getTopToolbar().findById('delete-branchPerformanceTrackingStatus').enable();
		p.getTopToolbar().findById('view-branchPerformanceTrackingStatus').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-branchPerformanceTrackingStatus').disable();
			p.getTopToolbar().findById('view-branchPerformanceTrackingStatus').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-branchPerformanceTrackingStatus').disable();
			p.getTopToolbar().findById('view-branchPerformanceTrackingStatus').disable();
			p.getTopToolbar().findById('delete-branchPerformanceTrackingStatus').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-branchPerformanceTrackingStatus').enable();
			p.getTopToolbar().findById('view-branchPerformanceTrackingStatus').enable();
			p.getTopToolbar().findById('delete-branchPerformanceTrackingStatus').enable();
		}
		else{
			p.getTopToolbar().findById('edit-branchPerformanceTrackingStatus').disable();
			p.getTopToolbar().findById('view-branchPerformanceTrackingStatus').disable();
			p.getTopToolbar().findById('delete-branchPerformanceTrackingStatus').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_branchPerformanceTrackingStatuses.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
