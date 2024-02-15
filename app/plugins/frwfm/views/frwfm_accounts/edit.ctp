		<?php
			$this->ExtForm->create('FrwfmAccount');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FrwfmAccountEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'frwfmAccounts', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $frwfm_account['FrwfmAccount']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $frwfm_applications;
					$options['value'] = $frwfm_account['FrwfmAccount']['frwfm_application_id'];
					$this->ExtForm->input('frwfm_application_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $frwfm_account['FrwfmAccount']['acc_no'];
					$this->ExtForm->input('acc_no', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $frwfm_account['FrwfmAccount']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $frwfm_account['FrwfmAccount']['branch'];
					$this->ExtForm->input('branch', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $frwfm_account['FrwfmAccount']['amount'];
					$this->ExtForm->input('amount', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $frwfm_account['FrwfmAccount']['currency'];
					$this->ExtForm->input('currency', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $frwfm_account['FrwfmAccount']['type'];
					$this->ExtForm->input('type', $options);
				?>			]
		});
		
		var FrwfmAccountEditWindow = new Ext.Window({
			title: '<?php __('Edit Frwfm Account'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FrwfmAccountEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FrwfmAccountEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Frwfm Account.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FrwfmAccountEditWindow.collapsed)
						FrwfmAccountEditWindow.expand(true);
					else
						FrwfmAccountEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FrwfmAccountEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FrwfmAccountEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentFrwfmAccountData();
<?php } else { ?>
							RefreshFrwfmAccountData();
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
					FrwfmAccountEditWindow.close();
				}
			}]
		});
