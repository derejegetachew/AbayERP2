		<?php
			$this->ExtForm->create('ReportField');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ReportFieldEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'reportFields', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $report_field['ReportField']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $reports;
					$options['value'] = $report_field['ReportField']['report_id'];
					$this->ExtForm->input('report_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $fields;
					$options['value'] = $report_field['ReportField']['field_id'];
					$this->ExtForm->input('field_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $report_field['ReportField']['Renamed'];
					$this->ExtForm->input('Renamed', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $report_field['ReportField']['getas'];
					$this->ExtForm->input('getas', $options);
				?>			]
		});
		
		var ReportFieldEditWindow = new Ext.Window({
			title: '<?php __('Edit Report Field'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ReportFieldEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ReportFieldEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Report Field.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ReportFieldEditWindow.collapsed)
						ReportFieldEditWindow.expand(true);
					else
						ReportFieldEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ReportFieldEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ReportFieldEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentReportFieldData();
<?php } else { ?>
							RefreshReportFieldData();
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
					ReportFieldEditWindow.close();
				}
			}]
		});
