
var store_fmsFuels = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','fms_vehicle','fueled_day','litre','price','kilometer','driver','round','status','created_by','approved_by','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsFuels', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'fms_vehicle', direction: "ASC"},
	groupField: 'fueled_day'
});


function AddFmsFuel() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsFuels', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var fmsFuel_data = response.responseText;
			
			eval(fmsFuel_data);
			
			FmsFuelAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Fuel add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditFmsFuel(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsFuels', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var fmsFuel_data = response.responseText;
			
			eval(fmsFuel_data);
			
			FmsFuelEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Fuel edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFmsFuel(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'fmsFuels', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var fmsFuel_data = response.responseText;

            eval(fmsFuel_data);

            FmsFuelViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Fuel view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteFmsFuel(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsFuels', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Fuel successfully deleted!'); ?>');
			RefreshFmsFuelData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Fuel add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchFmsFuel(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsFuels', 'action' => 'search')); ?>',
		success: function(response, opts){
			var fmsFuel_data = response.responseText;

			eval(fmsFuel_data);

			fmsFuelSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the Fuel search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByFmsFuelName(value){
	var conditions = '\'FmsFuel.name LIKE\' => \'%' + value + '%\'';
	store_fmsFuels.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshFmsFuelData() {
	store_fmsFuels.reload();
}

function PostFuel(id) {
		Ext.Ajax.request({
				url: '<?php echo $this->Html->url(array('controller' => 'fms_fuels', 'action' => 'post')); ?>/'+id,
				success: function(response, opts) {
					Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Fuel data successfully posted!'); ?>');
					RefreshFmsFuelData();
				},
				failure: function(response, opts) {
					Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot post the Fuel data. Error code'); ?>: ' + response.status);
				}
		});
    }


if(center_panel.find('id', 'fmsFuel-tab') != "") {
	var p = center_panel.findById('fmsFuel-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Fuels'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'fmsFuel-tab',
		xtype: 'grid',
		store: store_fmsFuels,
		columns: [
			{header: "<?php __('Vehicle'); ?>", dataIndex: 'fms_vehicle', sortable: true},
			{header: "<?php __('Fueled Day'); ?>", dataIndex: 'fueled_day', sortable: true},
			{header: "<?php __('Litre'); ?>", dataIndex: 'litre', sortable: true},
			{header: "<?php __('Price'); ?>", dataIndex: 'price', sortable: true},
			{header: "<?php __('Kilometer'); ?>", dataIndex: 'kilometer', sortable: true},
			{header: "<?php __('Driver'); ?>", dataIndex: 'driver', sortable: true},
			{header: "<?php __('Round'); ?>", dataIndex: 'round', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
			{header: "<?php __('Created By'); ?>", dataIndex: 'created_by', sortable: true},
			{header: "<?php __('Approved By'); ?>", dataIndex: 'approved_by', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "FmsFuels" : "FmsFuel"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewFmsFuel(Ext.getCmp('fmsFuel-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Fuels</b><br />Click here to create a new Fuel'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddFmsFuel();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-fmsFuel',
					tooltip:'<?php __('<b>Edit Fuels</b><br />Click here to modify the selected Fuel'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditFmsFuel(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-fmsFuel',
					tooltip:'<?php __('<b>Delete Fuels(s)</b><br />Click here to remove the selected Fuel(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Fuel'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.fms_vehicle+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteFmsFuel(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Fuel'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Fuels'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteFmsFuel(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Post'); ?>',
					id: 'post-fmsFuel',
					tooltip:'<?php __('<b>Post Fuel data</b><br />Click here to post the selected Fuel data'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							PostFuel(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View Fuel'); ?>',
					id: 'view-fmsFuel',
					tooltip:'<?php __('<b>View Fuel</b><br />Click here to see details of the selected Fuel'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewFmsFuel(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Vehicle'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($fms_vehicles as $item){if($st) echo ",
							";?>['<?php echo $item['FmsVehicle']['id']; ?>' ,'<?php echo $item['FmsVehicle']['plate_no']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_fmsFuels.reload({
								params: {
									start: 0,
									limit: list_size,
									fmsvehicle_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'fmsFuel_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByFmsFuelName(Ext.getCmp('fmsFuel_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'fmsFuel_go_button',
					handler: function(){
						SearchByFmsFuelName(Ext.getCmp('fmsFuel_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchFmsFuel();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_fmsFuels,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		if(this.getSelections()[0].data.status == 'created'){
			p.getTopToolbar().findById('edit-fmsFuel').enable();
			p.getTopToolbar().findById('delete-fmsFuel').enable();
			p.getTopToolbar().findById('post-fmsFuel').enable();
		}
		p.getTopToolbar().findById('view-fmsFuel').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-fmsFuel').disable();
			p.getTopToolbar().findById('view-fmsFuel').disable();
			p.getTopToolbar().findById('post-fmsFuel').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-fmsFuel').disable();
			p.getTopToolbar().findById('view-fmsFuel').disable();
			p.getTopToolbar().findById('delete-fmsFuel').enable();
			p.getTopToolbar().findById('post-fmsFuel').disable();
		}
		else if(this.getSelections().length == 1){
			if(this.getSelections()[0].data.status == 'created'){
				p.getTopToolbar().findById('edit-fmsFuel').enable();				
				p.getTopToolbar().findById('delete-fmsFuel').enable();
				p.getTopToolbar().findById('post-fmsFuel').enable();
			}
			p.getTopToolbar().findById('view-fmsFuel').enable();
		}
		else{
			p.getTopToolbar().findById('edit-fmsFuel').disable();
			p.getTopToolbar().findById('view-fmsFuel').disable();
			p.getTopToolbar().findById('delete-fmsFuel').disable();
			p.getTopToolbar().findById('post-fmsFuel').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_fmsFuels.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
