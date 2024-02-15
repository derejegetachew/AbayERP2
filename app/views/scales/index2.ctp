var store_parent_scales = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','grade','step','salary'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentScale() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_scale_data = response.responseText;
			
			eval(parent_scale_data);
			
			ScaleAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the scale add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentScale(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_scale_data = response.responseText;
			
			eval(parent_scale_data);
			
			ScaleEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the scale edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewScale(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var scale_data = response.responseText;

			eval(scale_data);

			ScaleViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the scale view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentScale(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Scale(s) successfully deleted!'); ?>');
			RefreshParentScaleData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the scale to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentScaleName(value){
	var conditions = '\'Scale.name LIKE\' => \'%' + value + '%\'';
	store_parent_scales.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentScaleData() {
	store_parent_scales.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Scales'); ?>',
	store: store_parent_scales,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'scaleGrid',
	columns: [
		{header:"<?php __('grade'); ?>", dataIndex: 'grade', sortable: true},
		{header:"<?php __('step'); ?>", dataIndex: 'step', sortable: true},
		{header: "<?php __('Salary'); ?>", dataIndex: 'salary', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewScale(Ext.getCmp('scaleGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Scale</b><br />Click here to create a new Scale'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentScale();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-scale',
				tooltip:'<?php __('<b>Edit Scale</b><br />Click here to modify the selected Scale'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentScale(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-scale',
				tooltip:'<?php __('<b>Delete Scale(s)</b><br />Click here to remove the selected Scale(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Scale'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentScale(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Scale'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Scale'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentScale(sel_ids);
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
				text: '<?php __('View Scale'); ?>',
				id: 'view-scale2',
				tooltip:'<?php __('<b>View Scale</b><br />Click here to see details of the selected Scale'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewScale(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_scale_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentScaleName(Ext.getCmp('parent_scale_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_scale_go_button',
				handler: function(){
					SearchByParentScaleName(Ext.getCmp('parent_scale_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_scales,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-scale').enable();
	g.getTopToolbar().findById('delete-parent-scale').enable();
        g.getTopToolbar().findById('view-scale2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-scale').disable();
                g.getTopToolbar().findById('view-scale2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-scale').disable();
		g.getTopToolbar().findById('delete-parent-scale').enable();
                g.getTopToolbar().findById('view-scale2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-scale').enable();
		g.getTopToolbar().findById('delete-parent-scale').enable();
                g.getTopToolbar().findById('view-scale2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-scale').disable();
		g.getTopToolbar().findById('delete-parent-scale').disable();
                g.getTopToolbar().findById('view-scale2').disable();
	}
});



var parentScalesViewWindow = new Ext.Window({
	title: 'Scale Under the selected Item',
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
			parentScalesViewWindow.close();
		}
	}]
});

store_parent_scales.load({
    params: {
        start: 0,    
        limit: list_size
    }
});