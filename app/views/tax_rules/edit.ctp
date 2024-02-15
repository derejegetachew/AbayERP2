		<?php
			$this->ExtForm->create('TaxRule');
			$this->ExtForm->defineFieldFunctions();
		?>
		var TaxRuleEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'taxRules', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $tax_rule['TaxRule']['id'])); ?>,
                                 <?php $this->ExtForm->input('payroll_id', array('hidden' => $tax_rule['TaxRule']['payroll_id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $tax_rule['TaxRule']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $tax_rule['TaxRule']['min'];
					$this->ExtForm->input('min', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $tax_rule['TaxRule']['max'];
					$this->ExtForm->input('max', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $tax_rule['TaxRule']['percent'];
					$this->ExtForm->input('percent', $options);
				?>,
				<?php 
					$options = array();
                                        $options['value'] = $tax_rule['TaxRule']['deductable'];
					$this->ExtForm->input('deductable', $options);
				?>	]
		});
		
		var TaxRuleEditWindow = new Ext.Window({
			title: '<?php __('Edit Tax Rule'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: TaxRuleEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					TaxRuleEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Tax Rule.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(TaxRuleEditWindow.collapsed)
						TaxRuleEditWindow.expand(true);
					else
						TaxRuleEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					TaxRuleEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							TaxRuleEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentTaxRuleData();
<?php } else { ?>
							RefreshTaxRuleData();
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
					TaxRuleEditWindow.close();
				}
			}]
		});
