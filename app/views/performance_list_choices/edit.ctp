		<?php
			$this->ExtForm->create('PerformanceListChoice');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PerformanceListChoiceEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'performanceListChoices', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $performance_list_choice['PerformanceListChoice']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $performance_list_choice['PerformanceListChoice']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $performance_lists;
					$options['value'] = $performance_list_choice['PerformanceListChoice']['performance_list_id'];
					$this->ExtForm->input('performance_list_id', $options);
				?>			]
		});
		
		var PerformanceListChoiceEditWindow = new Ext.Window({
			title: '<?php __('Edit Performance List Choice'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: PerformanceListChoiceEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					PerformanceListChoiceEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Performance List Choice.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(PerformanceListChoiceEditWindow.collapsed)
						PerformanceListChoiceEditWindow.expand(true);
					else
						PerformanceListChoiceEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PerformanceListChoiceEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PerformanceListChoiceEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentPerformanceListChoiceData();
<?php } else { ?>
							RefreshPerformanceListChoiceData();
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
					PerformanceListChoiceEditWindow.close();
				}
			}]
		});
