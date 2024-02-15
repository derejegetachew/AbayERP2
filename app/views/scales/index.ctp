//<script>
var store_scales = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: ['id','grade','step','salary']
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'salary', direction: "ASC"},
	groupField: 'grade'
});


function AddScale() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var scale_data = response.responseText;
			
			eval(scale_data);
			
			ScaleAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the scale add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditScale(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var scale_data = response.responseText;
			
			eval(scale_data);
			
			ScaleEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the scale edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewScale(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var scale_data = response.responseText;

            eval(scale_data);

            ScaleViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the scale view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteScale(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Scale successfully deleted!'); ?>');
			RefreshScaleData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the scale add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchScale(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'search')); ?>',
		success: function(response, opts){
			var scale_data = response.responseText;

			eval(scale_data);

			scaleSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the scale search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByScaleName(value){
	var conditions = '\'Scale.name LIKE\' => \'%' + value + '%\'';
	store_scales.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshScaleData() {
	store_scales.reload();
}


if(center_panel.find('id', 'scale-tab') != "") {
	var p = center_panel.findById('scale-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Scales'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'scale-tab',
		xtype: 'grid',
		store: store_scales,
		columns: [
			{header: "<?php __('Grade'); ?>", dataIndex: 'grade', sortable: true},
			{header: "<?php __('Step'); ?>", dataIndex: 'step', sortable: true},
			{header: "<?php __('Salary'); ?>", dataIndex: 'salary', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Scales" : "Scale"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewScale(Ext.getCmp('scale-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Scales</b><br />Click here to create a new Scale'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddScale();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-scale',
					tooltip:'<?php __('<b>Edit Scales</b><br />Click here to modify the selected Scale'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditScale(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-scale',
					tooltip:'<?php __('<b>Delete Scales(s)</b><br />Click here to remove the selected Scale(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Scale'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteScale(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Scale'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Scales'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteScale(sel_ids);
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
					text: '<?php __('View Scale'); ?>',
					id: 'view-scale',
					tooltip:'<?php __('<b>View Scale</b><br />Click here to see details of the selected Scale'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewScale(sel.data.id);
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
							store_scales.reload({
								params: {
									start: 0,
									limit: list_size,
									grade_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'scale_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByScaleName(Ext.getCmp('scale_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'scale_go_button',
					handler: function(){
						SearchByScaleName(Ext.getCmp('scale_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchScale();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_scales,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-scale').enable();
		p.getTopToolbar().findById('delete-scale').enable();
		p.getTopToolbar().findById('view-scale').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-scale').disable();
			p.getTopToolbar().findById('view-scale').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-scale').disable();
			p.getTopToolbar().findById('view-scale').disable();
			p.getTopToolbar().findById('delete-scale').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-scale').enable();
			p.getTopToolbar().findById('view-scale').enable();
			p.getTopToolbar().findById('delete-scale').enable();
		}
		else{
			p.getTopToolbar().findById('edit-scale').disable();
			p.getTopToolbar().findById('view-scale').disable();
			p.getTopToolbar().findById('delete-scale').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_scales.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
