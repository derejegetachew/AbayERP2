		<?php
			$this->ExtForm->create('ReportGroup');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ReportGroupEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'reportGroups', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $report_group['ReportGroup']['id'])); ?>,
                                <?php 
					$options = array();
					$options['hidden'] = $report_group['ReportGroup']['parent_id'];
					$this->ExtForm->input('parent_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $report_group['ReportGroup']['name'];
					$this->ExtForm->input('name', $options);
				?>			]
		});
		
		var ReportGroupEditWindow = new Ext.Window({
			title: '<?php __('Edit Report Group'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ReportGroupEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ReportGroupEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Report Group.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ReportGroupEditWindow.collapsed)
						ReportGroupEditWindow.expand(true);
					else
						ReportGroupEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ReportGroupEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                                                icon: Ext.MessageBox.INFO
							});
							ReportGroupEditWindow.close();
							RefreshReportGroupData();
                                                        p.getRootNode().reload();
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
					ReportGroupEditWindow.close();
				}
			}]
		});
