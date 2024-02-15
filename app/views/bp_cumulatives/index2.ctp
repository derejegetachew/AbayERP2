var store_parent_bpCumulatives = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','bp_item','bp_month','budget_year','plan','actual','cumilativePlan','cumilativeActual'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'bpCumulatives', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentBpCumulative() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpCumulatives', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_bpCumulative_data = response.responseText;
			
			eval(parent_bpCumulative_data);
			
			BpCumulativeAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpCumulative add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentBpCumulative(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpCumulatives', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_bpCumulative_data = response.responseText;
			
			eval(parent_bpCumulative_data);
			
			BpCumulativeEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpCumulative edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBpCumulative(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpCumulatives', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var bpCumulative_data = response.responseText;

			eval(bpCumulative_data);

			BpCumulativeViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpCumulative view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentBpCumulative(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpCumulatives', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BpCumulative(s) successfully deleted!'); ?>');
			RefreshParentBpCumulativeData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpCumulative to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentBpCumulativeName(value){
	var conditions = '\'BpCumulative.name LIKE\' => \'%' + value + '%\'';
	store_parent_bpCumulatives.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentBpCumulativeData() {
	store_parent_bpCumulatives.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('BpCumulatives'); ?>',
	store: store_parent_bpCumulatives,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'bpCumulativeGrid',
	columns: [
		{header:"<?php __('bp_item'); ?>", dataIndex: 'bp_item', sortable: true},
		{header:"<?php __('bp_month'); ?>", dataIndex: 'bp_month', sortable: true},
		{header:"<?php __('budget_year'); ?>", dataIndex: 'budget_year', sortable: true},
		{header: "<?php __('Plan'); ?>", dataIndex: 'plan', sortable: true},
		{header: "<?php __('Actual'); ?>", dataIndex: 'actual', sortable: true},
		{header: "<?php __('CumilativePlan'); ?>", dataIndex: 'cumilativePlan', sortable: true},
		{header: "<?php __('CumilativeActual'); ?>", dataIndex: 'cumilativeActual', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewBpCumulative(Ext.getCmp('bpCumulativeGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add BpCumulative</b><br />Click here to create a new BpCumulative'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentBpCumulative();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-bpCumulative',
				tooltip:'<?php __('<b>Edit BpCumulative</b><br />Click here to modify the selected BpCumulative'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentBpCumulative(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-bpCumulative',
				tooltip:'<?php __('<b>Delete BpCumulative(s)</b><br />Click here to remove the selected BpCumulative(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove BpCumulative'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentBpCumulative(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove BpCumulative'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected BpCumulative'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentBpCumulative(sel_ids);
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
				text: '<?php __('View BpCumulative'); ?>',
				id: 'view-bpCumulative2',
				tooltip:'<?php __('<b>View BpCumulative</b><br />Click here to see details of the selected BpCumulative'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewBpCumulative(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_bpCumulative_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentBpCumulativeName(Ext.getCmp('parent_bpCumulative_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_bpCumulative_go_button',
				handler: function(){
					SearchByParentBpCumulativeName(Ext.getCmp('parent_bpCumulative_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_bpCumulatives,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-bpCumulative').enable();
	g.getTopToolbar().findById('delete-parent-bpCumulative').enable();
        g.getTopToolbar().findById('view-bpCumulative2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-bpCumulative').disable();
                g.getTopToolbar().findById('view-bpCumulative2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-bpCumulative').disable();
		g.getTopToolbar().findById('delete-parent-bpCumulative').enable();
                g.getTopToolbar().findById('view-bpCumulative2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-bpCumulative').enable();
		g.getTopToolbar().findById('delete-parent-bpCumulative').enable();
                g.getTopToolbar().findById('view-bpCumulative2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-bpCumulative').disable();
		g.getTopToolbar().findById('delete-parent-bpCumulative').disable();
                g.getTopToolbar().findById('view-bpCumulative2').disable();
	}
});



var parentBpCumulativesViewWindow = new Ext.Window({
	title: 'BpCumulative Under the selected Item',
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
			parentBpCumulativesViewWindow.close();
		}
	}]
});

store_parent_bpCumulatives.load({
    params: {
        start: 0,    
        limit: list_size
    }
});