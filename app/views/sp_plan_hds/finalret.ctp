		<?php
			$this->ExtForm->create('SpPlanHd');
			$this->ExtForm->defineFieldFunctions();
		?>
		var SpPlanHdEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'spPlanHds', 'action' => 'finalret'))."/".$plan; ?>',
			defaultType: 'textfield',

			items: [
				
				<?php 
					$options = array('xtype'=>'textarea','fieldLabel'=>'Comment');
					$options['value'] = $sp_plan_hd['SpPlanHd']['rollback_comment'];
					$this->ExtForm->input('rollback_comment', $options);
				?>			]
		});
		
		var SpPlanHdReturnWindow = new Ext.Window({
			title: '<?php __('Return Plan'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: SpPlanHdEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					SpPlanHdEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Sp Plan Hd.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(SpPlanHdReturnWindow.collapsed)
						SpPlanHdReturnWindow.expand(true);
					else
						SpPlanHdReturnWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					SpPlanHdEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							SpPlanHdReturnWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentSpPlanHdData();
<?php } else { ?>
							RefreshSpPlanHdData();
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
					SpPlanHdReturnWindow.close();
				}
			}]
		});
