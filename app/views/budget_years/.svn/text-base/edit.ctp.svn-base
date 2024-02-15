		<?php
			$this->ExtForm->create('BudgetYear');
			$this->ExtForm->defineFieldFunctions();
		?>
		var BudgetYearEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'budgetYears', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $budget_year['BudgetYear']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $budget_year['BudgetYear']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $budget_year['BudgetYear']['from_date'];
					$this->ExtForm->input('from_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $budget_year['BudgetYear']['to_date'];
					$this->ExtForm->input('to_date', $options);
				?>
						]
		});
		
		var BudgetYearEditWindow = new Ext.Window({
			title: '<?php __('Edit Budget Year'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BudgetYearEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BudgetYearEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Budget Year.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BudgetYearEditWindow.collapsed)
						BudgetYearEditWindow.expand(true);
					else
						BudgetYearEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BudgetYearEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BudgetYearEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentBudgetYearData();
<?php } else { ?>
							RefreshBudgetYearData();
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
					BudgetYearEditWindow.close();
				}
			}]
		});
