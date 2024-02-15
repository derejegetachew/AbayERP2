		<?php
			$this->ExtForm->create('FaAsset');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FaAssetAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'faAssets', 'action' => 'fetch')); ?>',
			defaultType: 'textfield',

			items: [
				
				{					
				    xtype: 'datefield',
					fieldLabel: 'From Date',
					id:'fromDate',
					name: 'data[FaAsset][book_date_from]',
					anchor: '100%',
					format: 'j/n/Y'
				},{				
        			xtype: 'datefield',
					fieldLabel: 'To Date',
					id:'toDate',
					name: 'data[FaAsset][book_date_to]',
					anchor: '100%',
					format: 'j/n/Y'
				}			]
		});
		
		var FaAssetAddWindow = new Ext.Window({
			title: '<?php __('Fetch New Assets'); ?>',
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
						msg: 'This form is used to fetch a new Asset.',
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
