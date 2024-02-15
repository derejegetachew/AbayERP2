var store_parent_spPlans = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','branch','sp_item','budget_years','user','march_end','june_end','july','august','september','october','november','december','january','february','march','april','may','june'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlans', 'action' => 'list_data1', $parent_id)); ?>'	})
});


function AddParentSpPlan() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlans', 'action' => 'add2', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_spPlan_data = response.responseText;
			
			eval(parent_spPlan_data);
			
			SpPlanAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spPlan add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentSpPlan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlanHds', 'action' => 'edit1')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_spPlan_data = response.responseText;
			
			eval(parent_spPlan_data);
			
			SpPlanEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spPlan edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewSpPlan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlans', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var spPlan_data = response.responseText;

			eval(spPlan_data);

			SpPlanViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spPlan view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentSpPlan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlans', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('SpPlan(s) successfully deleted!'); ?>');
			RefreshParentSpPlanData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spPlan to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentSpPlanName(value){
	var conditions = '\'SpPlan.name LIKE\' => \'%' + value + '%\'';
	store_parent_spPlans.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentSpPlanData() {
	store_parent_spPlans.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Plans'); ?>',
	store: store_parent_spPlans,
	loadMask: true,
	resizable:true,
	stripeRows: true,
	height: 500,
	anchor: '100%',
    id: 'spPlanGrid',
	columns: [
		//{header:"<?php __('branch'); ?>", dataIndex: 'branch', sortable: true},
		{header:"<?php __('Particulars'); ?>", dataIndex: 'sp_item', sortable: true,width:100},
		//{header:"<?php __('budget_years'); ?>", dataIndex: 'budget_years', sortable: true},
		//{header:"<?php __('user'); ?>", dataIndex: 'user', sortable: true},
		{header: "<?php __('March End'); ?>", dataIndex: 'march_end', sortable: true},
		{header: "<?php __('June End'); ?>", dataIndex: 'june_end', sortable: true},
		{header: "<?php __('July'); ?>", dataIndex: 'july', sortable: true},
		{header: "<?php __('August'); ?>", dataIndex: 'august', sortable: true},
		{header: "<?php __('September'); ?>", dataIndex: 'september', sortable: true},
		{header: "<?php __('October'); ?>", dataIndex: 'october', sortable: true},
		{header: "<?php __('November'); ?>", dataIndex: 'november', sortable: true},
		{header: "<?php __('December'); ?>", dataIndex: 'december', sortable: true},
		{header: "<?php __('January'); ?>", dataIndex: 'january', sortable: true},
		{header: "<?php __('February'); ?>", dataIndex: 'february', sortable: true},
		{header: "<?php __('March'); ?>", dataIndex: 'march', sortable: true},
		{header: "<?php __('April'); ?>", dataIndex: 'april', sortable: true},
		{header: "<?php __('May'); ?>", dataIndex: 'may', sortable: true},
		{header: "<?php __('June'); ?>", dataIndex: 'june', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewSpPlan(Ext.getCmp('spPlanGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add SpPlan</b><br />Click here to create a new SpPlan'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				hidden:false,
				handler: function(btn) {
					AddParentSpPlan();
				}
			}, {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-spPlan',
				tooltip:'<?php __('<b>Edit SpPlan</b><br />Click here to modify the selected SpPlan'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentSpPlan(sel.data.id);
					};
				}
			}, {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-spPlan',
				tooltip:'<?php __('<b>Delete SpPlan(s)</b><br />Click here to remove the selected SpPlan(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				hidden:true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove SpPlan'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentSpPlan(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove SpPlan'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected SpPlan'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentSpPlan(sel_ids);
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
				text: '<?php __('View Plan'); ?>',
				id: 'view-spPlan2',
				tooltip:'<?php __('<b>View SpPlan</b><br />Click here to see details of the selected SpPlan'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewSpPlan(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_spPlan_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentSpPlanName(Ext.getCmp('parent_spPlan_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_spPlan_go_button',
				handler: function(){
					SearchByParentSpPlanName(Ext.getCmp('parent_spPlan_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_spPlans,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-spPlan').enable();
	g.getTopToolbar().findById('delete-parent-spPlan').enable();
        g.getTopToolbar().findById('view-spPlan2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-spPlan').disable();
                g.getTopToolbar().findById('view-spPlan2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-spPlan').disable();
		g.getTopToolbar().findById('delete-parent-spPlan').enable();
                g.getTopToolbar().findById('view-spPlan2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-spPlan').enable();
		g.getTopToolbar().findById('delete-parent-spPlan').enable();
                g.getTopToolbar().findById('view-spPlan2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-spPlan').disable();
		g.getTopToolbar().findById('delete-parent-spPlan').disable();
                g.getTopToolbar().findById('view-spPlan2').disable();
	}
});



var parentSpPlansViewWindow = new Ext.Window({
	title: 'SpPlan Under the selected Item',
	width: 1200,
	height:600,
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
			parentSpPlansViewWindow.close();
		}
	}]
});

store_parent_spPlans.load({
    params: {
        start: 0,    
        limit: list_size
    }
});