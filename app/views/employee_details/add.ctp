		<?php
			$this->ExtForm->create('EmployeeDetail');
			$this->ExtForm->defineFieldFunctions();
		?>
		var EmployeeDetailAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'employeeDetails', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$this->ExtForm->input('employee_id', $options);
				?>,
				<?php 
					$options = array();
                                        $options['items'] = $grades;
					$this->ExtForm->input('grade_id', $options);
				?>,
				<?php 
					$options = array();
					$options['items'] = $steps;
					$this->ExtForm->input('step_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('salary', $options);
				?>,
				<?php 
					$options = array();
					$options['items'] = $positions;
					$this->ExtForm->input('position_id', $options);
				?>,     <?php 
					$options = array();
					$options = array('xtype' => 'combo',  'fieldLabel' => 'Status', 'value' => 'PERMANENT');
                    $options['items'] = array('PERMANENT' => 'PERMANENT', 'ACTING' => 'ACTING');
					$options['xtype'] ='combo';
					$this->ExtForm->input('status', $options);
				?>,
				<?php 
					$options = array();
					$options['items'] = $branches;
					$this->ExtForm->input('branch_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('start_date', $options);
				?>,
                                <?php 
					$options = array();
					$this->ExtForm->input('end_date', $options);
				?>,     <?php 
					$options = array();
					 $options['hidden'] ='true';
                    //$options = array('xtype' => 'combo',  'fieldLabel' => 'Reason', 'value' => 'Recruitment');
					$options = array('xtype' => 'combo',  'fieldLabel' => 'Reason', 'value' => 'PROMOTION');
                    $options['items'] = array('RECRUITMENT' => 'RECRUITMENT', 'SALARY CHANGE' => 'SALARY CHANGE','PROMOTION'=>'PROMOTION','DEMOTION'=>'DEMOTION','NO CHANGE'=>'NO CHANGE');
					$options['xtype'] ='hidden';
					$this->ExtForm->input('type', $options);
				?>,
				            <?php 
					$options = array();					
					$options = array('xtype' => 'combo',  'fieldLabel' => 'Transfer', 'value' => 'NO BRANCH TRANSFER');
					$options['items'] = array('1'=>'BRANCH TRANSFER' , '0'=>'NO BRANCH TRANSFER');	
					$options['xtype'] ='hidden';					
					$this->ExtForm->input('transfer', $options);
				?>]
		});
		
		var EmployeeDetailAddWindow = new Ext.Window({
			title: '<?php __('Add Employment History'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: EmployeeDetailAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					EmployeeDetailAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Employee Detail.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(EmployeeDetailAddWindow.collapsed)
						EmployeeDetailAddWindow.expand(true);
					else
						EmployeeDetailAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					EmployeeDetailAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							EmployeeDetailAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentEmployeeDetailData();
<?php } else { ?>
							RefreshEmployeeDetailData();
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
					EmployeeDetailAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							EmployeeDetailAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentEmployeeDetailData();
<?php } else { ?>
							RefreshEmployeeDetailData();
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
					EmployeeDetailAddWindow.close();
				}
			}]
		});
