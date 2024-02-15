var store_parent_languages = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','speak','read','write','listen','employee','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'languages', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentLanguage() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'languages', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_language_data = response.responseText;
			
			eval(parent_language_data);
			
			LanguageAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the language add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentLanguage(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'languages', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_language_data = response.responseText;
			
			eval(parent_language_data);
			
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


function DeleteParentLanguage(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'languages', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Language(s) successfully deleted!'); ?>');
			RefreshParentLanguageData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the language to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentLanguageName(value){
	var conditions = '\'Language.name LIKE\' => \'%' + value + '%\'';
	store_parent_languages.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentLanguageData() {
	store_parent_languages.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Languages'); ?>',
	store: store_parent_languages,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'languageGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Speak'); ?>", dataIndex: 'speak', sortable: true},
		{header: "<?php __('Read'); ?>", dataIndex: 'read', sortable: true},
		{header: "<?php __('Write'); ?>", dataIndex: 'write', sortable: true},
		{header: "<?php __('Listen'); ?>", dataIndex: 'listen', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewLanguage(Ext.getCmp('languageGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Language</b><br />Click here to create a new Language'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentLanguage();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-language',
				tooltip:'<?php __('<b>Edit Language</b><br />Click here to modify the selected Language'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentLanguage(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-language',
				tooltip:'<?php __('<b>Delete Language(s)</b><br />Click here to remove the selected Language(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Language'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentLanguage(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Language'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Language'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentLanguage(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			},' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_languages,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-language').enable();
	g.getTopToolbar().findById('delete-parent-language').enable();
        g.getTopToolbar().findById('view-language2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-language').disable();
                g.getTopToolbar().findById('view-language2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-language').disable();
		g.getTopToolbar().findById('delete-parent-language').enable();
                g.getTopToolbar().findById('view-language2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-language').enable();
		g.getTopToolbar().findById('delete-parent-language').enable();
                g.getTopToolbar().findById('view-language2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-language').disable();
		g.getTopToolbar().findById('delete-parent-language').disable();
                g.getTopToolbar().findById('view-language2').disable();
	}
});



var parentLanguagesViewWindow = new Ext.Window({
	title: 'Language Under the selected Item',
	width: 700,
	height:375,
	minWidth: 700,
	minHeight: 400,
	resizable: false,
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
			parentLanguagesViewWindow.close();
		}
	}]
});

store_parent_languages.load({
    params: {
        start: 0,    
        limit: list_size
    }
});