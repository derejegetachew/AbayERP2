		<?php
			$this->ExtForm->create('PerformanceListChoice');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PerformanceListChoiceAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'performanceListChoices', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $performance_lists;
					$this->ExtForm->input('performance_list_id', $options);
				?>			]
		});
		
		var PerformanceListChoiceAddWindow = new Ext.Window({
			title: '<?php __('Add Performance List Choice'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: PerformanceListChoiceAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					PerformanceListChoiceAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Performance List Choice.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(PerformanceListChoiceAddWindow.collapsed)
						PerformanceListChoiceAddWindow.expand(true);
					else
						PerformanceListChoiceAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PerformanceListChoiceAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PerformanceListChoiceAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					PerformanceListChoiceAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PerformanceListChoiceAddWindow.close();
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
					PerformanceListChoiceAddWindow.close();
				}
			}]
		});
