
var store_cmsAttachments = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','file','name','created','cms_reply'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAttachments', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'file', direction: "ASC"},
	groupField: 'name'
});


function AddCmsAttachment() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAttachments', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var cmsAttachment_data = response.responseText;
			
			eval(cmsAttachment_data);
			
			CmsAttachmentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsAttachment add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditCmsAttachment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAttachments', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var cmsAttachment_data = response.responseText;
			
			eval(cmsAttachment_data);
			
			CmsAttachmentEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsAttachment edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCmsAttachment(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'cmsAttachments', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var cmsAttachment_data = response.responseText;

            eval(cmsAttachment_data);

            CmsAttachmentViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsAttachment view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteCmsAttachment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAttachments', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CmsAttachment successfully deleted!'); ?>');
			RefreshCmsAttachmentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsAttachment add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchCmsAttachment(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsAttachments', 'action' => 'search')); ?>',
		success: function(response, opts){
			var cmsAttachment_data = response.responseText;

			eval(cmsAttachment_data);

			cmsAttachmentSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the cmsAttachment search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByCmsAttachmentName(value){
	var conditions = '\'CmsAttachment.name LIKE\' => \'%' + value + '%\'';
	store_cmsAttachments.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshCmsAttachmentData() {
	store_cmsAttachments.reload();
}


if(center_panel.find('id', 'cmsAttachment-tab') != "") {
	var p = center_panel.findById('cmsAttachment-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Cms Attachments'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'cmsAttachment-tab',
		xtype: 'grid',
		store: store_cmsAttachments,
		columns: [
			{header: "<?php __('File'); ?>", dataIndex: 'file', sortable: true},
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('CmsReply'); ?>", dataIndex: 'cms_reply', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "CmsAttachments" : "CmsAttachment"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewCmsAttachment(Ext.getCmp('cmsAttachment-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add CmsAttachments</b><br />Click here to create a new CmsAttachment'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddCmsAttachment();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-cmsAttachment',
					tooltip:'<?php __('<b>Edit CmsAttachments</b><br />Click here to modify the selected CmsAttachment'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditCmsAttachment(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-cmsAttachment',
					tooltip:'<?php __('<b>Delete CmsAttachments(s)</b><br />Click here to remove the selected CmsAttachment(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove CmsAttachment'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteCmsAttachment(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove CmsAttachment'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected CmsAttachments'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteCmsAttachment(sel_ids);
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
					text: '<?php __('View CmsAttachment'); ?>',
					id: 'view-cmsAttachment',
					tooltip:'<?php __('<b>View CmsAttachment</b><br />Click here to see details of the selected CmsAttachment'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewCmsAttachment(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('CmsReply'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($cmsreplies as $item){if($st) echo ",
							";?>['<?php echo $item['CmsReply']['id']; ?>' ,'<?php echo $item['CmsReply']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_cmsAttachments.reload({
								params: {
									start: 0,
									limit: list_size,
									cmsreply_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'cmsAttachment_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByCmsAttachmentName(Ext.getCmp('cmsAttachment_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'cmsAttachment_go_button',
					handler: function(){
						SearchByCmsAttachmentName(Ext.getCmp('cmsAttachment_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchCmsAttachment();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_cmsAttachments,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-cmsAttachment').enable();
		p.getTopToolbar().findById('delete-cmsAttachment').enable();
		p.getTopToolbar().findById('view-cmsAttachment').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-cmsAttachment').disable();
			p.getTopToolbar().findById('view-cmsAttachment').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-cmsAttachment').disable();
			p.getTopToolbar().findById('view-cmsAttachment').disable();
			p.getTopToolbar().findById('delete-cmsAttachment').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-cmsAttachment').enable();
			p.getTopToolbar().findById('view-cmsAttachment').enable();
			p.getTopToolbar().findById('delete-cmsAttachment').enable();
		}
		else{
			p.getTopToolbar().findById('edit-cmsAttachment').disable();
			p.getTopToolbar().findById('view-cmsAttachment').disable();
			p.getTopToolbar().findById('delete-cmsAttachment').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_cmsAttachments.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
