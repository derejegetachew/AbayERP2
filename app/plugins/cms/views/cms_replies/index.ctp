
var store_cmsReplies = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','content','cms_case','user','created'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsReplies', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'content', direction: "ASC"},
	groupField: 'cms_case_id'
});


function AddCmsReply() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsReplies', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var cmsReply_data = response.responseText;
			
			eval(cmsReply_data);
			
			CmsReplyAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsReply add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditCmsReply(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsReplies', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var cmsReply_data = response.responseText;
			
			eval(cmsReply_data);
			
			CmsReplyEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsReply edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCmsReply(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'cmsReplies', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var cmsReply_data = response.responseText;

            eval(cmsReply_data);

            CmsReplyViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsReply view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentCmsAttachments(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'cmsAttachments', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_cmsAttachments_data = response.responseText;

            eval(parent_cmsAttachments_data);

            parentCmsAttachmentsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteCmsReply(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsReplies', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CmsReply successfully deleted!'); ?>');
			RefreshCmsReplyData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the cmsReply add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchCmsReply(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'cmsReplies', 'action' => 'search')); ?>',
		success: function(response, opts){
			var cmsReply_data = response.responseText;

			eval(cmsReply_data);

			cmsReplySearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the cmsReply search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByCmsReplyName(value){
	var conditions = '\'CmsReply.name LIKE\' => \'%' + value + '%\'';
	store_cmsReplies.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshCmsReplyData() {
	store_cmsReplies.reload();
}


if(center_panel.find('id', 'cmsReply-tab') != "") {
	var p = center_panel.findById('cmsReply-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Cms Replies'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'cmsReply-tab',
		xtype: 'grid',
		store: store_cmsReplies,
		columns: [
			{header: "<?php __('Content'); ?>", dataIndex: 'content', sortable: true},
			{header: "<?php __('CmsCase'); ?>", dataIndex: 'cms_case', sortable: true},
			{header: "<?php __('User'); ?>", dataIndex: 'user', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "CmsReplies" : "CmsReply"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewCmsReply(Ext.getCmp('cmsReply-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add CmsReplies</b><br />Click here to create a new CmsReply'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddCmsReply();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-cmsReply',
					tooltip:'<?php __('<b>Edit CmsReplies</b><br />Click here to modify the selected CmsReply'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditCmsReply(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-cmsReply',
					tooltip:'<?php __('<b>Delete CmsReplies(s)</b><br />Click here to remove the selected CmsReply(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove CmsReply'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteCmsReply(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove CmsReply'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected CmsReplies'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteCmsReply(sel_ids);
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
					text: '<?php __('View CmsReply'); ?>',
					id: 'view-cmsReply',
					tooltip:'<?php __('<b>View CmsReply</b><br />Click here to see details of the selected CmsReply'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewCmsReply(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Cms Attachments'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentCmsAttachments(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '<?php __('CmsCase'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($cmscases as $item){if($st) echo ",
							";?>['<?php echo $item['CmsCase']['id']; ?>' ,'<?php echo $item['CmsCase']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_cmsReplies.reload({
								params: {
									start: 0,
									limit: list_size,
									cmscase_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'cmsReply_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByCmsReplyName(Ext.getCmp('cmsReply_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'cmsReply_go_button',
					handler: function(){
						SearchByCmsReplyName(Ext.getCmp('cmsReply_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchCmsReply();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_cmsReplies,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-cmsReply').enable();
		p.getTopToolbar().findById('delete-cmsReply').enable();
		p.getTopToolbar().findById('view-cmsReply').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-cmsReply').disable();
			p.getTopToolbar().findById('view-cmsReply').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-cmsReply').disable();
			p.getTopToolbar().findById('view-cmsReply').disable();
			p.getTopToolbar().findById('delete-cmsReply').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-cmsReply').enable();
			p.getTopToolbar().findById('view-cmsReply').enable();
			p.getTopToolbar().findById('delete-cmsReply').enable();
		}
		else{
			p.getTopToolbar().findById('edit-cmsReply').disable();
			p.getTopToolbar().findById('view-cmsReply').disable();
			p.getTopToolbar().findById('delete-cmsReply').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_cmsReplies.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
