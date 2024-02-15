		<?php
			$this->ExtForm->create('Delegation');
			$this->ExtForm->defineFieldFunctions();
		?>
		var DelegationEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'delegations', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $delegation['Delegation']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$options['value'] = $delegation['Delegation']['employee_id'];
					$this->ExtForm->input('employee_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $delegation['Delegation']['delegated'];
					$this->ExtForm->input('delegated', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $delegation['Delegation']['start'];
					$this->ExtForm->input('start', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $delegation['Delegation']['end'];
					$this->ExtForm->input('end', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $delegation['Delegation']['comment'];
					$this->ExtForm->input('comment', $options);
				?>			]
		});
		
		var DelegationEditWindow = new Ext.Window({
			title: '<?php __('Edit Delegation'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: DelegationEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					DelegationEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Delegation.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(DelegationEditWindow.collapsed)
						DelegationEditWindow.expand(true);
					else
						DelegationEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					DelegationEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DelegationEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentDelegationData();
<?php } else { ?>
							RefreshDelegationData();
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
					DelegationEditWindow.close();
				}
			}]
		});
