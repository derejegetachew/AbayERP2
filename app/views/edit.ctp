<?php
			$this->ExtForm->create('LoanDisbursementRequest');
			$this->ExtForm->defineFieldFunctions();
		?>
		var LoanDisbursementRequestEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'loanDisbursementRequests', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: {
                xtype:'tabpanel',
                activeTab: 0,
				height: 300,
                id: 'form_tabs',
                tabWidth: 185,
                defaults:{ bodyStyle:'padding:10px'}, 
                items:[{
                        title:'tab1',
                        layout:'form',
                        defaultType: 'textfield',
                        id:'tab1',
                        items: [
							<?php $this->ExtForm->input('id', array('hidden' => $loan_disbursement_request['LoanDisbursementRequest']['id'])); ?>,
							<?php 
					$options = array();
					$options['value'] = $loan_disbursement_request['LoanDisbursementRequest']['name_of_applicants'];
					$this->ExtForm->input('name_of_applicants', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $loan_disbursement_request['LoanDisbursementRequest']['purpose_of_loan'];
					$this->ExtForm->input('purpose_of_loan', $options);
				?>,
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Branch');
					
						$options['items'] = $branches_array;
						$options['value'] = $loan_disbursement_request['LoanDisbursementRequest']['branch'];
					$this->ExtForm->input('branch', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $loan_disbursement_request['LoanDisbursementRequest']['approval_committee'];
					$this->ExtForm->input('approval_committee', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $loan_disbursement_request['LoanDisbursementRequest']['date_of_approval'];
					$this->ExtForm->input('date_of_approval', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $loan_disbursement_request['LoanDisbursementRequest']['sector'];
					$this->ExtForm->input('sector', $options);
				?>,
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Company Size');
					$options['items'] = array(1 => "Coorporate Customer", 2 => "Small & medium enterprise" );
					$options['value'] = $loan_disbursement_request['LoanDisbursementRequest']['company_size'];
					$this->ExtForm->input('company_size', $options);
				?>,
                        ]
                    }, {
                        title:'tab2',
                        layout:'form',
                        defaultType: 'textfield',
                        id:'tab2',
                        disabled: true,
                        items: [
							<?php 
					$options = array();
					$options['value'] = $loan_disbursement_request['LoanDisbursementRequest']['amount_approved'];
					$this->ExtForm->input('amount_approved', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $loan_disbursement_request['LoanDisbursementRequest']['disbursement_amount_requested'];
					$this->ExtForm->input('disbursement_amount_requested', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $loan_disbursement_request['LoanDisbursementRequest']['amount_disbursed'];
					$this->ExtForm->input('amount_disbursed', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $loan_disbursement_request['LoanDisbursementRequest']['undisbursed_amount'];
					$this->ExtForm->input('undisbursed_amount', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $loan_disbursement_request['LoanDisbursementRequest']['fcy_generated'];
					$this->ExtForm->input('fcy_generated', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $loan_disbursement_request['LoanDisbursementRequest']['date_dsb_requested'];
					$this->ExtForm->input('date_dsb_requested', $options);
				?>,
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Approval Status');
					$options['items'] = array(1 => "Pending", 2 => "Approved", 3 => "Rejected" );
					$options['value'] = $loan_disbursement_request['LoanDisbursementRequest']['approval_status'];
					$this->ExtForm->input('company_size', $options);
				?>,
                            
                        ]
                    }
                ]
            }

			
		});
		var activetab=1;
		var LoanDisbursementRequestEditWindow = new Ext.Window({
			title: '<?php __('Edit Loan Disbursement Request'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: LoanDisbursementRequestEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					LoanDisbursementRequestEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Loan Disbursement Request.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(LoanDisbursementRequestEditWindow.collapsed)
						LoanDisbursementRequestEditWindow.expand(true);
					else
						LoanDisbursementRequestEditWindow.collapse(true);
				}
			}],
			buttons: [ {
                    text: '<?php __('Back'); ?>',
                    disabled: true,
                    id:'back',
                    handler: function(btn){
                       
                        if(activetab==2){
                            Ext.getCmp('tab1').enable();
                            Ext.getCmp('tab2').disable();
                            Ext.getCmp('form_tabs').setActiveTab(Ext.getCmp('tab1'));
                            Ext.getCmp('next').setText('Next');
                            activetab=1;
                        }


                    }
                }, {
                    text: '<?php __('Next'); ?>',
                    id:'next',
                    handler: function(btn){
					
						if(activetab==2){
                            LoanDisbursementRequestEditForm.getForm().submit({
                                waitMsg: '<?php __('Submitting your data...'); ?>',
                                waitTitle: '<?php __('Wait Please...'); ?>',
                                success: function(f,a){
                                    Ext.Msg.show({
                                        title: '<?php __('Success'); ?>',
                                        buttons: Ext.MessageBox.OK,
                                        msg: a.result.msg,
                                        icon: Ext.MessageBox.INFO
                                    });
                                    LoanDisbursementRequestEditWindow.close();
        <?php if (isset($parent_id)) { ?>
			RefreshParentLoanDisbursementRequestData();
        <?php } else { ?>
			RefreshLoanDisbursementRequestData();
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
                        
                        if(activetab==1){
                            Ext.getCmp('back').enable();
                            Ext.getCmp('tab2').enable();
                            Ext.getCmp('tab1').disable();
                            Ext.getCmp('form_tabs').setActiveTab(Ext.getCmp('tab2'));
                            activetab=2;
                        }
                    }
					
                       
                },{
                    text: '<?php __('Cancel'); ?>',
                    handler: function(btn){
						LoanDisbursementRequestEditWindow.close();
                    }
                }]
		});
