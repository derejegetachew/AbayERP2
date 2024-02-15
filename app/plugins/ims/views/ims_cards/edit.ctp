//<script>
		<?php
			$this->ExtForm->create('Card');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CardEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ims_cards', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $card['Card']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $items;
					$options['value'] = $card['Card']['ims_item_id'];
					$this->ExtForm->input('ims_item_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $card['Card']['quantity'];
					$this->ExtForm->input('quantity', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $card['Card']['unit_price'];
					$this->ExtForm->input('unit_price', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $grns;
					$options['value'] = $card['Card']['ims_grn_id'];
					$this->ExtForm->input('ims_grn_id', $options);
				?>			]
		});
		
		var CardEditWindow = new Ext.Window({
			title: '<?php __('Edit Card'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CardEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CardEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Card.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CardEditWindow.collapsed)
						CardEditWindow.expand(true);
					else
						CardEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					CardEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CardEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentCardData();
<?php } else { ?>
							RefreshCardData();
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
					CardEditWindow.close();
				}
			}]
		});