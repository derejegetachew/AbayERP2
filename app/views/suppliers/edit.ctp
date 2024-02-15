		<?php
			$this->ExtForm->create('Supplier');
			$this->ExtForm->defineFieldFunctions();
		?>
		var SupplierEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'suppliers', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $supplier['Supplier']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $supplier['Supplier']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $supplier['Supplier']['address'];
					$this->ExtForm->input('address', $options);
				?>			]
		});
		
		var SupplierEditWindow = new Ext.Window({
			title: '<?php __('Edit Supplier'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: SupplierEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					SupplierEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Supplier.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(SupplierEditWindow.collapsed)
						SupplierEditWindow.expand(true);
					else
						SupplierEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					SupplierEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							SupplierEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentSupplierData();
<?php } else { ?>
							RefreshSupplierData();
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
					SupplierEditWindow.close();
				}
			}]
		});
