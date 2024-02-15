var store_parent_frwfmAccounts = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','frwfm_application','acc_no','name','branch','amount','currency','type'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmAccounts', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentFrwfmAccount() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmAccounts', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_frwfmAccount_data = response.responseText;
			
			eval(parent_frwfmAccount_data);
			
			FrwfmAccountAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmAccount add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentFrwfmAccount(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmAccounts', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_frwfmAccount_data = response.responseText;
			
			eval(parent_frwfmAccount_data);
			
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


function DeleteParentFrwfmAccount(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmAccounts', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FrwfmAccount(s) successfully deleted!'); ?>');
			RefreshParentFrwfmAccountData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmAccount to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentFrwfmAccountName(value){
	var conditions = '\'FrwfmAccount.name LIKE\' => \'%' + value + '%\'';
	store_parent_frwfmAccounts.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentFrwfmAccountData() {
	store_parent_frwfmAccounts.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('FrwfmAccounts'); ?>',
	store: store_parent_frwfmAccounts,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'frwfmAccountGrid',
	columns: [
		{header: "<?php __('Acc No'); ?>", dataIndex: 'acc_no', sortable: true},
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
		{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true},
		{header: "<?php __('Currency'); ?>", dataIndex: 'currency', sortable: true},
		{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewFrwfmAccount(Ext.getCmp('frwfmAccountGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add FrwfmAccount</b><br />Click here to create a new FrwfmAccount'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentFrwfmAccount();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-frwfmAccount',
				tooltip:'<?php __('<b>Delete FrwfmAccount(s)</b><br />Click here to remove the selected FrwfmAccount(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove FrwfmAccount'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentFrwfmAccount(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove FrwfmAccount'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected FrwfmAccount'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentFrwfmAccount(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			}
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_frwfmAccounts,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	//g.getTopToolbar().findById('edit-parent-frwfmAccount').enable();
	g.getTopToolbar().findById('delete-parent-frwfmAccount').enable();
       // g.getTopToolbar().findById('view-frwfmAccount2').enable();
	if(this.getSelections().length > 1){
		//g.getTopToolbar().findById('edit-parent-frwfmAccount').disable();
               // g.getTopToolbar().findById('view-frwfmAccount2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		//g.getTopToolbar().findById('edit-parent-frwfmAccount').disable();
		g.getTopToolbar().findById('delete-parent-frwfmAccount').enable();
               // g.getTopToolbar().findById('view-frwfmAccount2').disable();
	}
	else if(this.getSelections().length == 1){
		//g.getTopToolbar().findById('edit-parent-frwfmAccount').enable();
		g.getTopToolbar().findById('delete-parent-frwfmAccount').enable();
               // g.getTopToolbar().findById('view-frwfmAccount2').enable();
	}
	else{
		//g.getTopToolbar().findById('edit-parent-frwfmAccount').disable();
		g.getTopToolbar().findById('delete-parent-frwfmAccount').disable();
                //g.getTopToolbar().findById('view-frwfmAccount2').disable();
	}
});



var parentFrwfmAccountsViewWindow = new Ext.Window({
	title: 'FrwfmAccount Under the selected Item',
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
			parentFrwfmAccountsViewWindow.close();
		}
	}]
});

store_parent_frwfmAccounts.load({
    params: {
        start: 0,    
        limit: list_size
    }
});