		<?php
			$this->ExtForm->create('Price');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PriceEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'prices', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $price['Price']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $price['Price']['gas'];
					$this->ExtForm->input('gas', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $price['Price']['date'];
					$this->ExtForm->input('date', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $payrolls;
					$options['value'] = $price['Price']['payroll_id'];
					$this->ExtForm->input('payroll_id', $options);
				?>			]
		});
		
		var PriceEditWindow = new Ext.Window({
			title: '<?php __('Edit Price'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: PriceEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					PriceEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Price.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(PriceEditWindow.collapsed)
						PriceEditWindow.expand(true);
					else
						PriceEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PriceEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PriceEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentPriceData();
<?php } else { ?>
							RefreshPriceData();
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
					PriceEditWindow.close();
				}
			}]
		});
