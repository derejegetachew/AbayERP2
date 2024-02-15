		<?php
			$this->ExtForm->create('BpPlan');
			$this->ExtForm->defineFieldFunctions();
		?>
		
		
		function 	BpPlanBranchIdValidator(value){
		if(value!=null || value!= '')
			return true;
		else
			return false;
    	}
		function 	BpPlanBudgetYearIdValidator(value){
		if(value!=null || value!= '')
			return true;
		else
			return false;
    	}
		
		var BpPlanAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'bpPlans', 'action' => 'close_budget')); ?>',
			defaultType: 'textfield',

			items: [
			
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $budget_years;
					$this->ExtForm->input('budget_year_id', $options);
				?>			]
		});
		
		var BpPlanAddWindow = new Ext.Window({
			title: '<?php __('Add Bp Plan'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BpPlanAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BpPlanAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Bp Plan.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BpPlanAddWindow.collapsed)
						BpPlanAddWindow.expand(true);
					else
						BpPlanAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					BpPlanAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BpPlanAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentBpPlanData();
<?php } else { ?>
							RefreshBpPlanData();
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
					BpPlanAddWindow.close();
				}
			}]
		});
