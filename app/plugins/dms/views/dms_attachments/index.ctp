
var store_dmsAttachments = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','file','dms_message','created'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsAttachments', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'file'
});


function AddDmsAttachment() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsAttachments', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var dmsAttachment_data = response.responseText;
			
			eval(dmsAttachment_data);
			
			DmsAttachmentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsAttachment add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditDmsAttachment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsAttachments', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var dmsAttachment_data = response.responseText;
			
			eval(dmsAttachment_data);
			
			DmsAttachmentEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsAttachment edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewDmsAttachment(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'dmsAttachments', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var dmsAttachment_data = response.responseText;

            eval(dmsAttachment_data);

            DmsAttachmentViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsAttachment view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteDmsAttachment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsAttachments', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('DmsAttachment successfully deleted!'); ?>');
			RefreshDmsAttachmentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsAttachment add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchDmsAttachment(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsAttachments', 'action' => 'search')); ?>',
		success: function(response, opts){
			var dmsAttachment_data = response.responseText;

			eval(dmsAttachment_data);

			dmsAttachmentSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the dmsAttachment search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByDmsAttachmentName(value){
	var conditions = '\'DmsAttachment.name LIKE\' => \'%' + value + '%\'';
	store_dmsAttachments.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshDmsAttachmentData() {
	store_dmsAttachments.reload();
}


if(center_panel.find('id', 'dmsAttachment-tab') != "") {
	var p = center_panel.findById('dmsAttachment-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Dms Attachments'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'dmsAttachment-tab',
		xtype: 'grid',
		store: store_dmsAttachments,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('File'); ?>", dataIndex: 'file', sortable: true},
			{header: "<?php __('DmsMessage'); ?>", dataIndex: 'dms_message', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "DmsAttachments" : "DmsAttachment"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewDmsAttachment(Ext.getCmp('dmsAttachment-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add DmsAttachments</b><br />Click here to create a new DmsAttachment'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddDmsAttachment();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-dmsAttachment',
					tooltip:'<?php __('<b>Edit DmsAttachments</b><br />Click here to modify the selected DmsAttachment'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditDmsAttachment(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-dmsAttachment',
					tooltip:'<?php __('<b>Delete DmsAttachments(s)</b><br />Click here to remove the selected DmsAttachment(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove DmsAttachment'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteDmsAttachment(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove DmsAttachment'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected DmsAttachments'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteDmsAttachment(sel_ids);
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
					text: '<?php __('View DmsAttachment'); ?>',
					id: 'view-dmsAttachment',
					tooltip:'<?php __('<b>View DmsAttachment</b><br />Click here to see details of the selected DmsAttachment'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewDmsAttachment(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('DmsMessage'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($dmsmessages as $item){if($st) echo ",
							";?>['<?php echo $item['DmsMessage']['id']; ?>' ,'<?php echo $item['DmsMessage']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_dmsAttachments.reload({
								params: {
									start: 0,
									limit: list_size,
									dmsmessage_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'dmsAttachment_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByDmsAttachmentName(Ext.getCmp('dmsAttachment_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'dmsAttachment_go_button',
					handler: function(){
						SearchByDmsAttachmentName(Ext.getCmp('dmsAttachment_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchDmsAttachment();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_dmsAttachments,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-dmsAttachment').enable();
		p.getTopToolbar().findById('delete-dmsAttachment').enable();
		p.getTopToolbar().findById('view-dmsAttachment').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-dmsAttachment').disable();
			p.getTopToolbar().findById('view-dmsAttachment').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-dmsAttachment').disable();
			p.getTopToolbar().findById('view-dmsAttachment').disable();
			p.getTopToolbar().findById('delete-dmsAttachment').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-dmsAttachment').enable();
			p.getTopToolbar().findById('view-dmsAttachment').enable();
			p.getTopToolbar().findById('delete-dmsAttachment').enable();
		}
		else{
			p.getTopToolbar().findById('edit-dmsAttachment').disable();
			p.getTopToolbar().findById('view-dmsAttachment').disable();
			p.getTopToolbar().findById('delete-dmsAttachment').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_dmsAttachments.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
