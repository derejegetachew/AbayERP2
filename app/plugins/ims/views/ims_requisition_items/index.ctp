
var store_imsRequisitionItems = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_requisition','ims_item','quantity','measurement','remark','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitionItems', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'ims_requisition_id', direction: "ASC"},
	groupField: 'ims_item_id'
});


function AddImsRequisitionItem() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitionItems', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsRequisitionItem_data = response.responseText;
			
			eval(imsRequisitionItem_data);
			
			ImsRequisitionItemAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsRequisitionItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsRequisitionItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitionItems', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsRequisitionItem_data = response.responseText;
			
			eval(imsRequisitionItem_data);
			
			ImsRequisitionItemEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsRequisitionItem edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsRequisitionItem(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitionItems', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsRequisitionItem_data = response.responseText;

            eval(imsRequisitionItem_data);

            ImsRequisitionItemViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsRequisitionItem view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteImsRequisitionItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitionItems', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsRequisitionItem successfully deleted!'); ?>');
			RefreshImsRequisitionItemData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsRequisitionItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsRequisitionItem(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitionItems', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsRequisitionItem_data = response.responseText;

			eval(imsRequisitionItem_data);

			imsRequisitionItemSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the imsRequisitionItem search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsRequisitionItemName(value){
	var conditions = '\'ImsRequisitionItem.name LIKE\' => \'%' + value + '%\'';
	store_imsRequisitionItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsRequisitionItemData() {
	store_imsRequisitionItems.reload();
}


if(center_panel.find('id', 'imsRequisitionItem-tab') != "") {
	var p = center_panel.findById('imsRequisitionItem-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ims Requisition Items'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsRequisitionItem-tab',
		xtype: 'grid',
		store: store_imsRequisitionItems,
		columns: [
			{header: "<?php __('ImsRequisition'); ?>", dataIndex: 'ims_requisition', sortable: true},
			{header: "<?php __('ImsItem'); ?>", dataIndex: 'ims_item', sortable: true},
			{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
			{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
			{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true},			
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsRequisitionItems" : "ImsRequisitionItem"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewImsRequisitionItem(Ext.getCmp('imsRequisitionItem-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add ImsRequisitionItems</b><br />Click here to create a new ImsRequisitionItem'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsRequisitionItem();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsRequisitionItem',
					tooltip:'<?php __('<b>Edit ImsRequisitionItems</b><br />Click here to modify the selected ImsRequisitionItem'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsRequisitionItem(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsRequisitionItem',
					tooltip:'<?php __('<b>Delete ImsRequisitionItems(s)</b><br />Click here to remove the selected ImsRequisitionItem(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove ImsRequisitionItem'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsRequisitionItem(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove ImsRequisitionItem'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected ImsRequisitionItems'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsRequisitionItem(sel_ids);
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
					text: '<?php __('View ImsRequisitionItem'); ?>',
					id: 'view-imsRequisitionItem',
					tooltip:'<?php __('<b>View ImsRequisitionItem</b><br />Click here to see details of the selected ImsRequisitionItem'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsRequisitionItem(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('ImsRequisition'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($imsrequisitions as $item){if($st) echo ",
							";?>['<?php echo $item['ImsRequisition']['id']; ?>' ,'<?php echo $item['ImsRequisition']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_imsRequisitionItems.reload({
								params: {
									start: 0,
									limit: list_size,
									imsrequisition_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsRequisitionItem_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsRequisitionItemName(Ext.getCmp('imsRequisitionItem_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsRequisitionItem_go_button',
					handler: function(){
						SearchByImsRequisitionItemName(Ext.getCmp('imsRequisitionItem_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsRequisitionItem();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsRequisitionItems,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-imsRequisitionItem').enable();
		p.getTopToolbar().findById('delete-imsRequisitionItem').enable();
		p.getTopToolbar().findById('view-imsRequisitionItem').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsRequisitionItem').disable();
			p.getTopToolbar().findById('view-imsRequisitionItem').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsRequisitionItem').disable();
			p.getTopToolbar().findById('view-imsRequisitionItem').disable();
			p.getTopToolbar().findById('delete-imsRequisitionItem').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-imsRequisitionItem').enable();
			p.getTopToolbar().findById('view-imsRequisitionItem').enable();
			p.getTopToolbar().findById('delete-imsRequisitionItem').enable();
		}
		else{
			p.getTopToolbar().findById('edit-imsRequisitionItem').disable();
			p.getTopToolbar().findById('view-imsRequisitionItem').disable();
			p.getTopToolbar().findById('delete-imsRequisitionItem').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsRequisitionItems.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
