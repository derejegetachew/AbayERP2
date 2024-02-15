		<?php
			$this->ExtForm->create('CmsCase');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CmsTransferAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'cmsCases', 'action' => 'transfer')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Team', 'anchor' => '100%','items'=>$cms_groups);					
					$this->ExtForm->input('cms_group_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $cms_cases;
					$this->ExtForm->input('cms_case_id', $options);
				?>		]
		});
		
		var CmsTransferAddWindow = new Ext.Window({
			title: '<?php __('Transfer'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CmsTransferAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CmsTransferAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to transfer a new issue.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CmsTransferAddWindow.collapsed)
						CmsTransferAddWindow.expand(true);
					else
						CmsTransferAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Transfer'); ?>',
				handler: function(btn){
					CmsTransferAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: 'Transfer Saved',
                                icon: Ext.MessageBox.INFO
							});
							CmsTransferAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshCmsCaseData();
<?php } else { ?>
							RefreshCmsCaseData();
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
					CmsTransferAddWindow.close();
				}
			}]
		});
