		<?php
			$this->ExtForm->create('ImsStoresCard');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsStoresCardEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsStoresCards', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ims_stores_card['ImsStoresCard']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_stores;
					$options['value'] = $ims_stores_card['ImsStoresCard']['ims_store_id'];
					$this->ExtForm->input('ims_store_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_requisitions;
					$options['value'] = $ims_stores_card['ImsStoresCard']['ims_requisition_id'];
					$this->ExtForm->input('ims_requisition_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_cards;
					$options['value'] = $ims_stores_card['ImsStoresCard']['ims_card_id'];
					$this->ExtForm->input('ims_card_id', $options);
				?>			]
		});
		
		var ImsStoresCardEditWindow = new Ext.Window({
			title: '<?php __('Edit Ims Stores Card'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsStoresCardEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsStoresCardEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ims Stores Card.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsStoresCardEditWindow.collapsed)
						ImsStoresCardEditWindow.expand(true);
					else
						ImsStoresCardEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsStoresCardEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsStoresCardEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsStoresCardData();
<?php } else { ?>
							RefreshImsStoresCardData();
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
					ImsStoresCardEditWindow.close();
				}
			}]
		});
