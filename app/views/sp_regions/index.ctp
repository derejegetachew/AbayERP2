
var store_spRegions = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'spRegions', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'created'
});


function AddSpRegion() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spRegions', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var spRegion_data = response.responseText;
			
			eval(spRegion_data);
			
			SpRegionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spRegion add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditSpRegion(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spRegions', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var spRegion_data = response.responseText;
			
			eval(spRegion_data);
			
			SpRegionEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spRegion edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewSpRegion(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'spRegions', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var spRegion_data = response.responseText;

            eval(spRegion_data);

            SpRegionViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spRegion view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentBranches(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'branches', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_branches_data = response.responseText;

            eval(parent_branches_data);

            parentBranchesViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteSpRegion(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spRegions', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('SpRegion successfully deleted!'); ?>');
			RefreshSpRegionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spRegion add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchSpRegion(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spRegions', 'action' => 'search')); ?>',
		success: function(response, opts){
			var spRegion_data = response.responseText;

			eval(spRegion_data);

			spRegionSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the spRegion search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchBySpRegionName(value){
	var conditions = '\'SpRegion.name LIKE\' => \'%' + value + '%\'';
	store_spRegions.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshSpRegionData() {
	store_spRegions.reload();
}


if(center_panel.find('id', 'spRegion-tab') != "") {
	var p = center_panel.findById('spRegion-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Regions'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'spRegion-tab',
		xtype: 'grid',
		store: store_spRegions,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "SpRegions" : "SpRegion"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewSpRegion(Ext.getCmp('spRegion-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add SpRegions</b><br />Click here to create a new SpRegion'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddSpRegion();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-spRegion',
					tooltip:'<?php __('<b>Edit SpRegions</b><br />Click here to modify the selected SpRegion'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditSpRegion(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-spRegion',
					tooltip:'<?php __('<b>Delete SpRegions(s)</b><br />Click here to remove the selected SpRegion(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove SpRegion'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteSpRegion(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove SpRegion'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected SpRegions'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteSpRegion(sel_ids);
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
					text: '<?php __('View SpRegion'); ?>',
					id: 'view-spRegion',
					tooltip:'<?php __('<b>View SpRegion</b><br />Click here to see details of the selected SpRegion'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewSpRegion(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Branches'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentBranches(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'spRegion_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchBySpRegionName(Ext.getCmp('spRegion_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'spRegion_go_button',
					handler: function(){
						SearchBySpRegionName(Ext.getCmp('spRegion_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchSpRegion();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_spRegions,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-spRegion').enable();
		p.getTopToolbar().findById('delete-spRegion').enable();
		p.getTopToolbar().findById('view-spRegion').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-spRegion').disable();
			p.getTopToolbar().findById('view-spRegion').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-spRegion').disable();
			p.getTopToolbar().findById('view-spRegion').disable();
			p.getTopToolbar().findById('delete-spRegion').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-spRegion').enable();
			p.getTopToolbar().findById('view-spRegion').enable();
			p.getTopToolbar().findById('delete-spRegion').enable();
		}
		else{
			p.getTopToolbar().findById('edit-spRegion').disable();
			p.getTopToolbar().findById('view-spRegion').disable();
			p.getTopToolbar().findById('delete-spRegion').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_spRegions.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
