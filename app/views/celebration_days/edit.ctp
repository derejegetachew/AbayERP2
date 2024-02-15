		<?php
			$this->ExtForm->create('CelebrationDay');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CelebrationDayEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'celebrationDays', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $celebration_day['CelebrationDay']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $celebration_day['CelebrationDay']['day'];
					$this->ExtForm->input('day', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $celebration_day['CelebrationDay']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $budget_years;
					$options['value'] = $celebration_day['CelebrationDay']['budget_year_id'];
					$this->ExtForm->input('budget_year_id', $options);
				?>			]
		});
		
		var CelebrationDayEditWindow = new Ext.Window({
			title: '<?php __('Edit Celebration Day'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CelebrationDayEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CelebrationDayEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Celebration Day.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CelebrationDayEditWindow.collapsed)
						CelebrationDayEditWindow.expand(true);
					else
						CelebrationDayEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					CelebrationDayEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CelebrationDayEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentCelebrationDayData();
<?php } else { ?>
							RefreshCelebrationDayData();
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
					CelebrationDayEditWindow.close();
				}
			}]
		});
