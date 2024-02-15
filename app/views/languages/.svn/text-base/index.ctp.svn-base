
var store_languages = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','speak','read','write','listen','employee','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'languages', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'speak'
});


function AddLanguage() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'languages', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var language_data = response.responseText;
			
			eval(language_data);
			
			LanguageAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the language add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditLanguage(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'languages', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var language_data = response.responseText;
			
			eval(language_data);
			
			LanguageEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the language edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewLanguage(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'languages', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var language_data = response.responseText;

            eval(language_data);

            LanguageViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the language view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteLanguage(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'languages', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Language successfully deleted!'); ?>');
			RefreshLanguageData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the language add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchLanguage(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'languages', 'action' => 'search')); ?>',
		success: function(response, opts){
			var language_data = response.responseText;

			eval(language_data);

			languageSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the language search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByLanguageName(value){
	var conditions = '\'Language.name LIKE\' => \'%' + value + '%\'';
	store_languages.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshLanguageData() {
	store_languages.reload();
}


if(center_panel.find('id', 'language-tab') != "") {
	var p = center_panel.findById('language-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Languages'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'language-tab',
		xtype: 'grid',
		store: store_languages,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Speak'); ?>", dataIndex: 'speak', sortable: true},
			{header: "<?php __('Read'); ?>", dataIndex: 'read', sortable: true},
			{header: "<?php __('Write'); ?>", dataIndex: 'write', sortable: true},
			{header: "<?php __('Listen'); ?>", dataIndex: 'listen', sortable: true},
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Languages" : "Language"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewLanguage(Ext.getCmp('language-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Languages</b><br />Click here to create a new Language'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddLanguage();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-language',
					tooltip:'<?php __('<b>Edit Languages</b><br />Click here to modify the selected Language'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditLanguage(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-language',
					tooltip:'<?php __('<b>Delete Languages(s)</b><br />Click here to remove the selected Language(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Language'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteLanguage(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Language'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Languages'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteLanguage(sel_ids);
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
					text: '<?php __('View Language'); ?>',
					id: 'view-language',
					tooltip:'<?php __('<b>View Language</b><br />Click here to see details of the selected Language'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewLanguage(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Employee'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($employees as $item){if($st) echo ",
							";?>['<?php echo $item['Employee']['id']; ?>' ,'<?php echo $item['Employee']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_languages.reload({
								params: {
									start: 0,
									limit: list_size,
									employee_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'language_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByLanguageName(Ext.getCmp('language_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'language_go_button',
					handler: function(){
						SearchByLanguageName(Ext.getCmp('language_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchLanguage();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_languages,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-language').enable();
		p.getTopToolbar().findById('delete-language').enable();
		p.getTopToolbar().findById('view-language').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-language').disable();
			p.getTopToolbar().findById('view-language').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-language').disable();
			p.getTopToolbar().findById('view-language').disable();
			p.getTopToolbar().findById('delete-language').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-language').enable();
			p.getTopToolbar().findById('view-language').enable();
			p.getTopToolbar().findById('delete-language').enable();
		}
		else{
			p.getTopToolbar().findById('edit-language').disable();
			p.getTopToolbar().findById('view-language').disable();
			p.getTopToolbar().findById('delete-language').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_languages.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
