
var store_frwfmAccounts = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','frwfm_application','acc_no','name','branch','amount','currency','type'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmAccounts', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'frwfm_application_id', direction: "ASC"},
	groupField: 'acc_no'
});


function AddFrwfmAccount() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmAccounts', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var frwfmAccount_data = response.responseText;
			
			eval(frwfmAccount_data);
			
			FrwfmAccountAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmAccount add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditFrwfmAccount(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmAccounts', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var frwfmAccount_data = response.responseText;
			
			eval(frwfmAccount_data);
			
			FrwfmAccountEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmAccount edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFrwfmAccount(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'frwfmAccounts', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var frwfmAccount_data = response.responseText;

            eval(frwfmAccount_data);

            FrwfmAccountViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmAccount view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteFrwfmAccount(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmAccounts', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FrwfmAccount successfully deleted!'); ?>');
			RefreshFrwfmAccountData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmAccount add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchFrwfmAccount(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmAccounts', 'action' => 'search')); ?>',
		success: function(response, opts){
			var frwfmAccount_data = response.responseText;

			eval(frwfmAccount_data);

			frwfmAccountSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the frwfmAccount search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByFrwfmAccountName(value){
	var conditions = '\'FrwfmAccount.name LIKE\' => \'%' + value + '%\'';
	store_frwfmAccounts.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshFrwfmAccountData() {
	store_frwfmAccounts.reload();
}


if(center_panel.find('id', 'frwfmAccount-tab') != "") {
	var p = center_panel.findById('frwfmAccount-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Frwfm Accounts'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'frwfmAccount-tab',
		xtype: 'grid',
		store: store_frwfmAccounts,
		columns: [
			{header: "<?php __('FrwfmApplication'); ?>", dataIndex: 'frwfm_application', sortable: true},
			{header: "<?php __('Acc No'); ?>", dataIndex: 'acc_no', sortable: true},
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true},
			{header: "<?php __('Currency'); ?>", dataIndex: 'currency', sortable: true},
			{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "FrwfmAccounts" : "FrwfmAccount"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewFrwfmAccount(Ext.getCmp('frwfmAccount-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add FrwfmAccounts</b><br />Click here to create a new FrwfmAccount'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddFrwfmAccount();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-frwfmAccount',
					tooltip:'<?php __('<b>Edit FrwfmAccounts</b><br />Click here to modify the selected FrwfmAccount'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditFrwfmAccount(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-frwfmAccount',
					tooltip:'<?php __('<b>Delete FrwfmAccounts(s)</b><br />Click here to remove the selected FrwfmAccount(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove FrwfmAccount'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteFrwfmAccount(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove FrwfmAccount'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected FrwfmAccounts'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteFrwfmAccount(sel_ids);
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
					text: '<?php __('View FrwfmAccount'); ?>',
					id: 'view-frwfmAccount',
					tooltip:'<?php __('<b>View FrwfmAccount</b><br />Click here to see details of the selected FrwfmAccount'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewFrwfmAccount(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('FrwfmApplication'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($frwfmapplications as $item){if($st) echo ",
							";?>['<?php echo $item['FrwfmApplication']['id']; ?>' ,'<?php echo $item['FrwfmApplication']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_frwfmAccounts.reload({
								params: {
									start: 0,
									limit: list_size,
									frwfmapplication_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'frwfmAccount_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByFrwfmAccountName(Ext.getCmp('frwfmAccount_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'frwfmAccount_go_button',
					handler: function(){
						SearchByFrwfmAccountName(Ext.getCmp('frwfmAccount_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchFrwfmAccount();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_frwfmAccounts,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-frwfmAccount').enable();
		p.getTopToolbar().findById('delete-frwfmAccount').enable();
		p.getTopToolbar().findById('view-frwfmAccount').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-frwfmAccount').disable();
			p.getTopToolbar().findById('view-frwfmAccount').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-frwfmAccount').disable();
			p.getTopToolbar().findById('view-frwfmAccount').disable();
			p.getTopToolbar().findById('delete-frwfmAccount').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-frwfmAccount').enable();
			p.getTopToolbar().findById('view-frwfmAccount').enable();
			p.getTopToolbar().findById('delete-frwfmAccount').enable();
		}
		else{
			p.getTopToolbar().findById('edit-frwfmAccount').disable();
			p.getTopToolbar().findById('view-frwfmAccount').disable();
			p.getTopToolbar().findById('delete-frwfmAccount').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_frwfmAccounts.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
