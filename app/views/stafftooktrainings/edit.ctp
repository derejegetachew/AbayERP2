		<?php
			$this->ExtForm->create('Stafftooktraining');
			$this->ExtForm->defineFieldFunctions();
		?>
		var StafftooktrainingEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'stafftooktrainings', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $stafftooktraining['Stafftooktraining']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $takentrainings;
					$options['value'] = $stafftooktraining['Stafftooktraining']['takentraining_id'];
					$this->ExtForm->input('takentraining_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$options['value'] = $stafftooktraining['Stafftooktraining']['employee_id'];
					$this->ExtForm->input('employee_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $positions;
					$options['value'] = $stafftooktraining['Stafftooktraining']['position_id'];
					$this->ExtForm->input('position_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $branches;
					$options['value'] = $stafftooktraining['Stafftooktraining']['branch_id'];
					$this->ExtForm->input('branch_id', $options);
				?>			]
		});
		
		var StafftooktrainingEditWindow = new Ext.Window({
			title: '<?php __('Edit Stafftooktraining'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: StafftooktrainingEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					StafftooktrainingEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Stafftooktraining.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(StafftooktrainingEditWindow.collapsed)
						StafftooktrainingEditWindow.expand(true);
					else
						StafftooktrainingEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					StafftooktrainingEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							StafftooktrainingEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentStafftooktrainingData();
<?php } else { ?>
							RefreshStafftooktrainingData();
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
					StafftooktrainingEditWindow.close();
				}
			}]
		});
