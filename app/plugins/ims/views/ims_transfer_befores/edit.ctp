		<?php
			$this->ExtForm->create('ImsTransferBefore');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsTransferBeforeEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsTransferBefores', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ims_transfer_before['ImsTransferBefore']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $ims_transfer_before['ImsTransferBefore']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_sirv_befores;
					$options['value'] = $ims_transfer_before['ImsTransferBefore']['ims_sirv_before_id'];
					$this->ExtForm->input('ims_sirv_before_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_transfer_before['ImsTransferBefore']['from_user'];
					$this->ExtForm->input('from_user', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_transfer_before['ImsTransferBefore']['to_user'];
					$this->ExtForm->input('to_user', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_transfer_before['ImsTransferBefore']['from_branch'];
					$this->ExtForm->input('from_branch', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_transfer_before['ImsTransferBefore']['to_branch'];
					$this->ExtForm->input('to_branch', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_transfer_before['ImsTransferBefore']['observer'];
					$this->ExtForm->input('observer', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_transfer_before['ImsTransferBefore']['approved_by'];
					$this->ExtForm->input('approved_by', $options);
				?>			]
		});
		
		var ImsTransferBeforeEditWindow = new Ext.Window({
			title: '<?php __('Edit Ims Transfer Before'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsTransferBeforeEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsTransferBeforeEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ims Transfer Before.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsTransferBeforeEditWindow.collapsed)
						ImsTransferBeforeEditWindow.expand(true);
					else
						ImsTransferBeforeEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsTransferBeforeEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsTransferBeforeEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsTransferBeforeData();
<?php } else { ?>
							RefreshImsTransferBeforeData();
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
					ImsTransferBeforeEditWindow.close();
				}
			}]
		});
