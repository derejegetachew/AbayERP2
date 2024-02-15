
var store_confirmations = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','user','confirmation_code','status'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'confirmations', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'user', direction: "ASC"}
});


function AddConfirmation() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'confirmations', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var confirmation_data = response.responseText;
			
			eval(confirmation_data);
			
			ConfirmationAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the confirmation add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditConfirmation(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'confirmations', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var confirmation_data = response.responseText;
			
			eval(confirmation_data);
			
			ConfirmationEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the confirmation edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewConfirmation(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'confirmations', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var confirmation_data = response.responseText;

            eval(confirmation_data);

            ConfirmationViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the confirmation view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteConfirmation(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'confirmations', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Confirmation successfully deleted!'); ?>');
			RefreshConfirmationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the confirmation add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchConfirmation(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'confirmations', 'action' => 'search')); ?>',
		success: function(response, opts){
			var confirmation_data = response.responseText;

			eval(confirmation_data);

			confirmationSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the confirmation search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByConfirmationName(value){
	var conditions = '\'Confirmation.name LIKE\' => \'%' + value + '%\'';
	store_confirmations.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshConfirmationData() {
	store_confirmations.reload();
}


if(center_panel.find('id', 'confirmation-tab') != "") {
	var p = center_panel.findById('confirmation-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Confirmations'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'confirmation-tab',
		xtype: 'grid',
		store: store_confirmations,
		columns: [
			{header: "<?php __('User'); ?>", dataIndex: 'user', sortable: true},
			{header: "<?php __('Confirmation Code'); ?>", dataIndex: 'confirmation_code', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Confirmations" : "Confirmation"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewConfirmation(Ext.getCmp('confirmation-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Confirmations</b><br />Click here to create a new Confirmation'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddConfirmation();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-confirmation',
					tooltip:'<?php __('<b>Edit Confirmations</b><br />Click here to modify the selected Confirmation'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditConfirmation(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-confirmation',
					tooltip:'<?php __('<b>Delete Confirmations(s)</b><br />Click here to remove the selected Confirmation(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Confirmation'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteConfirmation(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Confirmation'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Confirmations'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteConfirmation(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View Confirmation'); ?>',
					id: 'view-confirmation',
					tooltip:'<?php __('<b>View Confirmation</b><br />Click here to see details of the selected Confirmation'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewConfirmation(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('User'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;
                                                        //print_r($users);
                                                        foreach ($users as $item){
                                                            if($st) echo ",";?>
                                                        ['<?php echo $item['User']['id']; ?>' ,'<?php echo $item['User']['username']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_confirmations.reload({
								params: {
									start: 0,
									limit: list_size,
									user_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'confirmation_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByConfirmationName(Ext.getCmp('confirmation_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'confirmation_go_button',
					handler: function(){
						SearchByConfirmationName(Ext.getCmp('confirmation_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchConfirmation();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_confirmations,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-confirmation').enable();
		p.getTopToolbar().findById('delete-confirmation').enable();
		p.getTopToolbar().findById('view-confirmation').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-confirmation').disable();
			p.getTopToolbar().findById('view-confirmation').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-confirmation').disable();
			p.getTopToolbar().findById('view-confirmation').disable();
			p.getTopToolbar().findById('delete-confirmation').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-confirmation').enable();
			p.getTopToolbar().findById('view-confirmation').enable();
			p.getTopToolbar().findById('delete-confirmation').enable();
		}
		else{
			p.getTopToolbar().findById('edit-confirmation').disable();
			p.getTopToolbar().findById('view-confirmation').disable();
			p.getTopToolbar().findById('delete-confirmation').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_confirmations.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
