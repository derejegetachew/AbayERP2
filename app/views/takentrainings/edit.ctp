		<?php
			$this->ExtForm->create('Takentraining');
			$this->ExtForm->defineFieldFunctions();
		?>
		var TakentrainingEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'takentrainings', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $takentraining['Takentraining']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $trainings;
					$options['value'] = $takentraining['Takentraining']['training_id'];
					$this->ExtForm->input('training_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $takentraining['Takentraining']['from'];
					$this->ExtForm->input('from', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $takentraining['Takentraining']['to'];
					$this->ExtForm->input('to', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $takentraining['Takentraining']['half_day'];
					$this->ExtForm->input('half_day', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $trainingvenues;
					$options['value'] = $takentraining['Takentraining']['trainingvenue_id'];
					$this->ExtForm->input('trainingvenue_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $takentraining['Takentraining']['cost_per_person'];
					$this->ExtForm->input('cost_per_person', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $trainers;
					$options['value'] = $takentraining['Takentraining']['trainer_id'];
					$this->ExtForm->input('trainer_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $trainingtargets;
					$options['value'] = $takentraining['Takentraining']['trainingtarget_id'];
					$this->ExtForm->input('trainingtarget_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $takentraining['Takentraining']['certification'];
					$this->ExtForm->input('certification', $options);
				?>			]
		});
		
		var TakentrainingEditWindow = new Ext.Window({
			title: '<?php __('Edit Takentraining'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: TakentrainingEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					TakentrainingEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Takentraining.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(TakentrainingEditWindow.collapsed)
						TakentrainingEditWindow.expand(true);
					else
						TakentrainingEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					TakentrainingEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							TakentrainingEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentTakentrainingData();
<?php } else { ?>
							RefreshTakentrainingData();
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
					TakentrainingEditWindow.close();
				}
			}]
		});
