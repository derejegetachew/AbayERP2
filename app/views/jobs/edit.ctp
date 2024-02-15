		<?php
			$this->ExtForm->create('Job');
			$this->ExtForm->defineFieldFunctions();
		?>
		var JobEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'jobs', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $job['Job']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $job['Job']['name'];
					if((time()-(60*60*24*2)) > strtotime($job['Job']['start_date']))
						$options['disabled']=true;
					if($job['Job']['status']!='Open')
						$options['disabled']=true;
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options = array(
						'xtype' => 'textarea',
						'grow' => false,
						'fieldLabel' => 'Requirements',
						'anchor' => '100%'					
						);
					$options['value'] = $job['Job']['description'];
					if((time()-(60*60*24*2)) > strtotime($job['Job']['start_date']))
						$options['disabled']=true;
						if($job['Job']['status']!='Open')
						$options['disabled']=true;
					$this->ExtForm->input('description', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $job['Job']['start_date'];
					if((time()-(60*60*24*2)) > strtotime($job['Job']['start_date']))
						$options['disabled']=true;
						if($job['Job']['status']!='Open')
						$options['disabled']=true;
					$this->ExtForm->input('start_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $job['Job']['end_date'];
					if(time() > strtotime($job['Job']['end_date']))
						$options['disabled']=true;
						if($job['Job']['status']!='Open')
						$options['disabled']=true;
					$this->ExtForm->input('end_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $job['Job']['grade'];
					if((time()-(60*60*24*2)) > strtotime($job['Job']['start_date']))
						$options['disabled']=true;
						if($job['Job']['status']!='Open')
						$options['disabled']=true;
					$this->ExtForm->input('grade', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $job['Job']['location'];
					if((time()-(60*60*24*2)) > strtotime($job['Job']['start_date']))
						$options['disabled']=true;
						if($job['Job']['status']!='Open')
						$options['disabled']=true;
					$this->ExtForm->input('location', $options);
				?>, <?php 
                $options = array();
                $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Status','value'=>$job['Job']['status'] );
                $options['items'] = array('Open'=>'Open','Filled'=>'Filled','Canceled'=>'Canceled');
					if($job['Job']['status']!='Open')
						$options['disabled']=true;
                $this->ExtForm->input('status', $options);
                ?>,
				<?php 
					$options = array();
					$options['value'] = $job['Job']['remark'];
					if($job['Job']['status']!='Open')
						$options['disabled']=true;
					$this->ExtForm->input('remark', $options);
				?>			]
		});
		
		var JobEditWindow = new Ext.Window({
			title: '<?php __('Edit Job'); ?>',
			width: 700,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: JobEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					JobEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Job.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(JobEditWindow.collapsed)
						JobEditWindow.expand(true);
					else
						JobEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					JobEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							JobEditWindow.close();
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
					JobEditWindow.close();
				}
			}]
		});
