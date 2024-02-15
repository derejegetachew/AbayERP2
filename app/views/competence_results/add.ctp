<?php
			$this->ExtForm->create('CompetenceResult');
			$this->ExtForm->defineFieldFunctions();
		?>

		var CompetenceResultAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'competenceResults', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				{
						xtype: 'combo',
						store: new Ext.data.ArrayStore({
							sortInfo: { field: "name", direction: "ASC" },
							storeId: 'my_emp_store',
							id: 0,
							fields: ['id','name'],
							
							data: [
								<?php foreach($emps as $key => $emp_name) { ?>
									['<?php echo $key; ?>', '<?php echo $emp_name; ?>'],
								<?php } ?>

							]
							
						}),					
						displayField: 'name',
						typeAhead: true,
						hiddenName:'data[CompetenceResult][employee_id]',
						id: 'employee',
						name: 'employee',
						mode: 'local',					
						triggerAction: 'all',
						emptyText: 'Select One',
						selectOnFocus:true,
						valueField: 'id',
						anchor: '100%',
						fieldLabel: '<span style="color:red;">*</span> Employee',
						allowBlank: false,
						editable: true,
						lazyRender: true,
						blankText: 'Your input is invalid.',
						

					},
				<?php 
					//$options = array();
					$options = array('id' => 'txt_budget_year_add');
				//	$options['disabled'] = true;
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $budget_years;
					$this->ExtForm->input('budget_year_id', $options);
				?>,
				<?php 
				
					// $options = array();
					//$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Quarter', 'id' => 'txt_quarter_add');
				//	$options['disabled'] = true;
					$options['items'] = array( 2 => "II",  4 => "IV");
					$this->ExtForm->input('quarter', $options);
				?>,
				
				
				
				
				<?php 
					$options = array();
					$options['hidden'] = 1;
					$this->ExtForm->input('actual_competence', $options);
				?>,
				<?php 
					//$options = array();
					$options = array('id' => 'txt_score_add');
					$options['hidden'] = 0;
					$this->ExtForm->input('score', $options);
				?>,
				<?php 
					//$options = array();
					$options = array('id' => 'txt_rating_add');
				//	$options['disabled'] = true;
					$options['hidden'] = 0;
					$this->ExtForm->input('rating', $options);
				?>			]
		});
		
		var CompetenceResultAddWindow = new Ext.Window({
			title: '<?php __('Add Competence Result'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CompetenceResultAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CompetenceResultAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Competence Result.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CompetenceResultAddWindow.collapsed)
						CompetenceResultAddWindow.expand(true);
					else
						CompetenceResultAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				//disabled: true,
				id: 'btn_save',
				handler: function(btn){
					CompetenceResultAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CompetenceResultAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentCompetenceResultData();
<?php } else { ?>
							RefreshCompetenceResultData();
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
				//disabled: true,
				id: 'btn_save_close',
				handler: function(btn){
					CompetenceResultAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CompetenceResultAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentCompetenceResultData();
<?php } else { ?>
							RefreshCompetenceResultData();
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
					CompetenceResultAddWindow.close();
				}
			}]
		});
