
var store_fmsMaintenances = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','fms_vehicle','item','serial','measurement','quantity','unit_price','status','created_by','approved_by','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenances', 'action' => 'list_data2')); ?>'
	})
,	sortInfo:{field: 'created', direction: "ASC"},
	groupField: 'fms_vehicle'
});


function ViewFmsMaintenance(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenances', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var fmsMaintenance_data = response.responseText;

            eval(fmsMaintenance_data);

            FmsMaintenanceViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Maintenance view form. Error code'); ?>: ' + response.status);
        }
    });
}



function SearchFmsMaintenance(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenances', 'action' => 'search')); ?>',
		success: function(response, opts){
			var fmsMaintenance_data = response.responseText;

			eval(fmsMaintenance_data);

			fmsMaintenanceSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the Maintenance search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByFmsMaintenanceName(value){
	var conditions = '\'FmsMaintenance.name LIKE\' => \'%' + value + '%\'';
	store_fmsMaintenances.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshFmsMaintenanceData() {
	store_fmsMaintenances.reload();
}

function ApproveMaintenance(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenances', 'action' => 'approve')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Maintenance data successfully approved!'); ?>');
                RefreshFmsMaintenanceData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot approve the Maintenance data. Error code'); ?>: ' + response.status);
            }
	});
}

function RejectMaintenance(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenances', 'action' => 'reject')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Maintenance data successfully rejected!'); ?>');
                RefreshFmsMaintenanceData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot reject the Maintenance data. Error code'); ?>: ' + response.status);
            }
	});
}

if(center_panel.find('id', 'fmsMaintenanceApprove-tab') != "") {
	var p = center_panel.findById('fmsMaintenanceApprove-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Approve Maintenances'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'fmsMaintenanceApprove-tab',
		xtype: 'grid',
		store: store_fmsMaintenances,
		columns: [
			{header: "<?php __('Vehicle'); ?>", dataIndex: 'fms_vehicle', sortable: true},
			{header: "<?php __('Item'); ?>", dataIndex: 'item', sortable: true},
			{header: "<?php __('Serial'); ?>", dataIndex: 'serial', sortable: true},
			{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
			{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
			{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
			{header: "<?php __('Created By'); ?>", dataIndex: 'created_by', sortable: true},
			{header: "<?php __('Approved By'); ?>", dataIndex: 'approved_by', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Maintenances" : "Maintenance"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewFmsMaintenance(Ext.getCmp('fmsMaintenanceApprove-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
                        xtype: 'tbbutton',
                        text: '<?php __('Approve'); ?>',
                        id: 'approve-maintenance',
                        tooltip:'<?php __('<b>Approve Maintenance data</b><br />Click here to approve the selected Maintenance data'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                Ext.Msg.show({
                                    title: '<?php __('Approve Maintenance data'); ?>',
                                    buttons: Ext.MessageBox.YESNO,
                                    msg: '<?php __('Approve'); ?> '+sel.data.fms_vehicle+'?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            ApproveMaintenance(sel.data.id);
                                        }
                                    }
                                });
                            };
                        }
                }, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Reject'); ?>',
                        id: 'reject-maintenance',
                        tooltip:'<?php __('<b>Reject Maintenance data</b><br />Click here to reject the selected Maintenance data'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                Ext.Msg.show({
                                    title: '<?php __('Reject Maintenance data'); ?>',
                                    buttons: Ext.MessageBox.YESNO,
                                    msg: '<?php __('Reject'); ?> '+sel.data.fms_vehicle+'?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            RejectMaintenance(sel.data.id);
                                        }
                                    }
                                });
                            };
                        }
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View Maintenance'); ?>',
					id: 'view-fmsMaintenance',
					tooltip:'<?php __('<b>View Maintenance</b><br />Click here to see details of the selected Maintenance'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewFmsMaintenance(sel.data.id);
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
							store_fmsMaintenances.reload({
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
					id: 'fmsMaintenance_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByFmsMaintenanceName(Ext.getCmp('fmsMaintenance_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'fmsMaintenance_go_button',
					handler: function(){
						SearchByFmsMaintenanceName(Ext.getCmp('fmsMaintenance_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchFmsMaintenance();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_fmsMaintenances,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		if(this.getSelections()[0].data.status != 'approve'){
			p.getTopToolbar().findById('approve-maintenance').enable();
			p.getTopToolbar().findById('reject-maintenance').enable();
		}
		p.getTopToolbar().findById('view-fmsMaintenance').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('approve-maintenance').disable();
			p.getTopToolbar().findById('view-fmsMaintenance').disable();
			p.getTopToolbar().findById('reject-maintenance').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('approve-maintenance').disable();
			p.getTopToolbar().findById('view-fmsMaintenance').disable();
			p.getTopToolbar().findById('reject-maintenance').disable();
		}
		else if(this.getSelections().length == 1){
			if(this.getSelections()[0].data.status != 'approve'){
				p.getTopToolbar().findById('approve-maintenance').enable();
				p.getTopToolbar().findById('reject-maintenance').enable();
			}
			p.getTopToolbar().findById('view-fmsMaintenance').enable();
		}
		else{
			p.getTopToolbar().findById('approve-maintenance').disable();
			p.getTopToolbar().findById('view-fmsMaintenance').disable();
			p.getTopToolbar().findById('reject-maintenance').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_fmsMaintenances.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
