
var store_fmsDrivers = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','person','license_no','date_given','expiration_date','created_by','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivers', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'person', direction: "ASC"}
});


function AddFmsDriver() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivers', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var fmsDriver_data = response.responseText;
			
			eval(fmsDriver_data);
			
			FmsDriverAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Driver add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditFmsDriver(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivers', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var fmsDriver_data = response.responseText;
			
			eval(fmsDriver_data);
			
			FmsDriverEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Driver edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFmsDriver(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivers', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var fmsDriver_data = response.responseText;

            eval(fmsDriver_data);

            FmsDriverViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Driver view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteFmsDriver(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivers', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Driver successfully deleted!'); ?>');
			RefreshFmsDriverData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Driver add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchFmsDriver(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsDrivers', 'action' => 'search')); ?>',
		success: function(response, opts){
			var fmsDriver_data = response.responseText;

			eval(fmsDriver_data);

			fmsDriverSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the Driver search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByFmsDriverName(value){
	var conditions = '\'FmsDriver.name LIKE\' => \'%' + value + '%\'';
	store_fmsDrivers.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshFmsDriverData() {
	store_fmsDrivers.reload();
}


if(center_panel.find('id', 'fmsDriver-tab') != "") {
	var p = center_panel.findById('fmsDriver-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Drivers'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'fmsDriver-tab',
		xtype: 'grid',
		store: store_fmsDrivers,
		columns: [
			{header: "<?php __('Person'); ?>", dataIndex: 'person', sortable: true},
			{header: "<?php __('License No'); ?>", dataIndex: 'license_no', sortable: true},
			{header: "<?php __('Date Given'); ?>", dataIndex: 'date_given', sortable: true},
			{header: "<?php __('Expiration Date'); ?>", dataIndex: 'expiration_date', sortable: true},
			{header: "<?php __('Created By'); ?>", dataIndex: 'created_by', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "FmsDrivers" : "FmsDriver"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewFmsDriver(Ext.getCmp('fmsDriver-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Drivers</b><br />Click here to create a new Driver'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddFmsDriver();
					}
				}/*, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-fmsDriver',
					tooltip:'<?php __('<b>Edit Drivers</b><br />Click here to modify the selected Driver'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditFmsDriver(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-fmsDriver',
					tooltip:'<?php __('<b>Delete Drivers(s)</b><br />Click here to remove the selected Driver(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Driver'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteFmsDriver(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Driver'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Drivers'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteFmsDriver(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}*/, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View Driver'); ?>',
					id: 'view-fmsDriver',
					tooltip:'<?php __('<b>View Driver</b><br />Click here to see details of the selected Driver'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewFmsDriver(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}/*, ' ', '-',  '<?php __('Person'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($people as $item){if($st) echo ",
							";?>['<?php echo $item['Person']['id']; ?>' ,'<?php echo $item['Person']['first_name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_fmsDrivers.reload({
								params: {
									start: 0,
									limit: list_size,
									person_id : combo.getValue()
								}
							});
						}
					}
				}*/,
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'fmsDriver_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByFmsDriverName(Ext.getCmp('fmsDriver_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'fmsDriver_go_button',
					handler: function(){
						SearchByFmsDriverName(Ext.getCmp('fmsDriver_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchFmsDriver();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_fmsDrivers,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		//p.getTopToolbar().findById('edit-fmsDriver').enable();
		//p.getTopToolbar().findById('delete-fmsDriver').enable();
		p.getTopToolbar().findById('view-fmsDriver').enable();
		if(this.getSelections().length > 1){
			//p.getTopToolbar().findById('edit-fmsDriver').disable();
			p.getTopToolbar().findById('view-fmsDriver').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			//p.getTopToolbar().findById('edit-fmsDriver').disable();
			p.getTopToolbar().findById('view-fmsDriver').disable();
			//p.getTopToolbar().findById('delete-fmsDriver').enable();
		}
		else if(this.getSelections().length == 1){
			//p.getTopToolbar().findById('edit-fmsDriver').enable();
			p.getTopToolbar().findById('view-fmsDriver').enable();
			//p.getTopToolbar().findById('delete-fmsDriver').enable();
		}
		else{
			//p.getTopToolbar().findById('edit-fmsDriver').disable();
			p.getTopToolbar().findById('view-fmsDriver').disable();
			//p.getTopToolbar().findById('delete-fmsDriver').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_fmsDrivers.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
