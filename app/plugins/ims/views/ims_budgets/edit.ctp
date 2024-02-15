		<?php
			$this->ExtForm->create('ImsBudget');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsBudgetEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsBudgets', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						id: 0,
						fields: ['id','name'],
						
						data: [
						<?php foreach($results as $result){?>
						['<?php echo $result['id']?>','<?php echo $result['name']?>'],
						<?php
						}
						?>
						]
						
					}),
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[ImsBudget][branch_id]',
					id: 'branch',
					name: 'branch',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					selectOnFocus:true,
					valueField: 'id',
					value:'<?php echo $ims_budget['Branch']['name']?>',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Branch',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						id: 0,
						fields: ['id','name'],
						data: [['<?php echo $ims_budget['BudgetYear']['id']?>','<?php echo $ims_budget['BudgetYear']['name']?>']]
					}),
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[ImsBudget][budget_year_id]',
					id: 'budget_year',
					name: 'budget_year',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					selectOnFocus:true,
					valueField: 'id',
					value:'<?php echo $ims_budget['BudgetYear']['name']?>',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Budget Year',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},
				<?php $this->ExtForm->input('id', array('hidden' => $ims_budget['ImsBudget']['id'])); ?>,
				<?php 
					$options = array('fieldLabel' => 'Description');
					$options['value'] = $ims_budget['ImsBudget']['name'];
					$this->ExtForm->input('name', $options);
				?>				
							]
		});
		
		var ImsBudgetEditWindow = new Ext.Window({
			title: '<?php __('Edit Ims Budget'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsBudgetEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsBudgetEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ims Budget.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsBudgetEditWindow.collapsed)
						ImsBudgetEditWindow.expand(true);
					else
						ImsBudgetEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsBudgetEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsBudgetEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsBudgetData();
<?php } else { ?>
							RefreshImsBudgetData();
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
					ImsBudgetEditWindow.close();
				}
			}]
		});
