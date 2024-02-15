var store_parent_imsRents = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','branch','width','monthly_rent','contract_signed_date','contract_age','contract_functional_date','contract_end_date','prepayed_amount','prepayed_end_date','created_by','renter','address','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRents', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentImsRent() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRents', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_imsRent_data = response.responseText;
			
			eval(parent_imsRent_data);
			
			ImsRentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsRent add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentImsRent(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRents', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_imsRent_data = response.responseText;
			
			eval(parent_imsRent_data);
			
			ImsRentEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsRent edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsRent(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRents', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsRent_data = response.responseText;

			eval(imsRent_data);

			ImsRentViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsRent view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentImsRent(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRents', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsRent(s) successfully deleted!'); ?>');
			RefreshParentImsRentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsRent to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsRentName(value){
	var conditions = '\'ImsRent.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsRents.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsRentData() {
	store_parent_imsRents.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('ImsRents'); ?>',
	store: store_parent_imsRents,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsRentGrid',
	columns: [
		{header:"<?php __('branch'); ?>", dataIndex: 'branch', sortable: true},
		{header: "<?php __('Width'); ?>", dataIndex: 'width', sortable: true},
		{header: "<?php __('Monthly Rent'); ?>", dataIndex: 'monthly_rent', sortable: true},
		{header: "<?php __('Contract Signed Date'); ?>", dataIndex: 'contract_signed_date', sortable: true},
		{header: "<?php __('Contract Age'); ?>", dataIndex: 'contract_age', sortable: true},
		{header: "<?php __('Contract Functional Date'); ?>", dataIndex: 'contract_functional_date', sortable: true},
		{header: "<?php __('Contract End Date'); ?>", dataIndex: 'contract_end_date', sortable: true},
		{header: "<?php __('Prepayed Amount'); ?>", dataIndex: 'prepayed_amount', sortable: true},
		{header: "<?php __('Prepayed End Date'); ?>", dataIndex: 'prepayed_end_date', sortable: true},
		{header: "<?php __('Created By'); ?>", dataIndex: 'created_by', sortable: true},
		{header: "<?php __('Renter Name'); ?>", dataIndex: 'renter', sortable: true},
		{header: "<?php __('Renter Address'); ?>", dataIndex: 'address', sortable: true},
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewImsRent(Ext.getCmp('imsRentGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add ImsRent</b><br />Click here to create a new ImsRent'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentImsRent();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-imsRent',
				tooltip:'<?php __('<b>Edit ImsRent</b><br />Click here to modify the selected ImsRent'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentImsRent(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-imsRent',
				tooltip:'<?php __('<b>Delete ImsRent(s)</b><br />Click here to remove the selected ImsRent(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove ImsRent'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentImsRent(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove ImsRent'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected ImsRent'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentImsRent(sel_ids);
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
				text: '<?php __('View ImsRent'); ?>',
				id: 'view-imsRent2',
				tooltip:'<?php __('<b>View ImsRent</b><br />Click here to see details of the selected ImsRent'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewImsRent(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_imsRent_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentImsRentName(Ext.getCmp('parent_imsRent_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_imsRent_go_button',
				handler: function(){
					SearchByParentImsRentName(Ext.getCmp('parent_imsRent_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsRents,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-imsRent').enable();
	g.getTopToolbar().findById('delete-parent-imsRent').enable();
        g.getTopToolbar().findById('view-imsRent2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsRent').disable();
                g.getTopToolbar().findById('view-imsRent2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-imsRent').disable();
		g.getTopToolbar().findById('delete-parent-imsRent').enable();
                g.getTopToolbar().findById('view-imsRent2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-imsRent').enable();
		g.getTopToolbar().findById('delete-parent-imsRent').enable();
                g.getTopToolbar().findById('view-imsRent2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-imsRent').disable();
		g.getTopToolbar().findById('delete-parent-imsRent').disable();
                g.getTopToolbar().findById('view-imsRent2').disable();
	}
});



var parentImsRentsViewWindow = new Ext.Window({
	title: 'ImsRent Under the selected Item',
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
			parentImsRentsViewWindow.close();
		}
	}]
});

store_parent_imsRents.load({
    params: {
        start: 0,    
        limit: list_size
    }
});