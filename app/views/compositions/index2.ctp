var store_parent_compositions = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','position','branch','vacant','additional','count','hired','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'compositions', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentComposition() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'compositions', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_composition_data = response.responseText;
			
			eval(parent_composition_data);
			
			CompositionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the composition add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentComposition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'compositions', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_composition_data = response.responseText;
			
			eval(parent_composition_data);
			
			CompositionEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the composition edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewComposition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'compositions', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var composition_data = response.responseText;

			eval(composition_data);

			CompositionViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the composition view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentComposition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'compositions', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('position setup successfully deleted!'); ?>');
			RefreshParentCompositionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the plan to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentCompositionName(value){
	var conditions = '\'Composition.name LIKE\' => \'%' + value + '%\'';
	store_parent_compositions.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentCompositionData() {
	store_parent_compositions.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Permanent Positions'); ?>',
	store: store_parent_compositions,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'compositionGrid',
	columns: [
		{header:"<?php __('Job Title'); ?>", dataIndex: 'position', sortable: true},
		{header:"<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
		{header: "<?php __('Approved Position(s)'); ?>", dataIndex: 'count', sortable: true},
		{header: "<?php __('Hired'); ?>", dataIndex: 'hired', sortable: true},
    {header: "<?php __('Vacant'); ?>", dataIndex: 'vacant', sortable: true},
    {header: "<?php __('Additional'); ?>", dataIndex: 'additional', sortable: true},
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
            ViewComposition(Ext.getCmp('compositionGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Composition</b><br />Click here to create a new Composition'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentComposition();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-composition',
				tooltip:'<?php __('<b>Edit Composition</b><br />Click here to modify the selected Composition'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentComposition(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-composition',
				tooltip:'<?php __('<b>Delete Composition(s)</b><br />Click here to remove the selected job plan(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove setup'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> setup?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentComposition(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove setup'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected setup'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentComposition(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			},  ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_composition_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentCompositionName(Ext.getCmp('parent_composition_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_composition_go_button',
				handler: function(){
					SearchByParentCompositionName(Ext.getCmp('parent_composition_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_compositions,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-composition').enable();
	g.getTopToolbar().findById('delete-parent-composition').enable();
        g.getTopToolbar().findById('view-composition2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-composition').disable();
                g.getTopToolbar().findById('view-composition2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-composition').disable();
		g.getTopToolbar().findById('delete-parent-composition').enable();
                g.getTopToolbar().findById('view-composition2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-composition').enable();
		g.getTopToolbar().findById('delete-parent-composition').enable();
                g.getTopToolbar().findById('view-composition2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-composition').disable();
		g.getTopToolbar().findById('delete-parent-composition').disable();
                g.getTopToolbar().findById('view-composition2').disable();
	}
});



var parentCompositionsViewWindow = new Ext.Window({
	title: '',
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
			RefreshCompositionData();
			parentCompositionsViewWindow.close();
		}
	}]
});

store_parent_compositions.load({
    params: {
        start: 0,    
        limit: list_size
    }
});