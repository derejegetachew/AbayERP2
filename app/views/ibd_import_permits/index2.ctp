var store_parent_ibdImportPermits = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','PERMIT_ISSUE_DATE','NAME_OF_IMPORTER','IMPORT_PERMIT_NO','currency_id','FCY_AMOUNT','PREVAILING_RATE','LCY_AMOUNT','payment_term_id','ITEM_DESCRIPTION_OF_GOODS','SUPPLIERS_NAME','MINUTE_NO','FCY_APPROVAL_DATE','FCY_APPROVAL_INTIAL_ORDER_NO','FROM_THEIR_FCY_ACCOUNT','THE_PRICE_AS_PER_NBE_SELLECTED','NBE_UNDERTAKING','SUPPLIERS_CREDIT','REMARK'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdImportPermits', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentIbdImportPermit() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdImportPermits', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_ibdImportPermit_data = response.responseText;
			
			eval(parent_ibdImportPermit_data);
			
			IbdImportPermitAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdImportPermit add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentIbdImportPermit(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdImportPermits', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_ibdImportPermit_data = response.responseText;
			
			eval(parent_ibdImportPermit_data);
			
			IbdImportPermitEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdImportPermit edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewIbdImportPermit(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdImportPermits', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var ibdImportPermit_data = response.responseText;

			eval(ibdImportPermit_data);

			IbdImportPermitViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdImportPermit view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentIbdImportPermit(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdImportPermits', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('IbdImportPermit(s) successfully deleted!'); ?>');
			RefreshParentIbdImportPermitData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdImportPermit to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentIbdImportPermitName(value){
	var conditions = '\'IbdImportPermit.name LIKE\' => \'%' + value + '%\'';
	store_parent_ibdImportPermits.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentIbdImportPermitData() {
	store_parent_ibdImportPermits.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('IbdImportPermits'); ?>',
	store: store_parent_ibdImportPermits,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'ibdImportPermitGrid',
	columns: [
		{header: "<?php __('PERMIT ISSUE DATE'); ?>", dataIndex: 'PERMIT_ISSUE_DATE', sortable: true},
		{header: "<?php __('NAME OF IMPORTER'); ?>", dataIndex: 'NAME_OF_IMPORTER', sortable: true},
		{header: "<?php __('IMPORT PERMIT NO'); ?>", dataIndex: 'IMPORT_PERMIT_NO', sortable: true},
		{header: "<?php __('Currency Id'); ?>", dataIndex: 'currency_id', sortable: true},
		{header: "<?php __('FCY AMOUNT'); ?>", dataIndex: 'FCY_AMOUNT', sortable: true},
		{header: "<?php __('PREVAILING RATE'); ?>", dataIndex: 'PREVAILING_RATE', sortable: true},
		{header: "<?php __('LCY AMOUNT'); ?>", dataIndex: 'LCY_AMOUNT', sortable: true},
		{header: "<?php __('Payment Term Id'); ?>", dataIndex: 'payment_term_id', sortable: true},
		{header: "<?php __('ITEM DESCRIPTION OF GOODS'); ?>", dataIndex: 'ITEM_DESCRIPTION_OF_GOODS', sortable: true},
		{header: "<?php __('SUPPLIERS NAME'); ?>", dataIndex: 'SUPPLIERS_NAME', sortable: true},
		{header: "<?php __('MINUTE NO'); ?>", dataIndex: 'MINUTE_NO', sortable: true},
		{header: "<?php __('FCY APPROVAL DATE'); ?>", dataIndex: 'FCY_APPROVAL_DATE', sortable: true},
		{header: "<?php __('FCY APPROVAL INTIAL ORDER NO'); ?>", dataIndex: 'FCY_APPROVAL_INTIAL_ORDER_NO', sortable: true},
		{header: "<?php __('FROM THEIR FCY ACCOUNT'); ?>", dataIndex: 'FROM_THEIR_FCY_ACCOUNT', sortable: true},
		{header: "<?php __('THE PRICE AS PER NBE SELLECTED'); ?>", dataIndex: 'THE_PRICE_AS_PER_NBE_SELLECTED', sortable: true},
		{header: "<?php __('NBE UNDERTAKING'); ?>", dataIndex: 'NBE_UNDERTAKING', sortable: true},
		{header: "<?php __('SUPPLIERS CREDIT'); ?>", dataIndex: 'SUPPLIERS_CREDIT', sortable: true},
		{header: "<?php __('REMARK'); ?>", dataIndex: 'REMARK', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewIbdImportPermit(Ext.getCmp('ibdImportPermitGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add IbdImportPermit</b><br />Click here to create a new IbdImportPermit'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentIbdImportPermit();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-ibdImportPermit',
				tooltip:'<?php __('<b>Edit IbdImportPermit</b><br />Click here to modify the selected IbdImportPermit'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentIbdImportPermit(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-ibdImportPermit',
				tooltip:'<?php __('<b>Delete IbdImportPermit(s)</b><br />Click here to remove the selected IbdImportPermit(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove IbdImportPermit'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentIbdImportPermit(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove IbdImportPermit'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected IbdImportPermit'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentIbdImportPermit(sel_ids);
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
				text: '<?php __('View IbdImportPermit'); ?>',
				id: 'view-ibdImportPermit2',
				tooltip:'<?php __('<b>View IbdImportPermit</b><br />Click here to see details of the selected IbdImportPermit'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewIbdImportPermit(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_ibdImportPermit_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentIbdImportPermitName(Ext.getCmp('parent_ibdImportPermit_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_ibdImportPermit_go_button',
				handler: function(){
					SearchByParentIbdImportPermitName(Ext.getCmp('parent_ibdImportPermit_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_ibdImportPermits,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-ibdImportPermit').enable();
	g.getTopToolbar().findById('delete-parent-ibdImportPermit').enable();
        g.getTopToolbar().findById('view-ibdImportPermit2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-ibdImportPermit').disable();
                g.getTopToolbar().findById('view-ibdImportPermit2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-ibdImportPermit').disable();
		g.getTopToolbar().findById('delete-parent-ibdImportPermit').enable();
                g.getTopToolbar().findById('view-ibdImportPermit2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-ibdImportPermit').enable();
		g.getTopToolbar().findById('delete-parent-ibdImportPermit').enable();
                g.getTopToolbar().findById('view-ibdImportPermit2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-ibdImportPermit').disable();
		g.getTopToolbar().findById('delete-parent-ibdImportPermit').disable();
                g.getTopToolbar().findById('view-ibdImportPermit2').disable();
	}
});



var parentIbdImportPermitsViewWindow = new Ext.Window({
	title: 'IbdImportPermit Under the selected Item',
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
			parentIbdImportPermitsViewWindow.close();
		}
	}]
});

store_parent_ibdImportPermits.load({
    params: {
        start: 0,    
        limit: list_size
    }
});