		<?php
			$this->ExtForm->create('MinerRule');
			$this->ExtForm->defineFieldFunctions();
		?>
		var MinerRuleAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'minerRules', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $mines;
					$this->ExtForm->input('mine_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('tableField', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('param', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('value', $options);
				?>			]
		});
		
		var MinerRuleAddWindow = new Ext.Window({
			title: '<?php __('Add Miner Rule'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: MinerRuleAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					MinerRuleAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Miner Rule.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(MinerRuleAddWindow.collapsed)
						MinerRuleAddWindow.expand(true);
					else
						MinerRuleAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					MinerRuleAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							MinerRuleAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentMinerRuleData();
<?php } else { ?>
							RefreshMinerRuleData();
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
					MinerRuleAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							MinerRuleAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentMinerRuleData();
<?php } else { ?>
							RefreshMinerRuleData();
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
					MinerRuleAddWindow.close();
				}
			}]
		});
