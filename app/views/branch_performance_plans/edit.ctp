<?php
			$this->ExtForm->create('BranchPerformancePlan');
			$this->ExtForm->defineFieldFunctions();
		?>
		var BranchPerformancePlanEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'branchPerformancePlans', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $branch_performance_plan['BranchPerformancePlan']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $branches;
					$options['value'] = $branch_performance_plan['BranchPerformancePlan']['branch_id'];
					$this->ExtForm->input('branch_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $budget_years;
					$options['value'] = $branch_performance_plan['BranchPerformancePlan']['budget_year_id'];
					$this->ExtForm->input('budget_year_id', $options);
				?>,
				
				<?php 
					//$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Quarter');
					$options['items'] = array(1 => "I", 2 => "II", 3 => "III", 4 => "IV" );
					$options['value'] = $branch_performance_plan['BranchPerformancePlan']['quarter'];
					$this->ExtForm->input('quarter', $options);
				?>,
				<?php 
					$options = array();
					$options['hidden'] = $branch_performance_plan['BranchPerformancePlan']['result'];
					$options['value'] = $branch_performance_plan['BranchPerformancePlan']['result'];
					$this->ExtForm->input('result', $options);
				?>,
				<?php 
					$options = array();
					$options['hidden'] = $branch_performance_plan['BranchPerformancePlan']['plan_status'];
					$options['value'] = $branch_performance_plan['BranchPerformancePlan']['plan_status'];
					$this->ExtForm->input('plan_status', $options);
				?>,
				<?php 
					$options = array();
					$options['hidden'] = $branch_performance_plan['BranchPerformancePlan']['result_status'];
					$options['value'] = $branch_performance_plan['BranchPerformancePlan']['result_status'];
					$this->ExtForm->input('result_status', $options);
				?>,
				<?php 
					$options = array();
					$options['hidden'] = $branch_performance_plan['BranchPerformancePlan']['comment'];
					$options['value'] = $branch_performance_plan['BranchPerformancePlan']['comment'];
					$this->ExtForm->input('comment', $options);
				?>			]
		});
		
		var BranchPerformancePlanEditWindow = new Ext.Window({
			title: '<?php __('Edit Branch Performance Plan'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BranchPerformancePlanEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BranchPerformancePlanEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Branch Performance Plan.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BranchPerformancePlanEditWindow.collapsed)
						BranchPerformancePlanEditWindow.expand(true);
					else
						BranchPerformancePlanEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BranchPerformancePlanEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BranchPerformancePlanEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentBranchPerformancePlanData();
<?php } else { ?>
							RefreshBranchPerformancePlanData();
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
					BranchPerformancePlanEditWindow.close();
				}
			}]
		});
