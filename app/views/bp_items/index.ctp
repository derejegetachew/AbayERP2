
var store_bpItems = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','accoun_no','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'bpItems', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"}
});


function AddBpItem() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpItems', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var bpItem_data = response.responseText;
			
			eval(bpItem_data);
			
			BpItemAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditBpItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpItems', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var bpItem_data = response.responseText;
			
			eval(bpItem_data);
			
			BpItemEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpItem edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBpItem(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'bpItems', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var bpItem_data = response.responseText;

            eval(bpItem_data);

            BpItemViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpItem view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentBpActuals(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_bpActuals_data = response.responseText;

            eval(parent_bpActuals_data);

            parentBpActualsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewParentBpPlans(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'bpPlans', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_bpPlans_data = response.responseText;

            eval(parent_bpPlans_data);

            parentBpPlansViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteBpItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpItems', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BpItem successfully deleted!'); ?>');
			RefreshBpItemData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchBpItem(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpItems', 'action' => 'search')); ?>',
		success: function(response, opts){
			var bpItem_data = response.responseText;

			eval(bpItem_data);

			bpItemSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the bpItem search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByBpItemName(value){
	var conditions = '\'BpItem.name LIKE\' => \'%' + value + '%\'';
	store_bpItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshBpItemData() {
	store_bpItems.reload();
}


if(center_panel.find('id', 'bpItem-tab') != "") {
	var p = center_panel.findById('bpItem-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Bp Items'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'bpItem-tab',
		xtype: 'grid',
		store: store_bpItems,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Accoun No'); ?>", dataIndex: 'accoun_no', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "BpItems" : "BpItem"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewBpItem(Ext.getCmp('bpItem-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add BpItems</b><br />Click here to create a new BpItem'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddBpItem();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-bpItem',
					tooltip:'<?php __('<b>Edit BpItems</b><br />Click here to modify the selected BpItem'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditBpItem(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-bpItem',
					tooltip:'<?php __('<b>Delete BpItems(s)</b><br />Click here to remove the selected BpItem(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove BpItem'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteBpItem(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove BpItem'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected BpItems'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteBpItem(sel_ids);
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
					text: '<?php __('View BpItem'); ?>',
					id: 'view-bpItem',
					tooltip:'<?php __('<b>View BpItem</b><br />Click here to see details of the selected BpItem'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewBpItem(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Bp Actuals'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentBpActuals(sel.data.id);
								};
							}
						}
,{
							text: '<?php __('View Bp Plans'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentBpPlans(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'bpItem_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByBpItemName(Ext.getCmp('bpItem_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'bpItem_go_button',
					handler: function(){
						SearchByBpItemName(Ext.getCmp('bpItem_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchBpItem();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_bpItems,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-bpItem').enable();
		p.getTopToolbar().findById('delete-bpItem').enable();
		p.getTopToolbar().findById('view-bpItem').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-bpItem').disable();
			p.getTopToolbar().findById('view-bpItem').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-bpItem').disable();
			p.getTopToolbar().findById('view-bpItem').disable();
			p.getTopToolbar().findById('delete-bpItem').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-bpItem').enable();
			p.getTopToolbar().findById('view-bpItem').enable();
			p.getTopToolbar().findById('delete-bpItem').enable();
		}
		else{
			p.getTopToolbar().findById('edit-bpItem').disable();
			p.getTopToolbar().findById('view-bpItem').disable();
			p.getTopToolbar().findById('delete-bpItem').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_bpItems.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
