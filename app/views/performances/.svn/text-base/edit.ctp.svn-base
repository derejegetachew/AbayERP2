		<?php
			$this->ExtForm->create('Performance');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PerformanceEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'performances', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $performance['Performance']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $performance['Performance']['status'];
                                        $options = array('xtype' => 'combo', 'anchor' => '50%', 'fieldLabel' => 'Type', 'value' => 'Deactivated');
                                        $options['items'] = array('Deactivated' => 'Deactivate');
					$this->ExtForm->input('status', $options);
				?>			]
		});
		
		var PerformanceEditWindow = new Ext.Window({
			title: '<?php __('Edit Performance'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: PerformanceEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					PerformanceEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Performance.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(PerformanceEditWindow.collapsed)
						PerformanceEditWindow.expand(true);
					else
						PerformanceEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PerformanceEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PerformanceEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentPerformanceData();
<?php } else { ?>
							RefreshPerformanceData();
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
					PerformanceEditWindow.close();
				}
			}]
		});
