
var store_imsTransferItemBefores = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_transfer_before','ims_sirv_item_before','ims_item','measurement','quantity','unit_price','tag','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItemBefores', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'ims_transfer_before_id', direction: "ASC"},
	groupField: 'ims_sirv_item_before_id'
});


function AddImsTransferItemBefore() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItemBefores', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsTransferItemBefore_data = response.responseText;
			
			eval(imsTransferItemBefore_data);
			
			ImsTransferItemBeforeAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferItemBefore add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsTransferItemBefore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItemBefores', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsTransferItemBefore_data = response.responseText;
			
			eval(imsTransferItemBefore_data);
			
			ImsTransferItemBeforeEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferItemBefore edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsTransferItemBefore(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItemBefores', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsTransferItemBefore_data = response.responseText;

            eval(imsTransferItemBefore_data);

            ImsTransferItemBeforeViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferItemBefore view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteImsTransferItemBefore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItemBefores', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsTransferItemBefore successfully deleted!'); ?>');
			RefreshImsTransferItemBeforeData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferItemBefore add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsTransferItemBefore(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItemBefores', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsTransferItemBefore_data = response.responseText;

			eval(imsTransferItemBefore_data);

			imsTransferItemBeforeSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the imsTransferItemBefore search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsTransferItemBeforeName(value){
	var conditions = '\'ImsTransferItemBefore.name LIKE\' => \'%' + value + '%\'';
	store_imsTransferItemBefores.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsTransferItemBeforeData() {
	store_imsTransferItemBefores.reload();
}


if(center_panel.find('id', 'imsTransferItemBefore-tab') != "") {
	var p = center_panel.findById('imsTransferItemBefore-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ims Transfer Item Befores'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsTransferItemBefore-tab',
		xtype: 'grid',
		store: store_imsTransferItemBefores,
		columns: [
			{header: "<?php __('ImsTransferBefore'); ?>", dataIndex: 'ims_transfer_before', sortable: true},
			{header: "<?php __('ImsSirvItemBefore'); ?>", dataIndex: 'ims_sirv_item_before', sortable: true},
			{header: "<?php __('ImsItem'); ?>", dataIndex: 'ims_item', sortable: true},
			{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
			{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
			{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
			{header: "<?php __('Tag'); ?>", dataIndex: 'tag', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsTransferItemBefores" : "ImsTransferItemBefore"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewImsTransferItemBefore(Ext.getCmp('imsTransferItemBefore-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add ImsTransferItemBefores</b><br />Click here to create a new ImsTransferItemBefore'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsTransferItemBefore();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsTransferItemBefore',
					tooltip:'<?php __('<b>Edit ImsTransferItemBefores</b><br />Click here to modify the selected ImsTransferItemBefore'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsTransferItemBefore(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsTransferItemBefore',
					tooltip:'<?php __('<b>Delete ImsTransferItemBefores(s)</b><br />Click here to remove the selected ImsTransferItemBefore(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove ImsTransferItemBefore'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsTransferItemBefore(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove ImsTransferItemBefore'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected ImsTransferItemBefores'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsTransferItemBefore(sel_ids);
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
					text: '<?php __('View ImsTransferItemBefore'); ?>',
					id: 'view-imsTransferItemBefore',
					tooltip:'<?php __('<b>View ImsTransferItemBefore</b><br />Click here to see details of the selected ImsTransferItemBefore'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsTransferItemBefore(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('ImsTransferBefore'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($imstransferbefores as $item){if($st) echo ",
							";?>['<?php echo $item['ImsTransferBefore']['id']; ?>' ,'<?php echo $item['ImsTransferBefore']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_imsTransferItemBefores.reload({
								params: {
									start: 0,
									limit: list_size,
									imstransferbefore_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsTransferItemBefore_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsTransferItemBeforeName(Ext.getCmp('imsTransferItemBefore_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsTransferItemBefore_go_button',
					handler: function(){
						SearchByImsTransferItemBeforeName(Ext.getCmp('imsTransferItemBefore_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsTransferItemBefore();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsTransferItemBefores,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-imsTransferItemBefore').enable();
		p.getTopToolbar().findById('delete-imsTransferItemBefore').enable();
		p.getTopToolbar().findById('view-imsTransferItemBefore').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsTransferItemBefore').disable();
			p.getTopToolbar().findById('view-imsTransferItemBefore').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsTransferItemBefore').disable();
			p.getTopToolbar().findById('view-imsTransferItemBefore').disable();
			p.getTopToolbar().findById('delete-imsTransferItemBefore').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-imsTransferItemBefore').enable();
			p.getTopToolbar().findById('view-imsTransferItemBefore').enable();
			p.getTopToolbar().findById('delete-imsTransferItemBefore').enable();
		}
		else{
			p.getTopToolbar().findById('edit-imsTransferItemBefore').disable();
			p.getTopToolbar().findById('view-imsTransferItemBefore').disable();
			p.getTopToolbar().findById('delete-imsTransferItemBefore').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsTransferItemBefores.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
