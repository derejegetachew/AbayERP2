//<script>
		<?php
			$this->ExtForm->create('Branch');
			$this->ExtForm->defineFieldFunctions();
		?>
    var BranchEditForm = new Ext.form.FormPanel({
            baseCls: 'x-plain',
            labelWidth: 100,
            labelAlign: 'right',
            url:'<?php echo $this->Html->url(array('controller' => 'branches', 'action' => 'edit')); ?>',
            defaultType: 'textfield',

            items: [
				<?php $this->ExtForm->input('id', array('hidden' => $branch['Branch']['id'])); ?>,
				<?php 
					$options = array('fieldLabel' => 'Branch Name','disabled' => 'false');
					$options['value'] = $branch['Branch']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'Branch Code','disabled' => 'true');
					$options['value'] = $branch['Branch']['list_order'];
					$this->ExtForm->input('list_order', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'Flex Cube Code');
					$options['value'] = $branch['Branch']['fc_code'];
					$this->ExtForm->input('fc_code', $options);
				?>,
								<?php 
					$options = array('fieldLabel' => "District",'xtype' => 'combo', 'value' => 'None');
					$options['items'] = array('None'=>'None','South and West Addis Distict' => 'South and West Addis Distict','DireDawa Distict' => 'DireDawa Distict','Dessie Distict' => 'Dessie Distict','Bahirdar Distict' => 'Bahirdar Distict','Hawassa District' => 'Hawassa District','Gonder District' => 'Gonder District', 'Bahirdar District' => 'Bahirdar District','Adama District' => 'Adama District','North and East Addis District'=>'North and East Addis District','Head Office'=>'Head Office','Debre Birhan District'=>'Debre Birhan District');
					$options['value'] = $branch['Branch']['region'];
					$this->ExtForm->input('region', $options);
				?>,
<?php 
					$options = array('fieldLabel' => 'City');
					$options['value'] = $branch['Branch']['city'];
					$this->ExtForm->input('city', $options);
				?>,
<?php 
					$options = array('fieldLabel' => 'Zone /Sub city');
					$options['value'] = $branch['Branch']['zone_sub_city'];
					$this->ExtForm->input('zone_sub_city', $options);
				?>
,
<?php 
					$options = array('fieldLabel' => 'Specific location or building name');
					$options['value'] = $branch['Branch']['location_building_name'];
					$this->ExtForm->input('location_building_name', $options);
				?>,
<?php 
					$options = array('fieldLabel' => 'Office Telephone');
					$options['value'] = $branch['Branch']['telephone'];
					$this->ExtForm->input('telephone', $options);
				?>,

<?php 
                                        $options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Type of Branch');
                                        $options['items'] = array('Conventional Branch' => 'Conventional Branch','IFB-Branch' => 'IFB-Branch','Sub-Branch' => 'Sub-Branch');					
					$options['value'] = $branch['Branch']['type_of_branch'];					$this->ExtForm->input('type_of_branch', $options);

									?>
,
<?php 
					                                        $options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Branch Grade');
                                        $options['items'] = array('1' => '1 ( C )','2' => '2 ( B )','3' => '3 ( A )','4' => '4 (Special)','N/A' => 'N/A');					
					$options['value'] = $branch['Branch']['branch_grade'];					$this->ExtForm->input('branch_grade', $options);
				?>

,
<?php 
					                  $options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Working Hour');
                                        $options['items'] = array('6' => '6','7' => '7','8' => '8','9' => '9');					
					$options['value'] = $branch['Branch']['working_hour'];					$this->ExtForm->input('working_hour', $options);
				?>,
<?php 
					                $options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Working Region');
                                        $options['items'] = array('Addis Ababa (city)' => 'Addis Ababa (city)','Afar Region' => 'Afar Region','Amhara Region' => 'Amhara Region','Benishangul-Gumuz Region' => 'Benishangul-Gumuz Region','Dire Dawa (city)' => 'Dire Dawa (city)','Gambela Region' => 'Gambela Region','Harari Region' => 'Harari Region','Oromia Region' => 'Oromia Region','Sidama Region' => 'Sidama Region','Somali Region' => 'Somali Region','South West Ethiopia Peoples Region' => 'South West Ethiopia Peoples Region','Tigray Region' => 'Tigray Region','Central Ethiopia Region' => 'Central Ethiopia Region','South Ethiopia  Region'=>'South Ethiopia  Region');					
					$options['value'] = $branch['Branch']['working_region'];					$this->ExtForm->input('working_region', $options);
				?>,
<?php 
					$options = array('fieldLabel' => 'branch Manager Name');
					$options['value'] = $branch['Branch']['branch_manager_name'];
					$this->ExtForm->input('branch_manager_name', $options);
				?>,
<?php 
					$options = array('fieldLabel' => 'Supervisor Name');
					$options['value'] = $branch['Branch']['contact_person'];
					$this->ExtForm->input('contact_person', $options);
				?>,
<?php 
					$options = array('fieldLabel' => 'Branch Manger Phone');
					$options['value'] = $branch['Branch']['manager_phone'];
					$this->ExtForm->input('manager_phone', $options);
				?>,
<?php 
					$options = array('fieldLabel' => 'Supervisor Phone');
					$options['value'] = $branch['Branch']['phone_number'];
					$this->ExtForm->input('phone_number', $options);
				?>,
<?php 
					$options = array('fieldLabel' => 'Branch Opened Date');
					$options['value'] = $branch['Branch']['date_opened'];
					$this->ExtForm->input('date_opened', $options);
				?>


 				]
    });

    var BranchEditWindow = new Ext.Window({
            title: '<?php __('Edit Branch'); ?>',
            width: 400,
            minWidth: 400,
            autoHeight: true,
            layout: 'fit',
            modal: true,
            resizable: true,
            plain:true,
            bodyStyle:'padding:5px;',
            buttonAlign:'right',
            items: BranchEditForm,
            tools: [{
                    id: 'refresh',
                    qtip: 'Reset',
                    handler: function () {
                            BranchEditForm.getForm().reset();
                    },
                    scope: this
            }, {
                    id: 'help',
                    qtip: 'Help',
                    handler: function () {
                            Ext.Msg.show({
                                    title: 'Help',
                                    buttons: Ext.MessageBox.OK,
                                    msg: 'This form is used to modify an existing Branch.',
                                    icon: Ext.MessageBox.INFO
                            });
                    }
            }, {
                    id: 'toggle',
                    qtip: 'Collapse / Expand',
                    handler: function () {
                            if(BranchEditWindow.collapsed)
                                    BranchEditWindow.expand(true);
                            else
                                    BranchEditWindow.collapse(true);
                    }
            }],
            buttons: [ {
                    text: '<?php __('Save'); ?>',
                    handler: function(btn){
                            BranchEditForm.getForm().submit({
                                    waitMsg: '<?php __('Submitting your data...'); ?>',
                                    waitTitle: '<?php __('Wait Please...'); ?>',
                                    success: function(f,a){
                                            Ext.Msg.show({
                                                    title: '<?php __('Success'); ?>',
                                                    buttons: Ext.MessageBox.OK,
                                                    msg: a.result.msg,
                    icon: Ext.MessageBox.INFO
                                            });
                                            BranchEditWindow.close();
<?php if(isset($parent_id)){ ?>
                                            RefreshParentBranchData();
<?php } else { ?>
                                            RefreshBranchData();
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
                            BranchEditWindow.close();
                    }
            }]
    });
