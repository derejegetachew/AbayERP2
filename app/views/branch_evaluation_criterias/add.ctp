		<?php
			$this->ExtForm->create('BranchEvaluationCriteria');
			$this->ExtForm->defineFieldFunctions();
		?>
		var BranchEvaluationCriteriaAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'branchEvaluationCriterias', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$this->ExtForm->input('goal', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('measure', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('target', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('weight', $options);
				?>,
				
				<?php 
					
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Direction');
					$options['items'] = array(1 => "incremental", 2 => "decremental", 3 => "Error", 4 => "No of Complains", 5 => "Delay", 6 => "SDT(Standard Delivery Time)");
					$this->ExtForm->input('direction', $options);

				?>,
							]
		});
		
		var BranchEvaluationCriteriaAddWindow = new Ext.Window({
			title: '<?php __('Add Branch Evaluation Criteria'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BranchEvaluationCriteriaAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BranchEvaluationCriteriaAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Branch Evaluation Criteria.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BranchEvaluationCriteriaAddWindow.collapsed)
						BranchEvaluationCriteriaAddWindow.expand(true);
					else
						BranchEvaluationCriteriaAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BranchEvaluationCriteriaAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BranchEvaluationCriteriaAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					BranchEvaluationCriteriaAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BranchEvaluationCriteriaAddWindow.close();
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
					BranchEvaluationCriteriaAddWindow.close();
				}
			}]
		});
