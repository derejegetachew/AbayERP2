<?php
			$this->ExtForm->create('CompetenceResult');
			$this->ExtForm->defineFieldFunctions();

			
				for($i = 0; $i < $competence_array_size; $i++){ 


				} 

		?>




		var CompetenceResultEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'competenceResults', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $competence_result[0]['competence_results']['employee_id']."$".$competence_result[0]['competence_results']['budget_year_id']."$".$competence_result[0]['competence_results']['quarter'])); ?>,
				<?php 
					$options = array( 'fieldLabel' => 'Employee Id');
					$options['disabled'] = true;
					$options['value'] = $emps[$competence_result[0]['competence_results']['employee_id']];
					$this->ExtForm->input('employeeId', $options);
				?>,
				<?php 
					$options = array( 'fieldLabel' => 'Budget Year');
					$options['disabled'] = true;
					$options['value'] = $budget_years[$competence_result[0]['competence_results']['budget_year_id']];
					$this->ExtForm->input('budgetYearId', $options);
				?>,
				<?php 
					$options = array( 'fieldLabel' => 'Quarter');
					$options['disabled'] = true;
					if($competence_result[0]['competence_results']['quarter'] == 2){
						$options['value'] = 'II';
					}
					else {
						$options['value'] = 'IV';
					}

					$this->ExtForm->input('qrtr', $options);
				?>,
				<?php 
				for($i = 0; $i < $competence_array_size; $i++){ 
					
					$options = array('xtype' => 'combo', 'fieldLabel' => $competences[$competence_result[$i]['competence_results']['competence_id']]. "( Expected is : ".$competence_levels[$competence_array[$competence_result[$i]['competence_results']['competence_id']]].")" );
					//$options = array( 'fieldLabel' => 'Competence'.'_'.$i);
					$options['items'] = $competence_levels;
					$options['value'] = $competence_result[$i]['competence_results']['actual_competence'];
					$this->ExtForm->input('competence'.'_'.$i, $options);
					echo ",";


				} 
				
				
				?>

				
				
				
				
				
			]
		});
		
		var CompetenceResultEditWindow = new Ext.Window({
			title: '<?php __('Edit Competence Result'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CompetenceResultEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CompetenceResultEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Competence Result.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CompetenceResultEditWindow.collapsed)
						CompetenceResultEditWindow.expand(true);
					else
						CompetenceResultEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				//disabled: true,
				id: 'btn_save',
				handler: function(btn){
					CompetenceResultEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CompetenceResultEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentCompetenceResultData();
<?php } else { ?>
							RefreshCompetenceResultData();
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
					CompetenceResultEditWindow.close();
				}
			}]
		});
