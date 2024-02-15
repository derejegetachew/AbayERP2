
var store_bpCumulatives = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','bp_item','bp_month','budget_year','plan','actual','cumilativePlan','cumilativeActual'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'bpCumulatives', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'bp_item_id', direction: "ASC"},
	groupField: 'bp_month_id'
});


function AddBpCumulative() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpCumulatives', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var bpCumulative_data = response.responseText;
			
			eval(bpCumulative_data);
			
			BpCumulativeAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpCumulative add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditBpCumulative(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpCumulatives', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var bpCumulative_data = response.responseText;
			
			eval(bpCumulative_data);
			
			BpCumulativeEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpCumulative edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBpCumulative(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'bpCumulatives', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var bpCumulative_data = response.responseText;

            eval(bpCumulative_data);

            BpCumulativeViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpCumulative view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteBpCumulative(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpCumulatives', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BpCumulative successfully deleted!'); ?>');
			RefreshBpCumulativeData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpCumulative add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchBpCumulative(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpCumulatives', 'action' => 'search')); ?>',
		success: function(response, opts){
			var bpCumulative_data = response.responseText;

			eval(bpCumulative_data);

			bpCumulativeSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the bpCumulative search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByBpCumulativeName(value){
	var conditions = '\'BpCumulative.name LIKE\' => \'%' + value + '%\'';
	store_bpCumulatives.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshBpCumulativeData() {
	store_bpCumulatives.reload();
}


if(center_panel.find('id', 'bpCumulative-tab') != "") {
	var p = center_panel.findById('bpCumulative-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Bp Cumulatives'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'bpCumulative-tab',
		xtype: 'grid',
		store: store_bpCumulatives,
		columns: [
			{header: "<?php __('BpItem'); ?>", dataIndex: 'bp_item', sortable: true},
			{header: "<?php __('BpMonth'); ?>", dataIndex: 'bp_month', sortable: true},
			{header: "<?php __('BudgetYear'); ?>", dataIndex: 'budget_year', sortable: true},
			{header: "<?php __('Plan'); ?>", dataIndex: 'plan', sortable: true,renderer: function(value, metaData, record){
                      
                           return Ext.util.Format.number(value, '0,0.00');
                      
                }},
			{header: "<?php __('Actual'); ?>", dataIndex: 'actual', sortable: true,renderer: function(value, metaData, record){
                      
                           return Ext.util.Format.number(value, '0,0.00');
                      
                }},
			{header: "<?php __('CumilativePlan'); ?>", dataIndex: 'cumilativePlan', sortable: true,renderer: function(value, metaData, record){
                      
                           return Ext.util.Format.number(value, '0,0.00');
                      
                }},
			{header: "<?php __('CumilativeActual'); ?>", dataIndex: 'cumilativeActual', sortable: true,renderer: function(value, metaData, record){
                      
                           return Ext.util.Format.number(value, '0,0.00');
                      
                }}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "BpCumulatives" : "BpCumulative"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewBpCumulative(Ext.getCmp('bpCumulative-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add BpCumulatives</b><br />Click here to create a new BpCumulative'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddBpCumulative();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-bpCumulative',
					tooltip:'<?php __('<b>Edit BpCumulatives</b><br />Click here to modify the selected BpCumulative'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditBpCumulative(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-bpCumulative',
					tooltip:'<?php __('<b>Delete BpCumulatives(s)</b><br />Click here to remove the selected BpCumulative(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove BpCumulative'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteBpCumulative(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove BpCumulative'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected BpCumulatives'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteBpCumulative(sel_ids);
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
					text: '<?php __('View BpCumulative'); ?>',
					id: 'view-bpCumulative',
					tooltip:'<?php __('<b>View BpCumulative</b><br />Click here to see details of the selected BpCumulative'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewBpCumulative(sel.data.id);
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
							store_bpCumulatives.reload({
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
					id: 'bpCumulative_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByBpCumulativeName(Ext.getCmp('bpCumulative_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'bpCumulative_go_button',
					handler: function(){
						SearchByBpCumulativeName(Ext.getCmp('bpCumulative_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchBpCumulative();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_bpCumulatives,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-bpCumulative').enable();
		p.getTopToolbar().findById('delete-bpCumulative').enable();
		p.getTopToolbar().findById('view-bpCumulative').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-bpCumulative').disable();
			p.getTopToolbar().findById('view-bpCumulative').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-bpCumulative').disable();
			p.getTopToolbar().findById('view-bpCumulative').disable();
			p.getTopToolbar().findById('delete-bpCumulative').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-bpCumulative').enable();
			p.getTopToolbar().findById('view-bpCumulative').enable();
			p.getTopToolbar().findById('delete-bpCumulative').enable();
		}
		else{
			p.getTopToolbar().findById('edit-bpCumulative').disable();
			p.getTopToolbar().findById('view-bpCumulative').disable();
			p.getTopToolbar().findById('delete-bpCumulative').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_bpCumulatives.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
