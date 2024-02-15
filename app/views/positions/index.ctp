//<script>
var store_positions = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: ['id','name','grade','status','updated_by','approved_by']
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'positions', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'grade'
});


function AddPosition() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'positions', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var position_data = response.responseText;
			
			eval(position_data);
			
			PositionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the position add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditPosition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'positions', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var position_data = response.responseText;
			
			eval(position_data);
			
			PositionEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the position edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPosition(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'positions', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var position_data = response.responseText;

            eval(position_data);

            PositionViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the position view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeletePosition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'positions', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Position successfully deleted!'); ?>');
			RefreshPositionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the position add form. Error code'); ?>: ' + response.status);
		}
	});
}
function approve(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'positions', 'action' => 'approve')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Position successfully approved!'); ?>');
			RefreshPositionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the position add form. Error code'); ?>: ' + response.status);
		}
	});
}
function unlock(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'positions', 'action' => 'unlock')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Position successfully unlocked!'); ?>');
			RefreshPositionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the position add form. Error code'); ?>: ' + response.status);
		}
	});
}
function SearchPosition(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'positions', 'action' => 'search')); ?>',
		success: function(response, opts){
			var position_data = response.responseText;

			eval(position_data);

			positionSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the position search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByPositionName(value){
	var conditions = '\'Position.name LIKE\' => \'%' + value + '%\'';
	store_positions.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshPositionData() {
	store_positions.reload();
}


if(center_panel.find('id', 'position-tab') != "") {
	var p = center_panel.findById('position-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Positions'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'position-tab',
		xtype: 'grid',
		store: store_positions,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Grade'); ?>", dataIndex: 'grade', sortable: true},
			{header: "<?php __('status'); ?>", dataIndex: 'status', sortable: true},
			{header: "<?php __('last updated by'); ?>", dataIndex: 'updated_by', sortable: true},
			{header: "<?php __('last approved/unlocked by'); ?>", dataIndex: 'approved_by', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Positions" : "Position"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewPosition(Ext.getCmp('position-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Positions</b><br />Click here to create a new Position'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddPosition();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-position',
					tooltip:'<?php __('<b>Edit Positions</b><br />Click here to modify the selected Position'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditPosition(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-position',
					tooltip:'<?php __('<b>Delete Positions(s)</b><br />Click here to remove the selected Position(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Position'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeletePosition(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Position'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Positions'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeletePosition(sel_ids);
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
					text: '<?php __('View Position'); ?>',
					id: 'view-position',
					tooltip:'<?php __('<b>View Position</b><br />Click here to see details of the selected Position'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewPosition(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Grade'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($grades as $item){if($st) echo ",
							";?>['<?php echo $item['Grade']['id']; ?>' ,'<?php echo $item['Grade']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_positions.reload({
								params: {
									start: 0,
									limit: list_size,
									grade_id : combo.getValue()
								}
							});
						}
					}
				}, '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'position_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByPositionName(Ext.getCmp('position_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'position_go_button',
					handler: function(){
						SearchByPositionName(Ext.getCmp('position_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchPosition();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_positions,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-position').enable();
		p.getTopToolbar().findById('delete-position').enable();
		p.getTopToolbar().findById('view-position').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-position').disable();
			p.getTopToolbar().findById('view-position').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-position').disable();
			p.getTopToolbar().findById('view-position').disable();
			p.getTopToolbar().findById('delete-position').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-position').enable();
			p.getTopToolbar().findById('view-position').enable();
			p.getTopToolbar().findById('delete-position').enable();
		}
		else{
			p.getTopToolbar().findById('edit-position').disable();
			p.getTopToolbar().findById('view-position').disable();
			p.getTopToolbar().findById('delete-position').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	
	
}
