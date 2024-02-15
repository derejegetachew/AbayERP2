
var store_spCats = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			
Warning: Invalid argument supplied for foreach() in C:\wamp\www\AbayERP\cake\console\templates\default\views\index.ctp on line 10

Call Stack:
    0.0030     542872   1. {main}() C:\wamp\www\AbayERP\cake\console\cake.php:0
    0.0032     543656   2. ShellDispatcher->ShellDispatcher() C:\wamp\www\AbayERP\cake\console\cake.php:660
    5.3635    2738680   3. ShellDispatcher->dispatch() C:\wamp\www\AbayERP\cake\console\cake.php:139
   15.6032    5378032   4. BakeShell->all() C:\wamp\www\AbayERP\cake\console\cake.php:373
  378.6831    9343712   5. ViewTask->execute() C:\wamp\www\AbayERP\cake\console\libs\bake.php:188
  378.9492   10486592   6. ViewTask->getContent() C:\wamp\www\AbayERP\cake\console\libs\tasks\view.php:137
  378.9495   10486144   7. TemplateTask->generate() C:\wamp\www\AbayERP\cake\console\libs\tasks\view.php:392
  379.0812   10668600   8. include('C:\wamp\www\AbayERP\cake\console\templates\default\views\index.ctp') C:\wamp\www\AbayERP\cake\console\libs\tasks\template.php:146

		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'spCats', 'action' => 'list_data')); ?>'
	})
});


function AddSpCat() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spCats', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var spCat_data = response.responseText;
			
			eval(spCat_data);
			
			SpCatAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spCat add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditSpCat(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spCats', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var spCat_data = response.responseText;
			
			eval(spCat_data);
			
			SpCatEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spCat edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewSpCat(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'spCats', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var spCat_data = response.responseText;

            eval(spCat_data);

            SpCatViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spCat view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteSpCat(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spCats', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('SpCat successfully deleted!'); ?>');
			RefreshSpCatData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spCat add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchSpCat(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spCats', 'action' => 'search')); ?>',
		success: function(response, opts){
			var spCat_data = response.responseText;

			eval(spCat_data);

			spCatSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the spCat search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchBySpCatName(value){
	var conditions = '\'SpCat.name LIKE\' => \'%' + value + '%\'';
	store_spCats.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshSpCatData() {
	store_spCats.reload();
}


if(center_panel.find('id', 'spCat-tab') != "") {
	var p = center_panel.findById('spCat-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Sp Cats'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'spCat-tab',
		xtype: 'grid',
		store: store_spCats,
		columns: [

Warning: Invalid argument supplied for foreach() in C:\wamp\www\AbayERP\cake\console\templates\default\views\index.ctp on line 183

Call Stack:
    0.0030     542872   1. {main}() C:\wamp\www\AbayERP\cake\console\cake.php:0
    0.0032     543656   2. ShellDispatcher->ShellDispatcher() C:\wamp\www\AbayERP\cake\console\cake.php:660
    5.3635    2738680   3. ShellDispatcher->dispatch() C:\wamp\www\AbayERP\cake\console\cake.php:139
   15.6032    5378032   4. BakeShell->all() C:\wamp\www\AbayERP\cake\console\cake.php:373
  378.6831    9343712   5. ViewTask->execute() C:\wamp\www\AbayERP\cake\console\libs\bake.php:188
  378.9492   10486592   6. ViewTask->getContent() C:\wamp\www\AbayERP\cake\console\libs\tasks\view.php:137
  378.9495   10486144   7. TemplateTask->generate() C:\wamp\www\AbayERP\cake\console\libs\tasks\view.php:392
  379.0812   10668600   8. include('C:\wamp\www\AbayERP\cake\console\templates\default\views\index.ctp') C:\wamp\www\AbayERP\cake\console\libs\tasks\template.php:146


		],
		viewConfig: {
			forceFit: true
		}
,
		listeners: {
			celldblclick: function(){
				ViewSpCat(Ext.getCmp('spCat-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add SpCats</b><br />Click here to create a new SpCat'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddSpCat();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-spCat',
					tooltip:'<?php __('<b>Edit SpCats</b><br />Click here to modify the selected SpCat'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditSpCat(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-spCat',
					tooltip:'<?php __('<b>Delete SpCats(s)</b><br />Click here to remove the selected SpCat(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove SpCat'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteSpCat(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove SpCat'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected SpCats'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteSpCat(sel_ids);
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
					text: '<?php __('View SpCat'); ?>',
					id: 'view-spCat',
					tooltip:'<?php __('<b>View SpCat</b><br />Click here to see details of the selected SpCat'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewSpCat(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'spCat_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchBySpCatName(Ext.getCmp('spCat_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'spCat_go_button',
					handler: function(){
						SearchBySpCatName(Ext.getCmp('spCat_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchSpCat();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_spCats,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-spCat').enable();
		p.getTopToolbar().findById('delete-spCat').enable();
		p.getTopToolbar().findById('view-spCat').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-spCat').disable();
			p.getTopToolbar().findById('view-spCat').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-spCat').disable();
			p.getTopToolbar().findById('view-spCat').disable();
			p.getTopToolbar().findById('delete-spCat').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-spCat').enable();
			p.getTopToolbar().findById('view-spCat').enable();
			p.getTopToolbar().findById('delete-spCat').enable();
		}
		else{
			p.getTopToolbar().findById('edit-spCat').disable();
			p.getTopToolbar().findById('view-spCat').disable();
			p.getTopToolbar().findById('delete-spCat').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_spCats.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
