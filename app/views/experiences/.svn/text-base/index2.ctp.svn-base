//<script>
    var store_parent_experiences = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','employer','job_title','from_date',
                'to_date','employee','created','modified'	
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'experiences', 'action' => 'list_data', $parent_id)); ?>'	})
    });


    function AddParentExperience() {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'experiences', 'action' => 'add', $parent_id)); ?>',
            success: function(response, opts) {
                var parent_experience_data = response.responseText;
			
                eval(parent_experience_data);
			
                ExperienceAddWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the experience add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function EditParentExperience(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'experiences', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
            success: function(response, opts) {
                var parent_experience_data = response.responseText;
			
                eval(parent_experience_data);
			
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


    function DeleteParentExperience(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'experiences', 'action' => 'delete')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Experience(s) successfully deleted!'); ?>');
                RefreshParentExperienceData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the experience to be deleted. Error code'); ?>: ' + response.status);
            }
	});
    }

    function SearchByParentExperienceName(value){
	var conditions = '\'Experience.name LIKE\' => \'%' + value + '%\'';
	store_parent_experiences.reload({
            params: {
                start: 0,
                limit: list_size,
                conditions: conditions
	    }
	});
    }

    function RefreshParentExperienceData() {
	store_parent_experiences.reload();
    }



    var g = new Ext.grid.GridPanel({
	title: '<?php __('Experiences'); ?>',
	store: store_parent_experiences,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
        id: 'experienceGrid',
	columns: [
            {header: "<?php __('Employer'); ?>", dataIndex: 'employer', sortable: true},
            {header: "<?php __('Job Title'); ?>", dataIndex: 'job_title', sortable: true},
            {header: "<?php __('From Date'); ?>", dataIndex: 'from_date', sortable: true},
            {header: "<?php __('To Date'); ?>", dataIndex: 'to_date', sortable: true}	
        ],
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
                    tooltip:'<?php __('<b>Add Experience</b><br />Click here to create a new Experience'); ?>',
                    icon: 'img/table_add.png',
                    cls: 'x-btn-text-icon',
                    handler: function(btn) {
                        AddParentExperience();
                    }
                }, ' ', '-', ' ', {
                    xtype: 'tbbutton',
                    text: '<?php __('Edit'); ?>',
                    id: 'edit-parent-experience',
                    tooltip:'<?php __('<b>Edit Experience</b><br />Click here to modify the selected Experience'); ?>',
                    icon: 'img/table_edit.png',
                    cls: 'x-btn-text-icon',
                    disabled: true,
                    handler: function(btn) {
                        var sm = g.getSelectionModel();
                        var sel = sm.getSelected();
                        if (sm.hasSelection()){
                            EditParentExperience(sel.data.id);
                        };
                    }
                }, ' ', '-', ' ', {
                    xtype: 'tbbutton',
                    text: '<?php __('Delete'); ?>',
                    id: 'delete-parent-experience',
                    tooltip:'<?php __('<b>Delete Experience(s)</b><br />Click here to remove the selected Experience(s)'); ?>',
                    icon: 'img/table_delete.png',
                    cls: 'x-btn-text-icon',
                    disabled: true,
                    handler: function(btn) {
                        var sm = g.getSelectionModel();
                        var sel = sm.getSelections();
                        if (sm.hasSelection()){
                            if(sel.length==1){
                                Ext.Msg.show({
                                    title: '<?php __('Remove Experience'); ?>',
                                    buttons: Ext.MessageBox.YESNOCANCEL,
                                    msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            DeleteParentExperience(sel[0].data.id);
                                        }
                                    }
                                });
                            } else {
                                Ext.Msg.show({
                                    title: '<?php __('Remove Experience'); ?>',
                                    buttons: Ext.MessageBox.YESNOCANCEL,
                                    msg: '<?php __('Remove the selected Experience'); ?>?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            var sel_ids = '';
                                            for(i=0;i<sel.length;i++){
                                                if(i>0)
                                                    sel_ids += '_';
                                                sel_ids += sel[i].data.id;
                                            }
                                            DeleteParentExperience(sel_ids);
                                        }
                                    }
                                });
                            }
                        } else {
                            Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
                        };
                    }
                }, ' '
            ]}),
	bbar: new Ext.PagingToolbar({
            pageSize: list_size,
            store: store_parent_experiences,
            displayInfo: true,
            displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
            beforePageText: '<?php __('Page'); ?>',
            afterPageText: '<?php __('of {0}'); ?>',
            emptyMsg: '<?php __('No data to display'); ?>'
	})
    });
    g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-experience').enable();
	g.getTopToolbar().findById('delete-parent-experience').enable();
        if(this.getSelections().length > 1){
            g.getTopToolbar().findById('edit-parent-experience').disable();
        }
    });
    g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
            g.getTopToolbar().findById('edit-parent-experience').disable();
            g.getTopToolbar().findById('delete-parent-experience').enable();
        }
	else if(this.getSelections().length == 1){
            g.getTopToolbar().findById('edit-parent-experience').enable();
            g.getTopToolbar().findById('delete-parent-experience').enable();
        }
	else{
            g.getTopToolbar().findById('edit-parent-experience').disable();
            g.getTopToolbar().findById('delete-parent-experience').disable();
        }
    });

    var parentExperiencesViewWindow = new Ext.Window({
	title: 'Experience of Employee: <b><?php echo $employee['User']['Person']['first_name'] . ' ' . $employee['User']['Person']['middle_name'] . ' ' . $employee['User']['Person']['last_name']; ?></b>',
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
                    parentExperiencesViewWindow.close();
                }
            }]
    });

    store_parent_experiences.load({
        params: {
            start: 0,    
            limit: list_size
        }
    });