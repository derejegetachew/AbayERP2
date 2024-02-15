		<?php
			$this->ExtForm->create('MisLetter');
			$this->ExtForm->defineFieldFunctions();
		?>
		var MisLetterEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'misLetters', 'action' => 'edit')); ?>',
			defaultType: 'textfield',
			defaultType: 'textfield',
			fileUpload: true,

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $mis_letter['MisLetter']['id'])); ?>,
				<?php 
					$options = array('fieldLabel' => 'Ref Number','readOnly' => 'true', 'anchor' => '60%');
					$options['value'] = $mis_letter['MisLetter']['ref_no'];
					$this->ExtForm->input('ref_no', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $mis_letter['MisLetter']['applicant'];
					$this->ExtForm->input('applicant', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $mis_letter['MisLetter']['defendant'];
					$this->ExtForm->input('defendant', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $mis_letter['MisLetter']['letter_no'];
					$this->ExtForm->input('letter_no', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'Letter Date', 'allowBlank' => 'false', 'anchor' => '60%');
					$options['value'] = $mis_letter['MisLetter']['date'];
					$this->ExtForm->input('date', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'Letter Deadline', 'allowBlank' => 'false', 'anchor' => '60%');
					$options['value'] = $mis_letter['MisLetter']['deadline'];
					$this->ExtForm->input('deadline', $options);
				?>,
				<?php 
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Source', 'editable' => false, 'anchor' => '60%');
					$options['items'] = array('COURT' => 'COURT', 'POLICE' => 'POLICE', 'CUSTOMS' => 'CUSTOMS', 'FIC' => 'FIC', 'NBE' => 'NBE', 'AUDIT' => 'AUDIT', 'PENSION' => 'PENSION', 'GA' => 'GA','OTHER' => 'OTHER');
					$options['value'] = $mis_letter['MisLetter']['source'];
					$this->ExtForm->input('source', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $mis_letter['MisLetter']['office'];
					$this->ExtForm->input('office', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $mis_letter['MisLetter']['messenger'];
					$this->ExtForm->input('messenger', $options);
				?>,	
				{
					xtype: 'fileuploadfield',
					id: 'form-file',
					emptyText: 'Select File',
					fieldLabel: 'File',
					name: 'data[MisLetter][file]',
					buttonText: 'Browse',
					anchor:'100%',
					multiple: true,
					allowBlank: false,
					value: '<?php echo $mis_letter['MisLetter']['file']?>'
				}  ]
		});
		
		var MisLetterEditWindow = new Ext.Window({
			title: '<?php __('Edit Mis Letter'); ?>',
			width: 500,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: MisLetterEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					MisLetterEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Mis Letter.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(MisLetterEditWindow.collapsed)
						MisLetterEditWindow.expand(true);
					else
						MisLetterEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					MisLetterEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							MisLetterEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentMisLetterData();
<?php } else { ?>
							RefreshMisLetterData();
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
					MisLetterEditWindow.close();
				}
			}]
		});
