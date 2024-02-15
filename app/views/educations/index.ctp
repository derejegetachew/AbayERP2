
var store_educations = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','level_of_attainment','field_of_study','institution','from_date','to_date','is_bank_related','employee','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'educations', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'level_of_attainment', direction: "ASC"},
	groupField: 'field_of_study'
});


function AddEducation() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'educations', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var education_data = response.responseText;
			
			eval(education_data);
			
			EducationAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the education add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditEducation(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'educations', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var education_data = response.responseText;
			
			eval(education_data);
			
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

function DeleteEducation(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'educations', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Education successfully deleted!'); ?>');
			RefreshEducationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the education add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchEducation(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'educations', 'action' => 'search')); ?>',
		success: function(response, opts){
			var education_data = response.responseText;

			eval(education_data);

			educationSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the education search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByEducationName(value){
	var conditions = '\'Education.name LIKE\' => \'%' + value + '%\'';
	store_educations.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshEducationData() {
	store_educations.reload();
}


if(center_panel.find('id', 'education-tab') != "") {
	var p = center_panel.findById('education-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Educations'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'education-tab',
		xtype: 'grid',
		store: store_educations,
		columns: [
			{header: "<?php __('Level Of Attainment'); ?>", dataIndex: 'level_of_attainment', sortable: true},
			{header: "<?php __('Field Of Study'); ?>", dataIndex: 'field_of_study', sortable: true},
			{header: "<?php __('Institution'); ?>", dataIndex: 'institution', sortable: true},
			{header: "<?php __('From Date'); ?>", dataIndex: 'from_date', sortable: true},
			{header: "<?php __('To Date'); ?>", dataIndex: 'to_date', sortable: true},
			{header: "<?php __('Is Bank Related'); ?>", dataIndex: 'is_bank_related', sortable: true},
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Educations" : "Education"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewEducation(Ext.getCmp('education-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Educations</b><br />Click here to create a new Education'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddEducation();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-education',
					tooltip:'<?php __('<b>Edit Educations</b><br />Click here to modify the selected Education'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditEducation(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-education',
					tooltip:'<?php __('<b>Delete Educations(s)</b><br />Click here to remove the selected Education(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Education'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteEducation(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Education'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Educations'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteEducation(sel_ids);
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
					text: '<?php __('View Education'); ?>',
					id: 'view-education',
					tooltip:'<?php __('<b>View Education</b><br />Click here to see details of the selected Education'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewEducation(sel.data.id);
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
							store_educations.reload({
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
					id: 'education_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByEducationName(Ext.getCmp('education_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'education_go_button',
					handler: function(){
						SearchByEducationName(Ext.getCmp('education_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchEducation();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_educations,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-education').enable();
		p.getTopToolbar().findById('delete-education').enable();
		p.getTopToolbar().findById('view-education').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-education').disable();
			p.getTopToolbar().findById('view-education').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-education').disable();
			p.getTopToolbar().findById('view-education').disable();
			p.getTopToolbar().findById('delete-education').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-education').enable();
			p.getTopToolbar().findById('view-education').enable();
			p.getTopToolbar().findById('delete-education').enable();
		}
		else{
			p.getTopToolbar().findById('edit-education').disable();
			p.getTopToolbar().findById('view-education').disable();
			p.getTopToolbar().findById('delete-education').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_educations.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
