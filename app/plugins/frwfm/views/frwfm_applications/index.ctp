
var store_frwfmApplications = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','branch','user','status','order','date','location','mobile_phone','email','amount','currency','expiry_date','license','created','modified','name'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'list_data')); ?>'
	})
});


function AddFrwfmApplication() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var frwfmApplication_data = response.responseText;
			
			eval(frwfmApplication_data);
			
			FrwfmApplicationAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditFrwfmApplication(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var frwfmApplication_data = response.responseText;
			
			eval(frwfmApplication_data);
			
			FrwfmApplicationEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFrwfmApplication(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var frwfmApplication_data = response.responseText;

            eval(frwfmApplication_data);

            FrwfmApplicationViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentFrwfmDocuments(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'frwfmDocuments', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_frwfmDocuments_data = response.responseText;

            eval(parent_frwfmDocuments_data);

            parentFrwfmDocumentsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentFrwfmAccounts(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'frwfmAccounts', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_frwfmDocuments_data = response.responseText;

            eval(parent_frwfmDocuments_data);

            parentFrwfmAccountsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentFrwfmEvents(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'frwfmEvents', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_frwfmEvents_data = response.responseText;

            eval(parent_frwfmEvents_data);

            parentFrwfmEventsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteFrwfmApplication(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Application successfully deleted!'); ?>');
			RefreshFrwfmApplicationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication add form. Error code'); ?>: ' + response.status);
		}
	});
}

function post(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'post')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Application successfully sent!'); ?>');
			RefreshFrwfmApplicationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchFrwfmApplication(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'search')); ?>',
		success: function(response, opts){
			var frwfmApplication_data = response.responseText;

			eval(frwfmApplication_data);

			frwfmApplicationSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the frwfmApplication search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByFrwfmApplicationName(value){
	var conditions = '\'FrwfmApplication.name LIKE\' => \'%' + value + '%\'';
	store_frwfmApplications.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshFrwfmApplicationData() {
	store_frwfmApplications.reload();
}


if(center_panel.find('id', 'frwfmApplication-tab') != "") {
	var p = center_panel.findById('frwfmApplication-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Foreign Request Applications'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'frwfmApplication-tab',
		xtype: 'grid',
		store: store_frwfmApplications,
		columns: [
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
			{header: "<?php __('Order'); ?>", dataIndex: 'order', sortable: true},
			{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true},
			{header: "<?php __('Currency'); ?>", dataIndex: 'currency', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "FrwfmApplications" : "FrwfmApplication"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewFrwfmApplication(Ext.getCmp('frwfmApplication-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add FrwfmApplications</b><br />Click here to create a new FrwfmApplication'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddFrwfmApplication();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-frwfmApplication',
					tooltip:'<?php __('<b>Edit FrwfmApplications</b><br />Click here to modify the selected FrwfmApplication'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							if(sel.data.status=="Created" || sel.data.status=="Rejected")
							EditFrwfmApplication(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-frwfmApplication',
					tooltip:'<?php __('<b>Delete FrwfmApplications(s)</b><br />Click here to remove the selected FrwfmApplication(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Application'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> ',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											if(sel[0].data.status=="Created" || sel[0].data.status=="Rejected")
											DeleteFrwfmApplication(sel[0].data.id);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, ' ', '-', ' ', 
						{
							text: '<?php __('Attachments'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							id: 'view-frwfmApplication',
							disabled: true,
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									if(sel.data.status=="Created" || sel.data.status=="Rejected")
									ViewParentFrwfmDocuments(sel.data.id);
								};
							}
						}, ' ', '-', ' ', 
						{
							text: '<?php __('Accounts'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							id: 'view-frwfmAccount',
							disabled: true,
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									if(sel.data.status=="Created" || sel.data.status=="Rejected")
									ViewParentFrwfmAccounts(sel.data.id);
								};
							}
						}, ' ', '-',{
							text: '<?php __('Post'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							id: 'post-frwfmApplication',
							disabled: true,
							handler: function(btn) {
									var sm = p.getSelectionModel();
									var sel = sm.getSelections();
									if (sm.hasSelection()){
										if(sel.length==1){
											Ext.Msg.show({
												title: '<?php __('Send'); ?>',
												buttons: Ext.MessageBox.YESNO,
												msg: '<?php __('Post Request'); ?> ',
												icon: Ext.MessageBox.QUESTION,
												fn: function(btn){
													if (btn == 'yes'){
														if(sel[0].data.status=="Created" || sel[0].data.status=="Rejected")
														post(sel[0].data.id);
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
			store: store_frwfmApplications,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-frwfmApplication').enable();
		p.getTopToolbar().findById('delete-frwfmApplication').enable();
		p.getTopToolbar().findById('post-frwfmApplication').enable();
		p.getTopToolbar().findById('view-frwfmApplication').enable();
		p.getTopToolbar().findById('view-frwfmAccount').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-frwfmApplication').disable();
			p.getTopToolbar().findById('post-frwfmApplication').disable();			p.getTopToolbar().findById('view-frwfmApplication').disable();
			p.getTopToolbar().findById('view-frwfmAccount').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-frwfmApplication').disable();
			p.getTopToolbar().findById('post-frwfmApplication').disable();
			p.getTopToolbar().findById('view-frwfmApplication').disable();			p.getTopToolbar().findById('view-frwfmAccount').disable();
			p.getTopToolbar().findById('delete-frwfmApplication').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-frwfmApplication').enable();
			p.getTopToolbar().findById('post-frwfmApplication').enable();
			p.getTopToolbar().findById('view-frwfmApplication').enable();
			p.getTopToolbar().findById('view-frwfmAccount').enable();
			p.getTopToolbar().findById('delete-frwfmApplication').enable();
		}
		else{
			p.getTopToolbar().findById('edit-frwfmApplication').disable();
			p.getTopToolbar().findById('post-frwfmApplication').disable();
			p.getTopToolbar().findById('view-frwfmApplication').disable();
			p.getTopToolbar().findById('view-frwfmAccount').disable();
			p.getTopToolbar().findById('delete-frwfmApplication').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_frwfmApplications.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
