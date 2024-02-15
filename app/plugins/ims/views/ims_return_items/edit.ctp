		<?php
			$this->ExtForm->create('ImsReturnItem');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsReturnItemEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsReturnItems', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ims_return_item['ImsReturnItem']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_returns;
					$options['value'] = $ims_return_item['ImsReturnItem']['ims_return_id'];
					$this->ExtForm->input('ims_return_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_sirv_items;
					$options['value'] = $ims_return_item['ImsReturnItem']['ims_sirv_item_id'];
					$this->ExtForm->input('ims_sirv_item_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_return_item['ImsReturnItem']['quantity'];
					$this->ExtForm->input('quantity', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_return_item['ImsReturnItem']['remark'];
					$this->ExtForm->input('remark', $options);
				?>			]
		});
		
		var ImsReturnItemEditWindow = new Ext.Window({
			title: '<?php __('Edit Ims Return Item'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsReturnItemEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsReturnItemEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ims Return Item.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsReturnItemEditWindow.collapsed)
						ImsReturnItemEditWindow.expand(true);
					else
						ImsReturnItemEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsReturnItemEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsReturnItemEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsReturnItemData();
<?php } else { ?>
							RefreshImsReturnItemData();
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
					ImsReturnItemEditWindow.close();
				}
			}]
		});
