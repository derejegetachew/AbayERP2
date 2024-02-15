
var store_bpActualDetails = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','GLCode','GLDescription','TDate','VDate','RefNo','CCY','DR','CR','TranCode','TranDesc','Amount','InstrumentCode','CPO','Description'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActualDetails', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'GLCode', direction: "ASC"},
	groupField: 'GLDescription'
});


function AddBpActualDetail() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActualDetails', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var bpActualDetail_data = response.responseText;
			
			eval(bpActualDetail_data);
			
			BpActualDetailAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActualDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditBpActualDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActualDetails', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var bpActualDetail_data = response.responseText;
			
			eval(bpActualDetail_data);
			
			BpActualDetailEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActualDetail edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBpActualDetail(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'bpActualDetails', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var bpActualDetail_data = response.responseText;

            eval(bpActualDetail_data);

            BpActualDetailViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActualDetail view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteBpActualDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActualDetails', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BpActualDetail successfully deleted!'); ?>');
			RefreshBpActualDetailData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActualDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchBpActualDetail(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActualDetails', 'action' => 'search')); ?>',
		success: function(response, opts){
			var bpActualDetail_data = response.responseText;

			eval(bpActualDetail_data);

			bpActualDetailSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the bpActualDetail search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByBpActualDetailName(value){
	var conditions = '\'BpActualDetail.name LIKE\' => \'%' + value + '%\'';
	store_bpActualDetails.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshBpActualDetailData() {
	store_bpActualDetails.reload();
}


if(center_panel.find('id', 'bpActualDetail-tab') != "") {
	var p = center_panel.findById('bpActualDetail-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Bp Actual Details'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'bpActualDetail-tab',
		xtype: 'grid',
		store: store_bpActualDetails,
		columns: [
			{header: "<?php __('GLCode'); ?>", dataIndex: 'GLCode', sortable: true},
			{header: "<?php __('GLDescription'); ?>", dataIndex: 'GLDescription', sortable: true},
			{header: "<?php __('TDate'); ?>", dataIndex: 'TDate', sortable: true},
			{header: "<?php __('VDate'); ?>", dataIndex: 'VDate', sortable: true},
			{header: "<?php __('RefNo'); ?>", dataIndex: 'RefNo', sortable: true},
			{header: "<?php __('CCY'); ?>", dataIndex: 'CCY', sortable: true},
			{header: "<?php __('DR'); ?>", dataIndex: 'DR', sortable: true},
			{header: "<?php __('CR'); ?>", dataIndex: 'CR', sortable: true},
			{header: "<?php __('TranCode'); ?>", dataIndex: 'TranCode', sortable: true},
			{header: "<?php __('TranDesc'); ?>", dataIndex: 'TranDesc', sortable: true},
			{header: "<?php __('Amount'); ?>", dataIndex: 'Amount', sortable: true,renderer: function(value, metaData, record){
                      
                           return Ext.util.Format.number(value, '0,0.00');
                      
                }},
			{header: "<?php __('InstrumentCode'); ?>", dataIndex: 'InstrumentCode', sortable: true},
			{header: "<?php __('CPO'); ?>", dataIndex: 'CPO', sortable: true},
			{header: "<?php __('Description'); ?>", dataIndex: 'Description', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "BpActualDetails" : "BpActualDetail"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewBpActualDetail(Ext.getCmp('bpActualDetail-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add BpActualDetails</b><br />Click here to create a new BpActualDetail'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddBpActualDetail();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-bpActualDetail',
					tooltip:'<?php __('<b>Edit BpActualDetails</b><br />Click here to modify the selected BpActualDetail'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditBpActualDetail(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-bpActualDetail',
					tooltip:'<?php __('<b>Delete BpActualDetails(s)</b><br />Click here to remove the selected BpActualDetail(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove BpActualDetail'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteBpActualDetail(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove BpActualDetail'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected BpActualDetails'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteBpActualDetail(sel_ids);
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
					text: '<?php __('View BpActualDetail'); ?>',
					id: 'view-bpActualDetail',
					tooltip:'<?php __('<b>View BpActualDetail</b><br />Click here to see details of the selected BpActualDetail'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewBpActualDetail(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'bpActualDetail_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByBpActualDetailName(Ext.getCmp('bpActualDetail_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'bpActualDetail_go_button',
					handler: function(){
						SearchByBpActualDetailName(Ext.getCmp('bpActualDetail_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchBpActualDetail();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_bpActualDetails,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-bpActualDetail').enable();
		p.getTopToolbar().findById('delete-bpActualDetail').enable();
		p.getTopToolbar().findById('view-bpActualDetail').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-bpActualDetail').disable();
			p.getTopToolbar().findById('view-bpActualDetail').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-bpActualDetail').disable();
			p.getTopToolbar().findById('view-bpActualDetail').disable();
			p.getTopToolbar().findById('delete-bpActualDetail').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-bpActualDetail').enable();
			p.getTopToolbar().findById('view-bpActualDetail').enable();
			p.getTopToolbar().findById('delete-bpActualDetail').enable();
		}
		else{
			p.getTopToolbar().findById('edit-bpActualDetail').disable();
			p.getTopToolbar().findById('view-bpActualDetail').disable();
			p.getTopToolbar().findById('delete-bpActualDetail').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_bpActualDetails.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
