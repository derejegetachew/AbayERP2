		<?php
			$this->ExtForm->create('Claimonjobtraining');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ClaimonjobtrainingAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'claimonjobtrainings', 'action' => 'add')); ?>',
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
					$this->ExtForm->input('position', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('date_of_employment', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('placement_date', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('date_responded', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('no_of_days', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('payment_month', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('placement_branch', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('basic_salary', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('transport', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('hardship', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('pension', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('total', $options);
				?>			]
		});
		
		var ClaimonjobtrainingAddWindow = new Ext.Window({
			title: '<?php __('Add Claimonjobtraining'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ClaimonjobtrainingAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ClaimonjobtrainingAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Claimonjobtraining.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ClaimonjobtrainingAddWindow.collapsed)
						ClaimonjobtrainingAddWindow.expand(true);
					else
						ClaimonjobtrainingAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ClaimonjobtrainingAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ClaimonjobtrainingAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					ClaimonjobtrainingAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ClaimonjobtrainingAddWindow.close();
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
					ClaimonjobtrainingAddWindow.close();
				}
			}]
		});
