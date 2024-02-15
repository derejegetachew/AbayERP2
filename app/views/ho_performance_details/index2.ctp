var store_parent_hoPerformanceDetails = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','perspective','objective','plan_description','plan_in_number','actual_result','measure','weight','accomplishment','total_score','final_score','direction'
			
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformanceDetails', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentHoPerformanceDetail() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformanceDetails', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_hoPerformanceDetail_data = response.responseText;
			
			eval(parent_hoPerformanceDetail_data);
			
			HoPerformanceDetailAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformanceDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentHoPerformanceDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformanceDetails', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_hoPerformanceDetail_data = response.responseText;
			
			eval(parent_hoPerformanceDetail_data);
			
			HoPerformanceDetailEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformanceDetail edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewHoPerformanceDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformanceDetails', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var hoPerformanceDetail_data = response.responseText;

			eval(hoPerformanceDetail_data);

			HoPerformanceDetailViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformanceDetail view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentHoPerformanceDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformanceDetails', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('HoPerformanceDetail(s) successfully deleted!'); ?>');
			RefreshParentHoPerformanceDetailData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformanceDetail to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentHoPerformanceDetailName(value){
	var conditions = '\'HoPerformanceDetail.name LIKE\' => \'%' + value + '%\'';
	store_parent_hoPerformanceDetails.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentHoPerformanceDetailData() {
	store_parent_hoPerformanceDetails.reload();
}
var myMask = new Ext.LoadMask(Ext.getBody(), {msg: "Processing please wait..."});

function RecalculateRefresh(id) {
	myMask.show();
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformanceDetails', 'action' => 'recalculate')); ?>/'+id,
		success: function(response, opts) {
			var hoPerformanceDetail_data = response.responseText;
			
		   // eval(hoPerformanceDetail_data);
			
		   myMask.hide();
		   store_parent_hoPerformanceDetails .reload();
		},
		failure: function(response, opts) {
			myMask.hide();
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformanceDetail edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function showMenu(grid, index, event) {
        event.stopEvent();
        var record = grid.getStore().getAt(index);
        var btnStatus = 0; //(record.get('rejectable') == 'True')? false: true;
        var menu = new Ext.menu.Menu({
            items: [
                {
                    text: '<b>Recalculate / Refresh </b>',
                    icon: 'img/table_add.png',
                    handler: function() {
                       RecalculateRefresh(record.get('id'));
					   
                    }
                }
            ]
        }).showAt(event.xy);
    }

function copy_previous_details() {
	var id = <?php echo $parent_id; ?> ;
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformanceDetails', 'action' => 'copy_previous_details')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_hoPerformanceDetail_data = response.responseText;
			
			eval(parent_hoPerformanceDetail_data);
			
			HoCopyPreviousDetailsWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformanceDetail edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function copy_previous_details_person() {
	var id = <?php echo $parent_id; ?> ;
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformanceDetails', 'action' => 'copy_previous_details_person')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_hoPerformanceDetail_data = response.responseText;
			
			eval(parent_hoPerformanceDetail_data);
			
			HoCopyPreviousDetailsWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformanceDetail edit form. Error code'); ?>: ' + response.status);
		}
	});
}


var g = new Ext.grid.GridPanel({
	title: '<?php __('HoPerformanceDetails'); ?>',
	store: store_parent_hoPerformanceDetails,
	loadMask: true,
	stripeRows: true,
    width: 1300,
	height: 400,
	anchor: '100%',
    id: 'hoPerformanceDetailGrid',
	columns: [
		
		{header: "<?php __('Perspective'); ?>", dataIndex: 'perspective', sortable: true},
		{header: "<?php __('Objective'); ?>", dataIndex: 'objective', sortable: true},
		{header: "<?php __('Plan Description(KPI)'); ?>", dataIndex: 'plan_description', sortable: true},
		{header: "<?php __('Plan In Number'); ?>", dataIndex: 'plan_in_number', sortable: true},
		{header: "<?php __('Actual Result'); ?>", dataIndex: 'actual_result', sortable: true},
		{header: "<?php __('Measure'); ?>", dataIndex: 'measure', sortable: true},
		{header: "<?php __('Weight'); ?>", dataIndex: 'weight', sortable: true},
		{header: "<?php __('Accomplishment'); ?>", dataIndex: 'accomplishment', sortable: true},
		{header: "<?php __('Total Score'); ?>", dataIndex: 'total_score', sortable: true},
		{header: "<?php __('Final Score'); ?>", dataIndex: 'final_score', sortable: true},
		{header: "<?php __('Direction'); ?>", dataIndex: 'direction', sortable: true},
		
			],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true,
   
	},
    listeners: {
        celldblclick: function(){
            ViewHoPerformanceDetail(Ext.getCmp('hoPerformanceDetailGrid').getSelectionModel().getSelected().data.id);
        },
		'rowcontextmenu': function(grid, index, event) {
                    showMenu(grid, index, event);
                        //grid.selectedNode = grid.store.getAt(row); // we need this
                        //if((index) !== false) {
                        this.getSelectionModel().selectRow(index);
                        //}
                }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add HoPerformanceDetail</b><br />Click here to create a new HoPerformanceDetail'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentHoPerformanceDetail();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-hoPerformanceDetail',
				tooltip:'<?php __('<b>Edit HoPerformanceDetail</b><br />Click here to modify the selected HoPerformanceDetail'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentHoPerformanceDetail(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-hoPerformanceDetail',
				tooltip:'<?php __('<b>Delete HoPerformanceDetail(s)</b><br />Click here to remove the selected HoPerformanceDetail(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove HoPerformanceDetail'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentHoPerformanceDetail(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove HoPerformanceDetail'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected HoPerformanceDetail'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentHoPerformanceDetail(sel_ids);
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
				text: '<?php __('View HoPerformanceDetail'); ?>',
				id: 'view-hoPerformanceDetail2',
				tooltip:'<?php __('<b>View HoPerformanceDetail</b><br />Click here to see details of the selected HoPerformanceDetail'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewHoPerformanceDetail(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            },' ','-',' ', {
				xtype: 'tbsplit',
				text: '<?php __('Copy previous (by position)'); ?>',
				id: 'copy-previous-details',
				tooltip:'<?php __('<b>Copy previous by position</b><br />Click here to see details of the selected HoPerformanceDetail'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				
				handler: function(btn) {
					
					copy_previous_details();

				},
				menu : {
					items: [
					]
				}

            }, ' ','-',' ', {
				xtype: 'tbsplit',
				text: '<?php __('Copy previous (by person)'); ?>',
				id: 'copy-previous-details-person',
				tooltip:'<?php __('<b>Copy previous by person</b><br />Click here to see details of the selected HoPerformanceDetail'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				
				handler: function(btn) {
					
					copy_previous_details_person();

				},
				menu : {
					items: [
					]
				}

            },  ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_hoPerformanceDetails,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-hoPerformanceDetail').enable();
	g.getTopToolbar().findById('delete-parent-hoPerformanceDetail').enable();
        g.getTopToolbar().findById('view-hoPerformanceDetail2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-hoPerformanceDetail').disable();
                g.getTopToolbar().findById('view-hoPerformanceDetail2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-hoPerformanceDetail').disable();
		g.getTopToolbar().findById('delete-parent-hoPerformanceDetail').enable();
                g.getTopToolbar().findById('view-hoPerformanceDetail2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-hoPerformanceDetail').enable();
		g.getTopToolbar().findById('delete-parent-hoPerformanceDetail').enable();
                g.getTopToolbar().findById('view-hoPerformanceDetail2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-hoPerformanceDetail').disable();
		g.getTopToolbar().findById('delete-parent-hoPerformanceDetail').disable();
                g.getTopToolbar().findById('view-hoPerformanceDetail2').disable();
	}
});



var parentHoPerformanceDetailsViewWindow = new Ext.Window({
	title: 'HoPerformanceDetail Under the selected Item',
	width: 1300,
	height:375,
	minWidth: 700,
	minHeight: 400,
	resizable: true,
    autoScroll: true,
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
			parentHoPerformanceDetailsViewWindow.close();
		}
	}]
});

store_parent_hoPerformanceDetails.load({
    params: {
        start: 0,    
        limit: list_size
    }
});