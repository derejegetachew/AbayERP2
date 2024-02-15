var store_parent_frwfmDocuments = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','frwfm_application','name','file_path','created'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmDocuments', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentFrwfmDocument() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmDocuments', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_frwfmDocument_data = response.responseText;
			
			eval(parent_frwfmDocument_data);
			
			FrwfmDocumentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmDocument add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentFrwfmDocument(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmDocuments', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_frwfmDocument_data = response.responseText;
			
			eval(parent_frwfmDocument_data);
			
			FrwfmDocumentEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmDocument edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFrwfmDocument(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmDocuments', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var frwfmDocument_data = response.responseText;

			eval(frwfmDocument_data);

			FrwfmDocumentViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmDocument view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentFrwfmDocument(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmDocuments', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FrwfmDocument(s) successfully deleted!'); ?>');
			RefreshParentFrwfmDocumentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmDocument to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentFrwfmDocumentName(value){
	var conditions = '\'FrwfmDocument.name LIKE\' => \'%' + value + '%\'';
	store_parent_frwfmDocuments.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentFrwfmDocumentData() {
	store_parent_frwfmDocuments.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __(''); ?>',
	store: store_parent_frwfmDocuments,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'frwfmDocumentGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewFrwfmDocument(Ext.getCmp('frwfmDocumentGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Upload'); ?>',
				tooltip:'<?php __('<b>Add FrwfmDocument</b><br />Click here to create a new FrwfmDocument'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentFrwfmDocument();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-frwfmDocument',
				tooltip:'<?php __('<b>Delete FrwfmDocument(s)</b><br />Click here to remove the selected FrwfmDocument(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove FrwfmDocument'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentFrwfmDocument(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove FrwfmDocument'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected FrwfmDocument'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentFrwfmDocument(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			}
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_frwfmDocuments,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('delete-parent-frwfmDocument').enable();
	if(this.getSelections().length > 1){
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('delete-parent-frwfmDocument').enable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('delete-parent-frwfmDocument').enable();
	}
	else{
		g.getTopToolbar().findById('delete-parent-frwfmDocument').disable();
	}
});



var parentFrwfmDocumentsViewWindow = new Ext.Window({
	title: 'Attachments',
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
		text: 'Close',
		handler: function(btn){
			parentFrwfmDocumentsViewWindow.close();
		}
	}]
});

store_parent_frwfmDocuments.load({
    params: {
        start: 0,    
        limit: list_size
    }
});