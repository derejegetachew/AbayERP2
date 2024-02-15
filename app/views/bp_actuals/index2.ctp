var store_parent_bpActuals = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','amount','month','branch','bp_item','remark','type','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentBpActual() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_bpActual_data = response.responseText;
			
			eval(parent_bpActual_data);
			
			BpActualAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActual add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentBpActual(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_bpActual_data = response.responseText;
			
			eval(parent_bpActual_data);
			
			BpActualEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActual edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBpActual(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var bpActual_data = response.responseText;

			eval(bpActual_data);

			BpActualViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActual view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentBpActual(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BpActual(s) successfully deleted!'); ?>');
			RefreshParentBpActualData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActual to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentBpActualName(value){
	var conditions = '\'BpActual.name LIKE\' => \'%' + value + '%\'';
	store_parent_bpActuals.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentBpActualData() {
	store_parent_bpActuals.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('BpActuals'); ?>',
	store: store_parent_bpActuals,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'bpActualGrid',
	columns: [
		{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true,renderer: function(value, metaData, record){
                      
                           return Ext.util.Format.number(value, '0,0.00');
                      
                }},
		{header: "<?php __('Month'); ?>", dataIndex: 'month', sortable: true},
		{header:"<?php __('branch'); ?>", dataIndex: 'branch', sortable: true},
		{header:"<?php __('bp_item'); ?>", dataIndex: 'bp_item', sortable: true},
		{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true},
		{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
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
            ViewBpActual(Ext.getCmp('bpActualGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add BpActual</b><br />Click here to create a new BpActual'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentBpActual();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-bpActual',
				tooltip:'<?php __('<b>Edit BpActual</b><br />Click here to modify the selected BpActual'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentBpActual(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-bpActual',
				tooltip:'<?php __('<b>Delete BpActual(s)</b><br />Click here to remove the selected BpActual(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove BpActual'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentBpActual(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove BpActual'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected BpActual'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentBpActual(sel_ids);
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
				text: '<?php __('View BpActual'); ?>',
				id: 'view-bpActual2',
				tooltip:'<?php __('<b>View BpActual</b><br />Click here to see details of the selected BpActual'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewBpActual(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_bpActual_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentBpActualName(Ext.getCmp('parent_bpActual_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_bpActual_go_button',
				handler: function(){
					SearchByParentBpActualName(Ext.getCmp('parent_bpActual_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_bpActuals,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-bpActual').enable();
	g.getTopToolbar().findById('delete-parent-bpActual').enable();
        g.getTopToolbar().findById('view-bpActual2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-bpActual').disable();
                g.getTopToolbar().findById('view-bpActual2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-bpActual').disable();
		g.getTopToolbar().findById('delete-parent-bpActual').enable();
                g.getTopToolbar().findById('view-bpActual2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-bpActual').enable();
		g.getTopToolbar().findById('delete-parent-bpActual').enable();
                g.getTopToolbar().findById('view-bpActual2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-bpActual').disable();
		g.getTopToolbar().findById('delete-parent-bpActual').disable();
                g.getTopToolbar().findById('view-bpActual2').disable();
	}
});



var parentBpActualsViewWindow = new Ext.Window({
	title: 'BpActual Under the selected Item',
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
			parentBpActualsViewWindow.close();
		}
	}]
});

store_parent_bpActuals.load({
    params: {
        start: 0,    
        limit: list_size
    }
});