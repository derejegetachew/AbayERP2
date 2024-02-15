		<?php
			$this->ExtForm->create('ImsRent');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsRentAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 120,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsRents', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				
				{
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							<?php $st = false;foreach ($branches as $item){if($st) echo ",
							";?>['<?php echo $item['Branch']['id']; ?>' ,'<?php echo $item['Branch']['name']; ?>']<?php $st = true;}
							 echo ',["Building A - Seventh Floor" ,"Building A - Seventh Floor"],["Ambassel ATM" ,"Ambassel ATM"],["DH Geda ATM" ,"DH Geda ATM"],["Stadium ATM","Stadium ATM"],["Head Office ATM","Head Office ATM"],["Bahir Dar Store" ,"Bahir Dar Store"],["Dessie Store" ,"Dessie Store"],["Enderase Store" ,"Enderase Store"],
									["Building B - Ground Floor","Building B - Ground Floor"],["Building B - Mezzanine Floor","Building B - Mezzanine Floor"],["Building B - First Floor","Building B - First Floor"],["Building B - Second Floor","Building B - Second Floor"],
									["Building B - Third Floor","Building B - Third Floor"],["Building B - Fourth Floor","Building B - Fourth Floor"],["Building B - Sixth Floor","Building B - Sixth Floor"],["Building B - Eighth Floor","Building B - Eighth Floor"],
									["Building B - Third Floor 2","Building B - Third Floor 2"], ["Building A - Eighth Floor","Building A - Eighth Floor"],["Building A - Roof Top (Strategy room)","Building A - Roof Top (Strategy room)"],["Figa ATM" ,"Figa ATM"],["Megenagna ATM" ,"Megenagna ATM"],
									["Building A - Roof Top (training room)","Building A - Roof Top (training room)"],["Service Quarter","Service Quarter"],["Project Office","Project Office"],["Kality DR site","Kality DR site"],["Building A - Nineth Floor","Building A - Nineth Floor"],
									["Mintwab district office","Mintwab district office"],["Archive store (Mintwab BLD)","Archive store (Mintwab BLD)"],["Kaliti store","Kaliti store"],["Betel store","Betel store"],["IFB Office (Shiber BLD)","IFB Office (Shiber BLD)"],["Project office (ShIbre BLD)","Project office (ShIbre BLD)"],["KYC Customer r/n office (Shibre BLD)","KYC Customer r/n office (Shibre BLD)"],["Building A Sixth Floor","Building A Sixth Floor"],["Betel store","Betel store"],["Meskel flower Head office","Meskel flower Head office"]'?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					hiddenName:'data[ImsRent][branch_id]',
					id: 'branch',
					name: 'branch',
					mode : 'local',
					triggerAction: 'all',
					emptyText: 'Select Branch',
					selectOnFocus:false,
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> የቅርንጫፉ ስም',
					allowBlank: false,
					editable: true,
					lazyRender: true,
					blankText: 'Your input is invalid.',
					disableKeyFilter: true,
					forceSelection:true,
					anyMatch : false,
				},
				<?php 
					$options = array('fieldLabel' => 'ስፋት በካ/ሜ', 'anchor' => '80%', 'vtype' => 'Decimal1', 'allowBlank' => false);
					$options['maskRe'] = '/[0-9.]/i';
					$this->ExtForm->input('width', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'ወርሃዊ ኪራይ ቫትን ጨምሮ', 'anchor' => '80%', 'vtype' => 'Decimal1', 'allowBlank' => false);
					$options['maskRe'] = '/[0-9.]/i';
					$this->ExtForm->input('monthly_rent', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'ዉሉ የተፈረመበት ቀን');
					$this->ExtForm->input('contract_signed_date', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'የውል ዘመን');
					$this->ExtForm->input('contract_age', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'ውሉ ተግባራዊ የሚሆንበት ቀን');
					$this->ExtForm->input('contract_functional_date', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'ውሉ የሚያልቅበት ቀን');
					$this->ExtForm->input('contract_end_date', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'የተከፈለዉ ቅ/ክፍያ', 'vtype' => 'Decimal1', 'allowBlank' => false);
					$options['maskRe'] = '/[0-9.]/i';
					$this->ExtForm->input('prepayed_amount', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'ቅድሚያ የተከፈለው የሚጠናቀቅበት ጊዜ');
					$this->ExtForm->input('prepayed_end_date', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'የአከራይ ሙሉ ስም');
					$this->ExtForm->input('renter', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'የአከራይ አድራሻ');
					$this->ExtForm->input('address', $options);
				?>	,
				<?php 
					$options = array('xtype'=>'combo','fieldLabel' => '&#4672;&#4650; &#4781;&#4941;&#4843; &#4768;&#4776;&#4939;&#4936;&#4621;');
          $list=array('ONE_TIME'=>'ONE_TIME','YEARLY'=>'YEARLY','N/A'=>'N/A');
					$options['items'] = $list;
					$this->ExtForm->input('rem_payment_term', $options);
				?>		]
		});
		
		var ImsRentAddWindow = new Ext.Window({
			title: '<?php __('Add Rent'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsRentAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsRentAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ims Rent.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsRentAddWindow.collapsed)
						ImsRentAddWindow.expand(true);
					else
						ImsRentAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsRentAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsRentAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsRentData();
<?php } else { ?>
							RefreshImsRentData();
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
					ImsRentAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsRentAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsRentData();
<?php } else { ?>
							RefreshImsRentData();
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
					ImsRentAddWindow.close();
				}
			}]
		});
