		<?php
			$this->ExtForm->create('Claimonjobtraining');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ClaimonjobtrainingEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'claimonjobtrainings', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $claimonjobtraining['Claimonjobtraining']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $claimonjobtraining['Claimonjobtraining']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimonjobtraining['Claimonjobtraining']['branch'];
					$this->ExtForm->input('branch', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimonjobtraining['Claimonjobtraining']['position'];
					$this->ExtForm->input('position', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimonjobtraining['Claimonjobtraining']['date_of_employment'];
					$this->ExtForm->input('date_of_employment', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimonjobtraining['Claimonjobtraining']['placement_date'];
					$this->ExtForm->input('placement_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimonjobtraining['Claimonjobtraining']['date_responded'];
					$this->ExtForm->input('date_responded', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimonjobtraining['Claimonjobtraining']['no_of_days'];
					$this->ExtForm->input('no_of_days', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimonjobtraining['Claimonjobtraining']['payment_month'];
					$this->ExtForm->input('payment_month', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimonjobtraining['Claimonjobtraining']['placement_branch'];
					$this->ExtForm->input('placement_branch', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimonjobtraining['Claimonjobtraining']['basic_salary'];
					$this->ExtForm->input('basic_salary', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimonjobtraining['Claimonjobtraining']['transport'];
					$this->ExtForm->input('transport', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimonjobtraining['Claimonjobtraining']['hardship'];
					$this->ExtForm->input('hardship', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimonjobtraining['Claimonjobtraining']['pension'];
					$this->ExtForm->input('pension', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimonjobtraining['Claimonjobtraining']['total'];
					$this->ExtForm->input('total', $options);
				?>			]
		});
		
		var ClaimonjobtrainingEditWindow = new Ext.Window({
			title: '<?php __('Edit Claimonjobtraining'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ClaimonjobtrainingEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ClaimonjobtrainingEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Claimonjobtraining.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ClaimonjobtrainingEditWindow.collapsed)
						ClaimonjobtrainingEditWindow.expand(true);
					else
						ClaimonjobtrainingEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ClaimonjobtrainingEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ClaimonjobtrainingEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentClaimonjobtrainingData();
<?php } else { ?>
							RefreshClaimonjobtrainingData();
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
					ClaimonjobtrainingEditWindow.close();
				}
			}]
		});
