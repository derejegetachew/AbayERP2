
var store_frwfmDocuments = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','frwfm_application','name','file_path','created'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmDocuments', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'frwfm_application_id', direction: "ASC"},
	groupField: 'name'
});


function AddFrwfmDocument() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmDocuments', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var frwfmDocument_data = response.responseText;
			
			eval(frwfmDocument_data);
			
			FrwfmDocumentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmDocument add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditFrwfmDocument(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmDocuments', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var frwfmDocument_data = response.responseText;
			
			eval(frwfmDocument_data);
			
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

function DeleteFrwfmDocument(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmDocuments', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FrwfmDocument successfully deleted!'); ?>');
			RefreshFrwfmDocumentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmDocument add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchFrwfmDocument(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmDocuments', 'action' => 'search')); ?>',
		success: function(response, opts){
			var frwfmDocument_data = response.responseText;

			eval(frwfmDocument_data);

			frwfmDocumentSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the frwfmDocument search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByFrwfmDocumentName(value){
	var conditions = '\'FrwfmDocument.name LIKE\' => \'%' + value + '%\'';
	store_frwfmDocuments.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshFrwfmDocumentData() {
	store_frwfmDocuments.reload();
}


if(center_panel.find('id', 'frwfmDocument-tab') != "") {
	var p = center_panel.findById('frwfmDocument-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Frwfm Documents'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'frwfmDocument-tab',
		xtype: 'grid',
		store: store_frwfmDocuments,
		columns: [
			{header: "<?php __('FrwfmApplication'); ?>", dataIndex: 'frwfm_application', sortable: true},
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('File Path'); ?>", dataIndex: 'file_path', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "FrwfmDocuments" : "FrwfmDocument"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewFrwfmDocument(Ext.getCmp('frwfmDocument-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add FrwfmDocuments</b><br />Click here to create a new FrwfmDocument'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddFrwfmDocument();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-frwfmDocument',
					tooltip:'<?php __('<b>Edit FrwfmDocuments</b><br />Click here to modify the selected FrwfmDocument'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditFrwfmDocument(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-frwfmDocument',
					tooltip:'<?php __('<b>Delete FrwfmDocuments(s)</b><br />Click here to remove the selected FrwfmDocument(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove FrwfmDocument'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteFrwfmDocument(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove FrwfmDocument'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected FrwfmDocuments'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteFrwfmDocument(sel_ids);
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
					text: '<?php __('View FrwfmDocument'); ?>',
					id: 'view-frwfmDocument',
					tooltip:'<?php __('<b>View FrwfmDocument</b><br />Click here to see details of the selected FrwfmDocument'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewFrwfmDocument(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('FrwfmApplication'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($frwfmapplications as $item){if($st) echo ",
							";?>['<?php echo $item['FrwfmApplication']['id']; ?>' ,'<?php echo $item['FrwfmApplication']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_frwfmDocuments.reload({
								params: {
									start: 0,
									limit: list_size,
									frwfmapplication_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'frwfmDocument_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByFrwfmDocumentName(Ext.getCmp('frwfmDocument_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'frwfmDocument_go_button',
					handler: function(){
						SearchByFrwfmDocumentName(Ext.getCmp('frwfmDocument_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchFrwfmDocument();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_frwfmDocuments,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-frwfmDocument').enable();
		p.getTopToolbar().findById('delete-frwfmDocument').enable();
		p.getTopToolbar().findById('view-frwfmDocument').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-frwfmDocument').disable();
			p.getTopToolbar().findById('view-frwfmDocument').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-frwfmDocument').disable();
			p.getTopToolbar().findById('view-frwfmDocument').disable();
			p.getTopToolbar().findById('delete-frwfmDocument').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-frwfmDocument').enable();
			p.getTopToolbar().findById('view-frwfmDocument').enable();
			p.getTopToolbar().findById('delete-frwfmDocument').enable();
		}
		else{
			p.getTopToolbar().findById('edit-frwfmDocument').disable();
			p.getTopToolbar().findById('view-frwfmDocument').disable();
			p.getTopToolbar().findById('delete-frwfmDocument').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_frwfmDocuments.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
