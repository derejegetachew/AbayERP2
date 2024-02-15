		<?php
			$this->ExtForm->create('DisciplinaryRecord');
			$this->ExtForm->defineFieldFunctions();
		?>
		var DisciplinaryRecordAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'disciplinaryRecords', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$this->ExtForm->input('employee_id', $options);
				?>,
				<?php 
					$options = array();
                    $options = array('xtype' => 'combo', 'anchor' => '70%', 'fieldLabel' => 'Type', 'value' => '1 Level');
                    $options['items'] = array('1 Level' => '1 Level', '2 Level' => '2 Level','3 Level'=>'3 Level','Final Warning'=>'Final Warning');
					
					$this->ExtForm->input('type', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('start', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('end', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('remark', $options);
				?>			]
		});
		
		var DisciplinaryRecordAddWindow = new Ext.Window({
			title: '<?php __('Add Disciplinary Record'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: DisciplinaryRecordAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					DisciplinaryRecordAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Disciplinary Record.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(DisciplinaryRecordAddWindow.collapsed)
						DisciplinaryRecordAddWindow.expand(true);
					else
						DisciplinaryRecordAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					DisciplinaryRecordAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DisciplinaryRecordAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentDisciplinaryRecordData();
<?php } else { ?>
							RefreshDisciplinaryRecordData();
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
					DisciplinaryRecordAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DisciplinaryRecordAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentDisciplinaryRecordData();
<?php } else { ?>
							RefreshDisciplinaryRecordData();
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
					DisciplinaryRecordAddWindow.close();
				}
			}]
		});
