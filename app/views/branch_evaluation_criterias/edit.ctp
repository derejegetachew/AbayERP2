		<?php
			$this->ExtForm->create('BranchEvaluationCriteria');
			$this->ExtForm->defineFieldFunctions();
		?>
		var BranchEvaluationCriteriaEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'branchEvaluationCriterias', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $branch_evaluation_criteria['BranchEvaluationCriteria']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $branch_evaluation_criteria['BranchEvaluationCriteria']['goal'];
					$this->ExtForm->input('goal', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $branch_evaluation_criteria['BranchEvaluationCriteria']['measure'];
					$this->ExtForm->input('measure', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $branch_evaluation_criteria['BranchEvaluationCriteria']['target'];
					$this->ExtForm->input('target', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $branch_evaluation_criteria['BranchEvaluationCriteria']['weight'];
					$this->ExtForm->input('weight', $options);
				?>,
				
				<?php 
					
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Direction');
					$options['value'] = $branch_evaluation_criteria['BranchEvaluationCriteria']['direction'];
					$options['items'] = array(1 => "incremental", 2 => "decremental", 3 => "Error", 4 => "No of Complains", 5 => "Delay", 6 => "SDT(Standard Delivery Time)");
					$this->ExtForm->input('direction', $options);

				?>,
				<?php 
					
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Status');
					$options['value'] = $branch_evaluation_criteria['BranchEvaluationCriteria']['STATUS'];
					$options['items'] = array(1 => "Active", 2 => "Inactive");
					$this->ExtForm->input('status', $options);

				?>,
							]
		});
		
		var BranchEvaluationCriteriaEditWindow = new Ext.Window({
			title: '<?php __('Edit Branch Evaluation Criteria'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BranchEvaluationCriteriaEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BranchEvaluationCriteriaEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Branch Evaluation Criteria.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BranchEvaluationCriteriaEditWindow.collapsed)
						BranchEvaluationCriteriaEditWindow.expand(true);
					else
						BranchEvaluationCriteriaEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BranchEvaluationCriteriaEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BranchEvaluationCriteriaEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentBranchEvaluationCriteriaData();
<?php } else { ?>
							RefreshBranchEvaluationCriteriaData();
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
					BranchEvaluationCriteriaEditWindow.close();
				}
			}]
		});
