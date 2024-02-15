
var store_fmsVehicles = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','vehicle_type','plate_no','model','engine_no','chassis_no','fuel_type','no_of_tyre','horsepower','carload_people','carload_goods','purchase_amount','purchase_date','remark','created_by','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsVehicles', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'plate_no', direction: "ASC"}
});


function AddFmsVehicle() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsVehicles', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var fmsVehicle_data = response.responseText;
			
			eval(fmsVehicle_data);
			
			FmsVehicleAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsVehicle add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditFmsVehicle(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsVehicles', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var fmsVehicle_data = response.responseText;
			
			eval(fmsVehicle_data);
			
			FmsVehicleEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Vehicle edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFmsVehicle(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'fmsVehicles', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var fmsVehicle_data = response.responseText;

            eval(fmsVehicle_data);

            FmsVehicleViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsVehicle view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteFmsVehicle(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsVehicles', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FmsVehicle successfully deleted!'); ?>');
			RefreshFmsVehicleData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsVehicle add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchFmsVehicle(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsVehicles', 'action' => 'search')); ?>',
		success: function(response, opts){
			var fmsVehicle_data = response.responseText;

			eval(fmsVehicle_data);

			fmsVehicleSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the fmsVehicle search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByFmsVehicleName(value){
	var conditions = '\'FmsVehicle.name LIKE\' => \'%' + value + '%\'';
	store_fmsVehicles.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshFmsVehicleData() {
	store_fmsVehicles.reload();
}


if(center_panel.find('id', 'fmsVehicle-tab') != "") {
	var p = center_panel.findById('fmsVehicle-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Vehicles'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'fmsVehicle-tab',
		xtype: 'grid',
		store: store_fmsVehicles,
		columns: [
			{header: "<?php __('Vehicle Type'); ?>", dataIndex: 'vehicle_type', sortable: true},
			{header: "<?php __('Plate No'); ?>", dataIndex: 'plate_no', sortable: true},
			{header: "<?php __('Model'); ?>", dataIndex: 'model', sortable: true},
			{header: "<?php __('Engine No'); ?>", dataIndex: 'engine_no', sortable: true},
			{header: "<?php __('Chassis No'); ?>", dataIndex: 'chassis_no', sortable: true},
			{header: "<?php __('Fuel Type'); ?>", dataIndex: 'fuel_type', sortable: true},
			{header: "<?php __('No Of Tyre'); ?>", dataIndex: 'no_of_tyre', sortable: true},
			{header: "<?php __('Horsepower'); ?>", dataIndex: 'horsepower', sortable: true},
			{header: "<?php __('Carload People'); ?>", dataIndex: 'carload_people', sortable: true},
			{header: "<?php __('Carload Goods'); ?>", dataIndex: 'carload_goods', sortable: true},
			{header: "<?php __('Purchase Amount'); ?>", dataIndex: 'purchase_amount', sortable: true},
			{header: "<?php __('Purchase Date'); ?>", dataIndex: 'purchase_date', sortable: true},
			{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true},
			{header: "<?php __('Created By'); ?>", dataIndex: 'created_by', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "FmsVehicles" : "FmsVehicle"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewFmsVehicle(Ext.getCmp('fmsVehicle-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Vehicles</b><br />Click here to create a new Vehicle'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddFmsVehicle();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-fmsVehicle',
					tooltip:'<?php __('<b>Edit Vehicles</b><br />Click here to modify the selected Vehicle'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditFmsVehicle(sel.data.id);
						};
					}
				}/*, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-fmsVehicle',
					tooltip:'<?php __('<b>Delete Vehicles(s)</b><br />Click here to remove the selected Vehicle(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Vehicle'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteFmsVehicle(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Vehicle'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Vehicles'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteFmsVehicle(sel_ids);
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
					text: '<?php __('View Vehicle'); ?>',
					id: 'view-fmsVehicle',
					tooltip:'<?php __('<b>View Vehicle</b><br />Click here to see details of the selected Vehicle'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewFmsVehicle(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'fmsVehicle_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByFmsVehicleName(Ext.getCmp('fmsVehicle_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'fmsVehicle_go_button',
					handler: function(){
						SearchByFmsVehicleName(Ext.getCmp('fmsVehicle_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchFmsVehicle();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_fmsVehicles,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-fmsVehicle').enable();
		//p.getTopToolbar().findById('delete-fmsVehicle').enable();
		p.getTopToolbar().findById('view-fmsVehicle').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-fmsVehicle').disable();
			p.getTopToolbar().findById('view-fmsVehicle').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-fmsVehicle').disable();
			p.getTopToolbar().findById('view-fmsVehicle').disable();
			//p.getTopToolbar().findById('delete-fmsVehicle').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-fmsVehicle').enable();
			p.getTopToolbar().findById('view-fmsVehicle').enable();
			//p.getTopToolbar().findById('delete-fmsVehicle').enable();
		}
		else{
			p.getTopToolbar().findById('edit-fmsVehicle').disable();
			p.getTopToolbar().findById('view-fmsVehicle').disable();
			//p.getTopToolbar().findById('delete-fmsVehicle').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_fmsVehicles.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
