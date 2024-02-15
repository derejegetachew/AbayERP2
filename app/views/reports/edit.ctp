		<?php
			$this->ExtForm->create('Report');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ReportEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $report['Report']['id'])); ?>,
                                <?php 
					$options = array();
                                        $options['value'] = $report['Report']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '50%', 'fieldLabel' => 'Type');
                                        $options['value'] = $report['Report']['type'];
                                        $options['items'] = array('PHP'=>'PHP','SQL' => 'SQL');
                             
					$this->ExtForm->input('type', $options);
				?>,
                                <?php 
					$options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '80%', 'fieldLabel' => 'Output');
                                         $options['items'] = array('Table'=>'Table','Custom' => 'Custom','Inline' => 'Inline');
                                        $options['value'] = $report['Report']['output'];
					$this->ExtForm->input('output', $options);
				?>,
				<?php 
					$options = array();
                                        $options['value'] = $report['Report']['rows'];
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
                                        $report['Report']['column_group'] = addslashes($report['Report']['column_group']);
                                        $report['Report']['column_group'] = str_replace(array("\n","\r"),array("\\n","\\r"),$report['Report']['column_group']);
					$options['value'] = $report['Report']['column_group'];
					$this->ExtForm->input('column_group', $options);
				?>,
                                <?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $report_groups;
                                        $options['value'] = $report['Report']['report_group_id'];
					$this->ExtForm->input('report_group_id', $options);
				?>	
                                
                                
                                ]
		});
		
		var ReportEditWindow = new Ext.Window({
			title: '<?php __('Edit Report'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ReportEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ReportEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Report.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ReportEditWindow.collapsed)
						ReportEditWindow.expand(true);
					else
						ReportEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ReportEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ReportEditWindow.close();
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
					ReportEditWindow.close();
				}
			}]
		});
