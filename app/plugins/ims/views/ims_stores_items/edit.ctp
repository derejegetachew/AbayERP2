		<?php
			$this->ExtForm->create('ImsStoresItem');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsStoresItemEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsStoresItems', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ims_stores_item['ImsStoresItem']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_stores;
					$options['value'] = $ims_stores_item['ImsStoresItem']['ims_store_id'];
					$this->ExtForm->input('ims_store_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_items;
					$options['value'] = $ims_stores_item['ImsStoresItem']['ims_item_id'];
					$this->ExtForm->input('ims_item_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_stores_item['ImsStoresItem']['balance'];
					$this->ExtForm->input('balance', $options);
				?>			]
		});
		
		var ImsStoresItemEditWindow = new Ext.Window({
			title: '<?php __('Edit Ims Stores Item'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsStoresItemEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsStoresItemEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ims Stores Item.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsStoresItemEditWindow.collapsed)
						ImsStoresItemEditWindow.expand(true);
					else
						ImsStoresItemEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsStoresItemEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsStoresItemEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsStoresItemData();
<?php } else { ?>
							RefreshImsStoresItemData();
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
					ImsStoresItemEditWindow.close();
				}
			}]
		});
