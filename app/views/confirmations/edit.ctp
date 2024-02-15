		<?php
			$this->ExtForm->create('Confirmation');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ConfirmationEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'confirmations', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $confirmation['Confirmation']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $users;
					$options['value'] = $confirmation['Confirmation']['user_id'];
					$this->ExtForm->input('user_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $confirmation['Confirmation']['confirmation_code'];
					$this->ExtForm->input('confirmation_code', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $confirmation['Confirmation']['status'];
					$this->ExtForm->input('status', $options);
				?>			]
		});
		
		var ConfirmationEditWindow = new Ext.Window({
			title: '<?php __('Edit Confirmation'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ConfirmationEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ConfirmationEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Confirmation.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ConfirmationEditWindow.collapsed)
						ConfirmationEditWindow.expand(true);
					else
						ConfirmationEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ConfirmationEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ConfirmationEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentConfirmationData();
<?php } else { ?>
							RefreshConfirmationData();
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
					ConfirmationEditWindow.close();
				}
			}]
		});
