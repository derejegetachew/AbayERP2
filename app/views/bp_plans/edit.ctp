		<?php
			$this->ExtForm->create('BpPlan');
			$this->ExtForm->defineFieldFunctions();
		?>
		var BpPlanEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'bpPlans', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $bp_plan['BpPlan']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $branches;
					$options['value'] = $bp_plan['BpPlan']['branch_id'];
					$this->ExtForm->input('branch_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_plan['BpPlan']['month'];
					$this->ExtForm->input('month', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_plan['BpPlan']['amount'];
					$this->ExtForm->input('amount', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $bp_items;
					$options['value'] = $bp_plan['BpPlan']['bp_item_id'];
					$this->ExtForm->input('bp_item_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $budget_years;
					$options['value'] = $bp_plan['BpPlan']['budget_year_id'];
					$this->ExtForm->input('budget_year_id', $options);
				?>			]
		});
		
		var BpPlanEditWindow = new Ext.Window({
			title: '<?php __('Edit Bp Plan'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BpPlanEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BpPlanEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Bp Plan.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BpPlanEditWindow.collapsed)
						BpPlanEditWindow.expand(true);
					else
						BpPlanEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BpPlanEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BpPlanEditWindow.close();
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
					BpPlanEditWindow.close();
				}
			}]
		});
