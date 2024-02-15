		<?php
			$this->ExtForm->create('SpRegion');
			$this->ExtForm->defineFieldFunctions();
		?>
		var SpRegionEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'spRegions', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $sp_region['SpRegion']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $sp_region['SpRegion']['name'];
					$this->ExtForm->input('name', $options);
				?>			]
		});
		
		var SpRegionEditWindow = new Ext.Window({
			title: '<?php __('Edit Sp Region'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: SpRegionEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					SpRegionEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Sp Region.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(SpRegionEditWindow.collapsed)
						SpRegionEditWindow.expand(true);
					else
						SpRegionEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					SpRegionEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							SpRegionEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentSpRegionData();
<?php } else { ?>
							RefreshSpRegionData();
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
					SpRegionEditWindow.close();
				}
			}]
		});
