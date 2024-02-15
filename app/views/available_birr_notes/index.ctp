
var store_availableBirrNotes = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','old_10_birr','old_50_birr','old_100_birr','new_200_birr','new_100_birr','new_50_birr','new_10_birr','new_5_birr','new_1_birr','new_50_cents','new_25_cents','new_10_cents','new_5_cents','date_of','created','updated'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'availableBirrNotes', 'action' => 'list_data')); ?>'
	})
	,	sortInfo:{field: 'id', direction: "ASC"}
});


function AddAvailableBirrNote() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'availableBirrNotes', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var availableBirrNote_data = response.responseText;
			
			eval(availableBirrNote_data);
			
			AvailableBirrNoteAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the availableBirrNote add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditAvailableBirrNote(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'availableBirrNotes', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var availableBirrNote_data = response.responseText;
			
			eval(availableBirrNote_data);
			
			AvailableBirrNoteEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the availableBirrNote edit form. Error code'); ?>: ' + response.status);
		}
	});
}
function ViewMissedReport() {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'availableBirrNotes', 'action' => 'display_missed_reports')); ?>/'+id,
        success: function(response, opts) {
            var availableBirrNote_data = response.responseText;

            eval(availableBirrNote_data);

            AvailableBirrNoteViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the availableBirrNote view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewAvailableBirrNote(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'availableBirrNotes', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var availableBirrNote_data = response.responseText;

            eval(availableBirrNote_data);

            AvailableBirrNoteViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the availableBirrNote view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteAvailableBirrNote(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'availableBirrNotes', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('AvailableBirrNote successfully deleted!'); ?>');
			RefreshAvailableBirrNoteData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the availableBirrNote add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchAvailableBirrNote(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'availableBirrNotes', 'action' => 'search')); ?>',
		success: function(response, opts){
			var availableBirrNote_data = response.responseText;

			eval(availableBirrNote_data);

			availableBirrNoteSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the availableBirrNote search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByAvailableBirrNoteName(value){
	var conditions = '\'AvailableBirrNote.name LIKE\' => \'%' + value + '%\'';
	store_availableBirrNotes.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshAvailableBirrNoteData() {
	store_availableBirrNotes.reload();
}


if(center_panel.find('id', 'availableBirrNote-tab') != "") {
	var p = center_panel.findById('availableBirrNote-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Available Birr Notes'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'availableBirrNote-tab',
		xtype: 'grid',
		store: store_availableBirrNotes,
		columns: [
			
			{header: "<?php __('Old 10 Birr'); ?>", dataIndex: 'old_10_birr', sortable: true},
			{header: "<?php __('Old 50 Birr'); ?>", dataIndex: 'old_50_birr', sortable: true},
			{header: "<?php __('Old 100 Birr'); ?>", dataIndex: 'old_100_birr', sortable: true},
			{header: "<?php __('New 200 Birr'); ?>", dataIndex: 'new_200_birr', sortable: true},
			{header: "<?php __('New 100 Birr'); ?>", dataIndex: 'new_100_birr', sortable: true},
			{header: "<?php __('New 50 Birr'); ?>", dataIndex: 'new_50_birr', sortable: true},
			{header: "<?php __('New 10 Birr'); ?>", dataIndex: 'new_10_birr', sortable: true},
			{header: "<?php __('New 5 Birr'); ?>", dataIndex: 'new_5_birr', sortable: true},
			{header: "<?php __('New 1 Birr'); ?>", dataIndex: 'new_1_birr', sortable: true},
			{header: "<?php __('New 50 Cents'); ?>", dataIndex: 'new_50_cents', sortable: true},
			{header: "<?php __('New 25 Cents'); ?>", dataIndex: 'new_25_cents', sortable: true},
			{header: "<?php __('New 10 Cents'); ?>", dataIndex: 'new_10_cents', sortable: true},
			{header: "<?php __('New 5 Cents'); ?>", dataIndex: 'new_5_cents', sortable: true},
			{header: "<?php __('Date Of'); ?>", dataIndex: 'date_of', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Updated'); ?>", dataIndex: 'updated', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "AvailableBirrNotes" : "AvailableBirrNote"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewAvailableBirrNote(Ext.getCmp('availableBirrNote-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add AvailableBirrNotes</b><br />Click here to create a new AvailableBirrNote'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddAvailableBirrNote();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-availableBirrNote',
					tooltip:'<?php __('<b>Edit AvailableBirrNotes</b><br />Click here to modify the selected AvailableBirrNote'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditAvailableBirrNote(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-availableBirrNote',
					tooltip:'<?php __('<b>Delete AvailableBirrNotes(s)</b><br />Click here to remove the selected AvailableBirrNote(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove AvailableBirrNote'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteAvailableBirrNote(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove AvailableBirrNote'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected AvailableBirrNotes'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteAvailableBirrNote(sel_ids);
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
					text: '<?php __('View AvailableBirrNote'); ?>',
					id: 'view-availableBirrNote',
					tooltip:'<?php __('<b>View AvailableBirrNote</b><br />Click here to see details of the selected AvailableBirrNote'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewAvailableBirrNote(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-', ' ', {
					xtype: 'button',
					fieldStyle: 'background-color: #ddd; background-image: none;',

				        text: '<div style="color: #000088">Check if there is any Missed Report</div>',
					id: 'view-missedReports',
					tooltip:'<?php __('<b>View Missed Report</b><br />Click here to see any missed report'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
					
							ViewMissedReport();
						
					},
					
				}<?php if($this->Session->read('is_admin_logged')=='true'){ ?>  , ' ', '-',  '<?php __('Branch'); ?>: ', { 
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($branches as $item){if($st) echo ",
							";?>['<?php echo $item['Branch']['id']; ?>' ,'  <?php  echo $item['Branch']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_availableBirrNotes.reload({
								params: {
									start: 0,
									limit: list_size,
									branch_id : combo.getValue()
								}
							});
						}
					}
				}  <?php } ?>,
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'availableBirrNote_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByAvailableBirrNoteName(Ext.getCmp('availableBirrNote_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'availableBirrNote_go_button',
					handler: function(){
						SearchByAvailableBirrNoteName(Ext.getCmp('availableBirrNote_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchAvailableBirrNote();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_availableBirrNotes,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-availableBirrNote').enable();
		p.getTopToolbar().findById('delete-availableBirrNote').enable();
		p.getTopToolbar().findById('view-availableBirrNote').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-availableBirrNote').disable();
			p.getTopToolbar().findById('view-availableBirrNote').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-availableBirrNote').disable();
			p.getTopToolbar().findById('view-availableBirrNote').disable();
			p.getTopToolbar().findById('delete-availableBirrNote').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-availableBirrNote').enable();
			p.getTopToolbar().findById('view-availableBirrNote').enable();
			p.getTopToolbar().findById('delete-availableBirrNote').enable();
		}
		else{
			p.getTopToolbar().findById('edit-availableBirrNote').disable();
			p.getTopToolbar().findById('view-availableBirrNote').disable();
			p.getTopToolbar().findById('delete-availableBirrNote').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_availableBirrNotes.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
