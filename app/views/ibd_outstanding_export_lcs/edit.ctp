		<?php
			$this->ExtForm->create('IbdOutstandingExportLc');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdOutstandingExportLcEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdOutstandingExportLcs', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ibd_outstanding_export_lc['IbdOutstandingExportLc']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_outstanding_export_lc['IbdOutstandingExportLc']['exporter_name'];
					$this->ExtForm->input('exporter_name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_outstanding_export_lc['IbdOutstandingExportLc']['total_lc_fcy'];
					$this->ExtForm->input('total_lc_fcy', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_outstanding_export_lc['IbdOutstandingExportLc']['total_lc_amount'];
					$this->ExtForm->input('total_lc_amount', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_outstanding_export_lc['IbdOutstandingExportLc']['outstanding_lc_fcy'];
					$this->ExtForm->input('outstanding_lc_fcy', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_outstanding_export_lc['IbdOutstandingExportLc']['outstanding_lc_amount'];
					$this->ExtForm->input('outstanding_lc_amount', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_outstanding_export_lc['IbdOutstandingExportLc']['issuing_bank_ref_no'];
					$this->ExtForm->input('issuing_bank_ref_no', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_outstanding_export_lc['IbdOutstandingExportLc']['our_ref_no'];
					$this->ExtForm->input('our_ref_no', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_outstanding_export_lc['IbdOutstandingExportLc']['date_of_issue'];
					$this->ExtForm->input('date_of_issue', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_outstanding_export_lc['IbdOutstandingExportLc']['expire_date'];
					$this->ExtForm->input('expire_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_outstanding_export_lc['IbdOutstandingExportLc']['place_of_expire'];
					$this->ExtForm->input('place_of_expire', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_outstanding_export_lc['IbdOutstandingExportLc']['sett_date'];
					$this->ExtForm->input('sett_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_outstanding_export_lc['IbdOutstandingExportLc']['sett_fcy'];
					$this->ExtForm->input('sett_fcy', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_outstanding_export_lc['IbdOutstandingExportLc']['sett_amount'];
					$this->ExtForm->input('sett_amount', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_outstanding_export_lc['IbdOutstandingExportLc']['sett_reference_no'];
					$this->ExtForm->input('sett_reference_no', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_outstanding_export_lc['IbdOutstandingExportLc']['outstanding_remaining_lc_fcy'];
					$this->ExtForm->input('outstanding_remaining_lc_fcy', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_outstanding_export_lc['IbdOutstandingExportLc']['outstanding_remaining_lc_value'];
					$this->ExtForm->input('outstanding_remaining_lc_value', $options);
				?>			]
		});
		
		var IbdOutstandingExportLcEditWindow = new Ext.Window({
			title: '<?php __('Edit Ibd Outstanding Export Lc'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdOutstandingExportLcEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdOutstandingExportLcEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ibd Outstanding Export Lc.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdOutstandingExportLcEditWindow.collapsed)
						IbdOutstandingExportLcEditWindow.expand(true);
					else
						IbdOutstandingExportLcEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdOutstandingExportLcEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdOutstandingExportLcEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdOutstandingExportLcData();
<?php } else { ?>
							RefreshIbdOutstandingExportLcData();
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
					IbdOutstandingExportLcEditWindow.close();
				}
			}]
		});
