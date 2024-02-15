		<?php
			$this->ExtForm->create('Price');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PriceAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'prices', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
                        <?php $this->ExtForm->input('payroll_id', array('hidden' => $this->Session->read('Auth.User.payroll_id'))); ?>,
				<?php 
					$options = array();
                                        $options = array('fieldLabel'=>'1 Littre Gas Price');
					$this->ExtForm->input('gas', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('date', $options);
				?>		]
		});
		
		var PriceAddWindow = new Ext.Window({
			title: '<?php __('Add Price'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: PriceAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					PriceAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Price.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(PriceAddWindow.collapsed)
						PriceAddWindow.expand(true);
					else
						PriceAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PriceAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PriceAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					PriceAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PriceAddWindow.close();
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
					PriceAddWindow.close();
				}
			}]
		});
