
var store_bpPlanAttachments = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','plan','file_name','path','created','modified','original'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanAttachments', 'action' => 'list_data',$parent_id)); ?>'
	})
,	sortInfo:{field: 'plan_id', direction: "ASC"},
	groupField: 'file_name'
});


function AddBpPlanAttachment() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanAttachments', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var bpPlanAttachment_data = response.responseText;
			
			eval(bpPlanAttachment_data);
			
			BpPlanAttachmentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanAttachment add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditBpPlanAttachment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanAttachments', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var bpPlanAttachment_data = response.responseText;
			
			eval(bpPlanAttachment_data);
			
			BpPlanAttachmentEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanAttachment edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBpPlanAttachment(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'bpPlanAttachments', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var bpPlanAttachment_data = response.responseText;

            eval(bpPlanAttachment_data);

            BpPlanAttachmentViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanAttachment view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteBpPlanAttachment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanAttachments', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BpPlanAttachment successfully deleted!'); ?>');
			RefreshBpPlanAttachmentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanAttachment add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchBpPlanAttachment(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanAttachments', 'action' => 'search')); ?>',
		success: function(response, opts){
			var bpPlanAttachment_data = response.responseText;

			eval(bpPlanAttachment_data);

			bpPlanAttachmentSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the bpPlanAttachment search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByBpPlanAttachmentName(value){
	var conditions = '\'BpPlanAttachment.name LIKE\' => \'%' + value + '%\'';
	store_bpPlanAttachments.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshBpPlanAttachmentData() {
	store_bpPlanAttachments.reload();
}


if(center_panel.find('id', 'bpPlanAttachment-tab') != "") {
	var p = center_panel.findById('bpPlanAttachment-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Bp Plan Attachments'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'bpPlanAttachment-tab',
		xtype: 'grid',
		store: store_bpPlanAttachments,
		columns: [
			{header: "<?php __('Plan'); ?>", dataIndex: 'plan', sortable: true},
			{header: "<?php __('File Name'); ?>", dataIndex: 'file_name', sortable: true},
			{header: "<?php __('Path'); ?>", dataIndex: 'path', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true},
			{header: "<?php __('original'); ?>", dataIndex: 'original', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "BpPlanAttachments" : "BpPlanAttachment"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewBpPlanAttachment(Ext.getCmp('bpPlanAttachment-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add BpPlanAttachments</b><br />Click here to create a new BpPlanAttachment'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddBpPlanAttachment();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-bpPlanAttachment',
					tooltip:'<?php __('<b>Edit BpPlanAttachments</b><br />Click here to modify the selected BpPlanAttachment'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditBpPlanAttachment(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-bpPlanAttachment',
					tooltip:'<?php __('<b>Delete BpPlanAttachments(s)</b><br />Click here to remove the selected BpPlanAttachment(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove BpPlanAttachment'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteBpPlanAttachment(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove BpPlanAttachment'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected BpPlanAttachments'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteBpPlanAttachment(sel_ids);
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
					text: '<?php __('View BpPlanAttachment'); ?>',
					id: 'view-bpPlanAttachment',
					tooltip:'<?php __('<b>View BpPlanAttachment</b><br />Click here to see details of the selected BpPlanAttachment'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewBpPlanAttachment(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Plan'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($plans as $item){if($st) echo ",
							";?>['<?php echo $item['Plan']['id']; ?>' ,'<?php echo $item['Plan']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_bpPlanAttachments.reload({
								params: {
									start: 0,
									limit: list_size,
									plan_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'bpPlanAttachment_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByBpPlanAttachmentName(Ext.getCmp('bpPlanAttachment_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'bpPlanAttachment_go_button',
					handler: function(){
						SearchByBpPlanAttachmentName(Ext.getCmp('bpPlanAttachment_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchBpPlanAttachment();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_bpPlanAttachments,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-bpPlanAttachment').enable();
		p.getTopToolbar().findById('delete-bpPlanAttachment').enable();
		p.getTopToolbar().findById('view-bpPlanAttachment').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-bpPlanAttachment').disable();
			p.getTopToolbar().findById('view-bpPlanAttachment').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-bpPlanAttachment').disable();
			p.getTopToolbar().findById('view-bpPlanAttachment').disable();
			p.getTopToolbar().findById('delete-bpPlanAttachment').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-bpPlanAttachment').enable();
			p.getTopToolbar().findById('view-bpPlanAttachment').enable();
			p.getTopToolbar().findById('delete-bpPlanAttachment').enable();
		}
		else{
			p.getTopToolbar().findById('edit-bpPlanAttachment').disable();
			p.getTopToolbar().findById('view-bpPlanAttachment').disable();
			p.getTopToolbar().findById('delete-bpPlanAttachment').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_bpPlanAttachments.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
