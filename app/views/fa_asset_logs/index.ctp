
var store_faAssetLogs = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','fa_asset','branch_name','branch_code','tax_rate','tax_cat','class','ifrs_cat','useful_age','residual_value','created_at'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'faAssetLogs', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'fa_asset_id', direction: "ASC"},
	groupField: 'branch_name'
});


function AddFaAssetLog() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faAssetLogs', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var faAssetLog_data = response.responseText;
			
			eval(faAssetLog_data);
			
			FaAssetLogAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faAssetLog add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditFaAssetLog(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faAssetLogs', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var faAssetLog_data = response.responseText;
			
			eval(faAssetLog_data);
			
			FaAssetLogEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faAssetLog edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFaAssetLog(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'faAssetLogs', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var faAssetLog_data = response.responseText;

            eval(faAssetLog_data);

            FaAssetLogViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faAssetLog view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteFaAssetLog(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faAssetLogs', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FaAssetLog successfully deleted!'); ?>');
			RefreshFaAssetLogData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faAssetLog add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchFaAssetLog(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faAssetLogs', 'action' => 'search')); ?>',
		success: function(response, opts){
			var faAssetLog_data = response.responseText;

			eval(faAssetLog_data);

			faAssetLogSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the faAssetLog search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByFaAssetLogName(value){
	var conditions = '\'FaAssetLog.name LIKE\' => \'%' + value + '%\'';
	store_faAssetLogs.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshFaAssetLogData() {
	store_faAssetLogs.reload();
}


if(center_panel.find('id', 'faAssetLog-tab') != "") {
	var p = center_panel.findById('faAssetLog-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Fa Asset Logs'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'faAssetLog-tab',
		xtype: 'grid',
		store: store_faAssetLogs,
		columns: [
			{header: "<?php __('FaAsset'); ?>", dataIndex: 'fa_asset', sortable: true},
			{header: "<?php __('Branch Name'); ?>", dataIndex: 'branch_name', sortable: true},
			{header: "<?php __('Branch Code'); ?>", dataIndex: 'branch_code', sortable: true},
			{header: "<?php __('Tax Rate'); ?>", dataIndex: 'tax_rate', sortable: true},
			{header: "<?php __('Tax Cat'); ?>", dataIndex: 'tax_cat', sortable: true},
			{header: "<?php __('Class'); ?>", dataIndex: 'class', sortable: true},
			{header: "<?php __('Ifrs Cat'); ?>", dataIndex: 'ifrs_cat', sortable: true},
			{header: "<?php __('Useful Age'); ?>", dataIndex: 'useful_age', sortable: true},
			{header: "<?php __('Residual Value'); ?>", dataIndex: 'residual_value', sortable: true},
			{header: "<?php __('Created At'); ?>", dataIndex: 'created_at', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "FaAssetLogs" : "FaAssetLog"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewFaAssetLog(Ext.getCmp('faAssetLog-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add FaAssetLogs</b><br />Click here to create a new FaAssetLog'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddFaAssetLog();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-faAssetLog',
					tooltip:'<?php __('<b>Edit FaAssetLogs</b><br />Click here to modify the selected FaAssetLog'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditFaAssetLog(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-faAssetLog',
					tooltip:'<?php __('<b>Delete FaAssetLogs(s)</b><br />Click here to remove the selected FaAssetLog(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove FaAssetLog'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteFaAssetLog(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove FaAssetLog'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected FaAssetLogs'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteFaAssetLog(sel_ids);
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
					text: '<?php __('View FaAssetLog'); ?>',
					id: 'view-faAssetLog',
					tooltip:'<?php __('<b>View FaAssetLog</b><br />Click here to see details of the selected FaAssetLog'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewFaAssetLog(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('FaAsset'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($faassets as $item){if($st) echo ",
							";?>['<?php echo $item['FaAsset']['id']; ?>' ,'<?php echo $item['FaAsset']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_faAssetLogs.reload({
								params: {
									start: 0,
									limit: list_size,
									faasset_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'faAssetLog_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByFaAssetLogName(Ext.getCmp('faAssetLog_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'faAssetLog_go_button',
					handler: function(){
						SearchByFaAssetLogName(Ext.getCmp('faAssetLog_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchFaAssetLog();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_faAssetLogs,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-faAssetLog').enable();
		p.getTopToolbar().findById('delete-faAssetLog').enable();
		p.getTopToolbar().findById('view-faAssetLog').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-faAssetLog').disable();
			p.getTopToolbar().findById('view-faAssetLog').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-faAssetLog').disable();
			p.getTopToolbar().findById('view-faAssetLog').disable();
			p.getTopToolbar().findById('delete-faAssetLog').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-faAssetLog').enable();
			p.getTopToolbar().findById('view-faAssetLog').enable();
			p.getTopToolbar().findById('delete-faAssetLog').enable();
		}
		else{
			p.getTopToolbar().findById('edit-faAssetLog').disable();
			p.getTopToolbar().findById('view-faAssetLog').disable();
			p.getTopToolbar().findById('delete-faAssetLog').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_faAssetLogs.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
