		<?php
			$this->ExtForm->create('FaTransaction');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FaTransactionEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'faTransactions', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $fa_transaction['FaTransaction']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $fa_assets;
					$options['value'] = $fa_transaction['FaTransaction']['fa_asset_id'];
					$this->ExtForm->input('fa_asset_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fa_transaction['FaTransaction']['tax_depreciated_value'];
					$this->ExtForm->input('tax_depreciated_value', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fa_transaction['FaTransaction']['tax_book_value'];
					$this->ExtForm->input('tax_book_value', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fa_transaction['FaTransaction']['ifrs_depreciated_value'];
					$this->ExtForm->input('ifrs_depreciated_value', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fa_transaction['FaTransaction']['ifrs_book_value'];
					$this->ExtForm->input('ifrs_book_value', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $budget_years;
					$options['value'] = $fa_transaction['FaTransaction']['budget_year_id'];
					$this->ExtForm->input('budget_year_id', $options);
				?>			]
		});
		
		var FaTransactionEditWindow = new Ext.Window({
			title: '<?php __('Edit Fa Transaction'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FaTransactionEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FaTransactionEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Fa Transaction.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FaTransactionEditWindow.collapsed)
						FaTransactionEditWindow.expand(true);
					else
						FaTransactionEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FaTransactionEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FaTransactionEditWindow.close();
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
					FaTransactionEditWindow.close();
				}
			}]
		});
