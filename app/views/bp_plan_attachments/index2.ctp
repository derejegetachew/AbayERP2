var store_parent_bpPlanAttachments = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','file_name','path','created','modified','original'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanAttachments', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentBpPlanAttachment() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanAttachments', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_bpPlanAttachment_data = response.responseText;
			
			eval(parent_bpPlanAttachment_data);
			
			DmsAttachmentAddWindow.show();
			//BpPlanAttachmentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanAttachment add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentBpPlanAttachment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanAttachments', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_bpPlanAttachment_data = response.responseText;
			
			eval(parent_bpPlanAttachment_data);
			
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


function DeleteParentBpPlanAttachment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanAttachments', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BpPlanAttachment(s) successfully deleted!'); ?>');
			RefreshParentBpPlanAttachmentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanAttachment to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentBpPlanAttachmentName(value){
	var conditions = '\'BpPlanAttachment.name LIKE\' => \'%' + value + '%\'';
	store_parent_bpPlanAttachments.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentBpPlanAttachmentData() {
	store_parent_bpPlanAttachments.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('BpPlanAttachments'); ?>',
	store: store_parent_bpPlanAttachments,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'bpPlanAttachmentGrid',
	columns: [
		
		{header: "<?php __('File Name'); ?>", dataIndex: 'file_name', sortable: true},
		{header: "<?php __('Original File'); ?>", dataIndex: 'original', sortable: true},
		{header: "<?php __('Path'); ?>", dataIndex: 'path', sortable: true,hidden:true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
		{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true,hidden:true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewBpPlanAttachment(Ext.getCmp('bpPlanAttachmentGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Upload'); ?>',
				tooltip:'<?php __('<b>Add BpPlanAttachment</b><br />Click here to create a new BpPlanAttachment'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentBpPlanAttachment();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-bpPlanAttachment',
				tooltip:'<?php __('<b>Edit BpPlanAttachment</b><br />Click here to modify the selected BpPlanAttachment'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentBpPlanAttachment(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-bpPlanAttachment',
				tooltip:'<?php __('<b>Delete BpPlanAttachment(s)</b><br />Click here to remove the selected BpPlanAttachment(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove BpPlanAttachment'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentBpPlanAttachment(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove BpPlanAttachment'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected BpPlanAttachment'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentBpPlanAttachment(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_bpPlanAttachments,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-bpPlanAttachment').enable();
	g.getTopToolbar().findById('delete-parent-bpPlanAttachment').enable();
        g.getTopToolbar().findById('view-bpPlanAttachment2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-bpPlanAttachment').disable();
                g.getTopToolbar().findById('view-bpPlanAttachment2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-bpPlanAttachment').disable();
		g.getTopToolbar().findById('delete-parent-bpPlanAttachment').enable();
                g.getTopToolbar().findById('view-bpPlanAttachment2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-bpPlanAttachment').enable();
		g.getTopToolbar().findById('delete-parent-bpPlanAttachment').enable();
                g.getTopToolbar().findById('view-bpPlanAttachment2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-bpPlanAttachment').disable();
		g.getTopToolbar().findById('delete-parent-bpPlanAttachment').disable();
                g.getTopToolbar().findById('view-bpPlanAttachment2').disable();
	}
});



var parentBpPlanAttachmentsViewWindow = new Ext.Window({
	title: 'BpPlanAttachment Under the selected Item',
	width: 700,
	height:375,
	minWidth: 700,
	minHeight: 400,
	resizable: false,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'center',
        modal: true,
	items: [
		g
	],

	buttons: [{
		text: 'Finishe',
		handler: function(btn){
			parentBpPlanAttachmentsViewWindow.close();
		}
	}]
});

store_parent_bpPlanAttachments.load({
    params: {
        start: 0,    
        limit: list_size
    }
});