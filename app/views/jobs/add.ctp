		<?php
			$this->ExtForm->create('Job');
			$this->ExtForm->defineFieldFunctions();
		?>

		var JobAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'jobs', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$options['items'] = $positions;
                    $options['fieldLabel'] = 'Job Title';
					 $options['xtype']='combo';
					$this->ExtForm->input('name', $options);
				?>,
                                <?php
                                /*$options = array(
                                    'xtype' => 'htmleditor',
                                    'height' => 370,
                                    'anchor' => '99%',
                                    'fieldLabel' => 'Description',
                                    'enableFont' => false,
                                    'enableFontSize' => false
                                );*/
								$options = array();
								$options = array(
						'xtype' => 'textarea',
						'grow' => false,
						'fieldLabel' => 'Requirements',
						'anchor' => '100%'					
						);
                                $this->ExtForm->input('description', $options);
                                ?>,
				<?php 
					$options = array();
					$this->ExtForm->input('start_date', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('end_date', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('grade', $options);
				?>,{
				msgTarget: 'under',
                allowAddNewData: false,
                id:'group-selector',
				height:300,
				forceSelection: true,
                xtype:'superboxselect',
                fieldLabel: 'Locations',
                emptyText: 'Enter or select one or more locations here',
                resizable: true,
                name: 'data[Job][location][]',
                anchor:'100%',
                store: new Ext.data.ArrayStore({
id: 0,
fields: [
'id',
'name'
],
data: [<?php foreach($locations as $loc) echo "['".$loc."','".$loc."'],"; ?>]}),
                mode: 'local',
                displayField: 'name',
                valueField: 'id',
                extraItemCls: 'x-tag',
                listeners: {
                    beforeadditem: function(bs,v){
                        //console.log('beforeadditem:', v);
                        //return false;
                    },
                    additem: function(bs,v){
                        //console.log('additem:', v);
                    },
                    beforeremoveitem: function(bs,v){
                        //console.log('beforeremoveitem:', v);
                        //return false;
                    },
                    removeitem: function(bs,v){
                        //console.log('removeitem:', v);
                    },
                    newitem: function(bs,v){
                        v = v.slice(0,1).toUpperCase() + v.slice(1).toLowerCase();
                        var newObj = {
                            id: v,
                            name: v
                        };
                        bs.addItem(newObj);
                    }
                }
             },
				<?php 
					$options = array();
					$this->ExtForm->input('remark', $options);
				?>			 ]
		});

		var JobAddWindow = new Ext.Window({
			title: '<?php __('Add Job'); ?>',
			width: 700,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: JobAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					JobAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Job.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(JobAddWindow.collapsed)
						JobAddWindow.expand(true);
					else
						JobAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					JobAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							JobAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentJobData();
<?php } else { ?>
							RefreshJobData();
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
					JobAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							JobAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentJobData();
<?php } else { ?>
							RefreshJobData();
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
					JobAddWindow.close();
				}
			}]
		});
