
var store_imsSirvItems = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_sirv','ims_item','measurement','quantity','unit_price','remark'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItems', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'ims_sirv_id', direction: "ASC"},
	groupField: 'ims_item_id'
});


function AddImsSirvItem() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItems', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsSirvItem_data = response.responseText;
			
			eval(imsSirvItem_data);
			
			ImsSirvItemAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsSirvItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItems', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsSirvItem_data = response.responseText;
			
			eval(imsSirvItem_data);
			
			ImsSirvItemEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvItem edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsSirvItem(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItems', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsSirvItem_data = response.responseText;

            eval(imsSirvItem_data);

            ImsSirvItemViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvItem view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteImsSirvItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItems', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsSirvItem successfully deleted!'); ?>');
			RefreshImsSirvItemData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsSirvItem(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItems', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsSirvItem_data = response.responseText;

			eval(imsSirvItem_data);

			imsSirvItemSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the imsSirvItem search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsSirvItemName(value){
	var conditions = '\'ImsSirvItem.name LIKE\' => \'%' + value + '%\'';
	store_imsSirvItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsSirvItemData() {
	store_imsSirvItems.reload();
}


if(center_panel.find('id', 'imsSirvItem-tab') != "") {
	var p = center_panel.findById('imsSirvItem-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ims Sirv Items'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsSirvItem-tab',
		xtype: 'grid',
		store: store_imsSirvItems,
		columns: [
			{header: "<?php __('ImsSirv'); ?>", dataIndex: 'ims_sirv', sortable: true},
			{header: "<?php __('ImsItem'); ?>", dataIndex: 'ims_item', sortable: true},
			{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
			{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
			{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
			{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsSirvItems" : "ImsSirvItem"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewImsSirvItem(Ext.getCmp('imsSirvItem-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add ImsSirvItems</b><br />Click here to create a new ImsSirvItem'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsSirvItem();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsSirvItem',
					tooltip:'<?php __('<b>Edit ImsSirvItems</b><br />Click here to modify the selected ImsSirvItem'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsSirvItem(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsSirvItem',
					tooltip:'<?php __('<b>Delete ImsSirvItems(s)</b><br />Click here to remove the selected ImsSirvItem(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove ImsSirvItem'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsSirvItem(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove ImsSirvItem'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected ImsSirvItems'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsSirvItem(sel_ids);
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
					text: '<?php __('View ImsSirvItem'); ?>',
					id: 'view-imsSirvItem',
					tooltip:'<?php __('<b>View ImsSirvItem</b><br />Click here to see details of the selected ImsSirvItem'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsSirvItem(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('ImsSirv'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($imssirvs as $item){if($st) echo ",
							";?>['<?php echo $item['ImsSirv']['id']; ?>' ,'<?php echo $item['ImsSirv']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_imsSirvItems.reload({
								params: {
									start: 0,
									limit: list_size,
									imssirv_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsSirvItem_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsSirvItemName(Ext.getCmp('imsSirvItem_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsSirvItem_go_button',
					handler: function(){
						SearchByImsSirvItemName(Ext.getCmp('imsSirvItem_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsSirvItem();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsSirvItems,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-imsSirvItem').enable();
		p.getTopToolbar().findById('delete-imsSirvItem').enable();
		p.getTopToolbar().findById('view-imsSirvItem').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsSirvItem').disable();
			p.getTopToolbar().findById('view-imsSirvItem').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsSirvItem').disable();
			p.getTopToolbar().findById('view-imsSirvItem').disable();
			p.getTopToolbar().findById('delete-imsSirvItem').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-imsSirvItem').enable();
			p.getTopToolbar().findById('view-imsSirvItem').enable();
			p.getTopToolbar().findById('delete-imsSirvItem').enable();
		}
		else{
			p.getTopToolbar().findById('edit-imsSirvItem').disable();
			p.getTopToolbar().findById('view-imsSirvItem').disable();
			p.getTopToolbar().findById('delete-imsSirvItem').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsSirvItems.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
