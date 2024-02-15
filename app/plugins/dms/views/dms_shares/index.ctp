
var store_dmsShares = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','dms_document','branch','user','read','write','delete','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsShares', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'dms_document_id', direction: "ASC"},
	groupField: 'branch_id'
});


function AddDmsShare() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsShares', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var dmsShare_data = response.responseText;
			
			eval(dmsShare_data);
			
			DmsShareAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsShare add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditDmsShare(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsShares', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var dmsShare_data = response.responseText;
			
			eval(dmsShare_data);
			
			DmsShareEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsShare edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewDmsShare(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'dmsShares', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var dmsShare_data = response.responseText;

            eval(dmsShare_data);

            DmsShareViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsShare view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteDmsShare(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsShares', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('DmsShare successfully deleted!'); ?>');
			RefreshDmsShareData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsShare add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchDmsShare(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsShares', 'action' => 'search')); ?>',
		success: function(response, opts){
			var dmsShare_data = response.responseText;

			eval(dmsShare_data);

			dmsShareSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the dmsShare search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByDmsShareName(value){
	var conditions = '\'DmsShare.name LIKE\' => \'%' + value + '%\'';
	store_dmsShares.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshDmsShareData() {
	store_dmsShares.reload();
}


if(center_panel.find('id', 'dmsShare-tab') != "") {
	var p = center_panel.findById('dmsShare-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Dms Shares'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'dmsShare-tab',
		xtype: 'grid',
		store: store_dmsShares,
		columns: [
			{header: "<?php __('DmsDocument'); ?>", dataIndex: 'dms_document', sortable: true},
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('User'); ?>", dataIndex: 'user', sortable: true},
			{header: "<?php __('Read'); ?>", dataIndex: 'read', sortable: true},
			{header: "<?php __('Write'); ?>", dataIndex: 'write', sortable: true},
			{header: "<?php __('Delete'); ?>", dataIndex: 'delete', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "DmsShares" : "DmsShare"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewDmsShare(Ext.getCmp('dmsShare-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add DmsShares</b><br />Click here to create a new DmsShare'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddDmsShare();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-dmsShare',
					tooltip:'<?php __('<b>Edit DmsShares</b><br />Click here to modify the selected DmsShare'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditDmsShare(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-dmsShare',
					tooltip:'<?php __('<b>Delete DmsShares(s)</b><br />Click here to remove the selected DmsShare(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove DmsShare'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteDmsShare(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove DmsShare'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected DmsShares'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteDmsShare(sel_ids);
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
					text: '<?php __('View DmsShare'); ?>',
					id: 'view-dmsShare',
					tooltip:'<?php __('<b>View DmsShare</b><br />Click here to see details of the selected DmsShare'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewDmsShare(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('DmsDocument'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($dmsdocuments as $item){if($st) echo ",
							";?>['<?php echo $item['DmsDocument']['id']; ?>' ,'<?php echo $item['DmsDocument']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_dmsShares.reload({
								params: {
									start: 0,
									limit: list_size,
									dmsdocument_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'dmsShare_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByDmsShareName(Ext.getCmp('dmsShare_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'dmsShare_go_button',
					handler: function(){
						SearchByDmsShareName(Ext.getCmp('dmsShare_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchDmsShare();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_dmsShares,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-dmsShare').enable();
		p.getTopToolbar().findById('delete-dmsShare').enable();
		p.getTopToolbar().findById('view-dmsShare').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-dmsShare').disable();
			p.getTopToolbar().findById('view-dmsShare').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-dmsShare').disable();
			p.getTopToolbar().findById('view-dmsShare').disable();
			p.getTopToolbar().findById('delete-dmsShare').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-dmsShare').enable();
			p.getTopToolbar().findById('view-dmsShare').enable();
			p.getTopToolbar().findById('delete-dmsShare').enable();
		}
		else{
			p.getTopToolbar().findById('edit-dmsShare').disable();
			p.getTopToolbar().findById('view-dmsShare').disable();
			p.getTopToolbar().findById('delete-dmsShare').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_dmsShares.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
