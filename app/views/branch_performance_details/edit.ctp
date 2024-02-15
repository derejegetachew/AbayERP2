		<?php
			$this->ExtForm->create('BranchPerformanceDetail');
			$this->ExtForm->defineFieldFunctions();
		?>
		var BranchPerformanceDetailEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'branchPerformanceDetails', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $branch_performance_detail['BranchPerformanceDetail']['id'])); ?>,
				<?php 
					$options = array();
					
					$options['items'] = $branch_evaluation_criterias;
					$options['value'] = $branch_performance_detail['BranchPerformanceDetail']['branch_evaluation_criteria_id'];
					$this->ExtForm->input('branch_evaluation_criteria_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $branch_performance_detail['BranchPerformanceDetail']['plan_in_number'];
					$this->ExtForm->input('plan_in_number', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $branch_performance_detail['BranchPerformanceDetail']['actual_result'];
					$this->ExtForm->input('actual_result', $options);
				?>,
				<?php 
					$options = array("disabled" => true);
					$options['value'] = $branch_performance_detail['BranchPerformanceDetail']['accomplishment'];
					$this->ExtForm->input('accomplishment', $options);
				?>,
				<?php 
					$options = array("disabled" => true);
					$options['value'] = $branch_performance_detail['BranchPerformanceDetail']['rating'];
					$this->ExtForm->input('rating', $options);
				?>,
				<?php 
					$options = array("disabled" => true);
					$options['value'] = $branch_performance_detail['BranchPerformanceDetail']['final_result'];
					$this->ExtForm->input('final_result', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $branch_performance_plans;
					$options['value'] = $branch_performance_detail['BranchPerformanceDetail']['branch_performance_plan_id'];
					$this->ExtForm->input('branch_performance_plan_id', $options);
				?>			]
		});
		
		var BranchPerformanceDetailEditWindow = new Ext.Window({
			title: '<?php __('Edit Branch Performance Detail'); ?>',
			width: 700,
			minWidth: 700,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BranchPerformanceDetailEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BranchPerformanceDetailEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Branch Performance Detail.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BranchPerformanceDetailEditWindow.collapsed)
						BranchPerformanceDetailEditWindow.expand(true);
					else
						BranchPerformanceDetailEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BranchPerformanceDetailEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BranchPerformanceDetailEditWindow.close();
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
					BranchPerformanceDetailEditWindow.close();
				}
			}]
		});
