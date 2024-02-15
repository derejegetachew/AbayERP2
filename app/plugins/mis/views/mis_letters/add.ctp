		<?php
			$this->ExtForm->create('MisLetter');
			$this->ExtForm->defineFieldFunctions();
		?>
		var MisLetterAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'misLetters', 'action' => 'add')); ?>',
			defaultType: 'textfield',
			fileUpload: true,

			items: [
				<?php 
					$options = array('fieldLabel' => 'Ref Number','readOnly' => 'true', 'anchor' => '60%');
					date_default_timezone_set("Africa/Addis_Ababa");  
                    $options['value'] = date("Ymd").'/'.str_pad(($count + 1), 3,'0',STR_PAD_LEFT);
					$this->ExtForm->input('ref_no', $options);
				?>,
				<?php 
					$options = array('value' => 'NA');
					$this->ExtForm->input('applicant', $options);
				?>,
				<?php 
					$options = array('value' => 'NA');
					$this->ExtForm->input('defendant', $options);
				?>,
				<?php 
					$options = array('value' => 'NA');
					$this->ExtForm->input('letter_no', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'Letter Date', 'anchor' => '60%');
					$this->ExtForm->input('date', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'Letter Deadline', 'anchor' => '60%');
					$this->ExtForm->input('deadline', $options);
				?>,
				<?php 
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Source', 'editable' => false, 'anchor' => '60%','value' => 'NA');
					$options['items'] = array('COURT' => 'COURT', 'POLICE' => 'POLICE', 'CUSTOMS' => 'CUSTOMS', 'FIC' => 'FIC', 'NBE' => 'NBE', 'AUDIT' => 'AUDIT', 'PENSION' => 'PENSION', 'GA' => 'GA','OTHER' => 'OTHER');
					$this->ExtForm->input('source', $options);
				?>,
				<?php 
					$options = array('value' => 'NA');
					$this->ExtForm->input('office', $options);
				?>,
				<?php 
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Subject', 'editable' => false, 'anchor' => '60%');
					$options['items'] = array('Reinstate' => 'Reinstate', 'Termination' => 'Termination', 'Blocking Amount' => 'Blocking Amount', 'Blocking Account' => 'Blocking Account', 'Release' => 'Release', 'Other' => 'Other');
					$this->ExtForm->input('subject', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'Source Address');
					$this->ExtForm->input('address', $options);
				?>,
				<?php 
					$options = array('value' => 'NA');
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
					allowBlank: true
				}		]
		});
		
		var MisLetterAddWindow = new Ext.Window({
			title: '<?php __('Add Letter'); ?>',
			width: 500,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: MisLetterAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					MisLetterAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Mis Letter.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(MisLetterAddWindow.collapsed)
						MisLetterAddWindow.expand(true);
					else
						MisLetterAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					MisLetterAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							MisLetterAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					MisLetterAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							MisLetterAddWindow.close();
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
					MisLetterAddWindow.close();
				}
			}]
		});
