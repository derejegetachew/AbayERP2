
var store_imsTransferStoreItemDetails = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_transfer_store_item','ims_item','quantity','measurement','remark','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItemDetails', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'ims_transfer_store_item_id', direction: "ASC"},
	groupField: 'ims_item_id'
});


function AddImsTransferStoreItemDetail() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItemDetails', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsTransferStoreItemDetail_data = response.responseText;
			
			eval(imsTransferStoreItemDetail_data);
			
			ImsTransferStoreItemDetailAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferStoreItemDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsTransferStoreItemDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItemDetails', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsTransferStoreItemDetail_data = response.responseText;
			
			eval(imsTransferStoreItemDetail_data);
			
			ImsTransferStoreItemDetailEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferStoreItemDetail edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsTransferStoreItemDetail(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItemDetails', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsTransferStoreItemDetail_data = response.responseText;

            eval(imsTransferStoreItemDetail_data);

            ImsTransferStoreItemDetailViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferStoreItemDetail view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteImsTransferStoreItemDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItemDetails', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsTransferStoreItemDetail successfully deleted!'); ?>');
			RefreshImsTransferStoreItemDetailData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferStoreItemDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsTransferStoreItemDetail(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItemDetails', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsTransferStoreItemDetail_data = response.responseText;

			eval(imsTransferStoreItemDetail_data);

			imsTransferStoreItemDetailSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the imsTransferStoreItemDetail search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsTransferStoreItemDetailName(value){
	var conditions = '\'ImsTransferStoreItemDetail.name LIKE\' => \'%' + value + '%\'';
	store_imsTransferStoreItemDetails.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsTransferStoreItemDetailData() {
	store_imsTransferStoreItemDetails.reload();
}


if(center_panel.find('id', 'imsTransferStoreItemDetail-tab') != "") {
	var p = center_panel.findById('imsTransferStoreItemDetail-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ims Transfer Store Item Details'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsTransferStoreItemDetail-tab',
		xtype: 'grid',
		store: store_imsTransferStoreItemDetails,
		columns: [
			{header: "<?php __('ImsTransferStoreItem'); ?>", dataIndex: 'ims_transfer_store_item', sortable: true},
			{header: "<?php __('ImsItem'); ?>", dataIndex: 'ims_item', sortable: true},
			{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
			{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
			{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsTransferStoreItemDetails" : "ImsTransferStoreItemDetail"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewImsTransferStoreItemDetail(Ext.getCmp('imsTransferStoreItemDetail-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add ImsTransferStoreItemDetails</b><br />Click here to create a new ImsTransferStoreItemDetail'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsTransferStoreItemDetail();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsTransferStoreItemDetail',
					tooltip:'<?php __('<b>Edit ImsTransferStoreItemDetails</b><br />Click here to modify the selected ImsTransferStoreItemDetail'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsTransferStoreItemDetail(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsTransferStoreItemDetail',
					tooltip:'<?php __('<b>Delete ImsTransferStoreItemDetails(s)</b><br />Click here to remove the selected ImsTransferStoreItemDetail(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove ImsTransferStoreItemDetail'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsTransferStoreItemDetail(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove ImsTransferStoreItemDetail'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected ImsTransferStoreItemDetails'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsTransferStoreItemDetail(sel_ids);
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
					text: '<?php __('View ImsTransferStoreItemDetail'); ?>',
					id: 'view-imsTransferStoreItemDetail',
					tooltip:'<?php __('<b>View ImsTransferStoreItemDetail</b><br />Click here to see details of the selected ImsTransferStoreItemDetail'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsTransferStoreItemDetail(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('ImsTransferStoreItem'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($imstransferstoreitems as $item){if($st) echo ",
							";?>['<?php echo $item['ImsTransferStoreItem']['id']; ?>' ,'<?php echo $item['ImsTransferStoreItem']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_imsTransferStoreItemDetails.reload({
								params: {
									start: 0,
									limit: list_size,
									imstransferstoreitem_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsTransferStoreItemDetail_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsTransferStoreItemDetailName(Ext.getCmp('imsTransferStoreItemDetail_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsTransferStoreItemDetail_go_button',
					handler: function(){
						SearchByImsTransferStoreItemDetailName(Ext.getCmp('imsTransferStoreItemDetail_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsTransferStoreItemDetail();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsTransferStoreItemDetails,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-imsTransferStoreItemDetail').enable();
		p.getTopToolbar().findById('delete-imsTransferStoreItemDetail').enable();
		p.getTopToolbar().findById('view-imsTransferStoreItemDetail').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsTransferStoreItemDetail').disable();
			p.getTopToolbar().findById('view-imsTransferStoreItemDetail').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsTransferStoreItemDetail').disable();
			p.getTopToolbar().findById('view-imsTransferStoreItemDetail').disable();
			p.getTopToolbar().findById('delete-imsTransferStoreItemDetail').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-imsTransferStoreItemDetail').enable();
			p.getTopToolbar().findById('view-imsTransferStoreItemDetail').enable();
			p.getTopToolbar().findById('delete-imsTransferStoreItemDetail').enable();
		}
		else{
			p.getTopToolbar().findById('edit-imsTransferStoreItemDetail').disable();
			p.getTopToolbar().findById('view-imsTransferStoreItemDetail').disable();
			p.getTopToolbar().findById('delete-imsTransferStoreItemDetail').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsTransferStoreItemDetails.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
