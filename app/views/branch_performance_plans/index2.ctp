var store_parent_branchPerformancePlans = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','branch','budget_year','quarter','result','plan_status','result_status','comment'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformancePlans', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentBranchPerformancePlan() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformancePlans', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_branchPerformancePlan_data = response.responseText;
			
			eval(parent_branchPerformancePlan_data);
			
			BranchPerformancePlanAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformancePlan add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentBranchPerformancePlan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformancePlans', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_branchPerformancePlan_data = response.responseText;
			
			eval(parent_branchPerformancePlan_data);
			
			BranchPerformancePlanEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformancePlan edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBranchPerformancePlan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformancePlans', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var branchPerformancePlan_data = response.responseText;

			eval(branchPerformancePlan_data);

			BranchPerformancePlanViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformancePlan view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBranchPerformancePlanBranchPerformanceDetails(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceDetails', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_branchPerformanceDetails_data = response.responseText;

			eval(parent_branchPerformanceDetails_data);

			parentBranchPerformanceDetailsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentBranchPerformancePlan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformancePlans', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BranchPerformancePlan(s) successfully deleted!'); ?>');
			RefreshParentBranchPerformancePlanData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformancePlan to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentBranchPerformancePlanName(value){
	var conditions = '\'BranchPerformancePlan.name LIKE\' => \'%' + value + '%\'';
	store_parent_branchPerformancePlans.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentBranchPerformancePlanData() {
	store_parent_branchPerformancePlans.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('BranchPerformancePlans'); ?>',
	store: store_parent_branchPerformancePlans,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'branchPerformancePlanGrid',
	columns: [
		{header:"<?php __('branch'); ?>", dataIndex: 'branch', sortable: true},
		{header:"<?php __('budget_year'); ?>", dataIndex: 'budget_year', sortable: true},
		{header: "<?php __('Quarter'); ?>", dataIndex: 'quarter', sortable: true},
		{header: "<?php __('Result'); ?>", dataIndex: 'result', sortable: true},
		{header: "<?php __('Plan Status'); ?>", dataIndex: 'plan_status', sortable: true},
		{header: "<?php __('Result Status'); ?>", dataIndex: 'result_status', sortable: true},
		{header: "<?php __('Comment'); ?>", dataIndex: 'comment', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewBranchPerformancePlan(Ext.getCmp('branchPerformancePlanGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add BranchPerformancePlan</b><br />Click here to create a new BranchPerformancePlan'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentBranchPerformancePlan();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-branchPerformancePlan',
				tooltip:'<?php __('<b>Edit BranchPerformancePlan</b><br />Click here to modify the selected BranchPerformancePlan'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentBranchPerformancePlan(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-branchPerformancePlan',
				tooltip:'<?php __('<b>Delete BranchPerformancePlan(s)</b><br />Click here to remove the selected BranchPerformancePlan(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove BranchPerformancePlan'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentBranchPerformancePlan(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove BranchPerformancePlan'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected BranchPerformancePlan'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentBranchPerformancePlan(sel_ids);
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
				text: '<?php __('View BranchPerformancePlan'); ?>',
				id: 'view-branchPerformancePlan2',
				tooltip:'<?php __('<b>View BranchPerformancePlan</b><br />Click here to see details of the selected BranchPerformancePlan'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewBranchPerformancePlan(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Branch Performance Details'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewBranchPerformancePlanBranchPerformanceDetails(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_branchPerformancePlan_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentBranchPerformancePlanName(Ext.getCmp('parent_branchPerformancePlan_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_branchPerformancePlan_go_button',
				handler: function(){
					SearchByParentBranchPerformancePlanName(Ext.getCmp('parent_branchPerformancePlan_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_branchPerformancePlans,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-branchPerformancePlan').enable();
	g.getTopToolbar().findById('delete-parent-branchPerformancePlan').enable();
        g.getTopToolbar().findById('view-branchPerformancePlan2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-branchPerformancePlan').disable();
                g.getTopToolbar().findById('view-branchPerformancePlan2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-branchPerformancePlan').disable();
		g.getTopToolbar().findById('delete-parent-branchPerformancePlan').enable();
                g.getTopToolbar().findById('view-branchPerformancePlan2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-branchPerformancePlan').enable();
		g.getTopToolbar().findById('delete-parent-branchPerformancePlan').enable();
                g.getTopToolbar().findById('view-branchPerformancePlan2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-branchPerformancePlan').disable();
		g.getTopToolbar().findById('delete-parent-branchPerformancePlan').disable();
                g.getTopToolbar().findById('view-branchPerformancePlan2').disable();
	}
});



var parentBranchPerformancePlansViewWindow = new Ext.Window({
	title: 'BranchPerformancePlan Under the selected Item',
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
			parentBranchPerformancePlansViewWindow.close();
		}
	}]
});

store_parent_branchPerformancePlans.load({
    params: {
        start: 0,    
        limit: list_size
    }
});