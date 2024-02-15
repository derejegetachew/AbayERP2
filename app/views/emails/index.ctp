
var store_emails = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','from_name','from','to','status'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'emails', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'from_name'
});


function AddEmail() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'emails', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var email_data = response.responseText;
			
			eval(email_data);
			
			EmailAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the email add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditEmail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'emails', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var email_data = response.responseText;
			
			eval(email_data);
			
			EmailEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the email edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewEmail(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'emails', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var email_data = response.responseText;

            eval(email_data);

            EmailViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the email view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteEmail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'emails', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Email successfully deleted!'); ?>');
			RefreshEmailData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the email add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchEmail(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'emails', 'action' => 'search')); ?>',
		success: function(response, opts){
			var email_data = response.responseText;

			eval(email_data);

			emailSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the email search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByEmailName(value){
	var conditions = '\'Email.name LIKE\' => \'%' + value + '%\'';
	store_emails.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshEmailData() {
	store_emails.reload();
}


if(center_panel.find('id', 'email-tab') != "") {
	var p = center_panel.findById('email-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Emails'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'email-tab',
		xtype: 'grid',
		store: store_emails,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('From Name'); ?>", dataIndex: 'from_name', sortable: true},
			{header: "<?php __('From'); ?>", dataIndex: 'from', sortable: true},
			{header: "<?php __('To'); ?>", dataIndex: 'to', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Emails" : "Email"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewEmail(Ext.getCmp('email-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Emails</b><br />Click here to create a new Email'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddEmail();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-email',
					tooltip:'<?php __('<b>Edit Emails</b><br />Click here to modify the selected Email'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditEmail(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-email',
					tooltip:'<?php __('<b>Delete Emails(s)</b><br />Click here to remove the selected Email(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Email'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteEmail(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Email'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Emails'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteEmail(sel_ids);
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
					text: '<?php __('View Email'); ?>',
					id: 'view-email',
					tooltip:'<?php __('<b>View Email</b><br />Click here to see details of the selected Email'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewEmail(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'email_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByEmailName(Ext.getCmp('email_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'email_go_button',
					handler: function(){
						SearchByEmailName(Ext.getCmp('email_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchEmail();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_emails,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-email').enable();
		p.getTopToolbar().findById('delete-email').enable();
		p.getTopToolbar().findById('view-email').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-email').disable();
			p.getTopToolbar().findById('view-email').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-email').disable();
			p.getTopToolbar().findById('view-email').disable();
			p.getTopToolbar().findById('delete-email').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-email').enable();
			p.getTopToolbar().findById('view-email').enable();
			p.getTopToolbar().findById('delete-email').enable();
		}
		else{
			p.getTopToolbar().findById('edit-email').disable();
			p.getTopToolbar().findById('view-email').disable();
			p.getTopToolbar().findById('delete-email').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_emails.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
