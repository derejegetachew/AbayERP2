		<?php
			$this->ExtForm->create('Stafftooktraining');
			$this->ExtForm->defineFieldFunctions();
		?>
		 
		var StafftooktrainingAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'stafftooktrainings', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $takentrainings;
					$this->ExtForm->input('takentraining_id', $options);
				?>,
				{
                        xtype: 'combo',
                        hiddenName: 'data[Stafftooktraining][employee_id]',
                        id: 'data[Stafftooktraining][employee_id]',
                        forceSelection: true,
                        emptyText: 'Enter Employee Name here',
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'local',
                        valueField: 'id',
                        displayField: 'full_name',
                        allowBlank: false,
                        blankText: 'Your input is invalid.',
                        store : vstore_employee_names,
                        fieldLabel: 'Full Name',
                        width:250,
                        hideTrigger:true,
                        tpl: '<tpl for="."><div ext:qtip="{full_name} . {position}" class="x-combo-list-item">{full_name} <br><b>{position}</b></div></tpl>'                       
                                    }
					]
		});
		
		var StafftooktrainingAddWindow = new Ext.Window({
			title: '<?php __('Add Stafftooktraining'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: StafftooktrainingAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					StafftooktrainingAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Stafftooktraining.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(StafftooktrainingAddWindow.collapsed)
						StafftooktrainingAddWindow.expand(true);
					else
						StafftooktrainingAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					StafftooktrainingAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							StafftooktrainingAddWindow.close();
							RefreshParentStafftooktrainingData();
							
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
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					StafftooktrainingAddWindow.close();
				}
			}]
		});
