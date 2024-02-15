		<?php
			$this->ExtForm->create('Takentraining');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FrwfmApplicationAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'takentrainings', 'action' => 'report')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 					
					$options = array();
						$options['items'] = $trainings;
						$options['value'] = 'All';
					$this->ExtForm->input('training_id', $options);
				?>,
				<?php 					
					$options = array();
						$options['items'] = $positions;
						$options['value'] = 'All';
					$this->ExtForm->input('position_id', $options);
				?>,
				<?php 					
					$options = array();
						$options['items'] = $branches;
						$options['value'] = 'All';
					$this->ExtForm->input('branch_id', $options);
				?>]
		});
		
		var ReportWindow = new Ext.Window({
			title: '<?php __('Report/Search'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FrwfmApplicationAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FrwfmApplicationAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Frwfm Application.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ReportWindow.collapsed)
						ReportWindow.expand(true);
					else
						ReportWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Printable'); ?>',
				handler: function(btn){
										     var form = FrwfmApplicationAddForm.getForm(); // or inputForm.getForm();
     var el = form.getEl().dom;
     var target = document.createAttribute("target");
     target.nodeValue = "_blank";
     el.setAttributeNode(target);
     el.action = form.url;
     el.submit();
				}
			}, {
				text: '<?php __('Excel'); ?>',
				handler: function(btn){
					 var form = FrwfmApplicationAddForm.getForm(); // or inputForm.getForm();
					 var el = form.getEl().dom;
					 var target = document.createAttribute("target");
					 target.nodeValue = "_blank";
					 el.setAttributeNode(target);
					 el.action = form.url + "/excel";
					 el.submit();
				}
			},{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					ReportWindow.close();
				}
			}]
		});
ReportWindow.show();