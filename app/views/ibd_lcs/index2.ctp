var store_parent_ibdLcs = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','LC_ISSUE_DATE','NAME_OF_IMPORTER','LC_REF_NO','PERMIT_NO','currency_type','FCY_AMOUNT','OPENING_RATE','LCY_AMOUNT','MARGIN_AMT','OPEN_THROUGH','REIBURSING_BANK','MARGIN_AMOUNT','EXPIRY_DATE','SETT_DATE','SETT_FCY_AMOUNT','SETT_Rate','SETT_LCY_Amt','SETT_Margin_Amt','OUT_FCY_AMOUNT','OUT_BIRR_VALUE','OUT_Margin_Amt'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdLcs', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentIbdLc() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdLcs', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_ibdLc_data = response.responseText;
			
			eval(parent_ibdLc_data);
			
			IbdLcAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdLc add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentIbdLc(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdLcs', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_ibdLc_data = response.responseText;
			
			eval(parent_ibdLc_data);
			
			IbdLcEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdLc edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewIbdLc(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdLcs', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var ibdLc_data = response.responseText;

			eval(ibdLc_data);

			IbdLcViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdLc view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentIbdLc(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdLcs', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('IbdLc(s) successfully deleted!'); ?>');
			RefreshParentIbdLcData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdLc to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentIbdLcName(value){
	var conditions = '\'IbdLc.name LIKE\' => \'%' + value + '%\'';
	store_parent_ibdLcs.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentIbdLcData() {
	store_parent_ibdLcs.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('IbdLcs'); ?>',
	store: store_parent_ibdLcs,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'ibdLcGrid',
	columns: [
		{header: "<?php __('LC ISSUE DATE'); ?>", dataIndex: 'LC_ISSUE_DATE', sortable: true},
		{header: "<?php __('NAME OF IMPORTER'); ?>", dataIndex: 'NAME_OF_IMPORTER', sortable: true},
		{header: "<?php __('LC REF NO'); ?>", dataIndex: 'LC_REF_NO', sortable: true},
		{header: "<?php __('PERMIT NO'); ?>", dataIndex: 'PERMIT_NO', sortable: true},
		{header:"<?php __('currency_type'); ?>", dataIndex: 'currency_type', sortable: true},
		{header: "<?php __('FCY AMOUNT'); ?>", dataIndex: 'FCY_AMOUNT', sortable: true},
		{header: "<?php __('OPENING RATE'); ?>", dataIndex: 'OPENING_RATE', sortable: true},
		{header: "<?php __('LCY AMOUNT'); ?>", dataIndex: 'LCY_AMOUNT', sortable: true},
		{header: "<?php __('MARGIN AMT'); ?>", dataIndex: 'MARGIN_AMT', sortable: true},
		{header: "<?php __('OPEN THROUGH'); ?>", dataIndex: 'OPEN_THROUGH', sortable: true},
		{header: "<?php __('REIBURSING BANK'); ?>", dataIndex: 'REIBURSING_BANK', sortable: true},
		{header: "<?php __('MARGIN AMOUNT'); ?>", dataIndex: 'MARGIN_AMOUNT', sortable: true},
		{header: "<?php __('EXPIRY DATE'); ?>", dataIndex: 'EXPIRY_DATE', sortable: true},
		{header: "<?php __('SETT DATE'); ?>", dataIndex: 'SETT_DATE', sortable: true},
		{header: "<?php __('SETT FCY AMOUNT'); ?>", dataIndex: 'SETT_FCY_AMOUNT', sortable: true},
		{header: "<?php __('SETT Rate'); ?>", dataIndex: 'SETT_Rate', sortable: true},
		{header: "<?php __('SETT LCY Amt'); ?>", dataIndex: 'SETT_LCY_Amt', sortable: true},
		{header: "<?php __('SETT Margin Amt'); ?>", dataIndex: 'SETT_Margin_Amt', sortable: true},
		{header: "<?php __('OUT FCY AMOUNT'); ?>", dataIndex: 'OUT_FCY_AMOUNT', sortable: true},
		{header: "<?php __('OUT BIRR VALUE'); ?>", dataIndex: 'OUT_BIRR_VALUE', sortable: true},
		{header: "<?php __('OUT Margin Amt'); ?>", dataIndex: 'OUT_Margin_Amt', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewIbdLc(Ext.getCmp('ibdLcGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add IbdLc</b><br />Click here to create a new IbdLc'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentIbdLc();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-ibdLc',
				tooltip:'<?php __('<b>Edit IbdLc</b><br />Click here to modify the selected IbdLc'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentIbdLc(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-ibdLc',
				tooltip:'<?php __('<b>Delete IbdLc(s)</b><br />Click here to remove the selected IbdLc(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove IbdLc'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentIbdLc(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove IbdLc'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected IbdLc'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentIbdLc(sel_ids);
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
				text: '<?php __('View IbdLc'); ?>',
				id: 'view-ibdLc2',
				tooltip:'<?php __('<b>View IbdLc</b><br />Click here to see details of the selected IbdLc'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewIbdLc(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_ibdLc_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentIbdLcName(Ext.getCmp('parent_ibdLc_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_ibdLc_go_button',
				handler: function(){
					SearchByParentIbdLcName(Ext.getCmp('parent_ibdLc_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_ibdLcs,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-ibdLc').enable();
	g.getTopToolbar().findById('delete-parent-ibdLc').enable();
        g.getTopToolbar().findById('view-ibdLc2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-ibdLc').disable();
                g.getTopToolbar().findById('view-ibdLc2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-ibdLc').disable();
		g.getTopToolbar().findById('delete-parent-ibdLc').enable();
                g.getTopToolbar().findById('view-ibdLc2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-ibdLc').enable();
		g.getTopToolbar().findById('delete-parent-ibdLc').enable();
                g.getTopToolbar().findById('view-ibdLc2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-ibdLc').disable();
		g.getTopToolbar().findById('delete-parent-ibdLc').disable();
                g.getTopToolbar().findById('view-ibdLc2').disable();
	}
});



var parentIbdLcsViewWindow = new Ext.Window({
	title: 'IbdLc Under the selected Item',
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
			parentIbdLcsViewWindow.close();
		}
	}]
});

store_parent_ibdLcs.load({
    params: {
        start: 0,    
        limit: list_size
    }
});