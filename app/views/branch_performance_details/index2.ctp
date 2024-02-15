var store_parent_branchPerformanceDetails = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','branch_evaluation_criteria','plan_in_number','actual_result','accomplishment','rating','final_result'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceDetails', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentBranchPerformanceDetail() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceDetails', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_branchPerformanceDetail_data = response.responseText;
			
			eval(parent_branchPerformanceDetail_data);
			
			BranchPerformanceDetailAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentBranchPerformanceDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceDetails', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_branchPerformanceDetail_data = response.responseText;
			
			eval(parent_branchPerformanceDetail_data);
			
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


function DeleteParentBranchPerformanceDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceDetails', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BranchPerformanceDetail(s) successfully deleted!'); ?>');
			RefreshParentBranchPerformanceDetailData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceDetail to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentBranchPerformanceDetailName(value){
	var conditions = '\'BranchPerformanceDetail.name LIKE\' => \'%' + value + '%\'';
	store_parent_branchPerformanceDetails.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentBranchPerformanceDetailData() {
	store_parent_branchPerformanceDetails.reload();
}

var myMask = new Ext.LoadMask(Ext.getBody(), {msg: "Processing please wait..."});

function RecalculateRefresh(id) {
	myMask.show();
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceDetails', 'action' => 'recalculate')); ?>/'+id,
		success: function(response, opts) {
			var brPerformanceDetail_data = response.responseText;
			
		   // eval(brPerformanceDetail_data);
			
		   myMask.hide();
		   store_parent_branchPerformanceDetails.reload();
		},
		failure: function(response, opts) {
			myMask.hide();
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the brPerformanceDetail edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function showMenu(grid, index, event) {
        event.stopEvent();
        var record = grid.getStore().getAt(index);
        var btnStatus = 0; //(record.get('rejectable') == 'True')? false: true;
        var menu = new Ext.menu.Menu({
            items: [
                {
                    text: '<b>Recalculate / Refresh </b>',
                    icon: 'img/table_add.png',
                    handler: function() {
                       RecalculateRefresh(record.get('id'));
					   
                    }
                }
            ]
        }).showAt(event.xy);
    }

function copy_previous_details_branch() {
	var id = <?php echo $parent_id; ?> ;
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceDetails', 'action' => 'copy_previous_details_branch')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_branchPerformanceDetail_data = response.responseText;
			
			eval(parent_branchPerformanceDetail_data);
			
			BrCopyPreviousDetailsWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceDetail edit form. Error code'); ?>: ' + response.status);
		}
	});
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('BranchPerformanceDetails'); ?>',
	store: store_parent_branchPerformanceDetails,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'branchPerformanceDetailGrid',
	columns: [
		{header:"<?php __('branch_evaluation_criteria'); ?>", dataIndex: 'branch_evaluation_criteria', sortable: true},
		{header: "<?php __('Plan In Number'); ?>", dataIndex: 'plan_in_number', sortable: true},
		{header: "<?php __('Actual Result'); ?>", dataIndex: 'actual_result', sortable: true},
		{header: "<?php __('Accomplishment'); ?>", dataIndex: 'accomplishment', sortable: true},
		{header: "<?php __('Rating'); ?>", dataIndex: 'rating', sortable: true},
		{header: "<?php __('Final Result'); ?>", dataIndex: 'final_result', sortable: true},
			],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewBranchPerformanceDetail(Ext.getCmp('branchPerformanceDetailGrid').getSelectionModel().getSelected().data.id);
        },
		'rowcontextmenu': function(grid, index, event) {
                    showMenu(grid, index, event);
                        //grid.selectedNode = grid.store.getAt(row); // we need this
                        //if((index) !== false) {
                        this.getSelectionModel().selectRow(index);
                        //}
                }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add BranchPerformanceDetail</b><br />Click here to create a new BranchPerformanceDetail'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentBranchPerformanceDetail();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-branchPerformanceDetail',
				tooltip:'<?php __('<b>Edit BranchPerformanceDetail</b><br />Click here to modify the selected BranchPerformanceDetail'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentBranchPerformanceDetail(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-branchPerformanceDetail',
				tooltip:'<?php __('<b>Delete BranchPerformanceDetail(s)</b><br />Click here to remove the selected BranchPerformanceDetail(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove BranchPerformanceDetail'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentBranchPerformanceDetail(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove BranchPerformanceDetail'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected BranchPerformanceDetail'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentBranchPerformanceDetail(sel_ids);
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
				text: '<?php __('View BranchPerformanceDetail'); ?>',
				id: 'view-branchPerformanceDetail2',
				tooltip:'<?php __('<b>View BranchPerformanceDetail</b><br />Click here to see details of the selected BranchPerformanceDetail'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewBranchPerformanceDetail(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            },  ' ','-',' ', {
				xtype: 'tbsplit',
				text: '<?php __('Copy previous (by branch)'); ?>',
				id: 'copy-previous-details-person',
				tooltip:'<?php __('<b>Copy previous by person</b><br />Click here to see details of the selected BrPerformanceDetail'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				
				handler: function(btn) {
					
					copy_previous_details_branch();

				},
				menu : {
					items: [
					]
				}

            },  ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_branchPerformanceDetails,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-branchPerformanceDetail').enable();
	g.getTopToolbar().findById('delete-parent-branchPerformanceDetail').enable();
        g.getTopToolbar().findById('view-branchPerformanceDetail2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-branchPerformanceDetail').disable();
                g.getTopToolbar().findById('view-branchPerformanceDetail2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-branchPerformanceDetail').disable();
		g.getTopToolbar().findById('delete-parent-branchPerformanceDetail').enable();
                g.getTopToolbar().findById('view-branchPerformanceDetail2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-branchPerformanceDetail').enable();
		g.getTopToolbar().findById('delete-parent-branchPerformanceDetail').enable();
                g.getTopToolbar().findById('view-branchPerformanceDetail2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-branchPerformanceDetail').disable();
		g.getTopToolbar().findById('delete-parent-branchPerformanceDetail').disable();
                g.getTopToolbar().findById('view-branchPerformanceDetail2').disable();
	}
});



var parentBranchPerformanceDetailsViewWindow = new Ext.Window({
	title: 'BranchPerformanceDetail Under the selected Item',
	width: 700,
	height:375,
	minWidth: 700,
	minHeight: 400,
	resizable: false,
	autoScroll: true,
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
			parentBranchPerformanceDetailsViewWindow.close();
		}
	}]
});

store_parent_branchPerformanceDetails.load({
    params: {
        start: 0,    
        limit: list_size
    }
});