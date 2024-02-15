		<?php
			$this->ExtForm->create('Claimoffjobtraining');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ClaimoffjobtrainingAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'claimoffjobtrainings', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('branch', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('training_title', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('position', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('venue', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('date_responded', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('starting_date', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('ending_date', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('perdiem', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('transport', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('accomadation', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('refreshment', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('total', $options);
				?>			]
		});
		
		var ClaimoffjobtrainingAddWindow = new Ext.Window({
			title: '<?php __('Add Claimoffjobtraining'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ClaimoffjobtrainingAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ClaimoffjobtrainingAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Claimoffjobtraining.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ClaimoffjobtrainingAddWindow.collapsed)
						ClaimoffjobtrainingAddWindow.expand(true);
					else
						ClaimoffjobtrainingAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ClaimoffjobtrainingAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ClaimoffjobtrainingAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					ClaimoffjobtrainingAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ClaimoffjobtrainingAddWindow.close();
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
					ClaimoffjobtrainingAddWindow.close();
				}
			}]
		});
