
var store_bpPlanDetails = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','bp_item','bp_plan','amount'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanDetails', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'bp_item_id', direction: "ASC"},
	groupField: 'bp_plan_id'
});


function AddBpPlanDetail() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanDetails', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var bpPlanDetail_data = response.responseText;
			
			eval(bpPlanDetail_data);
			
			BpPlanDetailAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditBpPlanDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanDetails', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var bpPlanDetail_data = response.responseText;
			
			eval(bpPlanDetail_data);
			
			BpPlanDetailEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanDetail edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBpPlanDetail(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'bpPlanDetails', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var bpPlanDetail_data = response.responseText;

            eval(bpPlanDetail_data);

            BpPlanDetailViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanDetail view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteBpPlanDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanDetails', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BpPlanDetail successfully deleted!'); ?>');
			RefreshBpPlanDetailData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlanDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchBpPlanDetail(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlanDetails', 'action' => 'search')); ?>',
		success: function(response, opts){
			var bpPlanDetail_data = response.responseText;

			eval(bpPlanDetail_data);

			bpPlanDetailSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the bpPlanDetail search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByBpPlanDetailName(value){
	var conditions = '\'BpPlanDetail.name LIKE\' => \'%' + value + '%\'';
	store_bpPlanDetails.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshBpPlanDetailData() {
	store_bpPlanDetails.reload();
}


if(center_panel.find('id', 'bpPlanDetail-tab') != "") {
	var p = center_panel.findById('bpPlanDetail-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Bp Plan Details'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'bpPlanDetail-tab',
		xtype: 'grid',
		store: store_bpPlanDetails,
		columns: [
			{header: "<?php __('BpItem'); ?>", dataIndex: 'bp_item', sortable: true},
			{header: "<?php __('BpPlan'); ?>", dataIndex: 'bp_plan', sortable: true},
			{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true,renderer: function(value, metaData, record){
                      
                           return Ext.util.Format.number(value, '0,0.00');
                      
                }}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "BpPlanDetails" : "BpPlanDetail"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewBpPlanDetail(Ext.getCmp('bpPlanDetail-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add BpPlanDetails</b><br />Click here to create a new BpPlanDetail'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddBpPlanDetail();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-bpPlanDetail',
					tooltip:'<?php __('<b>Edit BpPlanDetails</b><br />Click here to modify the selected BpPlanDetail'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditBpPlanDetail(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-bpPlanDetail',
					tooltip:'<?php __('<b>Delete BpPlanDetails(s)</b><br />Click here to remove the selected BpPlanDetail(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove BpPlanDetail'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteBpPlanDetail(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove BpPlanDetail'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected BpPlanDetails'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteBpPlanDetail(sel_ids);
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
					text: '<?php __('View BpPlanDetail'); ?>',
					id: 'view-bpPlanDetail',
					tooltip:'<?php __('<b>View BpPlanDetail</b><br />Click here to see details of the selected BpPlanDetail'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewBpPlanDetail(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('BpItem'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($bpitems as $item){if($st) echo ",
							";?>['<?php echo $item['BpItem']['id']; ?>' ,'<?php echo $item['BpItem']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_bpPlanDetails.reload({
								params: {
									start: 0,
									limit: list_size,
									bpitem_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'bpPlanDetail_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByBpPlanDetailName(Ext.getCmp('bpPlanDetail_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'bpPlanDetail_go_button',
					handler: function(){
						SearchByBpPlanDetailName(Ext.getCmp('bpPlanDetail_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchBpPlanDetail();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_bpPlanDetails,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-bpPlanDetail').enable();
		p.getTopToolbar().findById('delete-bpPlanDetail').enable();
		p.getTopToolbar().findById('view-bpPlanDetail').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-bpPlanDetail').disable();
			p.getTopToolbar().findById('view-bpPlanDetail').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-bpPlanDetail').disable();
			p.getTopToolbar().findById('view-bpPlanDetail').disable();
			p.getTopToolbar().findById('delete-bpPlanDetail').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-bpPlanDetail').enable();
			p.getTopToolbar().findById('view-bpPlanDetail').enable();
			p.getTopToolbar().findById('delete-bpPlanDetail').enable();
		}
		else{
			p.getTopToolbar().findById('edit-bpPlanDetail').disable();
			p.getTopToolbar().findById('view-bpPlanDetail').disable();
			p.getTopToolbar().findById('delete-bpPlanDetail').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_bpPlanDetails.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
