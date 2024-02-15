
var store_imsTags = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','code','ims_sirv_item','ims_sirv_item_before','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTags', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'code', direction: "ASC"},
	groupField: 'ims_sirv_item_id'
});


function AddImsTag() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTags', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsTag_data = response.responseText;
			
			eval(imsTag_data);
			
			ImsTagAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTag add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsTag(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTags', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsTag_data = response.responseText;
			
			eval(imsTag_data);
			
			ImsTagEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTag edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsTag(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsTags', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsTag_data = response.responseText;

            eval(imsTag_data);

            ImsTagViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTag view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteImsTag(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTags', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsTag successfully deleted!'); ?>');
			RefreshImsTagData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTag add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsTag(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTags', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsTag_data = response.responseText;

			eval(imsTag_data);

			imsTagSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the imsTag search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsTagName(value){
	var conditions = '\'ImsTag.name LIKE\' => \'%' + value + '%\'';
	store_imsTags.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsTagData() {
	store_imsTags.reload();
}


if(center_panel.find('id', 'imsTag-tab') != "") {
	var p = center_panel.findById('imsTag-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ims Tags'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsTag-tab',
		xtype: 'grid',
		store: store_imsTags,
		columns: [
			{header: "<?php __('Code'); ?>", dataIndex: 'code', sortable: true},
			{header: "<?php __('ImsSirvItem'); ?>", dataIndex: 'ims_sirv_item', sortable: true},
			{header: "<?php __('ImsSirvItemBefore'); ?>", dataIndex: 'ims_sirv_item_before', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsTags" : "ImsTag"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewImsTag(Ext.getCmp('imsTag-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add ImsTags</b><br />Click here to create a new ImsTag'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsTag();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsTag',
					tooltip:'<?php __('<b>Edit ImsTags</b><br />Click here to modify the selected ImsTag'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsTag(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsTag',
					tooltip:'<?php __('<b>Delete ImsTags(s)</b><br />Click here to remove the selected ImsTag(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove ImsTag'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsTag(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove ImsTag'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected ImsTags'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsTag(sel_ids);
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
					text: '<?php __('View ImsTag'); ?>',
					id: 'view-imsTag',
					tooltip:'<?php __('<b>View ImsTag</b><br />Click here to see details of the selected ImsTag'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsTag(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('ImsSirvItem'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($imssirvitems as $item){if($st) echo ",
							";?>['<?php echo $item['ImsSirvItem']['id']; ?>' ,'<?php echo $item['ImsSirvItem']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_imsTags.reload({
								params: {
									start: 0,
									limit: list_size,
									imssirvitem_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsTag_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsTagName(Ext.getCmp('imsTag_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsTag_go_button',
					handler: function(){
						SearchByImsTagName(Ext.getCmp('imsTag_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsTag();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsTags,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-imsTag').enable();
		p.getTopToolbar().findById('delete-imsTag').enable();
		p.getTopToolbar().findById('view-imsTag').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsTag').disable();
			p.getTopToolbar().findById('view-imsTag').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsTag').disable();
			p.getTopToolbar().findById('view-imsTag').disable();
			p.getTopToolbar().findById('delete-imsTag').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-imsTag').enable();
			p.getTopToolbar().findById('view-imsTag').enable();
			p.getTopToolbar().findById('delete-imsTag').enable();
		}
		else{
			p.getTopToolbar().findById('edit-imsTag').disable();
			p.getTopToolbar().findById('view-imsTag').disable();
			p.getTopToolbar().findById('delete-imsTag').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsTags.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
