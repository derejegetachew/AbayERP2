var store_parent_fmsFuels = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','fms_vehicle','fueled_day','litre','price','kilometer','round','status','created_by','approved_by','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsFuels', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentFmsFuel() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsFuels', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_fmsFuel_data = response.responseText;
			
			eval(parent_fmsFuel_data);
			
			FmsFuelAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsFuel add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentFmsFuel(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsFuels', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_fmsFuel_data = response.responseText;
			
			eval(parent_fmsFuel_data);
			
			FmsFuelEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsFuel edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFmsFuel(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsFuels', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var fmsFuel_data = response.responseText;

			eval(fmsFuel_data);

			FmsFuelViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsFuel view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentFmsFuel(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsFuels', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FmsFuel(s) successfully deleted!'); ?>');
			RefreshParentFmsFuelData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsFuel to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentFmsFuelName(value){
	var conditions = '\'FmsFuel.name LIKE\' => \'%' + value + '%\'';
	store_parent_fmsFuels.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentFmsFuelData() {
	store_parent_fmsFuels.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('FmsFuels'); ?>',
	store: store_parent_fmsFuels,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'fmsFuelGrid',
	columns: [
		{header:"<?php __('fms_vehicle'); ?>", dataIndex: 'fms_vehicle', sortable: true},
		{header: "<?php __('Fueled Day'); ?>", dataIndex: 'fueled_day', sortable: true},
		{header: "<?php __('Litre'); ?>", dataIndex: 'litre', sortable: true},
		{header: "<?php __('Price'); ?>", dataIndex: 'price', sortable: true},
		{header: "<?php __('Kilometer'); ?>", dataIndex: 'kilometer', sortable: true},
		{header: "<?php __('Round'); ?>", dataIndex: 'round', sortable: true},
		{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
		{header: "<?php __('Created By'); ?>", dataIndex: 'created_by', sortable: true},
		{header: "<?php __('Approved By'); ?>", dataIndex: 'approved_by', sortable: true},
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
            ViewFmsFuel(Ext.getCmp('fmsFuelGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add FmsFuel</b><br />Click here to create a new FmsFuel'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentFmsFuel();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-fmsFuel',
				tooltip:'<?php __('<b>Edit FmsFuel</b><br />Click here to modify the selected FmsFuel'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentFmsFuel(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-fmsFuel',
				tooltip:'<?php __('<b>Delete FmsFuel(s)</b><br />Click here to remove the selected FmsFuel(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove FmsFuel'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentFmsFuel(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove FmsFuel'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected FmsFuel'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentFmsFuel(sel_ids);
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
				text: '<?php __('View FmsFuel'); ?>',
				id: 'view-fmsFuel2',
				tooltip:'<?php __('<b>View FmsFuel</b><br />Click here to see details of the selected FmsFuel'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewFmsFuel(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_fmsFuel_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentFmsFuelName(Ext.getCmp('parent_fmsFuel_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_fmsFuel_go_button',
				handler: function(){
					SearchByParentFmsFuelName(Ext.getCmp('parent_fmsFuel_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_fmsFuels,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-fmsFuel').enable();
	g.getTopToolbar().findById('delete-parent-fmsFuel').enable();
        g.getTopToolbar().findById('view-fmsFuel2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-fmsFuel').disable();
                g.getTopToolbar().findById('view-fmsFuel2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-fmsFuel').disable();
		g.getTopToolbar().findById('delete-parent-fmsFuel').enable();
                g.getTopToolbar().findById('view-fmsFuel2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-fmsFuel').enable();
		g.getTopToolbar().findById('delete-parent-fmsFuel').enable();
                g.getTopToolbar().findById('view-fmsFuel2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-fmsFuel').disable();
		g.getTopToolbar().findById('delete-parent-fmsFuel').disable();
                g.getTopToolbar().findById('view-fmsFuel2').disable();
	}
});



var parentFmsFuelsViewWindow = new Ext.Window({
	title: 'FmsFuel Under the selected Item',
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
			parentFmsFuelsViewWindow.close();
		}
	}]
});

store_parent_fmsFuels.load({
    params: {
        start: 0,    
        limit: list_size
    }
});