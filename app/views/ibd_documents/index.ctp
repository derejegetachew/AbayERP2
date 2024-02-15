
var store_ibdDocuments = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','description','controller','action','doc_type','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdDocuments', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
   groupField: 'doc_type'
});


function AddIbdDocument() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdDocuments', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var ibdDocument_data = response.responseText;
			
			eval(ibdDocument_data);
			
			IbdDocumentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdDocument add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditIbdDocument(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdDocuments', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var ibdDocument_data = response.responseText;
			
			eval(ibdDocument_data);
			
			IbdDocumentEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdDocument edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewIbdDocument(controller,action) {
	
    Ext.Ajax.request({

    	
        url: '<?php echo $this->Html->url(array('controller' => '', 'action' => '')); ?>/'+controller+'/'+action,
        success: function(response, opts) {
            var ibdDocument_data = response.responseText;

            eval(ibdDocument_data);


            IbdDocumentViewWindow.show();

			alert(document.getElementById("REMARK"));
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdDocument view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteIbdDocument(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdDocuments', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('IbdDocument successfully deleted!'); ?>');
			RefreshIbdDocumentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdDocument add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchIbdDocument(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdDocuments', 'action' => 'search')); ?>',
		success: function(response, opts){
			var ibdDocument_data = response.responseText;

			eval(ibdDocument_data);

			ibdDocumentSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the ibdDocument search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByIbdDocumentName(value){
	var conditions = '\'IbdDocument.name LIKE\' => \'%' + value + '%\'';
	store_ibdDocuments.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshIbdDocumentData() {
	store_ibdDocuments.reload();
}

function ShowBanks(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdBanks', 'action' => 'index')); ?>',
		success: function(response, opts){
			var ibdDocument_data = response.responseText;

			eval(ibdDocument_data);

			ibdDocument_data.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the ibdDocument search form. Error Code'); ?>: ' + response.status);
		}
	});
}


if(center_panel.find('id', 'ibdDocument-tab') != "") {
	var p = center_panel.findById('ibdDocument-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Import Registration'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'ibdDocument-tab',
		xtype: 'grid',
		store: store_ibdDocuments,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Description'); ?>", dataIndex: 'description', sortable: true},
			{header: "<?php __('Type'); ?>", dataIndex: 'doc_type', sortable: true},
			//{header: "<?php __('Controller'); ?>", dataIndex: 'controller', sortable: true},
			//{header: "<?php __('Action'); ?>", dataIndex: 'action', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Documents" : "Document"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewIbdDocument(Ext.getCmp('ibdDocument-tab').getSelectionModel().getSelected().data.controller,Ext.getCmp('ibdDocument-tab').getSelectionModel().getSelected().data.action);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add IbdDocuments</b><br />Click here to create a new IbdDocument'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddIbdDocument();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-ibdDocument',
					tooltip:'<?php __('<b>Edit IbdDocuments</b><br />Click here to modify the selected IbdDocument'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditIbdDocument(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-ibdDocument',
					tooltip:'<?php __('<b>Delete IbdDocuments(s)</b><br />Click here to remove the selected IbdDocument(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove IbdDocument'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteIbdDocument(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove IbdDocument'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected IbdDocuments'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteIbdDocument(sel_ids);
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
					text: '<?php __('View IbdDocument'); ?>',
					id: 'view-ibdDocument',
					tooltip:'<?php __('<b>View IbdDocument</b><br />Click here to see details of the selected IbdDocument'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewIbdDocument(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-', '', {
					xtype: 'tbbutton',
					text: '<?php __('Banks'); ?>',
					id: 'Banks-ibdDocument',
					tooltip:'<?php __('<b>Edit IbdDocuments</b><br />Click here to modify the selected IbdDocument'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						ShowBanks();
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'ibdDocument_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByIbdDocumentName(Ext.getCmp('ibdDocument_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'ibdDocument_go_button',
					handler: function(){
						SearchByIbdDocumentName(Ext.getCmp('ibdDocument_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchIbdDocument();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_ibdDocuments,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-ibdDocument').enable();
		p.getTopToolbar().findById('delete-ibdDocument').enable();
		p.getTopToolbar().findById('view-ibdDocument').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdDocument').disable();
			p.getTopToolbar().findById('view-ibdDocument').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdDocument').disable();
			p.getTopToolbar().findById('view-ibdDocument').disable();
			p.getTopToolbar().findById('delete-ibdDocument').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-ibdDocument').enable();
			p.getTopToolbar().findById('view-ibdDocument').enable();
			p.getTopToolbar().findById('delete-ibdDocument').enable();
		}
		else{
			p.getTopToolbar().findById('edit-ibdDocument').disable();
			p.getTopToolbar().findById('view-ibdDocument').disable();
			p.getTopToolbar().findById('delete-ibdDocument').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_ibdDocuments.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
