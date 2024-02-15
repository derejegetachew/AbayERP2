		<?php
			$this->ExtForm->create('Termination');
			$this->ExtForm->defineFieldFunctions();
		?>
		var TerminationEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'terminations', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $termination['Termination']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$options['value'] = $termination['Termination']['employee_id'];
					$this->ExtForm->input('employee_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $termination['Termination']['reason'];
					$this->ExtForm->input('reason', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $termination['Termination']['date'];
					$this->ExtForm->input('date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $termination['Termination']['note'];
					$this->ExtForm->input('note', $options);
				?>			]
		});
		
		var TerminationEditWindow = new Ext.Window({
			title: '<?php __('Edit Termination'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: TerminationEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					TerminationEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Termination.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(TerminationEditWindow.collapsed)
						TerminationEditWindow.expand(true);
					else
						TerminationEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					TerminationEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							TerminationEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentTerminationData();
<?php } else { ?>
							RefreshTerminationData();
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
					TerminationEditWindow.close();
				}
			}]
		});
