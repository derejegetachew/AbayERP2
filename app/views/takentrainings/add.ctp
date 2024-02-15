		<?php
			$this->ExtForm->create('Takentraining');
			$this->ExtForm->defineFieldFunctions();
		?>
		var TakentrainingAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'takentrainings', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $trainings;
					$this->ExtForm->input('training_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('from', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('to', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('half_day', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $trainingvenues;
					$this->ExtForm->input('trainingvenue_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('cost_per_person', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $trainers;
					$this->ExtForm->input('trainer_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $trainingtargets;
					$this->ExtForm->input('trainingtarget_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('certification', $options);
				?>			]
		});
		
		var TakentrainingAddWindow = new Ext.Window({
			title: '<?php __('Add Takentraining'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: TakentrainingAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					TakentrainingAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Takentraining.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(TakentrainingAddWindow.collapsed)
						TakentrainingAddWindow.expand(true);
					else
						TakentrainingAddWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					TakentrainingAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							TakentrainingAddWindow.close();

		Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'stafftooktrainings', 'action' => 'add2')); ?>/'+a.result.id,
		success: function(response, opts) {
			var parent_stafftooktraining_data = response.responseText;
			
			eval(parent_stafftooktraining_data);
			
			StafftooktrainingAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the stafftooktraining add form. Error code'); ?>: ' + response.status);
		}
	});
							RefreshTakentrainingData();
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
					TakentrainingAddWindow.close();
				}
			}]
		});
