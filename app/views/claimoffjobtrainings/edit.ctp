		<?php
			$this->ExtForm->create('Claimoffjobtraining');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ClaimoffjobtrainingEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'claimoffjobtrainings', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $claimoffjobtraining['Claimoffjobtraining']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $claimoffjobtraining['Claimoffjobtraining']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimoffjobtraining['Claimoffjobtraining']['branch'];
					$this->ExtForm->input('branch', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimoffjobtraining['Claimoffjobtraining']['training_title'];
					$this->ExtForm->input('training_title', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimoffjobtraining['Claimoffjobtraining']['position'];
					$this->ExtForm->input('position', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimoffjobtraining['Claimoffjobtraining']['venue'];
					$this->ExtForm->input('venue', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimoffjobtraining['Claimoffjobtraining']['date_responded'];
					$this->ExtForm->input('date_responded', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimoffjobtraining['Claimoffjobtraining']['starting_date'];
					$this->ExtForm->input('starting_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimoffjobtraining['Claimoffjobtraining']['ending_date'];
					$this->ExtForm->input('ending_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimoffjobtraining['Claimoffjobtraining']['perdiem'];
					$this->ExtForm->input('perdiem', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimoffjobtraining['Claimoffjobtraining']['transport'];
					$this->ExtForm->input('transport', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimoffjobtraining['Claimoffjobtraining']['accomadation'];
					$this->ExtForm->input('accomadation', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimoffjobtraining['Claimoffjobtraining']['refreshment'];
					$this->ExtForm->input('refreshment', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $claimoffjobtraining['Claimoffjobtraining']['total'];
					$this->ExtForm->input('total', $options);
				?>			]
		});
		
		var ClaimoffjobtrainingEditWindow = new Ext.Window({
			title: '<?php __('Edit Claimoffjobtraining'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ClaimoffjobtrainingEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ClaimoffjobtrainingEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Claimoffjobtraining.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ClaimoffjobtrainingEditWindow.collapsed)
						ClaimoffjobtrainingEditWindow.expand(true);
					else
						ClaimoffjobtrainingEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ClaimoffjobtrainingEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ClaimoffjobtrainingEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentClaimoffjobtrainingData();
<?php } else { ?>
							RefreshClaimoffjobtrainingData();
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
					ClaimoffjobtrainingEditWindow.close();
				}
			}]
		});
