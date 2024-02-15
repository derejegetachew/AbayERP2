
var store_fmsFuels = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','fms_vehicle','fueled_day','litre','price','kilometer','driver','round','status','created_by','approved_by','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsFuels', 'action' => 'list_data2')); ?>'
	})
,	sortInfo:{field: 'fms_vehicle', direction: "ASC"},
	groupField: 'fueled_day'
});



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

function ApproveFuel(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'fms_fuels', 'action' => 'approve')); ?>/'+id,
            success: function(f,a) {
				var obj = Ext.decode(Ext.decode(JSON.stringify(f)).responseText);
				Ext.Msg.show({
					title: '<?php __('Success'); ?>',
					buttons: Ext.MessageBox.OK,
					msg: obj.msg,
					icon: Ext.MessageBox.INFO
				});
                
                RefreshFmsFuelData();
            },
            failure: function(f,a) {
                var obj = Ext.decode(Ext.decode(JSON.stringify(f)).responseText);
				Ext.Msg.show({
					title: '<?php __('Warning'); ?>',
					buttons: Ext.MessageBox.OK,
					msg: obj.errormsg,
					icon: Ext.MessageBox.ERROR
				});
            }
	});
}

function RejectFuel(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'fms_fuels', 'action' => 'reject')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Fuel data successfully rejected!'); ?>');
                RefreshFmsFuelData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot reject the fuel data. Error code'); ?>: ' + response.status);
            }
	});
}

if(center_panel.find('id', 'fmsFuelApprove-tab') != "") {
	var p = center_panel.findById('fmsFuelApprove-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Approve Fuels'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'fmsFuelApprove-tab',
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
				ViewFmsFuel(Ext.getCmp('fmsFuelApprove-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
                        xtype: 'tbbutton',
                        text: '<?php __('Approve'); ?>',
                        id: 'approve-fuel',
                        tooltip:'<?php __('<b>Approve Fuel data</b><br />Click here to approve the selected Fuel data'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                Ext.Msg.show({
                                    title: '<?php __('Approve Fuel data'); ?>',
                                    buttons: Ext.MessageBox.YESNO,
                                    msg: '<?php __('Approve'); ?> '+sel.data.fms_vehicle+'?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            ApproveFuel(sel.data.id);
                                        }
                                    }
                                });
                            };
                        }
                }, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Reject'); ?>',
                        id: 'reject-fuel',
                        tooltip:'<?php __('<b>Reject Fuel data</b><br />Click here to reject the selected Fuel data'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                Ext.Msg.show({
                                    title: '<?php __('Reject Fuel data'); ?>',
                                    buttons: Ext.MessageBox.YESNO,
                                    msg: '<?php __('Reject'); ?> '+sel.data.fms_vehicle+'?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            RejectFuel(sel.data.id);
                                        }
                                    }
                                });
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
		if(this.getSelections()[0].data.status != 'approve'){
			p.getTopToolbar().findById('approve-fuel').enable();
			p.getTopToolbar().findById('reject-fuel').enable();
		}
		p.getTopToolbar().findById('view-fmsFuel').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('approve-fuel').disable();
			p.getTopToolbar().findById('view-fmsFuel').disable();
			p.getTopToolbar().findById('reject-fuel').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('approve-fuel').disable();
			p.getTopToolbar().findById('view-fmsFuel').disable();
			p.getTopToolbar().findById('reject-fuel').enable();
		}
		else if(this.getSelections().length == 1){
			if(this.getSelections()[0].data.status != 'approve'){
				p.getTopToolbar().findById('approve-fuel').enable();				
				p.getTopToolbar().findById('reject-fuel').enable();
			}
			p.getTopToolbar().findById('view-fmsFuel').enable();
		}
		else{
			p.getTopToolbar().findById('approve-fuel').disable();
			p.getTopToolbar().findById('view-fmsFuel').disable();
			p.getTopToolbar().findById('reject-fuel').disable();
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
