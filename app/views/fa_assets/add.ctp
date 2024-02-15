		<?php
			$this->ExtForm->create('FaAsset');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FaAssetAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'faAssets', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$this->ExtForm->input('reference', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('book_value', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('book_date', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('sold', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('sold_date', $options);
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
					$this->ExtForm->input('ifrs_class', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('ifrs_cat', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('ifrs_useful_age', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('residual_value_rate', $options);
				?>			]
		});
		
		var FaAssetAddWindow = new Ext.Window({
			title: '<?php __('Add Fa Asset'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FaAssetAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FaAssetAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Fa Asset.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FaAssetAddWindow.collapsed)
						FaAssetAddWindow.expand(true);
					else
						FaAssetAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FaAssetAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FaAssetAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentFaAssetData();
<?php } else { ?>
							RefreshFaAssetData();
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
					FaAssetAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FaAssetAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentFaAssetData();
<?php } else { ?>
							RefreshFaAssetData();
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
					FaAssetAddWindow.close();
				}
			}]
		});
