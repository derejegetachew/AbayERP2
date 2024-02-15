
var store_imsStoresCards = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_store','ims_requisition','ims_card','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsStoresCards', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'ims_store_id', direction: "ASC"},
	groupField: 'ims_requisition_id'
});


function AddImsStoresCard() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsStoresCards', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsStoresCard_data = response.responseText;
			
			eval(imsStoresCard_data);
			
			ImsStoresCardAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsStoresCard add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsStoresCard(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsStoresCards', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsStoresCard_data = response.responseText;
			
			eval(imsStoresCard_data);
			
			ImsStoresCardEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsStoresCard edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsStoresCard(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsStoresCards', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsStoresCard_data = response.responseText;

            eval(imsStoresCard_data);

            ImsStoresCardViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsStoresCard view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteImsStoresCard(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsStoresCards', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsStoresCard successfully deleted!'); ?>');
			RefreshImsStoresCardData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsStoresCard add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsStoresCard(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsStoresCards', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsStoresCard_data = response.responseText;

			eval(imsStoresCard_data);

			imsStoresCardSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the imsStoresCard search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsStoresCardName(value){
	var conditions = '\'ImsStoresCard.name LIKE\' => \'%' + value + '%\'';
	store_imsStoresCards.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsStoresCardData() {
	store_imsStoresCards.reload();
}


if(center_panel.find('id', 'imsStoresCard-tab') != "") {
	var p = center_panel.findById('imsStoresCard-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ims Stores Cards'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsStoresCard-tab',
		xtype: 'grid',
		store: store_imsStoresCards,
		columns: [
			{header: "<?php __('ImsStore'); ?>", dataIndex: 'ims_store', sortable: true},
			{header: "<?php __('ImsRequisition'); ?>", dataIndex: 'ims_requisition', sortable: true},
			{header: "<?php __('ImsCard'); ?>", dataIndex: 'ims_card', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsStoresCards" : "ImsStoresCard"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewImsStoresCard(Ext.getCmp('imsStoresCard-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add ImsStoresCards</b><br />Click here to create a new ImsStoresCard'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsStoresCard();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsStoresCard',
					tooltip:'<?php __('<b>Edit ImsStoresCards</b><br />Click here to modify the selected ImsStoresCard'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsStoresCard(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsStoresCard',
					tooltip:'<?php __('<b>Delete ImsStoresCards(s)</b><br />Click here to remove the selected ImsStoresCard(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove ImsStoresCard'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsStoresCard(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove ImsStoresCard'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected ImsStoresCards'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsStoresCard(sel_ids);
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
					text: '<?php __('View ImsStoresCard'); ?>',
					id: 'view-imsStoresCard',
					tooltip:'<?php __('<b>View ImsStoresCard</b><br />Click here to see details of the selected ImsStoresCard'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsStoresCard(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('ImsStore'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($imsstores as $item){if($st) echo ",
							";?>['<?php echo $item['ImsStore']['id']; ?>' ,'<?php echo $item['ImsStore']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_imsStoresCards.reload({
								params: {
									start: 0,
									limit: list_size,
									imsstore_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsStoresCard_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsStoresCardName(Ext.getCmp('imsStoresCard_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsStoresCard_go_button',
					handler: function(){
						SearchByImsStoresCardName(Ext.getCmp('imsStoresCard_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsStoresCard();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsStoresCards,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-imsStoresCard').enable();
		p.getTopToolbar().findById('delete-imsStoresCard').enable();
		p.getTopToolbar().findById('view-imsStoresCard').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsStoresCard').disable();
			p.getTopToolbar().findById('view-imsStoresCard').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsStoresCard').disable();
			p.getTopToolbar().findById('view-imsStoresCard').disable();
			p.getTopToolbar().findById('delete-imsStoresCard').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-imsStoresCard').enable();
			p.getTopToolbar().findById('view-imsStoresCard').enable();
			p.getTopToolbar().findById('delete-imsStoresCard').enable();
		}
		else{
			p.getTopToolbar().findById('edit-imsStoresCard').disable();
			p.getTopToolbar().findById('view-imsStoresCard').disable();
			p.getTopToolbar().findById('delete-imsStoresCard').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsStoresCards.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
