
var store_perrdiemms = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','payroll','days','rate','taxable','date'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'perrdiemms', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'employee_id', direction: "ASC"},
	groupField: 'payroll_id'
});


function AddPerrdiemm() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'perrdiemms', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var perrdiemm_data = response.responseText;
			
			eval(perrdiemm_data);
			
			PerrdiemmAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the perrdiemm add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditPerrdiemm(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'perrdiemms', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var perrdiemm_data = response.responseText;
			
			eval(perrdiemm_data);
			
			PerrdiemmEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the perrdiemm edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPerrdiemm(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'perrdiemms', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var perrdiemm_data = response.responseText;

            eval(perrdiemm_data);

            PerrdiemmViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the perrdiemm view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeletePerrdiemm(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'perrdiemms', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Perrdiemm successfully deleted!'); ?>');
			RefreshPerrdiemmData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the perrdiemm add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchPerrdiemm(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'perrdiemms', 'action' => 'search')); ?>',
		success: function(response, opts){
			var perrdiemm_data = response.responseText;

			eval(perrdiemm_data);

			perrdiemmSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the perrdiemm search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByPerrdiemmName(value){
	var conditions = '\'Perrdiemm.name LIKE\' => \'%' + value + '%\'';
	store_perrdiemms.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshPerrdiemmData() {
	store_perrdiemms.reload();
}


if(center_panel.find('id', 'perrdiemm-tab') != "") {
	var p = center_panel.findById('perrdiemm-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Perrdiemms'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'perrdiemm-tab',
		xtype: 'grid',
		store: store_perrdiemms,
		columns: [
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('Payroll'); ?>", dataIndex: 'payroll', sortable: true},
			{header: "<?php __('Days'); ?>", dataIndex: 'days', sortable: true},
			{header: "<?php __('Rate'); ?>", dataIndex: 'rate', sortable: true},
			{header: "<?php __('Taxable'); ?>", dataIndex: 'taxable', sortable: true},
			{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Perrdiemms" : "Perrdiemm"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewPerrdiemm(Ext.getCmp('perrdiemm-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Perrdiemms</b><br />Click here to create a new Perrdiemm'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddPerrdiemm();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-perrdiemm',
					tooltip:'<?php __('<b>Edit Perrdiemms</b><br />Click here to modify the selected Perrdiemm'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditPerrdiemm(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-perrdiemm',
					tooltip:'<?php __('<b>Delete Perrdiemms(s)</b><br />Click here to remove the selected Perrdiemm(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Perrdiemm'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeletePerrdiemm(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Perrdiemm'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Perrdiemms'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeletePerrdiemm(sel_ids);
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
					text: '<?php __('View Perrdiemm'); ?>',
					id: 'view-perrdiemm',
					tooltip:'<?php __('<b>View Perrdiemm</b><br />Click here to see details of the selected Perrdiemm'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewPerrdiemm(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Employee'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($employees as $item){if($st) echo ",
							";?>['<?php echo $item['Employee']['id']; ?>' ,'<?php echo $item['Employee']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_perrdiemms.reload({
								params: {
									start: 0,
									limit: list_size,
									employee_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'perrdiemm_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByPerrdiemmName(Ext.getCmp('perrdiemm_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'perrdiemm_go_button',
					handler: function(){
						SearchByPerrdiemmName(Ext.getCmp('perrdiemm_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchPerrdiemm();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_perrdiemms,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-perrdiemm').enable();
		p.getTopToolbar().findById('delete-perrdiemm').enable();
		p.getTopToolbar().findById('view-perrdiemm').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-perrdiemm').disable();
			p.getTopToolbar().findById('view-perrdiemm').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-perrdiemm').disable();
			p.getTopToolbar().findById('view-perrdiemm').disable();
			p.getTopToolbar().findById('delete-perrdiemm').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-perrdiemm').enable();
			p.getTopToolbar().findById('view-perrdiemm').enable();
			p.getTopToolbar().findById('delete-perrdiemm').enable();
		}
		else{
			p.getTopToolbar().findById('edit-perrdiemm').disable();
			p.getTopToolbar().findById('view-perrdiemm').disable();
			p.getTopToolbar().findById('delete-perrdiemm').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_perrdiemms.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
