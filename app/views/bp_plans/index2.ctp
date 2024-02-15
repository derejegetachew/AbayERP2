var store_parent_bpPlans = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','branch','month','amount','bp_item','budget_year','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlans', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentBpPlan() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlans', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_bpPlan_data = response.responseText;
			
			eval(parent_bpPlan_data);
			
			BpPlanAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlan add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentBpPlan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlans', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_bpPlan_data = response.responseText;
			
			eval(parent_bpPlan_data);
			
			BpPlanEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlan edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBpPlan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlans', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var bpPlan_data = response.responseText;

			eval(bpPlan_data);

			BpPlanViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlan view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentBpPlan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlans', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BpPlan(s) successfully deleted!'); ?>');
			RefreshParentBpPlanData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlan to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentBpPlanName(value){
	var conditions = '\'BpPlan.name LIKE\' => \'%' + value + '%\'';
	store_parent_bpPlans.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentBpPlanData() {
	store_parent_bpPlans.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('BpPlans'); ?>',
	store: store_parent_bpPlans,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'bpPlanGrid',
	columns: [
		{header:"<?php __('branch'); ?>", dataIndex: 'branch', sortable: true},
		{header: "<?php __('Month'); ?>", dataIndex: 'month', sortable: true},
		{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true,renderer: function(value, metaData, record){
                      
                           return Ext.util.Format.number(value, '0,0.00');
                      
                }},
		{header:"<?php __('bp_item'); ?>", dataIndex: 'bp_item', sortable: true},
		{header:"<?php __('budget_year'); ?>", dataIndex: 'budget_year', sortable: true},
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
            ViewBpPlan(Ext.getCmp('bpPlanGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add BpPlan</b><br />Click here to create a new BpPlan'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentBpPlan();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-bpPlan',
				tooltip:'<?php __('<b>Edit BpPlan</b><br />Click here to modify the selected BpPlan'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentBpPlan(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-bpPlan',
				tooltip:'<?php __('<b>Delete BpPlan(s)</b><br />Click here to remove the selected BpPlan(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove BpPlan'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentBpPlan(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove BpPlan'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected BpPlan'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentBpPlan(sel_ids);
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
				text: '<?php __('View BpPlan'); ?>',
				id: 'view-bpPlan2',
				tooltip:'<?php __('<b>View BpPlan</b><br />Click here to see details of the selected BpPlan'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewBpPlan(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_bpPlan_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentBpPlanName(Ext.getCmp('parent_bpPlan_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_bpPlan_go_button',
				handler: function(){
					SearchByParentBpPlanName(Ext.getCmp('parent_bpPlan_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_bpPlans,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-bpPlan').enable();
	g.getTopToolbar().findById('delete-parent-bpPlan').enable();
        g.getTopToolbar().findById('view-bpPlan2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-bpPlan').disable();
                g.getTopToolbar().findById('view-bpPlan2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-bpPlan').disable();
		g.getTopToolbar().findById('delete-parent-bpPlan').enable();
                g.getTopToolbar().findById('view-bpPlan2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-bpPlan').enable();
		g.getTopToolbar().findById('delete-parent-bpPlan').enable();
                g.getTopToolbar().findById('view-bpPlan2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-bpPlan').disable();
		g.getTopToolbar().findById('delete-parent-bpPlan').disable();
                g.getTopToolbar().findById('view-bpPlan2').disable();
	}
});



var parentBpPlansViewWindow = new Ext.Window({
	title: 'BpPlan Under the selected Item',
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
			parentBpPlansViewWindow.close();
		}
	}]
});

store_parent_bpPlans.load({
    params: {
        start: 0,    
        limit: list_size
    }
});