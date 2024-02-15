		<?php
			$this->ExtForm->create('CompetenceCategory');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CompetenceCategoryEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'competenceCategories', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $competence_category['CompetenceCategory']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $competence_category['CompetenceCategory']['name'];
					$this->ExtForm->input('name', $options);
				?>			]
		});
		
		var CompetenceCategoryEditWindow = new Ext.Window({
			title: '<?php __('Edit Competence Category'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CompetenceCategoryEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CompetenceCategoryEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Competence Category.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CompetenceCategoryEditWindow.collapsed)
						CompetenceCategoryEditWindow.expand(true);
					else
						CompetenceCategoryEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					CompetenceCategoryEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CompetenceCategoryEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentCompetenceCategoryData();
<?php } else { ?>
							RefreshCompetenceCategoryData();
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
					CompetenceCategoryEditWindow.close();
				}
			}]
		});
