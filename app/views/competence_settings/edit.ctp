		<?php
			$this->ExtForm->create('CompetenceSetting');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CompetenceSettingEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'competenceSettings', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $competence_setting['CompetenceSetting']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $grades;
					$options['value'] = $competence_setting['CompetenceSetting']['grade_id'];
					$this->ExtForm->input('grade_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $competences;
					$options['value'] = $competence_setting['CompetenceSetting']['competence_id'];
					$this->ExtForm->input('competence_id', $options);
				?>,
				
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Expected Competence');
					$options['items'] = $competence_levels;
					$options['value'] = $competence_setting['CompetenceSetting']['expected_competence'];
					$this->ExtForm->input('expected_competence', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $competence_setting['CompetenceSetting']['weight'];
					$this->ExtForm->input('weight', $options);
				?>			]
		});
		
		var CompetenceSettingEditWindow = new Ext.Window({
			title: '<?php __('Edit Competence Setting'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CompetenceSettingEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CompetenceSettingEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Competence Setting.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CompetenceSettingEditWindow.collapsed)
						CompetenceSettingEditWindow.expand(true);
					else
						CompetenceSettingEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					CompetenceSettingEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CompetenceSettingEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentCompetenceSettingData();
<?php } else { ?>
							RefreshCompetenceSettingData();
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
					CompetenceSettingEditWindow.close();
				}
			}]
		});
