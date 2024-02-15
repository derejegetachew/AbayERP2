		<?php
			$this->ExtForm->create('ImsTransfer');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsTransferEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsTransfers', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ims_transfer['ImsTransfer']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $ims_transfer['ImsTransfer']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_sirvs;
					$options['value'] = $ims_transfer['ImsTransfer']['ims_sirv_id'];
					$this->ExtForm->input('ims_sirv_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_transfer['ImsTransfer']['from_user'];
					$this->ExtForm->input('from_user', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_transfer['ImsTransfer']['to_user'];
					$this->ExtForm->input('to_user', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_transfer['ImsTransfer']['from_branch'];
					$this->ExtForm->input('from_branch', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_transfer['ImsTransfer']['to_branch'];
					$this->ExtForm->input('to_branch', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_transfer['ImsTransfer']['observer'];
					$this->ExtForm->input('observer', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_transfer['ImsTransfer']['approved_by'];
					$this->ExtForm->input('approved_by', $options);
				?>			]
		});
		
		var ImsTransferEditWindow = new Ext.Window({
			title: '<?php __('Edit Ims Transfer'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsTransferEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsTransferEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ims Transfer.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsTransferEditWindow.collapsed)
						ImsTransferEditWindow.expand(true);
					else
						ImsTransferEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsTransferEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsTransferEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsTransferData();
<?php } else { ?>
							RefreshImsTransferData();
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
					ImsTransferEditWindow.close();
				}
			}]
		});
