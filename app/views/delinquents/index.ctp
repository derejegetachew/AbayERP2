
var store_delinquents = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','Name','letter_no','Closing_Bank','Branch','Date_Account_Closed','Tin','type','holder', 'Reason_For_Closing','type','holder','created']
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'delinquents', 'action' => 'list_data')); ?>'
	})
});


function AddDelinquent() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'delinquents', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var delinquent_data = response.responseText;
			
			eval(delinquent_data);
			
			DelinquentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the delinquent add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditDelinquent(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'delinquents', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var delinquent_data = response.responseText;
			
			eval(delinquent_data);
			
			DelinquentEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the delinquent edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewDelinquent(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'delinquents', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var delinquent_data = response.responseText;

            eval(delinquent_data);

            DelinquentViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the delinquent view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteDelinquent(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'delinquents', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Delinquent successfully deleted!'); ?>');
			RefreshDelinquentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the delinquent add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchDelinquent(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'delinquents', 'action' => 'search')); ?>',
		success: function(response, opts){
			var delinquent_data = response.responseText;

			eval(delinquent_data);

			delinquentSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the delinquent search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByDelinquentName(value){
	var conditions = '\'Delinquent.name LIKE\' => \'%' + value + '%\'';
	store_delinquents.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshDelinquentData() {
	store_delinquents.reload();
}


if(center_panel.find('id', 'delinquent-tab') != "") {
	var p = center_panel.findById('delinquent-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Delinquents'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'delinquent-tab',
		xtype: 'grid',
		store: store_delinquents,
		columns: [
			{header: "<?php __('Letter No'); ?>", dataIndex: 'letter_no', sortable: true},
			{header: "<?php __('Name'); ?>", dataIndex: 'Name', sortable: true},
			{header: "<?php __('Closing Bank'); ?>", dataIndex: 'Closing_Bank', sortable: true},
			{header: "<?php __('Branch'); ?>", dataIndex: 'Branch', sortable: true},
			{header: "<?php __('Date Account Closed'); ?>", dataIndex: 'Date_Account_Closed', sortable: true},
			{header: "<?php __('Tin'); ?>", dataIndex: 'Tin', sortable: true},
                        {header: "<?php __('holder'); ?>", dataIndex: 'holder', sortable: true},
                         {header: "<?php __('type'); ?>", dataIndex: 'type', sortable: true},
			{header: "<?php __('Reason_For_Closing'); ?>", dataIndex: 'Reason_For_Closing', sortable: true},
			{header: "<?php __('Entry Date'); ?>", dataIndex: 'created', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Delinquents" : "Delinquent"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewDelinquent(Ext.getCmp('delinquent-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Delinquents</b><br />Click here to create a new Delinquent'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddDelinquent();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-delinquent',
					tooltip:'<?php __('<b>Edit Delinquents</b><br />Click here to modify the selected Delinquent'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditDelinquent(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-delinquent',
					tooltip:'<?php __('<b>Delete Delinquents(s)</b><br />Click here to remove the selected Delinquent(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Delinquent'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteDelinquent(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Delinquent'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Delinquents'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteDelinquent(sel_ids);
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
					text: '<?php __('View Delinquent'); ?>',
					id: 'view-delinquent',
					tooltip:'<?php __('<b>View Delinquent</b><br />Click here to see details of the selected Delinquent'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewDelinquent(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'delinquent_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByDelinquentName(Ext.getCmp('delinquent_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'delinquent_go_button',
					handler: function(){
						SearchByDelinquentName(Ext.getCmp('delinquent_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchDelinquent();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_delinquents,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-delinquent').enable();
		p.getTopToolbar().findById('delete-delinquent').enable();
		p.getTopToolbar().findById('view-delinquent').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-delinquent').disable();
			p.getTopToolbar().findById('view-delinquent').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-delinquent').disable();
			p.getTopToolbar().findById('view-delinquent').disable();
			p.getTopToolbar().findById('delete-delinquent').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-delinquent').enable();
			p.getTopToolbar().findById('view-delinquent').enable();
			p.getTopToolbar().findById('delete-delinquent').enable();
		}
		else{
			p.getTopToolbar().findById('edit-delinquent').disable();
			p.getTopToolbar().findById('view-delinquent').disable();
			p.getTopToolbar().findById('delete-delinquent').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_delinquents.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
