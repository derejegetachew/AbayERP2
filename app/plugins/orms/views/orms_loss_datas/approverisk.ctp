		<?php
			$this->ExtForm->create('OrmsLossData');
			$this->ExtForm->defineFieldFunctions();
		?>
		
		var OrmsLossDataApproveForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 120,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ormsLossDatas', 'action' => 'approve')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $orms_loss_data['OrmsLossData']['id'])); ?>,
				
				
				<?php 
					$options = array('xtype' => 'textarea','grow' => false,'fieldLabel' => 'Action to be Taken','anchor' => '100%','required' => true);					
					$this->ExtForm->input('action_tobe_taken', $options);
				?>,
				<?php 
					$options1 = array('anchor' => '60%','fieldLabel' => 'Action to be Taken date','required' => false);					
					$this->ExtForm->input('action_taken_date', $options1);
				?>	]
		});
		
		var OrmsLossDataApproveWindow = new Ext.Window({
			title: '<?php __('Approve Loss Data'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: OrmsLossDataApproveForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					OrmsLossDataApproveForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Orms Loss Data.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(OrmsLossDataApproveWindow.collapsed)
						OrmsLossDataApproveWindow.expand(true);
					else
						OrmsLossDataApproveWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Approve'); ?>',
				handler: function(btn){
					OrmsLossDataApproveForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							OrmsLossDataApproveWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentOrmsLossDataData();
<?php } else { ?>
							RefreshOrmsLossDataData();
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
					OrmsLossDataApproveWindow.close();
				}
			}]
		});
