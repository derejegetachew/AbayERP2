		<?php
			$this->ExtForm->create('MinerRule');
			$this->ExtForm->defineFieldFunctions();
		?>
		var MinerRuleEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'minerRules', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $miner_rule['MinerRule']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $mines;
					$options['value'] = $miner_rule['MinerRule']['mine_id'];
					$this->ExtForm->input('mine_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $miner_rule['MinerRule']['tableField'];
					$this->ExtForm->input('tableField', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $miner_rule['MinerRule']['param'];
					$this->ExtForm->input('param', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $miner_rule['MinerRule']['value'];
					$this->ExtForm->input('value', $options);
				?>			]
		});
		
		var MinerRuleEditWindow = new Ext.Window({
			title: '<?php __('Edit Miner Rule'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: MinerRuleEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					MinerRuleEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Miner Rule.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(MinerRuleEditWindow.collapsed)
						MinerRuleEditWindow.expand(true);
					else
						MinerRuleEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					MinerRuleEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							MinerRuleEditWindow.close();
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
					MinerRuleEditWindow.close();
				}
			}]
		});
