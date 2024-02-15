		<?php
			$this->ExtForm->create('FaAssetLog');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FaAssetLogEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'faAssetLogs', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $fa_asset_log['FaAssetLog']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $fa_assets;
					$options['value'] = $fa_asset_log['FaAssetLog']['fa_asset_id'];
					$this->ExtForm->input('fa_asset_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fa_asset_log['FaAssetLog']['branch_name'];
					$this->ExtForm->input('branch_name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fa_asset_log['FaAssetLog']['branch_code'];
					$this->ExtForm->input('branch_code', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fa_asset_log['FaAssetLog']['tax_rate'];
					$this->ExtForm->input('tax_rate', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fa_asset_log['FaAssetLog']['tax_cat'];
					$this->ExtForm->input('tax_cat', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fa_asset_log['FaAssetLog']['class'];
					$this->ExtForm->input('class', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fa_asset_log['FaAssetLog']['ifrs_cat'];
					$this->ExtForm->input('ifrs_cat', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fa_asset_log['FaAssetLog']['useful_age'];
					$this->ExtForm->input('useful_age', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fa_asset_log['FaAssetLog']['residual_value'];
					$this->ExtForm->input('residual_value', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fa_asset_log['FaAssetLog']['created_at'];
					$this->ExtForm->input('created_at', $options);
				?>			]
		});
		
		var FaAssetLogEditWindow = new Ext.Window({
			title: '<?php __('Edit Fa Asset Log'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FaAssetLogEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FaAssetLogEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Fa Asset Log.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FaAssetLogEditWindow.collapsed)
						FaAssetLogEditWindow.expand(true);
					else
						FaAssetLogEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FaAssetLogEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FaAssetLogEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentFaAssetLogData();
<?php } else { ?>
							RefreshFaAssetLogData();
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
					FaAssetLogEditWindow.close();
				}
			}]
		});
