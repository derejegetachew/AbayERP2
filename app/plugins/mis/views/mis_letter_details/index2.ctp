var store_parent_misLetterDetails = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','mis_letter','type','account_of','account_number','amount','branch','parent_status','status','created_by','replied_by','completed_by','letter_prepared_by','remark','file','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'misLetterDetails', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentMisLetterDetail() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'misLetterDetails', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_misLetterDetail_data = response.responseText;
			
			eval(parent_misLetterDetail_data);
			
			MisLetterDetailAddWindow.show();
			RefreshMisLetterData;
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the misLetterDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentMisLetterDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'misLetterDetails', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_misLetterDetail_data = response.responseText;
			
			eval(parent_misLetterDetail_data);
			
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


function DeleteParentMisLetterDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'misLetterDetails', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('MisLetterDetail(s) successfully deleted!'); ?>');
			RefreshParentMisLetterDetailData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the misLetterDetail to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentMisLetterDetailName(value){
	var conditions = '\'MisLetterDetail.name LIKE\' => \'%' + value + '%\'';
	store_parent_misLetterDetails.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentMisLetterDetailData() {
	store_parent_misLetterDetails.reload();
}

function DownloadMisLetter(id) {
         url = '<?php echo $this->Html->url(array('controller' => 'mis_letter_details', 'action' => 'download')); ?>/' + id;	
		 window.open(url);
}


var g = new Ext.grid.GridPanel({
	title: '<?php __('Letter Details'); ?>',
	store: store_parent_misLetterDetails,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'misLetterDetailGrid',
	columns: [
		{header:"<?php __('mis_letter'); ?>", dataIndex: 'mis_letter', sortable: true, hidden: true},
		{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
		{header: "<?php __('Account Of'); ?>", dataIndex: 'account_of', sortable: true},
		{header: "<?php __('Account Number'); ?>", dataIndex: 'account_number', sortable: true},
		{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true},
		{header:"<?php __('branch'); ?>", dataIndex: 'branch', sortable: true},
		{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
		{header: "<?php __('Created By'); ?>", dataIndex: 'created_by', sortable: true},
		{header: "<?php __('Replied By'); ?>", dataIndex: 'replied_by', sortable: true},
		{header: "<?php __('Completed By'); ?>", dataIndex: 'completed_by', sortable: true},
		{header: "<?php __('Letter Prepared By'); ?>", dataIndex: 'letter_prepared_by', sortable: true},
		{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true},
		{header: "<?php __('File'); ?>", dataIndex: 'file', sortable: true}
			],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: true
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewMisLetterDetail(Ext.getCmp('misLetterDetailGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				id: 'add-parent-misLetterDetail',
				tooltip:'<?php __('<b>Add Letter Detail</b><br />Click here to create a new Letter Detail'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				disabled: <?php echo ($mis_letter['MisLetter']['status'] == 'created')? 'false': 'true'; ?>,
				handler: function(btn) {
					AddParentMisLetterDetail();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-misLetterDetail',
				tooltip:'<?php __('<b>Edit Letter Detail</b><br />Click here to modify the selected Letter Detail'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentMisLetterDetail(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-misLetterDetail',
				tooltip:'<?php __('<b>Delete Letter Detail(s)</b><br />Click here to remove the selected Letter Detail(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Letter Detail'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentMisLetterDetail(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Letter Detail'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Letter Detail'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentMisLetterDetail(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			}, ' ','-',' ', {
				xtype: 'tbsplit',
				text: '<?php __('View Letter Detail'); ?>',
				id: 'view-misLetterDetail2',
				tooltip:'<?php __('<b>View Letter Detail</b><br />Click here to see details of the selected Letter Detail'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewMisLetterDetail(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ','-',' ', {
					xtype: 'tbbutton',
					text: '<?php __('Download Letter'); ?>',
					id: 'misLetterDetail_download',
					tooltip:'<?php __('<b>Download Replied Letter</b><br />Click here to download Replied Letter'); ?>',
					icon: 'img/download.gif',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = g.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							DownloadMisLetter(sel.data.id);
						};
					}
				}, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_misLetterDetail_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentMisLetterDetailName(Ext.getCmp('parent_misLetterDetail_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_misLetterDetail_go_button',
				handler: function(){
					SearchByParentMisLetterDetailName(Ext.getCmp('parent_misLetterDetail_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_misLetterDetails,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	if(this.getSelections()[0].data.status.indexOf('created') != -1){
		g.getTopToolbar().findById('edit-parent-misLetterDetail').enable();
		g.getTopToolbar().findById('delete-parent-misLetterDetail').enable();
		g.getTopToolbar().findById('view-misLetterDetail2').enable();
	}
	if(this.getSelections()[0].data.file != null){
		g.getTopToolbar().findById('misLetterDetail_download').enable();
	}
	
});




var parentMisLetterDetailsViewWindow = new Ext.Window({
	title: 'Detail Info Under the selected Letter',
	width: 700,
	height:375,
	minWidth: 700,
	minHeight: 400,
	resizable: false,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'center',
        modal: true,
	items: [
		g
	],

	buttons: [{
		text: 'Close',
		handler: function(btn){
			parentMisLetterDetailsViewWindow.close();
		}
	}]
});

store_parent_misLetterDetails.load({
    params: {
        start: 0,    
        limit: list_size
    }
});