		<?php
			$this->ExtForm->create('BranchPerformancePlan');
			$this->ExtForm->defineFieldFunctions();
		?>
		var BranchPerformancePlanAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'branchPerformancePlans', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $branches;
					$this->ExtForm->input('branch_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $budget_years;
					$this->ExtForm->input('budget_year_id', $options);
				?>,
				<?php 
					//$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Quarter');
					$options['items'] = array(1 => "I", 2 => "II", 3 => "III", 4 => "IV" );
					$this->ExtForm->input('quarter', $options);
				?>,
				<?php 
					$options = array();
					$options['hidden'] = 0;
					$this->ExtForm->input('result', $options);
				?>,
				<?php 
					$options = array();
					$options['hidden'] = 2;
					$this->ExtForm->input('plan_status', $options);
				?>,
				<?php 
					$options = array();
					$options['hidden'] = 1;
					$this->ExtForm->input('result_status', $options);
				?>,
				<?php 
					$options = array();
					$options['hidden'] = "";
					$this->ExtForm->input('comment', $options);
				?>			]
		});
		
		var BranchPerformancePlanAddWindow = new Ext.Window({
			title: '<?php __('Add Branch Performance Plan'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BranchPerformancePlanAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BranchPerformancePlanAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Branch Performance Plan.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BranchPerformancePlanAddWindow.collapsed)
						BranchPerformancePlanAddWindow.expand(true);
					else
						BranchPerformancePlanAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BranchPerformancePlanAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BranchPerformancePlanAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					BranchPerformancePlanAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BranchPerformancePlanAddWindow.close();
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
					BranchPerformancePlanAddWindow.close();
				}
			}]
		});
