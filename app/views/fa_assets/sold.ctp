		<?php
			$this->ExtForm->create('FaAsset');
			$this->ExtForm->defineFieldFunctions();
		?>



		var FaAssetSoldForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'faAssets', 'action' => 'sold')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $fa_asset['FaAsset']['id'])); ?>,
	            <?php $this->ExtForm->input('reference', array('hidden' => $fa_asset['FaAsset']['reference'])); ?>,
				<?php 
					$options = array('readOnly'=>false,'disabled'=>true);
					$options['value'] = $fa_asset['FaAsset']['reference'];
					$this->ExtForm->input('reference', $options);
				?>,
				<?php 
					$options = array('readOnly'=>true,'disabled'=>true);
					$options['value'] = $fa_asset['FaAsset']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array('readOnly'=>true,'disabled'=>true);
					$options['value'] = $fa_asset['FaAsset']['original_cost'];
					$this->ExtForm->input('original_cost', $options);
				?>,
				<?php 
					$options = array('readOnly'=>true,'disabled'=>true);
					$options['value'] = $fa_asset['FaAsset']['book_date'];
					$this->ExtForm->input('book_date', $options);
				?>,
        <?php 
					$options = array('xtype'=>'combo','fieldLabel'=>'Sold Type');
					$options['value'] = $fa_asset['FaAsset']['sold_type'];
          $list=array('ADJUSTMENT'=>'ADJUSTMENT (Not Subjected to Depreciation)','SOLED'=>'SOLED (Subjected to Depreciation)');
          $options['items']=$list;
					$this->ExtForm->input('sold_type', $options);
				?>
        ,
				<?php 
					$options = array('xtype'=> 'datefield');
					$this->ExtForm->input('sold_date', $options);
				?>,	<?php 
					$options = array();
					$this->ExtForm->input('sold_amount', $options);
				?>]
		});
		
		var FaAssetSoldWindow = new Ext.Window({
			title: '<?php __('Sale Asset'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FaAssetSoldForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FaAssetSoldForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Fa Asset.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FaAssetSoldWindow.collapsed)
						FaAssetSoldWindow.expand(true);
					else
						FaAssetSoldWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FaAssetSoldForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FaAssetSoldWindow.close();
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
					FaAssetSoldWindow.close();
				}
			}]
		});
