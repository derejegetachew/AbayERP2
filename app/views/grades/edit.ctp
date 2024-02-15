		<?php
			$this->ExtForm->create('Grade');
			$this->ExtForm->defineFieldFunctions();
		?>
		var GradeEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'grades', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $grade['Grade']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $grade['Grade']['name'];
					$this->ExtForm->input('name', $options);
				?>			]
		});
		
		var GradeEditWindow = new Ext.Window({
			title: '<?php __('Edit Grade'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: GradeEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					GradeEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Grade.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(GradeEditWindow.collapsed)
						GradeEditWindow.expand(true);
					else
						GradeEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					GradeEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							GradeEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentGradeData();
<?php } else { ?>
							RefreshGradeData();
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
					GradeEditWindow.close();
				}
			}]
		});
