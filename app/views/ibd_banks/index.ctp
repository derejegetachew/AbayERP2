
var store_ibdBanks = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdBanks', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"}
//,	groupField: 'created'
});


function AddIbdBank() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdBanks', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var ibdBank_data = response.responseText;
			
			eval(ibdBank_data);
			
			IbdBankAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdBank add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditIbdBank(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdBanks', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var ibdBank_data = response.responseText;
			
			eval(ibdBank_data);
			
			IbdBankEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdBank edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewIbdBank(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdBanks', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var ibdBank_data = response.responseText;

            eval(ibdBank_data);

            IbdBankViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdBank view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteIbdBank(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdBanks', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('IbdBank successfully deleted!'); ?>');
			RefreshIbdBankData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdBank add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchIbdBank(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdBanks', 'action' => 'search')); ?>',
		success: function(response, opts){
			var ibdBank_data = response.responseText;

			eval(ibdBank_data);

			ibdBankSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the ibdBank search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByIbdBankName(value){
	var conditions = '\'IbdBank.name LIKE\' => \'%' + value + '%\'';
	store_ibdBanks.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshIbdBankData() {
	store_ibdBanks.reload();
}


if(center_panel.find('id', 'ibdBank-tab') != "") {
	var p = center_panel.findById('ibdBank-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ibd Banks'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'ibdBank-tab',
		xtype: 'grid',
		store: store_ibdBanks,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "IbdBanks" : "IbdBank"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewIbdBank(Ext.getCmp('ibdBank-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add IbdBanks</b><br />Click here to create a new IbdBank'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddIbdBank();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-ibdBank',
					tooltip:'<?php __('<b>Edit IbdBanks</b><br />Click here to modify the selected IbdBank'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditIbdBank(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-ibdBank',
					tooltip:'<?php __('<b>Delete IbdBanks(s)</b><br />Click here to remove the selected IbdBank(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove IbdBank'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteIbdBank(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove IbdBank'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected IbdBanks'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteIbdBank(sel_ids);
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
					text: '<?php __('View IbdBank'); ?>',
					id: 'view-ibdBank',
					tooltip:'<?php __('<b>View IbdBank</b><br />Click here to see details of the selected IbdBank'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewIbdBank(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'ibdBank_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByIbdBankName(Ext.getCmp('ibdBank_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'ibdBank_go_button',
					handler: function(){
						SearchByIbdBankName(Ext.getCmp('ibdBank_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchIbdBank();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_ibdBanks,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-ibdBank').enable();
		p.getTopToolbar().findById('delete-ibdBank').enable();
		p.getTopToolbar().findById('view-ibdBank').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdBank').disable();
			p.getTopToolbar().findById('view-ibdBank').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdBank').disable();
			p.getTopToolbar().findById('view-ibdBank').disable();
			p.getTopToolbar().findById('delete-ibdBank').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-ibdBank').enable();
			p.getTopToolbar().findById('view-ibdBank').enable();
			p.getTopToolbar().findById('delete-ibdBank').enable();
		}
		else{
			p.getTopToolbar().findById('edit-ibdBank').disable();
			p.getTopToolbar().findById('view-ibdBank').disable();
			p.getTopToolbar().findById('delete-ibdBank').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_ibdBanks.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
