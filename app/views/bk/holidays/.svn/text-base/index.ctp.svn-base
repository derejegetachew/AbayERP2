
var store_holidays = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','type','from_date','to_date','filled_date','status'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'employee', direction: "ASC"},
	groupField: 'type'
});


function AddHoliday() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var holiday_data = response.responseText;
			
			eval(holiday_data);
			
			HolidayAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the holiday add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditHoliday(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var holiday_data = response.responseText;
			
			eval(holiday_data);
			
			HolidayEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the holiday edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewHoliday(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var holiday_data = response.responseText;

            eval(holiday_data);

            HolidayViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the holiday view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteHoliday(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Holiday successfully deleted!'); ?>');
			RefreshHolidayData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the holiday add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchHoliday(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'search')); ?>',
		success: function(response, opts){
			var holiday_data = response.responseText;

			eval(holiday_data);

			holidaySearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the holiday search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByHolidayName(value){
	var conditions = '\'Holiday.name LIKE\' => \'%' + value + '%\'';
	store_holidays.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshHolidayData() {
	store_holidays.reload();
}


if(center_panel.find('id', 'holiday-tab') != "") {
	var p = center_panel.findById('holiday-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Holidays'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'holiday-tab',
		xtype: 'grid',
		store: store_holidays,
		columns: [
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
			{header: "<?php __('From Date'); ?>", dataIndex: 'from_date', sortable: true},
			{header: "<?php __('To Date'); ?>", dataIndex: 'to_date', sortable: true},
			{header: "<?php __('Filled Date'); ?>", dataIndex: 'filled_date', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Holidays" : "Holiday"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewHoliday(Ext.getCmp('holiday-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Request'); ?>',
					tooltip:'<?php __('<b>Add Holidays</b><br />Click here to create a new Holiday'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddHoliday();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-holiday',
					tooltip:'<?php __('<b>Edit Holidays</b><br />Click here to modify the selected Holiday'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditHoliday(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-holiday',
					tooltip:'<?php __('<b>Delete Holidays(s)</b><br />Click here to remove the selected Holiday(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Holiday'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteHoliday(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Holiday'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Holidays'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteHoliday(sel_ids);
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
					text: '<?php __('View Holiday'); ?>',
					id: 'view-holiday',
					tooltip:'<?php __('<b>View Holiday</b><br />Click here to see details of the selected Holiday'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewHoliday(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-', 
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'holiday_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByHolidayName(Ext.getCmp('holiday_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'holiday_go_button',
					handler: function(){
						SearchByHolidayName(Ext.getCmp('holiday_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchHoliday();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_holidays,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-holiday').enable();
		p.getTopToolbar().findById('delete-holiday').enable();
		p.getTopToolbar().findById('view-holiday').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-holiday').disable();
			p.getTopToolbar().findById('view-holiday').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-holiday').disable();
			p.getTopToolbar().findById('view-holiday').disable();
			p.getTopToolbar().findById('delete-holiday').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-holiday').enable();
			p.getTopToolbar().findById('view-holiday').enable();
			p.getTopToolbar().findById('delete-holiday').enable();
		}
		else{
			p.getTopToolbar().findById('edit-holiday').disable();
			p.getTopToolbar().findById('view-holiday').disable();
			p.getTopToolbar().findById('delete-holiday').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_holidays.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
