


		<?php
			$this->ExtForm->create('BpActual');
			$this->ExtForm->defineFieldFunctions();
		?>
		function BpActualBpItemIdValidator(value){
			if(value!=null || value!= '')
			return true;
		else
			return false;
		}


		var BpActualAddForm = new Ext.form.FormPanel({

			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'split'));?>',
			//defaultType: 'textfield',
            xtype:'compositefield',
            fieldLabel:'Amount',
			items:[
                   
        <?php foreach($splits as $split) {  ?>
             {
             xtype:'compositefield',
            fieldLabel:'Amount | Branch',
            items:[
			       {
					xtype: 'textfield',
					fieldLabel: 'Amount',
					id:'amount_<?php echo $split ?>',
					name: 'data[BpActual][<?php echo $split ?>]',
					anchor: '50%',
					minValue:1,
					maxValue:100
				  },
				  {
					xtype: 'combo',
					emptyText: 'All',
					id:'amount_<?php echo $split+2 ?>',
					name:'data[Branch][<?php echo $split ?>]',
					anchor: '50%',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
					     <?php $st = false;
					     foreach ($branches as $item){
					     	if($st) echo ",";?>
					     ['<?php echo $item['Branch']['id']; ?>' ,'<?php echo $item['Branch']['name']; ?>']
					     <?php $st = true; }
					     ?>						]
					
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					disableKeyFilter : true,
					triggerAction: 'all',
					hiddenValue:'id',
					hiddenName:'data[Branch][<?php echo $split ?>]',
					listeners : {
					
						select : function(combo, record, index){
						  console.log(combo.getValue());
						}
						
					}

				  },
				   ]
                  },
         <?php  } ?>
                   {
                   	xtype: 'textfield',
					fieldLabel: 'ID',
					id:'amount',
					name: 'data[BpActual][id]',
					value:'<?php echo $id."_".$plan_id ?>',
					anchor: '100%',
					hidden:true,
					minValue:1,
					maxValue:100
                   }
                  
				  ]
		});
		
		var splitWindow = new Ext.Window({
			title: '<?php __('Add Bp Actual'); ?>',
			width: 500,
			minWidth: 400,
			height:500,
			maxHeight: 400,
			minHeight: 100,
			autoScroll:true,
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BpActualAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BpActualAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Bp Actual.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(splitWindow.collapsed)
						splitWindow.expand(true);
					else
						splitWindow.collapse(true);
				}
			}],
			buttons: [{
				text: '<?php __('Split'); ?>',
				handler: function(btn){
					
					var values=BpActualAddForm.getForm().getValues();
					var total=0;
					var last=0;
					//console.log(values);
					for(var k in values){
						if(k.includes("data[BpActual]")){
								if(!k.includes("data[BpActual][id]")){
	                           // console.log(k);
	                            total=Number(total)+Number(values[k]);
	                            //last=Number(values[k]);
	                        }
                        }else{

                        }
					}
					total=total-last;
					var tTotal='<?php echo $amount ?>';
					total=Math.round(total);
					tTotal=Math.round(tTotal);
					console.log(total);
					console.log(tTotal);
					if(total!=tTotal){
					// Ext.Msg.alert('Info',total);
				     Ext.Msg.alert('Info','Total Amount Missmatch');
				      return;
				   }
					BpActualAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							splitWindow.close();
                         <?php if(isset($parent_id)){ ?>
                         	RefreshParentBpActualData();
                         	RefreshActualData();
                         <?php } else { ?>
							RefreshParentBpActualData();
							RefreshActualData();
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
					splitWindow.close();
				}
			}]
		});

