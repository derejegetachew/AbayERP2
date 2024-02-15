
var store_branchPerformanceDetails = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','branch_evaluation_criteria','plan_in_number','actual_result','accomplishment','rating','final_result','branch_performance_plan'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceDetails', 'action' => 'list_data')); ?>'
	})

});


function AddBranchPerformanceDetail() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceDetails', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var branchPerformanceDetail_data = response.responseText;
			
			eval(branchPerformanceDetail_data);
			
			BranchPerformanceDetailAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditBranchPerformanceDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceDetails', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var branchPerformanceDetail_data = response.responseText;
			
			eval(branchPerformanceDetail_data);
			
			BranchPerformanceDetailEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceDetail edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBranchPerformanceDetail(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceDetails', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var branchPerformanceDetail_data = response.responseText;

            eval(branchPerformanceDetail_data);

            BranchPerformanceDetailViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceDetail view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteBranchPerformanceDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceDetails', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BranchPerformanceDetail successfully deleted!'); ?>');
			RefreshBranchPerformanceDetailData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchBranchPerformanceDetail(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceDetails', 'action' => 'search')); ?>',
		success: function(response, opts){
			var branchPerformanceDetail_data = response.responseText;

			eval(branchPerformanceDetail_data);

			branchPerformanceDetailSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the branchPerformanceDetail search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByBranchPerformanceDetailName(value){
	var conditions = '\'BranchPerformanceDetail.name LIKE\' => \'%' + value + '%\'';
	store_branchPerformanceDetails.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshBranchPerformanceDetailData() {
	store_branchPerformanceDetails.reload();
}


if(center_panel.find('id', 'branchPerformanceDetail-tab') != "") {
	var p = center_panel.findById('branchPerformanceDetail-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Branch Performance Details'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'branchPerformanceDetail-tab',
		xtype: 'grid',
		store: store_branchPerformanceDetails,
		columns: [
			{header: "<?php __('BranchEvaluationCriteria'); ?>", dataIndex: 'branch_evaluation_criteria', sortable: true},
			{header: "<?php __('Plan In Number'); ?>", dataIndex: 'plan_in_number', sortable: true},
			{header: "<?php __('Actual Result'); ?>", dataIndex: 'actual_result', sortable: true},
			{header: "<?php __('Accomplishment'); ?>", dataIndex: 'accomplishment', sortable: true},
			{header: "<?php __('Rating'); ?>", dataIndex: 'rating', sortable: true},
			{header: "<?php __('Final Result'); ?>", dataIndex: 'final_result', sortable: true},
			{header: "<?php __('BranchPerformancePlan'); ?>", dataIndex: 'branch_performance_plan', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "BranchPerformanceDetails" : "BranchPerformanceDetail"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewBranchPerformanceDetail(Ext.getCmp('branchPerformanceDetail-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add BranchPerformanceDetails</b><br />Click here to create a new BranchPerformanceDetail'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddBranchPerformanceDetail();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-branchPerformanceDetail',
					tooltip:'<?php __('<b>Edit BranchPerformanceDetails</b><br />Click here to modify the selected BranchPerformanceDetail'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditBranchPerformanceDetail(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-branchPerformanceDetail',
					tooltip:'<?php __('<b>Delete BranchPerformanceDetails(s)</b><br />Click here to remove the selected BranchPerformanceDetail(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove BranchPerformanceDetail'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteBranchPerformanceDetail(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove BranchPerformanceDetail'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected BranchPerformanceDetails'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteBranchPerformanceDetail(sel_ids);
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
					text: '<?php __('View BranchPerformanceDetail'); ?>',
					id: 'view-branchPerformanceDetail',
					tooltip:'<?php __('<b>View BranchPerformanceDetail</b><br />Click here to see details of the selected BranchPerformanceDetail'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewBranchPerformanceDetail(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchBranchPerformanceDetail();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_branchPerformanceDetails,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-branchPerformanceDetail').enable();
		p.getTopToolbar().findById('delete-branchPerformanceDetail').enable();
		p.getTopToolbar().findById('view-branchPerformanceDetail').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-branchPerformanceDetail').disable();
			p.getTopToolbar().findById('view-branchPerformanceDetail').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-branchPerformanceDetail').disable();
			p.getTopToolbar().findById('view-branchPerformanceDetail').disable();
			p.getTopToolbar().findById('delete-branchPerformanceDetail').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-branchPerformanceDetail').enable();
			p.getTopToolbar().findById('view-branchPerformanceDetail').enable();
			p.getTopToolbar().findById('delete-branchPerformanceDetail').enable();
		}
		else{
			p.getTopToolbar().findById('edit-branchPerformanceDetail').disable();
			p.getTopToolbar().findById('view-branchPerformanceDetail').disable();
			p.getTopToolbar().findById('delete-branchPerformanceDetail').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_branchPerformanceDetails.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
