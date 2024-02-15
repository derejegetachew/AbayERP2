		<?php
			$this->ExtForm->create('ImsGrnItem');
			$this->ExtForm->defineFieldFunctions();
		?>
		var GrnItemEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ims_grn_items', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $grn_item['ImsGrnItem']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $grns;
					$options['value'] = $grn_item['ImsGrnItem']['ims_grn_id'];
					$this->ExtForm->input('ims_grn_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $purchase_order_items;
					$options['value'] = $grn_item['ImsGrnItem']['ims_purchase_order_item_id'];
					$this->ExtForm->input('ims_purchase_order_item_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $grn_item['ImsGrnItem']['quantity'];
					$this->ExtForm->input('quantity', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $grn_item['ImsGrnItem']['unit_price'];
					$this->ExtForm->input('unit_price', $options);
				?>			]
		});
		
		var GrnItemEditWindow = new Ext.Window({
			title: '<?php __('Edit Grn Item'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: GrnItemEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					GrnItemEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Grn Item.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(GrnItemEditWindow.collapsed)
						GrnItemEditWindow.expand(true);
					else
						GrnItemEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					GrnItemEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							GrnItemEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentGrnItemData();
<?php } else { ?>
							RefreshGrnItemData();
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
					GrnItemEditWindow.close();
				}
			}]
		});
