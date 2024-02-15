		<?php
			$this->ExtForm->create('Report');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ReportAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '50%', 'fieldLabel' => 'Type', 'value' => 'PHP');
                                        $options['items'] = array('PHP'=>'PHP','SQL' => 'SQL');
                             
					$this->ExtForm->input('type', $options);
				?>,
                                <?php 
					$options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '80%', 'fieldLabel' => 'Output', 'value' => 'Table');
                                        $options['items'] = array('Table'=>'Table','Custom' => 'Custom','Inline' => 'Inline');
					$this->ExtForm->input('output', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('rows', $options);
				?>,
				<?php 
					$options = array();
                                                  $options = array(
                                    'xtype' => 'textarea',
                                    'height' => 170,
                                    'anchor' => '99%',
                                    'fieldLabel' => 'Table Header',
                                    'enableFont' => true,
                                    'enableFontSize' => true,
                                                'id'=>'data[Field][column_group]'
                                );
					$this->ExtForm->input('column_group', $options);
				?>,
                                <?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $report_groups;
					$this->ExtForm->input('report_group_id', $options);
				?>			]
		});
		
		var ReportAddWindow = new Ext.Window({
			title: '<?php __('Add Report'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ReportAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ReportAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Report.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ReportAddWindow.collapsed)
						ReportAddWindow.expand(true);
					else
						ReportAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ReportAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ReportAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentReportData();
<?php } else { ?>
							RefreshReportData();
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
					ReportAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ReportAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentReportData();
<?php } else { ?>
							RefreshReportData();
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
					ReportAddWindow.close();
				}
			}]
		});
