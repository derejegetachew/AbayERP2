		<?php
			$this->ExtForm->create('BranchPerformanceSetting');
			$this->ExtForm->defineFieldFunctions();
		?>
		var BranchPerformanceSettingAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'branchPerformanceSettings', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				
				{   
                                xtype:'fieldset',
                                title: 'Goal/Objective',
                                autoHeight: true,
                                boxMinHeight: 300,
                                items: [{
                                        layout:'column',
                                        items:[{
                                            columnWidth:.5,
                                            layout: 'form',
                                            items:[
                                                
                                                <?php 
														$options = array();
														if(isset($parent_id))
															$options['hidden'] = $parent_id;
														else
															$options['items'] = $positions;
														$this->ExtForm->input('position_id', $options);
													?>, 
                                              <?php 
					$options = array();
					$this->ExtForm->input('measure', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('weight', $options);
				?>,
												
                                                
                                            ]
                                        }, {
                                            columnWidth:.5,
                                            layout: 'form',
                                            items:[ 
												<?php 
					$options = array();
					$this->ExtForm->input('goal', $options);
				?>, 
                                               <?php 
					$options = array();
					$this->ExtForm->input('target', $options);
				?>,
												
                                            ]
                                        }
                                    ]
                                }, 
								
                                
                                ]
                            }, 
				{   
                                xtype:'fieldset',
                                title: 'Rate settings',
                                autoHeight: true,
                                boxMinHeight: 300,
                                items: [{
                                        layout:'column',
                                        items:[{
                                            columnWidth:.5,
                                            layout: 'form',
                                            items:[
                                                
                                                <?php
                                                    $options = array();
													$options = array('fieldLabel' => '5 Rating  Min');
                                                    $this->ExtForm->input('five_pointer_min', $options);
                                                ?>, 
                                                 <?php
                                                    $options = array();
													$options = array('fieldLabel' => '4 Rating  Min');
                                                    $this->ExtForm->input('four_pointer_min', $options);
                                                ?>,
												<?php
                                                    $options = array();
													$options = array('fieldLabel' => '3 Rating  Min');
                                                    $this->ExtForm->input('three_pointer_min', $options);
                                                ?>, 
                                                 <?php
                                                    $options = array();
													$options = array('fieldLabel' => '2 Rating  Min');
                                                    $this->ExtForm->input('two_pointer_min', $options);
                                                ?>,
												<?php
                                                    $options = array();
													$options = array('fieldLabel' => '1 Rating  Min');
                                                    $this->ExtForm->input('one_pointer_min', $options);
                                                ?>, 
                                                
                                            ]
                                        }, {
                                            columnWidth:.5,
                                            layout: 'form',
                                            items:[ 
												<?php
                                                    $options = array();
													$options = array('fieldLabel' => 'Max(included)');
                                                    $this->ExtForm->input('five_pointer_max_included', $options);
                                                ?>, 
                                                 <?php
                                                    $options = array();
													$options = array('fieldLabel' => 'Max(included)');
                                                    $this->ExtForm->input('four_pointer_max_included', $options);
                                                ?>,
												<?php
                                                    $options = array();
													$options = array('fieldLabel' => 'Max(included)');
                                                    $this->ExtForm->input('three_pointer_max_included', $options);
                                                ?>, 
                                                 <?php
                                                    $options = array();
													$options = array('fieldLabel' => 'Max(included)');
                                                    $this->ExtForm->input('two_pointer_max_included', $options);
                                                ?>,
												<?php
                                                    $options = array();
													$options = array('fieldLabel' => 'Max(included)');
                                                    $this->ExtForm->input('one_pointer_max_included', $options);
                                                ?>, 
                                            ]
                                        }
                                    ]
                                }, 
                                
                                ]
                            }, 
							]
		});
		
		var BranchPerformanceSettingAddWindow = new Ext.Window({
			title: '<?php __('Add Branch Performance Setting'); ?>',
			width: 700,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BranchPerformanceSettingAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BranchPerformanceSettingAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Branch Performance Setting.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BranchPerformanceSettingAddWindow.collapsed)
						BranchPerformanceSettingAddWindow.expand(true);
					else
						BranchPerformanceSettingAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BranchPerformanceSettingAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BranchPerformanceSettingAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentBranchPerformanceSettingData();
<?php } else { ?>
							RefreshBranchPerformanceSettingData();
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
					BranchPerformanceSettingAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BranchPerformanceSettingAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentBranchPerformanceSettingData();
<?php } else { ?>
							RefreshBranchPerformanceSettingData();
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
					BranchPerformanceSettingAddWindow.close();
				}
			}]
		});
