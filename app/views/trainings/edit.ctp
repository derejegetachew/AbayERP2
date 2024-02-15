		<?php
			$this->ExtForm->create('Training');
			$this->ExtForm->defineFieldFunctions();
		?>
		var TrainingEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'trainings', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $training['Training']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $training['Training']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Type');
                    $options['items'] = array('Technical'=>'Technical','Leadership and management development'=>'Leadership and management development');
					$options['value'] = $training['Training']['type'];
					$this->ExtForm->input('type', $options);
				?>			]
		});
		
		var TrainingEditWindow = new Ext.Window({
			title: '<?php __('Edit Training'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: TrainingEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					TrainingEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Training.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(TrainingEditWindow.collapsed)
						TrainingEditWindow.expand(true);
					else
						TrainingEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					TrainingEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							TrainingEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentTrainingData();
<?php } else { ?>
							RefreshTrainingData();
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
					TrainingEditWindow.close();
				}
			}]
		});
