var store_parent_spPlanHds = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','branch','budget_year','user','approved','rollback_comment'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlanHds', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentSpPlanHd() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlanHds', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_spPlanHd_data = response.responseText;
			
			eval(parent_spPlanHd_data);
			
			SpPlanHdAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spPlanHd add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentSpPlanHd(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlanHds', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_spPlanHd_data = response.responseText;
			
			eval(parent_spPlanHd_data);
			
			SpPlanHdEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spPlanHd edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewSpPlanHd(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlanHds', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var spPlanHd_data = response.responseText;

			eval(spPlanHd_data);

			SpPlanHdViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spPlanHd view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewSpPlanHdSpPlans(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlans', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_spPlans_data = response.responseText;

			eval(parent_spPlans_data);

			parentSpPlansViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentSpPlanHd(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlanHds', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('SpPlanHd(s) successfully deleted!'); ?>');
			RefreshParentSpPlanHdData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spPlanHd to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentSpPlanHdName(value){
	var conditions = '\'SpPlanHd.name LIKE\' => \'%' + value + '%\'';
	store_parent_spPlanHds.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentSpPlanHdData() {
	store_parent_spPlanHds.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('SpPlanHds'); ?>',
	store: store_parent_spPlanHds,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'spPlanHdGrid',
	columns: [
		{header:"<?php __('branch'); ?>", dataIndex: 'branch', sortable: true},
		{header:"<?php __('budget_year'); ?>", dataIndex: 'budget_year', sortable: true},
		{header:"<?php __('user'); ?>", dataIndex: 'user', sortable: true},
		{header: "<?php __('Approved'); ?>", dataIndex: 'approved', sortable: true},
		{header: "<?php __('Rollback Comment'); ?>", dataIndex: 'rollback_comment', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewSpPlanHd(Ext.getCmp('spPlanHdGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add SpPlanHd</b><br />Click here to create a new SpPlanHd'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentSpPlanHd();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-spPlanHd',
				tooltip:'<?php __('<b>Edit SpPlanHd</b><br />Click here to modify the selected SpPlanHd'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentSpPlanHd(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-spPlanHd',
				tooltip:'<?php __('<b>Delete SpPlanHd(s)</b><br />Click here to remove the selected SpPlanHd(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove SpPlanHd'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentSpPlanHd(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove SpPlanHd'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected SpPlanHd'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentSpPlanHd(sel_ids);
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
				text: '<?php __('View SpPlanHd'); ?>',
				id: 'view-spPlanHd2',
				tooltip:'<?php __('<b>View SpPlanHd</b><br />Click here to see details of the selected SpPlanHd'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewSpPlanHd(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Sp Plans'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewSpPlanHdSpPlans(sel.data.id);
							};
						}
					}
					]
				}

            }, '->',{
					xtype: 'tbbutton',
					text: '<?php __('Budget Year: ');__($by); ?>'
				} '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_spPlanHds,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-spPlanHd').enable();
	g.getTopToolbar().findById('delete-parent-spPlanHd').enable();
        g.getTopToolbar().findById('view-spPlanHd2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-spPlanHd').disable();
                g.getTopToolbar().findById('view-spPlanHd2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-spPlanHd').disable();
		g.getTopToolbar().findById('delete-parent-spPlanHd').enable();
                g.getTopToolbar().findById('view-spPlanHd2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-spPlanHd').enable();
		g.getTopToolbar().findById('delete-parent-spPlanHd').enable();
                g.getTopToolbar().findById('view-spPlanHd2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-spPlanHd').disable();
		g.getTopToolbar().findById('delete-parent-spPlanHd').disable();
                g.getTopToolbar().findById('view-spPlanHd2').disable();
	}
});



var parentSpPlanHdsViewWindow = new Ext.Window({
	title: 'SpPlanHd Under the selected Item',
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
			parentSpPlanHdsViewWindow.close();
		}
	}]
});

store_parent_spPlanHds.load({
    params: {
        start: 0,    
        limit: list_size
    }
});