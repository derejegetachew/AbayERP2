
var store_ormsLossDatas = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','branch','risk_category','risk_subcategory','risk','created_by','approved_by','occured_from','occured_to','discovered_date','description','created','modified'	,'status','severity','frequency'	]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsLossDatas', 'action' => 'list_data2')); ?>'
	})
,	sortInfo:{field: 'risk', direction: "ASC"},
	groupField: 'risk_category'
});


function ViewOrmsLossData(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ormsLossDatas', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var ormsLossData_data = response.responseText;

            eval(ormsLossData_data);

            OrmsLossDataViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Loss Data view form. Error code'); ?>: ' + response.status);
        }
    });
}

function SearchOrmsLossData(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsLossDatas', 'action' => 'search')); ?>',
		success: function(response, opts){
			var ormsLossData_data = response.responseText;

			eval(ormsLossData_data);

			ormsLossDataSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the Loss Data search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByOrmsLossDataName(value){
	var conditions = '\'OrmsLossData.name LIKE\' => \'%' + value + '%\'';
	store_ormsLossDatas.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function ApproveRisk(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'orms_loss_datas', 'action' => 'approverisk')); ?>/'+id,
            success: function(response, opts) {
                 var ormsLossData_data = response.responseText;

				eval(ormsLossData_data);

				OrmsLossDataApproveWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot approve the Risk. Error code'); ?>: ' + response.status);
            }
	});
}

function Approve(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'orms_loss_datas', 'action' => 'approve')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Risk successfully approved!'); ?>');
                RefreshOrmsLossDataData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot approve the Risk. Error code'); ?>: ' + response.status);
            }
	});
}

function RejectRisk(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'orms_loss_datas', 'action' => 'reject')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Risk successfully rejected!'); ?>');
                RefreshOrmsLossDataData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot reject the Risk. Error code'); ?>: ' + response.status);
            }
	});
}

function RefreshOrmsLossDataData() {
	store_ormsLossDatas.reload();
}


if(center_panel.find('id', 'ormsLossData-tab') != "") {
	var p = center_panel.findById('ormsLossData-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Loss Datas'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'ormsLossData-tab',
		xtype: 'grid',
		store: store_ormsLossDatas,
		columns: [
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('Risk Category'); ?>", dataIndex: 'risk_category', sortable: true},
			{header: "<?php __('Risk Sub Category'); ?>", dataIndex: 'risk_subcategory', sortable: true},
			{header: "<?php __('Risk'); ?>", dataIndex: 'risk', sortable: true},
			{header: "<?php __('Description'); ?>", dataIndex: 'description', sortable: true},
			{header: "<?php __('Occured From'); ?>", dataIndex: 'occured_from', sortable: true},
			{header: "<?php __('Occured To'); ?>", dataIndex: 'occured_to', sortable: true},
			{header: "<?php __('Discovered Date'); ?>", dataIndex: 'discovered_date', sortable: true},
			//{header: "<?php __('Event'); ?>", dataIndex: 'event', sortable: true},			
			{header: "<?php __('Severity'); ?>", dataIndex: 'severity', sortable: true},
			{header: "<?php __('Frequency'); ?>", dataIndex: 'frequency', sortable: true},
			{header: "<?php __('Insured Amount'); ?>", dataIndex: 'insured_amount', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
			{header: "<?php __('Created By'); ?>", dataIndex: 'created_by', sortable: true},
			{header: "<?php __('Approved By'); ?>", dataIndex: 'approved_by', sortable: true},
			//{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			//{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "OrmsLossDatas" : "OrmsLossData"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewOrmsLossData(Ext.getCmp('ormsLossData-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
                        xtype: 'tbbutton',
                        text: '<?php __('Approve'); ?>',
                        id: 'approve-risk',
                        tooltip:'<?php __('<b>Approve Risk</b><br />Click here to approve the selected Risk'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                ApproveRisk(sel.data.id);
                            };
                        }
                }, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Reject'); ?>',
                        id: 'reject-risk',
                        tooltip:'<?php __('<b>Reject Risk</b><br />Click here to reject the selected Risk'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                Ext.Msg.show({
                                    title: '<?php __('Reject Risk'); ?>',
                                    buttons: Ext.MessageBox.YESNO,
                                    msg: '<?php __('Reject the selected Loss Data'); ?> '+'?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            RejectRisk(sel.data.id);
                                        }
                                    }
                                });
                            };
                        }
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View Loss Data'); ?>',
					id: 'view-ormsLossData',
					tooltip:'<?php __('<b>View Loss Data</b><br />Click here to see details of the selected Loss Data'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewOrmsLossData(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Branch'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($branches as $item){if($st) echo ",
							";?>['<?php echo $item['Branch']['id']; ?>' ,'<?php echo $item['Branch']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_ormsLossDatas.reload({
								params: {
									start: 0,
									limit: list_size,
									branch_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'ormsLossData_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByOrmsLossDataName(Ext.getCmp('ormsLossData_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'ormsLossData_go_button',
					handler: function(){
						SearchByOrmsLossDataName(Ext.getCmp('ormsLossData_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchOrmsLossData();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_ormsLossDatas,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		is_created = (this.getSelections()[0].data.status == 'posted');
		if(is_created){
			p.getTopToolbar().findById('approve-risk').enable();
			p.getTopToolbar().findById('reject-risk').enable();			
		}
		p.getTopToolbar().findById('view-ormsLossData').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('approve-risk').disable();
			p.getTopToolbar().findById('view-ormsLossData').disable();
			p.getTopToolbar().findById('reject-risk').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('approve-risk').disable();
			p.getTopToolbar().findById('view-ormsLossData').disable();
			p.getTopToolbar().findById('reject-risk').disable();
			
		}
		else if(this.getSelections().length == 1){
			if(is_created){
				p.getTopToolbar().findById('approve-risk').enable();
				p.getTopToolbar().findById('view-ormsLossData').enable();
				p.getTopToolbar().findById('reject-risk').enable();
				
			}
		}
		else{
			p.getTopToolbar().findById('approve-risk').disable();
			p.getTopToolbar().findById('view-ormsLossData').disable();
			p.getTopToolbar().findById('reject-risk').disable();
			
		}
	});
	center_panel.setActiveTab(p);
	
	store_ormsLossDatas.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
