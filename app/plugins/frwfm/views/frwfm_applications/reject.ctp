		<?php
			$this->ExtForm->create('FrwfmApplication');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FrwfmApplicationEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'reject')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $frwfm_application['FrwfmApplication']['id'])); ?>,
				<?php 
					$options = array();
					$this->ExtForm->input('rejection_reason',$options);
				?>
				]
		});
		
		var FrwfmApplicationApproveWindow = new Ext.Window({
			title: '<?php __('Reject Application'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FrwfmApplicationEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FrwfmApplicationEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Frwfm Application.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FrwfmApplicationEditWindow.collapsed)
						FrwfmApplicationEditWindow.expand(true);
					else
						FrwfmApplicationEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Reject'); ?>',
				handler: function(btn){
					FrwfmApplicationEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FrwfmApplicationApproveWindow.close();
							RefreshFrwfmApplicationData();
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
					FrwfmApplicationApproveWindow.close();
				}
			}]
		});
