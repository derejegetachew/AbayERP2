//<script>
    var store_parent_educations = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','level_of_attainment','field_of_study','institution','date','is_bank_related','employee','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'educations', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentEducation() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'educations', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_education_data = response.responseText;
			
			eval(parent_education_data);
			
			EducationAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the education add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentEducation(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'educations', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_education_data = response.responseText;
			
			eval(parent_education_data);
			
			EducationEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the education edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewEducation(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'educations', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var education_data = response.responseText;

			eval(education_data);

			EducationViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the education view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentEducation(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'educations', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Education(s) successfully deleted!'); ?>');
			RefreshParentEducationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the education to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentEducationName(value){
	var conditions = '\'Education.name LIKE\' => \'%' + value + '%\'';
	store_parent_educations.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentEducationData() {
	store_parent_educations.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Educations'); ?>',
	store: store_parent_educations,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'educationGrid',
	columns: [
		{header: "<?php __('Level Of Attainment'); ?>", dataIndex: 'level_of_attainment', sortable: true},
		{header: "<?php __('Field Of Study'); ?>", dataIndex: 'field_of_study', sortable: true},
		{header: "<?php __('Institution'); ?>", dataIndex: 'institution', sortable: true},
		{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true},
		{header: "<?php __('Is Bank Related'); ?>", dataIndex: 'is_bank_related', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Education</b><br />Click here to create a new Education'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentEducation();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-education',
				tooltip:'<?php __('<b>Edit Education</b><br />Click here to modify the selected Education'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentEducation(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-education',
				tooltip:'<?php __('<b>Delete Education(s)</b><br />Click here to remove the selected Education(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Education'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentEducation(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Education'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Education'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentEducation(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			},  ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_educations,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-education').enable();
	g.getTopToolbar().findById('delete-parent-education').enable();
       // g.getTopToolbar().findById('view-education2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-education').disable();
              //  g.getTopToolbar().findById('view-education2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-education').disable();
		g.getTopToolbar().findById('delete-parent-education').enable();
            //    g.getTopToolbar().findById('view-education2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-education').enable();
		g.getTopToolbar().findById('delete-parent-education').enable();
              //  g.getTopToolbar().findById('view-education2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-education').disable();
		g.getTopToolbar().findById('delete-parent-education').disable();
              //  g.getTopToolbar().findById('view-education2').disable();
	}
});



var parentEducationsViewWindow = new Ext.Window({
	title: 'Education Under the selected Item',
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
			parentEducationsViewWindow.close();
		}
	}]
});

store_parent_educations.load({
    params: {
        start: 0,    
        limit: list_size
    }
});