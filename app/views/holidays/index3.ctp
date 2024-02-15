
var store_holidays = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','leave_type','from_date','to_date','no_days','filled_date','status','no_of_dates'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'list_data3')); ?>'
	})
,	sortInfo:{field: 'employee', direction: "ASC"},
	groupField: 'status'
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

function ApproveHoliday(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'approve')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Leave approved!'); ?>');
			RefreshHolidayData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the leave approve form. Error code'); ?>: ' + response.status);
		}
	});
}
function RejectHoliday(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'reject')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Leave Request successfully Rejected!'); ?>');
			RefreshHolidayData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the leave reject form. Error code'); ?>: ' + response.status);
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


if(center_panel.find('id', 'holidayadmin-tab') != "") {
	var p = center_panel.findById('holidayadmin-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Leave Request'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'holidayadmin-tab',
		xtype: 'grid',
		store: store_holidays,
		columns: [
                        {header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('Leave Type'); ?>", dataIndex: 'leave_type', sortable: true},
			{header: "<?php __('From Date'); ?>", dataIndex: 'from_date', sortable: true},
			{header: "<?php __('To Date'); ?>", dataIndex: 'to_date', sortable: true},
                         {header: "<?php __('No of Dates'); ?>", dataIndex: 'no_of_dates', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "" : ""]})'
        })
,
		listeners: {
			celldblclick: function(){
				//ViewHoliday(Ext.getCmp('holiday-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Approve'); ?>',
					id: 'approve-holiday',
					tooltip:'<?php __('<b>Approve Leave</b><br />Click here to Approve leave'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Approve'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Approve Leave?'); ?>',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											ApproveHoliday(sel[0].data.id);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				},' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Reject'); ?>',
					id: 'reject-holiday',
					tooltip:'<?php __('<b>Reject Leave</b><br />Click here to Reject leave'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Reject'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Reject Request?'); ?>',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											RejectHoliday(sel[0].data.id);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
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
		//p.getTopToolbar().findById('edit-holiday').enable();
		//p.getTopToolbar().findById('delete-holiday').enable();
                if(r.get('status')=='Pending Approval' || r.get('status')=='Scheduled' || r.get('status')=='Resubmitted for Cancellation' || r.get('status')=='Resubmitted for Correction')
                p.getTopToolbar().findById('reject-holiday').enable();
                if(r.get('status')=='Pending Approval' || r.get('status')=='Resubmitted for Cancellation' || r.get('status')=='Resubmitted for Correction')
                p.getTopToolbar().findById('approve-holiday').enable();
		//p.getTopToolbar().findById('view-holiday').enable();
		if(this.getSelections().length > 1){
			//p.getTopToolbar().findById('edit-holiday').disable();
			//p.getTopToolbar().findById('view-holiday').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			//p.getTopToolbar().findById('edit-holiday').disable();
			//p.getTopToolbar().findById('view-holiday').disable();
			//p.getTopToolbar().findById('delete-holiday').enable();
                        p.getTopToolbar().findById('approve-holiday').disable();
                        p.getTopToolbar().findById('reject-holiday').disable();
		}
		else if(this.getSelections().length == 1){
			//p.getTopToolbar().findById('edit-holiday').enable();
			//p.getTopToolbar().findById('view-holiday').enable();
			//p.getTopToolbar().findById('delete-holiday').enable();
                        p.getTopToolbar().findById('approve-holiday').disable();
                        p.getTopToolbar().findById('reject-holiday').disable();
		}
		else{
			//p.getTopToolbar().findById('edit-holiday').disable();
			//p.getTopToolbar().findById('view-holiday').disable();
			//p.getTopToolbar().findById('delete-holiday').disable();
                        p.getTopToolbar().findById('approve-holiday').disable();
                        p.getTopToolbar().findById('reject-holiday').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	
	store_holidays.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
 store_holidays.on('load', function(){
			p.getTopToolbar().findById('approve-holiday').disable();
            p.getTopToolbar().findById('reject-holiday').disable();
  });
	
}
