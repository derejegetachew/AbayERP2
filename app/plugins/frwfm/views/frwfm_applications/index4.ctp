
var store_frwfmApplications = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','branch','user','status','order','date','location','mobile_phone','email','amount','currency','expiry_date','license','created','modified','name','color']
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'list_data4')); ?>'
	})
});


function ApproveFrwfmApplication(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'approve')); ?>/'+id,
		success: function(response, opts) {
			var frwfmApplication_data = response.responseText;
			
			eval(frwfmApplication_data);
			
			FrwfmApplicationApproveWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication add form. Error code'); ?>: ' + response.status);
		}
	});
}
function RemoveFrwfmApplication(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'remove')); ?>/'+id,
		success: function(response, opts) {
			var frwfmApplication_data = response.responseText;
			
			eval(frwfmApplication_data);
			
			FrwfmApplicationApproveWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication add form. Error code'); ?>: ' + response.status);
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
function EditFrwfmApplication(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'edit2')); ?>/'+id,
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
function DiffFrwfmApplication() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'diff')); ?>/',
		success: function(response, opts) {
			
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('diff'); ?>');
			//RefreshFrwfmApplicationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication add form. Error code'); ?>: ' + response.status);
		}
	});
}
function ReportFrwfmApplication(){
Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'report')); ?>',
		success: function(response, opts) {
			  var parent_frwfmEvents_data = response.responseText;

            eval(parent_frwfmEvents_data);

            ReportWindow.show();
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
function approve(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'approve')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Request Sent'); ?>');
			RefreshFrwfmApplicationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication add form. Error code'); ?>: ' + response.status);
		}
	});
}
function accept(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'accept')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Request Sent'); ?>');
			RefreshFrwfmApplicationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication add form. Error code'); ?>: ' + response.status);
		}
	});
}
function edit(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Request Sent'); ?>');
			RefreshFrwfmApplicationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmApplication add form. Error code'); ?>: ' + response.status);
		}
	});
}

function reject(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'reject')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Request Sent'); ?>');
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


function customRenderer(value, metaData, record, rowIndex, colIndex, store) {
		if(record.get('color') == 1){
		//	return '<span style="color:green;">' + value + '</span>';
			return '<div class="x-grid3-cell-inner" style="background-color:#B0FFC5;"><span style="color:green;">' + value + '</span></div>';
		}
		return value;
}

if(center_panel.find('id', 'frwfmApplication-tab4') != "") {
	var p = center_panel.findById('frwfmApplication-tab4');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Approve Requests'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'frwfmApplication-tab4',
		xtype: 'grid',
		store: store_frwfmApplications,
		columns: [
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch',renderer: customRenderer, sortable: true},
			{header: "<?php __('Name'); ?>", dataIndex: 'name', renderer: customRenderer, sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', renderer: customRenderer, sortable: true},
			{header: "<?php __('Order'); ?>", dataIndex: 'order',renderer: customRenderer, sortable: true},
			{header: "<?php __('Amount'); ?>", dataIndex: 'amount', renderer: customRenderer,sortable: true},
			{header: "<?php __('Currency'); ?>", dataIndex: 'currency',renderer: customRenderer, sortable: true},
			//{header: "<?php __('color'); ?>", dataIndex: 'color', renderer: customRenderer, sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', renderer: customRenderer,sortable: true},
		],
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "FrwfmApplications" : "FrwfmApplication"]})'
        }),
		listeners: {
			celldblclick: function(){
				ViewFrwfmApplication(Ext.getCmp('frwfmApplication-tab4').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [ {
							text: '<?php __('Approve'); ?>',
                           // icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							id: 'accept-frwfmApplication',
							disabled: true,
							handler: function(btn) {
									var sm = p.getSelectionModel();
									var sel = sm.getSelections();
									if (sm.hasSelection()){
										if(sel.length==1){
											ApproveFrwfmApplication(sel[0].data.id);
											
										}
									} else {
										Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
									};
							}
						},' ', '-', ' ', 
						{
							text: '<?php __('Edit'); ?>',
                           // icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							id: 'edit-frwfmApplication',
							disabled: true,
							handler: function(btn) {
									var sm = p.getSelectionModel();
									var sel = sm.getSelections();
									if (sm.hasSelection()){
										if(sel.length==1){
											EditFrwfmApplication(sel[0].data.id);
											
										}
									} else {
										Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
									};
							}
						}, ' ', '-', ' ', 
										/*		{
							text: '<?php __('diff'); ?>',
                           // icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							id: 'diff-frwfmApplication',
							disabled: false,
							handler: function(btn) {
								DiffFrwfmApplication();
									
							}
						}, ' ', '-', ' ', */
						{
							text: '<?php __('Remove'); ?>',
                           // icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							id: 'reject-frwfmApplication',
							disabled: true,
							handler: function(btn) {
									var sm = p.getSelectionModel();
									var sel = sm.getSelections();
									if (sm.hasSelection()){
										if(sel.length==1){
											RemoveFrwfmApplication(sel[0].data.id);
											
										}
									} else {
										Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
									};
							}
						}, ' ', '-', ' ', 
						{
							text: '<?php __('Accounts'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							id: 'view-frwfmAccount',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentFrwfmAccounts(sel.data.id);
								};
							}
						}, ' ', ' ', '->',{
							text: '<?php __('Search / Report'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							id: 'report-frwfmApplication',
							handler: function(btn) {
											ReportFrwfmApplication();
							
							}
						}, {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_frwfmApplication_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByFrwfmApplicationName(Ext.getCmp('parent_frwfmApplication_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_frwfmApplication_go_button',
				handler: function(){
					SearchByFrwfmApplicationName(Ext.getCmp('parent_frwfmApplication_search_field').getValue());
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
		p.getTopToolbar().findById('accept-frwfmApplication').enable();
		p.getTopToolbar().findById('edit-frwfmApplication').enable();
		p.getTopToolbar().findById('reject-frwfmApplication').enable();
		//p.getTopToolbar().findById('view-edit').enable();		
		p.getTopToolbar().findById('view-frwfmAccount').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('accept-frwfmApplication').disable();
			p.getTopToolbar().findById('reject-frwfmApplication').disable();
			p.getTopToolbar().findById('view-edit').disable();	
			p.getTopToolbar().findById('view-frwfmAccount').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('accept-frwfmApplication').disable();
			p.getTopToolbar().findById('edit-frwfmApplication').disable();
			p.getTopToolbar().findById('reject-frwfmApplication').disable();
			p.getTopToolbar().findById('view-edit').disable();	
			p.getTopToolbar().findById('view-frwfmAccount').disable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('accept-frwfmApplication').enable();
			p.getTopToolbar().findById('edit-frwfmApplication').enable();
			p.getTopToolbar().findById('reject-frwfmApplication').enable();
			//p.getTopToolbar().findById('view-edit').enable();	
			p.getTopToolbar().findById('view-frwfmAccount').enable();
		}
		else{
			p.getTopToolbar().findById('accept-frwfmApplication').disable();
			p.getTopToolbar().findById('edit-frwfmApplication').disable();
			p.getTopToolbar().findById('reject-frwfmApplication').disable();
			p.getTopToolbar().findById('view-edit').disable();	
			p.getTopToolbar().findById('view-frwfmAccount').disable();
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
