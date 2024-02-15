		<?php
			$this->ExtForm->create('FaTransaction');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FaTransactionAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'faTransactions', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $budget_years;
					$this->ExtForm->input('budget_year_id', $options);
				?>			]
		});
		
		var FaTransactionAddWindow = new Ext.Window({
			title: '<?php __('Depreciation Tax'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FaTransactionAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FaTransactionAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Fa Transaction.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FaTransactionAddWindow.collapsed)
						FaTransactionAddWindow.expand(true);
					else
						FaTransactionAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Calculate'); ?>',
				handler: function(btn){
					FaTransactionAddForm.getForm().submit({
						waitMsg: '<?php __('Calculation in progress...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FaTransactionAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentFaTransactionData();
<?php } else { ?>
							RefreshFaTransactionData();
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
				text: '<?php __('Calculate & Close'); ?>',
				handler: function(btn){
					FaTransactionAddForm.getForm().submit({
						waitMsg: '<?php __('Calculation in progress...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FaTransactionAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentFaTransactionData();
<?php } else { ?>
							RefreshFaTransactionData();
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
					FaTransactionAddWindow.close();
				}
			}]
		});
