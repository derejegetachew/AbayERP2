
var store_experiences = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employer','job_title','from_date','to_date','employee','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'experiences', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'employer', direction: "ASC"},
	groupField: 'job_title'
});


function AddExperience() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'experiences', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var experience_data = response.responseText;
			
			eval(experience_data);
			
			ExperienceAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the experience add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditExperience(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'experiences', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var experience_data = response.responseText;
			
			eval(experience_data);
			
			ExperienceEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the experience edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewExperience(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'experiences', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var experience_data = response.responseText;

            eval(experience_data);

            ExperienceViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the experience view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteExperience(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'experiences', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Experience successfully deleted!'); ?>');
			RefreshExperienceData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the experience add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchExperience(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'experiences', 'action' => 'search')); ?>',
		success: function(response, opts){
			var experience_data = response.responseText;

			eval(experience_data);

			experienceSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the experience search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByExperienceName(value){
	var conditions = '\'Experience.name LIKE\' => \'%' + value + '%\'';
	store_experiences.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshExperienceData() {
	store_experiences.reload();
}


if(center_panel.find('id', 'experience-tab') != "") {
	var p = center_panel.findById('experience-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Experiences'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'experience-tab',
		xtype: 'grid',
		store: store_experiences,
		columns: [
			{header: "<?php __('Employer'); ?>", dataIndex: 'employer', sortable: true},
			{header: "<?php __('Job Title'); ?>", dataIndex: 'job_title', sortable: true},
			{header: "<?php __('From Date'); ?>", dataIndex: 'from_date', sortable: true},
			{header: "<?php __('To Date'); ?>", dataIndex: 'to_date', sortable: true},
			{header: "<?php __('Employee'); ?>", dataIndex: 'employee', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Experiences" : "Experience"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewExperience(Ext.getCmp('experience-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Experiences</b><br />Click here to create a new Experience'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddExperience();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-experience',
					tooltip:'<?php __('<b>Edit Experiences</b><br />Click here to modify the selected Experience'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditExperience(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-experience',
					tooltip:'<?php __('<b>Delete Experiences(s)</b><br />Click here to remove the selected Experience(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Experience'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteExperience(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Experience'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Experiences'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteExperience(sel_ids);
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
					text: '<?php __('View Experience'); ?>',
					id: 'view-experience',
					tooltip:'<?php __('<b>View Experience</b><br />Click here to see details of the selected Experience'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewExperience(sel.data.id);
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
							store_experiences.reload({
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
					id: 'experience_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByExperienceName(Ext.getCmp('experience_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'experience_go_button',
					handler: function(){
						SearchByExperienceName(Ext.getCmp('experience_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchExperience();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_experiences,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-experience').enable();
		p.getTopToolbar().findById('delete-experience').enable();
		p.getTopToolbar().findById('view-experience').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-experience').disable();
			p.getTopToolbar().findById('view-experience').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-experience').disable();
			p.getTopToolbar().findById('view-experience').disable();
			p.getTopToolbar().findById('delete-experience').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-experience').enable();
			p.getTopToolbar().findById('view-experience').enable();
			p.getTopToolbar().findById('delete-experience').enable();
		}
		else{
			p.getTopToolbar().findById('edit-experience').disable();
			p.getTopToolbar().findById('view-experience').disable();
			p.getTopToolbar().findById('delete-experience').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_experiences.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
