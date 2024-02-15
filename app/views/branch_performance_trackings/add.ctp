		<?php
			$this->ExtForm->create('BranchPerformanceTracking');
			$this->ExtForm->defineFieldFunctions();
		?>

		var arr = [['1', 'hi'], ['2', 'hello']];
		var str_goals = new Ext.data.ArrayStore({
					
					storeId: 'my_emp_store2',
					
					fields: ['id','name'],
					
					data: arr,
					
				});

		function load_goals(combo, record, index) {
							// add_emp_id = combo.getValue();
							add_emp_id = BranchPerformanceTrackingAddForm.findById('employee').getValue();
							budget_year_id = BranchPerformanceTrackingAddForm.findById('slc_budget_year_add').getValue();
							quarter = BranchPerformanceTrackingAddForm.findById('slc_quarter_add').getValue();



							Ext.getCmp('btn_save').disable();
							Ext.getCmp('btn_save_close').disable();
							BranchPerformanceTrackingAddForm.findById('slc_goal_add').disable();

							if(add_emp_id == "" || budget_year_id == "" || quarter == ""){
								return 1;
							}

						//	alert("hello");

						var tracking_id = add_emp_id+"^"+budget_year_id+"^"+quarter;
							
							Ext.Ajax.request({
									//	url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackings', 'action' => 'list_goals')); ?>/'+add_emp_id,
									url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackings', 'action' => 'list_goals')); ?>/'+tracking_id,
										success: function(response, opts) {
											var goal_data = response.responseText;
											
											
											var slc_array = [];
											var goal_array = goal_data.split(',');
											for(var i = 0; i < goal_array.length; i+=2){
												var one_array = [goal_array[i], goal_array[i+1]];
												slc_array.push(one_array);
											}
											// alert("hello");
											// alert(competence_array.length);
											if(goal_data != ""){  //it must have a select value
												str_goals.loadData(slc_array);
												BranchPerformanceTrackingAddForm.findById('slc_goal_add').setValue("-- select --");
												BranchPerformanceTrackingAddForm.findById('slc_goal_add').enable();
												BranchPerformanceTrackingAddForm.findById('txt_date_add').enable();
												BranchPerformanceTrackingAddForm.findById('txt_value_add').enable();
												Ext.getCmp('btn_save').disable();
												Ext.getCmp('btn_save_close').disable();
											}
											else {
												str_goals.loadData([]);
												BranchPerformanceTrackingAddForm.findById('slc_goal_add').setValue("-- select --");
												BranchPerformanceTrackingAddForm.findById('slc_goal_add').disable();
												BranchPerformanceTrackingAddForm.findById('txt_date_add').disable();
												BranchPerformanceTrackingAddForm.findById('txt_value_add').disable();
												Ext.getCmp('btn_save').disable();
												Ext.getCmp('btn_save_close').disable();
											}
											
										},
										failure: function(response, opts) {
											Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the BranchPerformanceTrackingAddForm add form. Error code'); ?>: ' + response.status);
										}
							});

		}
		var BranchPerformanceTrackingAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'branchPerformanceTrackings', 'action' => 'add')); ?>',
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
									[<?php echo $key; ?>, '<?php echo $emp_name; ?>'],
								<?php } ?>

							]
							
						}),					
						displayField: 'name',
						typeAhead: true,
						hiddenName:'data[BranchPerformanceTracking][employee_id]',
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
						listeners : {
						select : function(combo, record, index){
							load_goals(combo, record, index);
								
						}
					}

					},
					{
					
					xtype : 'combo',
					anchor: '100%',
					id: 'slc_budget_year_add',
					hiddenName:'data[BranchPerformanceTracking][budget_year_id]',
					disabled: false,
					emptyText: 'Select One',
					fieldLabel: '<span style="color:red;">*</span> Budget Year',
					<!-- store : str_goals, -->
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					allowBlank: false,
					editable: true,
					lazyRender: true,
					blankText: 'Your input is invalid.',
					selectOnFocus:true,
					disableKeyFilter : true,
					triggerAction: 'all',
					fields: ['id','name'],
					store: new Ext.data.ArrayStore({
							sortInfo: { field: "name", direction: "ASC" },
							storeId: 'my_budget_year_store',
							id: 0,
							fields: ['id','name'],
							
							data: [
								<?php foreach($budget_years as $key => $value) { ?>
									[<?php echo $key; ?>, '<?php echo $value; ?>'],
								<?php } ?>

							]
							
						}),
							
							
					listeners : {
						select : function(combo, record, index){

							load_goals(combo, record, index);

						
							
							
						}
					}
				
				},

				{
					
					xtype : 'combo',
					anchor: '100%',
					id: 'slc_quarter_add',
					hiddenName:'data[BranchPerformanceTracking][quarter]',
					disabled: false,
					emptyText: 'Select One',
					fieldLabel: '<span style="color:red;">*</span> Quarter',
					<!-- store : str_goals, -->
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					allowBlank: false,
					editable: true,
					lazyRender: true,
					blankText: 'Your input is invalid.',
					selectOnFocus:true,
					disableKeyFilter : true,
					triggerAction: 'all',
					fields: ['id','name'],
					store: new Ext.data.ArrayStore({
							sortInfo: { field: "name", direction: "ASC" },
							storeId: 'my_quarter_store',
							id: 0,
							fields: ['id','name'],
							
							data: [
								[1,'I'],
								[2,'II'],
								[3,'III'],
								[4,'IV']
								

							]
							
						}),
							
							
					listeners : {
						select : function(combo, record, index){
							load_goals(combo, record, index);
							 
							
						}
					}
				
				},

				
				{
					
					xtype : 'combo',
					anchor: '100%',
					id: 'slc_goal_add',
					hiddenName:'data[BranchPerformanceTracking][goal]',
					disabled: true,
					emptyText: 'Select One',
					fieldLabel: '<span style="color:red;">*</span> Goal',
					store : str_goals,
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					allowBlank: false,
					editable: true,
					lazyRender: true,
					blankText: 'Your input is invalid.',
					selectOnFocus:true,
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							var val = BranchPerformanceTrackingAddForm.findById('slc_goal_add').getValue();
							 if(val == "-- select --"){
								Ext.getCmp('btn_save').disable();
								Ext.getCmp('btn_save_close').disable();
							}
							else {
								Ext.getCmp('btn_save').enable();
								Ext.getCmp('btn_save_close').enable();
							} 
							
						}
					}
				
				},
				<?php 
					// $options = array();
					$options = array('id' => 'txt_date_add');
					$options['disabled'] = true;
					$this->ExtForm->input('date', $options);
				?>,

				<?php 
					//$options = array();
					$options = array('id' => 'txt_value_add');
					$options['disabled'] = true;
					$this->ExtForm->input('value', $options);
				?>			]
		});
		
		var BranchPerformanceTrackingAddWindow = new Ext.Window({
			title: '<?php __('Add Branch Performance Tracking'); ?>',
			width: 700,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BranchPerformanceTrackingAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BranchPerformanceTrackingAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Branch Performance Tracking.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BranchPerformanceTrackingAddWindow.collapsed)
						BranchPerformanceTrackingAddWindow.expand(true);
					else
						BranchPerformanceTrackingAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				disabled: true,
				id: 'btn_save',
				handler: function(btn){
					BranchPerformanceTrackingAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BranchPerformanceTrackingAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentBranchPerformanceTrackingData();
<?php } else { ?>
							RefreshBranchPerformanceTrackingData();
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
				disabled: true,
				id: 'btn_save_close',
				handler: function(btn){
					BranchPerformanceTrackingAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BranchPerformanceTrackingAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentBranchPerformanceTrackingData();
<?php } else { ?>
							RefreshBranchPerformanceTrackingData();
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
					BranchPerformanceTrackingAddWindow.close();
				}
			}]
		});
