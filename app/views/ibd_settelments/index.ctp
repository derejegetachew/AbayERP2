
var store_ibdSettelments = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','reference','date','opening_date','fcy_amount','rate','lcy_amount','margin_amount','ibc_no'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdSettelments', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'reference', direction: "ASC"},
	groupField: 'date'
});


function AddIbdSettelment() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdSettelments', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var ibdSettelment_data = response.responseText;
			
			eval(ibdSettelment_data);
			
			IbdSettelmentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdSettelment add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditIbdSettelment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdSettelments', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var ibdSettelment_data = response.responseText;
			
			eval(ibdSettelment_data);
			
			IbdSettelmentEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdSettelment edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewIbdSettelment(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdSettelments', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var ibdSettelment_data = response.responseText;

            eval(ibdSettelment_data);

            IbdSettelmentViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdSettelment view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteIbdSettelment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdSettelments', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('IbdSettelment successfully deleted!'); ?>');
			RefreshIbdSettelmentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdSettelment add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchIbdSettelment(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdSettelments', 'action' => 'search')); ?>',
		success: function(response, opts){
			var ibdSettelment_data = response.responseText;

			eval(ibdSettelment_data);

			ibdSettelmentSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the ibdSettelment search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByIbdSettelmentName(value){
	var conditions = '\'IbdSettelment.name LIKE\' => \'%' + value + '%\'';
	store_ibdSettelments.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshIbdSettelmentData() {
	store_ibdSettelments.reload();
}


if(center_panel.find('id', 'ibdSettelment-tab') != "") {
	var p = center_panel.findById('ibdSettelment-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ibd Settelments'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'ibdSettelment-tab',
		xtype: 'grid',
		store: store_ibdSettelments,
		columns: [
			{header: "<?php __('Reference'); ?>", dataIndex: 'reference', sortable: true},
			{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true},
			{header: "<?php __('Opening Date'); ?>", dataIndex: 'opening_date', sortable: true},
			{header: "<?php __('Fcy Amount'); ?>", dataIndex: 'fcy_amount', sortable: true},
			{header: "<?php __('Rate'); ?>", dataIndex: 'rate', sortable: true},
			{header: "<?php __('Lcy Amount'); ?>", dataIndex: 'lcy_amount', sortable: true},
			{header: "<?php __('Margin Amount'); ?>", dataIndex: 'margin_amount', sortable: true},
			
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "IbdSettelments" : "IbdSettelment"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewIbdSettelment(Ext.getCmp('ibdSettelment-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add IbdSettelments</b><br />Click here to create a new IbdSettelment'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddIbdSettelment();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-ibdSettelment',
					tooltip:'<?php __('<b>Edit IbdSettelments</b><br />Click here to modify the selected IbdSettelment'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditIbdSettelment(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-ibdSettelment',
					tooltip:'<?php __('<b>Delete IbdSettelments(s)</b><br />Click here to remove the selected IbdSettelment(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove IbdSettelment'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteIbdSettelment(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove IbdSettelment'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected IbdSettelments'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteIbdSettelment(sel_ids);
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
					text: '<?php __('View IbdSettelment'); ?>',
					id: 'view-ibdSettelment',
					tooltip:'<?php __('<b>View IbdSettelment</b><br />Click here to see details of the selected IbdSettelment'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewIbdSettelment(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'ibdSettelment_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByIbdSettelmentName(Ext.getCmp('ibdSettelment_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'ibdSettelment_go_button',
					handler: function(){
						SearchByIbdSettelmentName(Ext.getCmp('ibdSettelment_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchIbdSettelment();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_ibdSettelments,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-ibdSettelment').enable();
		p.getTopToolbar().findById('delete-ibdSettelment').enable();
		p.getTopToolbar().findById('view-ibdSettelment').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdSettelment').disable();
			p.getTopToolbar().findById('view-ibdSettelment').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdSettelment').disable();
			p.getTopToolbar().findById('view-ibdSettelment').disable();
			p.getTopToolbar().findById('delete-ibdSettelment').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-ibdSettelment').enable();
			p.getTopToolbar().findById('view-ibdSettelment').enable();
			p.getTopToolbar().findById('delete-ibdSettelment').enable();
		}
		else{
			p.getTopToolbar().findById('edit-ibdSettelment').disable();
			p.getTopToolbar().findById('view-ibdSettelment').disable();
			p.getTopToolbar().findById('delete-ibdSettelment').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_ibdSettelments.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
