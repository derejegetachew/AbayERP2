		<?php
			$this->ExtForm->create('ImsTransferItemBefore');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsTransferItemBeforeEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsTransferItemBefores', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ims_transfer_item_before['ImsTransferItemBefore']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_transfer_befores;
					$options['value'] = $ims_transfer_item_before['ImsTransferItemBefore']['ims_transfer_before_id'];
					$this->ExtForm->input('ims_transfer_before_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_sirv_item_befores;
					$options['value'] = $ims_transfer_item_before['ImsTransferItemBefore']['ims_sirv_item_before_id'];
					$this->ExtForm->input('ims_sirv_item_before_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_items;
					$options['value'] = $ims_transfer_item_before['ImsTransferItemBefore']['ims_item_id'];
					$this->ExtForm->input('ims_item_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_transfer_item_before['ImsTransferItemBefore']['measurement'];
					$this->ExtForm->input('measurement', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_transfer_item_before['ImsTransferItemBefore']['quantity'];
					$this->ExtForm->input('quantity', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_transfer_item_before['ImsTransferItemBefore']['unit_price'];
					$this->ExtForm->input('unit_price', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_transfer_item_before['ImsTransferItemBefore']['tag'];
					$this->ExtForm->input('tag', $options);
				?>			]
		});
		
		var ImsTransferItemBeforeEditWindow = new Ext.Window({
			title: '<?php __('Edit Ims Transfer Item Before'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsTransferItemBeforeEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsTransferItemBeforeEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ims Transfer Item Before.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsTransferItemBeforeEditWindow.collapsed)
						ImsTransferItemBeforeEditWindow.expand(true);
					else
						ImsTransferItemBeforeEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsTransferItemBeforeEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsTransferItemBeforeEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsTransferItemBeforeData();
<?php } else { ?>
							RefreshImsTransferItemBeforeData();
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
					ImsTransferItemBeforeEditWindow.close();
				}
			}]
		});
