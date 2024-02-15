
var store_misLetterDetails = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','mis_letter','type','account_of','account_number','amount','branch','status','created_by','replied_by','completed_by','letter_prepared_by','remark','file','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'misLetterDetails', 'action' => 'list_data_1')); ?>'
	})
,	sortInfo:{field: 'mis_letter', direction: "ASC"},
	groupField: 'type'
});


function AddMisLetterDetail() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'misLetterDetails', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var misLetterDetail_data = response.responseText;
			
			eval(misLetterDetail_data);
			
			MisLetterDetailAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the misLetterDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditMisLetterDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'misLetterDetails', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var misLetterDetail_data = response.responseText;
			
			eval(misLetterDetail_data);
			
			MisLetterDetailEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the misLetterDetail edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewMisLetterDetail(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'misLetterDetails', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var misLetterDetail_data = response.responseText;

            eval(misLetterDetail_data);

            MisLetterDetailViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the misLetterDetail view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteMisLetterDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'misLetterDetails', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('MisLetterDetail successfully deleted!'); ?>');
			RefreshMisLetterDetailData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the misLetterDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchMisLetterDetail(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'misLetterDetails', 'action' => 'search')); ?>',
		success: function(response, opts){
			var misLetterDetail_data = response.responseText;

			eval(misLetterDetail_data);

			misLetterDetailSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the misLetterDetail search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByMisLetterDetailName(value){
	var conditions = '\'MisLetterDetail.name LIKE\' => \'%' + value + '%\'';
	store_misLetterDetails.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshMisLetterDetailData() {
	store_misLetterDetails.reload();
}


if(center_panel.find('id', 'misLetterDetail-tab') != "") {
	var p = center_panel.findById('misLetterDetail-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Mis Letter Details'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'misLetterDetail-tab',
		xtype: 'grid',
		store: store_misLetterDetails,
		columns: [
			{header: "<?php __('MisLetter'); ?>", dataIndex: 'mis_letter', sortable: true},
			{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
			{header: "<?php __('Account Of'); ?>", dataIndex: 'account_of', sortable: true},
			{header: "<?php __('Account Number'); ?>", dataIndex: 'account_number', sortable: true},
			{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true},
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true, hidden: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
			{header: "<?php __('Created By'); ?>", dataIndex: 'created_by', sortable: true},
			{header: "<?php __('Replied By'); ?>", dataIndex: 'replied_by', sortable: true, hidden: true},
			{header: "<?php __('Completed By'); ?>", dataIndex: 'completed_by', sortable: true, hidden: true},
			{header: "<?php __('Letter Prepared By'); ?>", dataIndex: 'letter_prepared_by', sortable: true, hidden: true},
			{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true},
			{header: "<?php __('File'); ?>", dataIndex: 'file', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "MisLetterDetails" : "MisLetterDetail"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewMisLetterDetail(Ext.getCmp('misLetterDetail-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add MisLetterDetails</b><br />Click here to create a new MisLetterDetail'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddMisLetterDetail();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-misLetterDetail',
					tooltip:'<?php __('<b>Edit MisLetterDetails</b><br />Click here to modify the selected MisLetterDetail'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditMisLetterDetail(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-misLetterDetail',
					tooltip:'<?php __('<b>Delete MisLetterDetails(s)</b><br />Click here to remove the selected MisLetterDetail(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove MisLetterDetail'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteMisLetterDetail(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove MisLetterDetail'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected MisLetterDetails'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteMisLetterDetail(sel_ids);
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
					text: '<?php __('View MisLetterDetail'); ?>',
					id: 'view-misLetterDetail',
					tooltip:'<?php __('<b>View MisLetterDetail</b><br />Click here to see details of the selected MisLetterDetail'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewMisLetterDetail(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('MisLetter'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($mis_letters as $item){if($st) echo ",
							";?>['<?php echo $item['MisLetter']['id']; ?>' ,'<?php echo $item['MisLetter']['ref_no']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_misLetterDetails.reload({
								params: {
									start: 0,
									limit: list_size,
									misletter_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'misLetterDetail_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByMisLetterDetailName(Ext.getCmp('misLetterDetail_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'misLetterDetail_go_button',
					handler: function(){
						SearchByMisLetterDetailName(Ext.getCmp('misLetterDetail_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchMisLetterDetail();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_misLetterDetails,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-misLetterDetail').enable();
		p.getTopToolbar().findById('delete-misLetterDetail').enable();
		p.getTopToolbar().findById('view-misLetterDetail').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-misLetterDetail').disable();
			p.getTopToolbar().findById('view-misLetterDetail').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-misLetterDetail').disable();
			p.getTopToolbar().findById('view-misLetterDetail').disable();
			p.getTopToolbar().findById('delete-misLetterDetail').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-misLetterDetail').enable();
			p.getTopToolbar().findById('view-misLetterDetail').enable();
			p.getTopToolbar().findById('delete-misLetterDetail').enable();
		}
		else{
			p.getTopToolbar().findById('edit-misLetterDetail').disable();
			p.getTopToolbar().findById('view-misLetterDetail').disable();
			p.getTopToolbar().findById('delete-misLetterDetail').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_misLetterDetails.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
