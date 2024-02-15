var store_parent_bpPlanDetails = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','bp_item','bp_plan','amount'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanDetails', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentBpPlanDetail() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanDetails', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_bpPlanDetail_data = response.responseText;
			
			eval(parent_bpPlanDetail_data);
			
			BpPlanDetailAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentBpPlanDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanDetails', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_bpPlanDetail_data = response.responseText;
			
			eval(parent_bpPlanDetail_data);
			
			BpPlanDetailEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanDetail edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBpPlanDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanDetails', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var bpPlanDetail_data = response.responseText;

			eval(bpPlanDetail_data);

			BpPlanDetailViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanDetail view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentBpPlanDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanDetails', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BpPlanDetail(s) successfully deleted!'); ?>');
			RefreshParentBpPlanDetailData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanDetail to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentBpPlanDetailName(value){
	var conditions = '\'BpPlanDetail.name LIKE\' => \'%' + value + '%\'';
	store_parent_bpPlanDetails.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentBpPlanDetailData() {
	store_parent_bpPlanDetails.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('BpPlanDetails'); ?>',
	store: store_parent_bpPlanDetails,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'bpPlanDetailGrid',
	columns: [
		{header:"<?php __('bp_item'); ?>", dataIndex: 'bp_item', sortable: true},
		{header:"<?php __('bp_plan'); ?>", dataIndex: 'bp_plan', sortable: true},
		{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewBpPlanDetail(Ext.getCmp('bpPlanDetailGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add BpPlanDetail</b><br />Click here to create a new BpPlanDetail'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentBpPlanDetail();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-bpPlanDetail',
				tooltip:'<?php __('<b>Edit BpPlanDetail</b><br />Click here to modify the selected BpPlanDetail'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentBpPlanDetail(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-bpPlanDetail',
				tooltip:'<?php __('<b>Delete BpPlanDetail(s)</b><br />Click here to remove the selected BpPlanDetail(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove BpPlanDetail'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentBpPlanDetail(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove BpPlanDetail'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected BpPlanDetail'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentBpPlanDetail(sel_ids);
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
				text: '<?php __('View BpPlanDetail'); ?>',
				id: 'view-bpPlanDetail2',
				tooltip:'<?php __('<b>View BpPlanDetail</b><br />Click here to see details of the selected BpPlanDetail'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewBpPlanDetail(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_bpPlanDetail_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentBpPlanDetailName(Ext.getCmp('parent_bpPlanDetail_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_bpPlanDetail_go_button',
				handler: function(){
					SearchByParentBpPlanDetailName(Ext.getCmp('parent_bpPlanDetail_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_bpPlanDetails,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-bpPlanDetail').enable();
	g.getTopToolbar().findById('delete-parent-bpPlanDetail').enable();
        g.getTopToolbar().findById('view-bpPlanDetail2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-bpPlanDetail').disable();
                g.getTopToolbar().findById('view-bpPlanDetail2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-bpPlanDetail').disable();
		g.getTopToolbar().findById('delete-parent-bpPlanDetail').enable();
                g.getTopToolbar().findById('view-bpPlanDetail2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-bpPlanDetail').enable();
		g.getTopToolbar().findById('delete-parent-bpPlanDetail').enable();
                g.getTopToolbar().findById('view-bpPlanDetail2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-bpPlanDetail').disable();
		g.getTopToolbar().findById('delete-parent-bpPlanDetail').disable();
                g.getTopToolbar().findById('view-bpPlanDetail2').disable();
	}
});



var parentBpPlanDetailsViewWindow = new Ext.Window({
	title: 'BpPlanDetail Under the selected Item',
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
			parentBpPlanDetailsViewWindow.close();
		}
	}]
});

store_parent_bpPlanDetails.load({
    params: {
        start: 0,    
        limit: list_size
    }
});