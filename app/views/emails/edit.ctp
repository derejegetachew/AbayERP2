		<?php
			$this->ExtForm->create('Email');
			$this->ExtForm->defineFieldFunctions();
		?>
		var EmailEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'emails', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $email['Email']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $email['Email']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $email['Email']['from_name'];
					$this->ExtForm->input('from_name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $email['Email']['from'];
					$this->ExtForm->input('from', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $email['Email']['to'];
					$this->ExtForm->input('to', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $email['Email']['body'];
					$this->ExtForm->input('body', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $email['Email']['status'];
					$this->ExtForm->input('status', $options);
				?>			]
		});
		
		var EmailEditWindow = new Ext.Window({
			title: '<?php __('Edit Email'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: EmailEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					EmailEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Email.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(EmailEditWindow.collapsed)
						EmailEditWindow.expand(true);
					else
						EmailEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					EmailEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							EmailEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentEmailData();
<?php } else { ?>
							RefreshEmailData();
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
					EmailEditWindow.close();
				}
			}]
		});
