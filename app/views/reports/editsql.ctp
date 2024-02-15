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
                                                       $options = array(
                                    'xtype' => 'textarea',
                                    'height' => 370,
                                    'anchor' => '99%',
                                    'fieldLabel' => 'SQL',
                                    'enableFont' => true,
                                    'enableFontSize' => true,
                                                'id'=>'data[Report][SQL]'
                                );
                                        $report['Report']['SQL'] = addslashes($report['Report']['SQL']);
                                        $report['Report']['SQL'] = str_replace(array("\n","\r"),array("\\n","\\r"),$report['Report']['SQL']);
					$options['value'] = $report['Report']['SQL'];
					$this->ExtForm->input('SQL', $options);
				?>
                                
                                ]
		});
		
		var ReportEditWindow = new Ext.Window({
			title: '<?php __('Edit Report'); ?>',
			width: 640,
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
