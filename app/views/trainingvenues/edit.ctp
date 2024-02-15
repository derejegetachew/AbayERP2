		<?php
			$this->ExtForm->create('Trainingvenue');
			$this->ExtForm->defineFieldFunctions();
		?>
		var TrainingvenueEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'trainingvenues', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $trainingvenue['Trainingvenue']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $trainingvenue['Trainingvenue']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $trainingvenue['Trainingvenue']['address'];
					$this->ExtForm->input('address', $options);
				?>			]
		});
		
		var TrainingvenueEditWindow = new Ext.Window({
			title: '<?php __('Edit Trainingvenue'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: TrainingvenueEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					TrainingvenueEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Trainingvenue.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(TrainingvenueEditWindow.collapsed)
						TrainingvenueEditWindow.expand(true);
					else
						TrainingvenueEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					TrainingvenueEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							TrainingvenueEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentTrainingvenueData();
<?php } else { ?>
							RefreshTrainingvenueData();
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
					TrainingvenueEditWindow.close();
				}
			}]
		});
