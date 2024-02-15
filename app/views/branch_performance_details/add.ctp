		<?php
			$this->ExtForm->create('BranchPerformanceDetail');
			$this->ExtForm->defineFieldFunctions();
		?>
		var BranchPerformanceDetailAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'branchPerformanceDetails', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					//$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Branch evaluation criteria');
					$options['items'] = $branch_evaluation_criterias;
					$this->ExtForm->input('branch_evaluation_criteria_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('plan_in_number', $options);
				?>,
				<?php 
					$options = array();
					$options['hidden'] = 0;
					$this->ExtForm->input('actual_result', $options);
				?>,
				<?php 
					$options = array();
					$options['hidden'] = 0;
					$this->ExtForm->input('accomplishment', $options);
				?>,
				<?php 
					$options = array();
					$options['hidden'] = 0;
					$this->ExtForm->input('rating', $options);
				?>,
				<?php 
					$options = array();
					$options['hidden'] = 0;
					$this->ExtForm->input('final_result', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $branch_performance_plans;
					$this->ExtForm->input('branch_performance_plan_id', $options);
				?>			]
		});
		
		var BranchPerformanceDetailAddWindow = new Ext.Window({
			title: '<?php __('Add Branch Performance Detail'); ?>',
			width: 700,
			minWidth: 700,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BranchPerformanceDetailAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BranchPerformanceDetailAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Branch Performance Detail.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BranchPerformanceDetailAddWindow.collapsed)
						BranchPerformanceDetailAddWindow.expand(true);
					else
						BranchPerformanceDetailAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BranchPerformanceDetailAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BranchPerformanceDetailAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentBranchPerformanceDetailData();
<?php } else { ?>
							RefreshBranchPerformanceDetailData();
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
					BranchPerformanceDetailAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BranchPerformanceDetailAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentBranchPerformanceDetailData();
<?php } else { ?>
							RefreshBranchPerformanceDetailData();
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
					BranchPerformanceDetailAddWindow.close();
				}
			}]
		});
