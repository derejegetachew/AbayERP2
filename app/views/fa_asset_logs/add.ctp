		<?php
			$this->ExtForm->create('FaAssetLog');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FaAssetLogAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'faAssetLogs', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $fa_assets;
					$this->ExtForm->input('fa_asset_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('branch_name', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('branch_code', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('tax_rate', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('tax_cat', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('class', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('ifrs_cat', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('useful_age', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('residual_value', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('created_at', $options);
				?>			]
		});
		
		var FaAssetLogAddWindow = new Ext.Window({
			title: '<?php __('Add Fa Asset Log'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FaAssetLogAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FaAssetLogAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Fa Asset Log.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FaAssetLogAddWindow.collapsed)
						FaAssetLogAddWindow.expand(true);
					else
						FaAssetLogAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FaAssetLogAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FaAssetLogAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					FaAssetLogAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FaAssetLogAddWindow.close();
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
					FaAssetLogAddWindow.close();
				}
			}]
		});
