var store_parent_positions = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','grade'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'positions', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentPosition() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'positions', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_position_data = response.responseText;
			
			eval(parent_position_data);
			
			PositionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the position add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentPosition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'positions', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_position_data = response.responseText;
			
			eval(parent_position_data);
			
			PositionEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the position edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPosition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'positions', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var position_data = response.responseText;

			eval(position_data);

			PositionViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the position view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentPosition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'positions', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Position(s) successfully deleted!'); ?>');
			RefreshParentPositionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the position to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentPositionName(value){
	var conditions = '\'Position.name LIKE\' => \'%' + value + '%\'';
	store_parent_positions.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentPositionData() {
	store_parent_positions.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Positions'); ?>',
	store: store_parent_positions,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'positionGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header:"<?php __('grade'); ?>", dataIndex: 'grade', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewPosition(Ext.getCmp('positionGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Position</b><br />Click here to create a new Position'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentPosition();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-position',
				tooltip:'<?php __('<b>Edit Position</b><br />Click here to modify the selected Position'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentPosition(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-position',
				tooltip:'<?php __('<b>Delete Position(s)</b><br />Click here to remove the selected Position(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Position'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentPosition(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Position'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Position'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentPosition(sel_ids);
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
				text: '<?php __('View Position'); ?>',
				id: 'view-position2',
				tooltip:'<?php __('<b>View Position</b><br />Click here to see details of the selected Position'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewPosition(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_position_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentPositionName(Ext.getCmp('parent_position_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_position_go_button',
				handler: function(){
					SearchByParentPositionName(Ext.getCmp('parent_position_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_positions,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-position').enable();
	g.getTopToolbar().findById('delete-parent-position').enable();
        g.getTopToolbar().findById('view-position2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-position').disable();
                g.getTopToolbar().findById('view-position2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-position').disable();
		g.getTopToolbar().findById('delete-parent-position').enable();
                g.getTopToolbar().findById('view-position2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-position').enable();
		g.getTopToolbar().findById('delete-parent-position').enable();
                g.getTopToolbar().findById('view-position2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-position').disable();
		g.getTopToolbar().findById('delete-parent-position').disable();
                g.getTopToolbar().findById('view-position2').disable();
	}
});



var parentPositionsViewWindow = new Ext.Window({
	title: 'Position Under the selected Item',
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
			parentPositionsViewWindow.close();
		}
	}]
});

store_parent_positions.load({
    params: {
        start: 0,    
        limit: list_size
    }
});