		<?php
			$this->ExtForm->create('Experience');
			$this->ExtForm->defineFieldFunctions();
		?>
 var store_employer = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id', 'employer'
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'experiences', 'action' => 'employer')); ?>'
	})
    });
          store_employer.load({
            params: {
                start: 0,
                limit:100
            }
        });
 var store_job_title = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id', 'job_title'		
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'experiences', 'action' => 'job_title')); ?>'
	})
    });
          store_job_title.load({
            params: {
                start: 0,
                limit:100
            }
        });
		var ExperienceEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'experiences', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $experience['Experience']['id'])); ?>,
                                {
                                    xtype: 'combo',
                                    name: 'data[Experience][employer]',
                                    emptyText: 'All',
                                    id: 'data[Experience][employer]',
                                    name: 'data[Experience][employer]',
                                    store : store_employer,
                                    displayField : 'employer',
                                    valueField : 'id',
                                    fieldLabel: '<span style="color:red;">*</span> Employer',
                                    mode: 'local',
                                    disableKeyFilter : true,
                                    allowBlank: false,
                                    emptyText: '',
                                    editable: true,
                                    triggerAction: 'all',
                                    hideTrigger:true,
                                    width:250,
                                    value:'<?php echo  $experience['Experience']['employer']; ?>'
                                },
                                {
                                    xtype: 'combo',
                                    name: 'data[Experience][job_title]',
                                    emptyText: 'All',
                                    id: 'data[Experience][job_title]',
                                    name: 'data[Experience][job_title]',
                                    store : store_job_title,
                                    displayField : 'job_title',
                                    valueField : 'id',
                                    fieldLabel: '<span style="color:red;">*</span> Job Title',
                                    mode: 'local',
                                    disableKeyFilter : true,
                                    allowBlank: false,
                                    emptyText: '',
                                    editable: true,
                                    triggerAction: 'all',
                                    hideTrigger:true,
                                    width:250,
                                    value:'<?php echo $experience['Experience']['job_title']; ?>'
                                },
				<?php 
					$options = array();
					$options['value'] = $experience['Experience']['from_date'];
					$this->ExtForm->input('from_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $experience['Experience']['to_date'];
					$this->ExtForm->input('to_date', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$options['value'] = $experience['Experience']['employee_id'];
					$this->ExtForm->input('employee_id', $options);
				?>			]
		});
		
		var ExperienceEditWindow = new Ext.Window({
			title: '<?php __('Edit Experience'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ExperienceEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ExperienceEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Experience.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ExperienceEditWindow.collapsed)
						ExperienceEditWindow.expand(true);
					else
						ExperienceEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ExperienceEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ExperienceEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentExperienceData();
<?php } else { ?>
							RefreshExperienceData();
<?php } ?>
						},
						failure: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Warning'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.errormsg,
                                icon: Ext.MessageBox.ERROR
							});
						}
					});
				}
			},{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					ExperienceEditWindow.close();
				}
			}]
		});
