		<?php
			$this->ExtForm->create('Employee');
			$this->ExtForm->defineFieldFunctions();
		?>
		var TerminationAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'message')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Use','value' => 'Both');
                                        $options['items'] = array('Email' => 'Email', 'SMS' => 'SMS','Both'=>'Both');
					$this->ExtForm->input('use', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('subject', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('xtype'=>'textarea');
					$this->ExtForm->input('message', $options);
				?>			]
		});
		
		var MessageAddWindow = new Ext.Window({
			title: '<?php __('Send Message'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: TerminationAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					TerminationAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Termination.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(TerminationAddWindow.collapsed)
						TerminationAddWindow.expand(true);
					else
						TerminationAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Send'); ?>',
				handler: function(btn){
					TerminationAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							TerminationAddWindow.close();
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
					MessageAddWindow.close();
				}
			}]
		});
