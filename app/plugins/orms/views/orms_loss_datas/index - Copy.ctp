
var store_ormsLossDatas = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','branch','orms_risk_category','created_by','approved_by','occured_from','occured_to','discovered_date','event','description','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsLossDatas', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'branch_id', direction: "ASC"},
	groupField: 'orms_risk_category_id'
});


function AddOrmsLossData() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsLossDatas', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var ormsLossData_data = response.responseText;
			
			eval(ormsLossData_data);
			
			OrmsLossDataAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ormsLossData add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditOrmsLossData(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsLossDatas', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var ormsLossData_data = response.responseText;
			
			eval(ormsLossData_data);
			
			OrmsLossDataEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ormsLossData edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewOrmsLossData(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ormsLossDatas', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var ormsLossData_data = response.responseText;

            eval(ormsLossData_data);

            OrmsLossDataViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ormsLossData view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteOrmsLossData(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsLossDatas', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('OrmsLossData successfully deleted!'); ?>');
			RefreshOrmsLossDataData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ormsLossData add form. Error code'); ?>: ' + response.status);
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
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the ormsLossData search form. Error Code'); ?>: ' + response.status);
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

function RefreshOrmsLossDataData() {
	store_ormsLossDatas.reload();
}


if(center_panel.find('id', 'ormsLossData-tab') != "") {
	var p = center_panel.findById('ormsLossData-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Orms Loss Datas'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'ormsLossData-tab',
		xtype: 'grid',
		store: store_ormsLossDatas,
		columns: [
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('OrmsRiskCategory'); ?>", dataIndex: 'orms_risk_category', sortable: true},
			{header: "<?php __('Created By'); ?>", dataIndex: 'created_by', sortable: true},
			{header: "<?php __('Approved By'); ?>", dataIndex: 'approved_by', sortable: true},
			{header: "<?php __('Occured From'); ?>", dataIndex: 'occured_from', sortable: true},
			{header: "<?php __('Occured To'); ?>", dataIndex: 'occured_to', sortable: true},
			{header: "<?php __('Discovered Date'); ?>", dataIndex: 'discovered_date', sortable: true},
			{header: "<?php __('Event'); ?>", dataIndex: 'event', sortable: true},
			{header: "<?php __('Description'); ?>", dataIndex: 'description', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
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
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add OrmsLossDatas</b><br />Click here to create a new OrmsLossData'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddOrmsLossData();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-ormsLossData',
					tooltip:'<?php __('<b>Edit OrmsLossDatas</b><br />Click here to modify the selected OrmsLossData'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditOrmsLossData(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-ormsLossData',
					tooltip:'<?php __('<b>Delete OrmsLossDatas(s)</b><br />Click here to remove the selected OrmsLossData(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove OrmsLossData'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteOrmsLossData(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove OrmsLossData'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected OrmsLossDatas'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteOrmsLossData(sel_ids);
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
					text: '<?php __('View OrmsLossData'); ?>',
					id: 'view-ormsLossData',
					tooltip:'<?php __('<b>View OrmsLossData</b><br />Click here to see details of the selected OrmsLossData'); ?>',
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
		p.getTopToolbar().findById('edit-ormsLossData').enable();
		p.getTopToolbar().findById('delete-ormsLossData').enable();
		p.getTopToolbar().findById('view-ormsLossData').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ormsLossData').disable();
			p.getTopToolbar().findById('view-ormsLossData').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ormsLossData').disable();
			p.getTopToolbar().findById('view-ormsLossData').disable();
			p.getTopToolbar().findById('delete-ormsLossData').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-ormsLossData').enable();
			p.getTopToolbar().findById('view-ormsLossData').enable();
			p.getTopToolbar().findById('delete-ormsLossData').enable();
		}
		else{
			p.getTopToolbar().findById('edit-ormsLossData').disable();
			p.getTopToolbar().findById('view-ormsLossData').disable();
			p.getTopToolbar().findById('delete-ormsLossData').disable();
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
