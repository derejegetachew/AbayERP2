		<?php
			$this->ExtForm->create('DisciplinaryRecord');
			$this->ExtForm->defineFieldFunctions();
		?>
		var DisciplinaryRecordEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'disciplinaryRecords', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $disciplinary_record['DisciplinaryRecord']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$options['value'] = $disciplinary_record['DisciplinaryRecord']['employee_id'];
					$this->ExtForm->input('employee_id', $options);
				?>,
				<?php 
					$options = array();
					 $options = array('xtype' => 'combo', 'anchor' => '70%', 'fieldLabel' => 'Type');
                    $options['items'] = array('1 Level' => '1 Level', '2 Level' => '2 Level','3 Level'=>'3 Level','Final Warning'=>'Final Warning');
					$options['value'] = $disciplinary_record['DisciplinaryRecord']['type'];
					$this->ExtForm->input('type', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $disciplinary_record['DisciplinaryRecord']['start'];
					$this->ExtForm->input('start', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $disciplinary_record['DisciplinaryRecord']['end'];
					$this->ExtForm->input('end', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $disciplinary_record['DisciplinaryRecord']['remark'];
					$this->ExtForm->input('remark', $options);
				?>			]
		});
		
		var DisciplinaryRecordEditWindow = new Ext.Window({
			title: '<?php __('Edit Disciplinary Record'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: DisciplinaryRecordEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					DisciplinaryRecordEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Disciplinary Record.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(DisciplinaryRecordEditWindow.collapsed)
						DisciplinaryRecordEditWindow.expand(true);
					else
						DisciplinaryRecordEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					DisciplinaryRecordEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DisciplinaryRecordEditWindow.close();
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
					DisciplinaryRecordEditWindow.close();
				}
			}]
		});
