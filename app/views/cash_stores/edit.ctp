		<?php
			$this->ExtForm->create('CashStore');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CashStoreEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'cashStores', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $cash_store['CashStore']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $cash_store['CashStore']['account_no'];
					$this->ExtForm->input('account_no', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$options['value'] = $cash_store['CashStore']['employee_id'];
					$this->ExtForm->input('employee_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $cash_store['CashStore']['value'];
					$this->ExtForm->input('value', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $budget_years;
					$options['value'] = $cash_store['CashStore']['budget_year_id'];
					$this->ExtForm->input('budget_year_id', $options);
				?>			]
		});
		
		var CashStoreEditWindow = new Ext.Window({
			title: '<?php __('Edit Cash Indeminity'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CashStoreEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CashStoreEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Cash Store.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CashStoreEditWindow.collapsed)
						CashStoreEditWindow.expand(true);
					else
						CashStoreEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					CashStoreEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CashStoreEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentCashStoreData();
<?php } else { ?>
							RefreshCashStoreData();
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
					CashStoreEditWindow.close();
				}
			}]
		});
