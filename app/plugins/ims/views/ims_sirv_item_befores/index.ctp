
var store_imsSirvItemBefores = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ims_sirv_before','ims_item','measurement','quantity','unit_price','remark'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItemBefores', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'ims_sirv_before_id', direction: "ASC"},
	groupField: 'ims_item_id'
});


function AddImsSirvItemBefore() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItemBefores', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsSirvItemBefore_data = response.responseText;
			
			eval(imsSirvItemBefore_data);
			
			ImsSirvItemBeforeAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvItemBefore add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsSirvItemBefore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItemBefores', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsSirvItemBefore_data = response.responseText;
			
			eval(imsSirvItemBefore_data);
			
			ImsSirvItemBeforeEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvItemBefore edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsSirvItemBefore(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItemBefores', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsSirvItemBefore_data = response.responseText;

            eval(imsSirvItemBefore_data);

            ImsSirvItemBeforeViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvItemBefore view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentImsTags(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsTags', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_imsTags_data = response.responseText;

            eval(parent_imsTags_data);

            parentImsTagsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteImsSirvItemBefore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItemBefores', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsSirvItemBefore successfully deleted!'); ?>');
			RefreshImsSirvItemBeforeData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvItemBefore add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsSirvItemBefore(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItemBefores', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsSirvItemBefore_data = response.responseText;

			eval(imsSirvItemBefore_data);

			imsSirvItemBeforeSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the imsSirvItemBefore search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsSirvItemBeforeName(value){
	var conditions = '\'ImsSirvItemBefore.name LIKE\' => \'%' + value + '%\'';
	store_imsSirvItemBefores.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsSirvItemBeforeData() {
	store_imsSirvItemBefores.reload();
}


if(center_panel.find('id', 'imsSirvItemBefore-tab') != "") {
	var p = center_panel.findById('imsSirvItemBefore-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ims Sirv Item Befores'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsSirvItemBefore-tab',
		xtype: 'grid',
		store: store_imsSirvItemBefores,
		columns: [
			{header: "<?php __('ImsSirvBefore'); ?>", dataIndex: 'ims_sirv_before', sortable: true},
			{header: "<?php __('ImsItem'); ?>", dataIndex: 'ims_item', sortable: true},
			{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
			{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
			{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
			{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsSirvItemBefores" : "ImsSirvItemBefore"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewImsSirvItemBefore(Ext.getCmp('imsSirvItemBefore-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add ImsSirvItemBefores</b><br />Click here to create a new ImsSirvItemBefore'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsSirvItemBefore();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsSirvItemBefore',
					tooltip:'<?php __('<b>Edit ImsSirvItemBefores</b><br />Click here to modify the selected ImsSirvItemBefore'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsSirvItemBefore(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsSirvItemBefore',
					tooltip:'<?php __('<b>Delete ImsSirvItemBefores(s)</b><br />Click here to remove the selected ImsSirvItemBefore(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove ImsSirvItemBefore'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsSirvItemBefore(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove ImsSirvItemBefore'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected ImsSirvItemBefores'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsSirvItemBefore(sel_ids);
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
					text: '<?php __('View ImsSirvItemBefore'); ?>',
					id: 'view-imsSirvItemBefore',
					tooltip:'<?php __('<b>View ImsSirvItemBefore</b><br />Click here to see details of the selected ImsSirvItemBefore'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsSirvItemBefore(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Ims Tags'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentImsTags(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '<?php __('ImsSirvBefore'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($imssirvbefores as $item){if($st) echo ",
							";?>['<?php echo $item['ImsSirvBefore']['id']; ?>' ,'<?php echo $item['ImsSirvBefore']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_imsSirvItemBefores.reload({
								params: {
									start: 0,
									limit: list_size,
									imssirvbefore_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsSirvItemBefore_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsSirvItemBeforeName(Ext.getCmp('imsSirvItemBefore_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsSirvItemBefore_go_button',
					handler: function(){
						SearchByImsSirvItemBeforeName(Ext.getCmp('imsSirvItemBefore_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsSirvItemBefore();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsSirvItemBefores,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-imsSirvItemBefore').enable();
		p.getTopToolbar().findById('delete-imsSirvItemBefore').enable();
		p.getTopToolbar().findById('view-imsSirvItemBefore').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsSirvItemBefore').disable();
			p.getTopToolbar().findById('view-imsSirvItemBefore').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsSirvItemBefore').disable();
			p.getTopToolbar().findById('view-imsSirvItemBefore').disable();
			p.getTopToolbar().findById('delete-imsSirvItemBefore').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-imsSirvItemBefore').enable();
			p.getTopToolbar().findById('view-imsSirvItemBefore').enable();
			p.getTopToolbar().findById('delete-imsSirvItemBefore').enable();
		}
		else{
			p.getTopToolbar().findById('edit-imsSirvItemBefore').disable();
			p.getTopToolbar().findById('view-imsSirvItemBefore').disable();
			p.getTopToolbar().findById('delete-imsSirvItemBefore').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsSirvItemBefores.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
