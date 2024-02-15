
var store_compositions = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','position','branch','count','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'compositions', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'position_id', direction: "ASC"},
	groupField: 'branch_id'
});


function AddComposition() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'compositions', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var composition_data = response.responseText;
			
			eval(composition_data);
			
			CompositionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the composition add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditComposition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'compositions', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var composition_data = response.responseText;
			
			eval(composition_data);
			
			CompositionEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the composition edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewComposition(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'compositions', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var composition_data = response.responseText;

            eval(composition_data);

            CompositionViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the composition view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteComposition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'compositions', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Composition successfully deleted!'); ?>');
			RefreshCompositionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the composition add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchComposition(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'compositions', 'action' => 'search')); ?>',
		success: function(response, opts){
			var composition_data = response.responseText;

			eval(composition_data);

			compositionSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the composition search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByCompositionName(value){
	var conditions = '\'Composition.name LIKE\' => \'%' + value + '%\'';
	store_compositions.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshCompositionData() {
	store_compositions.reload();
}


if(center_panel.find('id', 'composition-tab') != "") {
	var p = center_panel.findById('composition-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Compositions'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'composition-tab',
		xtype: 'grid',
		store: store_compositions,
		columns: [
			{header: "<?php __('Position'); ?>", dataIndex: 'position', sortable: true},
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('Count'); ?>", dataIndex: 'count', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Compositions" : "Composition"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewComposition(Ext.getCmp('composition-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Compositions</b><br />Click here to create a new Composition'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddComposition();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-composition',
					tooltip:'<?php __('<b>Edit Compositions</b><br />Click here to modify the selected Composition'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditComposition(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-composition',
					tooltip:'<?php __('<b>Delete Compositions(s)</b><br />Click here to remove the selected Composition(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Composition'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteComposition(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Composition'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Compositions'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteComposition(sel_ids);
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
					text: '<?php __('View Composition'); ?>',
					id: 'view-composition',
					tooltip:'<?php __('<b>View Composition</b><br />Click here to see details of the selected Composition'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewComposition(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Position'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($positions as $item){if($st) echo ",
							";?>['<?php echo $item['Position']['id']; ?>' ,'<?php echo $item['Position']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_compositions.reload({
								params: {
									start: 0,
									limit: list_size,
									position_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'composition_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByCompositionName(Ext.getCmp('composition_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'composition_go_button',
					handler: function(){
						SearchByCompositionName(Ext.getCmp('composition_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchComposition();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_compositions,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-composition').enable();
		p.getTopToolbar().findById('delete-composition').enable();
		p.getTopToolbar().findById('view-composition').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-composition').disable();
			p.getTopToolbar().findById('view-composition').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-composition').disable();
			p.getTopToolbar().findById('view-composition').disable();
			p.getTopToolbar().findById('delete-composition').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-composition').enable();
			p.getTopToolbar().findById('view-composition').enable();
			p.getTopToolbar().findById('delete-composition').enable();
		}
		else{
			p.getTopToolbar().findById('edit-composition').disable();
			p.getTopToolbar().findById('view-composition').disable();
			p.getTopToolbar().findById('delete-composition').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_compositions.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
