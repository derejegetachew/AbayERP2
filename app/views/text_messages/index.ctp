
var store_textMessages = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','text','status'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'textMessages', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"}
});


function AddTextMessage() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'textMessages', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var textMessage_data = response.responseText;
			
			eval(textMessage_data);
			
			TextMessageAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the textMessage add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditTextMessage(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'textMessages', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var textMessage_data = response.responseText;
			
			eval(textMessage_data);
			
			TextMessageEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the textMessage edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewTextMessage(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'textMessages', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var textMessage_data = response.responseText;

            eval(textMessage_data);

            TextMessageViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the textMessage view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteTextMessage(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'textMessages', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('TextMessage successfully deleted!'); ?>');
			RefreshTextMessageData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the textMessage add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchTextMessage(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'textMessages', 'action' => 'search')); ?>',
		success: function(response, opts){
			var textMessage_data = response.responseText;

			eval(textMessage_data);

			textMessageSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the textMessage search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByTextMessageName(value){
	var conditions = '\'TextMessage.name LIKE\' => \'%' + value + '%\'';
	store_textMessages.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshTextMessageData() {
	store_textMessages.reload();
}


if(center_panel.find('id', 'textMessage-tab') != "") {
	var p = center_panel.findById('textMessage-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Text Messages'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'textMessage-tab',
		xtype: 'grid',
		store: store_textMessages,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Text'); ?>", dataIndex: 'text', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "TextMessages" : "TextMessage"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewTextMessage(Ext.getCmp('textMessage-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add TextMessages</b><br />Click here to create a new TextMessage'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddTextMessage();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-textMessage',
					tooltip:'<?php __('<b>Edit TextMessages</b><br />Click here to modify the selected TextMessage'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditTextMessage(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-textMessage',
					tooltip:'<?php __('<b>Delete TextMessages(s)</b><br />Click here to remove the selected TextMessage(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove TextMessage'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteTextMessage(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove TextMessage'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected TextMessages'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteTextMessage(sel_ids);
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
					text: '<?php __('View TextMessage'); ?>',
					id: 'view-textMessage',
					tooltip:'<?php __('<b>View TextMessage</b><br />Click here to see details of the selected TextMessage'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewTextMessage(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'textMessage_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByTextMessageName(Ext.getCmp('textMessage_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'textMessage_go_button',
					handler: function(){
						SearchByTextMessageName(Ext.getCmp('textMessage_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchTextMessage();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_textMessages,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-textMessage').enable();
		p.getTopToolbar().findById('delete-textMessage').enable();
		p.getTopToolbar().findById('view-textMessage').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-textMessage').disable();
			p.getTopToolbar().findById('view-textMessage').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-textMessage').disable();
			p.getTopToolbar().findById('view-textMessage').disable();
			p.getTopToolbar().findById('delete-textMessage').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-textMessage').enable();
			p.getTopToolbar().findById('view-textMessage').enable();
			p.getTopToolbar().findById('delete-textMessage').enable();
		}
		else{
			p.getTopToolbar().findById('edit-textMessage').disable();
			p.getTopToolbar().findById('view-textMessage').disable();
			p.getTopToolbar().findById('delete-textMessage').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_textMessages.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
