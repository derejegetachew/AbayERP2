		<?php
			$this->ExtForm->create('Application');
			$this->ExtForm->defineFieldFunctions();
		?>

	 function ViewEmployee() {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'view')).'/'.$employee['Employee']['id']; ?>',
            success: function(response, opts) {
                var employee_data = response.responseText;

                eval(employee_data);

                EmployeeViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employee view form. Error code'); ?>: ' + response.status);
            }
        });
    }
		var ApplicationAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'applications', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
                                        $this->ExtForm->input('employee_id', array('hidden' =>$employee['Employee']['id']));
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $jobs;
					$this->ExtForm->input('job_id', $options);
				?>,
				<?php 
					$options = array();				
					$options['items'] = $jobs;
					$options['value'] = $parent_id;
					$options['fieldLabel'] = "Applying For ";
					$options['disabled'] = 'true';
					$this->ExtForm->input('job_id', $options);
				?>,{
            xtype: 'checkboxgroup',
            fieldLabel: 'Locations',
			allowBlank: false,
            columns: 6,
            items: [
			<?php 
			$locations=explode(',',$post['Job']['location']);
				//print_r($locations);
				foreach($locations as $loc){
					echo "{boxLabel: '".$loc."',name: 'data[Application][loca][".$loc."]'},";
					}
			?>
            ]
        },{
            xtype: 'displayfield',
            name: 'displayfield1',
            fieldLabel: 'Notice: ',
            value: 'Before you apply it is recommended that you check if your profile info is complete and correct. If not <span style="color:green;">contact HR Department</span>'
        } 				]
		});
		
		var ApplicationAddWindow = new Ext.Window({
			title: '<?php __('Apply'); ?>',
			width: 800,
			minWidth: 500,
			autoHeight: true,			
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ApplicationAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ApplicationAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Application.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ApplicationAddWindow.collapsed)
						ApplicationAddWindow.expand(true);
					else
						ApplicationAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Apply'); ?>',
				handler: function(btn){
					ApplicationAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ApplicationAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentApplicationData();
<?php } else { ?>
							RefreshApplicationData();
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
				text: '<?php __('View Profile Info'); ?>',
				handler: function(btn){
					ViewEmployee();
				}
			},{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					ApplicationAddWindow.close();
				}
			}]
		});
