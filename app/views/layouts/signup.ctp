<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       nma
 * @subpackage    nma.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php __('Login to Abay Bank HR Management System'); ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('default') . "\n";
        echo $this->Html->css('extjs/resources/css/ext-all') . "\n";
        echo $this->Html->css('extjs/resources/css/xtheme-gray') . "\n";
        echo $this->Html->css('extjs/ux/css/ux-all') . "\n";

        echo $this->Html->script('extjs/adapter/ext/ext-base') . "\n";
        echo $this->Html->script('extjs/ext-all') . "\n";

        //echo $scripts_for_layout . "\n";
        ?>
        <script>
                var vstore_employee_names = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            fields: [
                'id', 'full_name','position','photo'		
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'search_emp2')); ?>'
	}),	
        sortInfo:{field: 'full_name', direction: "ASC"}
    });
      vstore_employee_names.load({
            params: {
                start: 0
            }
        });
       vstore_employee_names.on('load', function(){
Ext.getCmp('data[Employee][emp_id]').setValue('Write Your Full Name');
Ext.getCmp('data[Employee][emp_id]').emptyText = 'Write Your Full Name';
    Ext.getCmp('data[Employee][emp_id]').applyEmptyText();
});
            Ext.onReady(function() {
                Ext.QuickTips.init();
                Ext.History.init();
		
                Ext.Ajax.timeout = 9000000000;		
                if(Ext.isIE ) {
                    var the_message = 'Sorry! Abay Bank HR Management System is not working on Internet Explorer. <br/>';

                    the_message += '<br/>Please use Mozilla Firefox above 3.x or any other browser';
                    
                    Ext.Msg.show({
                        title: 'Sorry Admin',
                        buttons: Ext.MessageBox.OK,
                        msg: the_message,
                        icon: Ext.MessageBox.ERROR
                    });
                }else{
                    
               
                    var loginForm = new Ext.form.FormPanel({
                        baseCls: 'x-plain',
                        labelWidth: 75,
                        labelAlign: 'right',
                        url: "<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'signup')); ?>",
                        defaultType: 'textfield',

                        items: [ {
                        xtype: 'combo',
                        hiddenName: 'data[Employee][emp_id]',
                        id: 'data[Employee][emp_id]',
                        forceSelection: true,
                        emptyText: 'Loading list... Please wait',
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'local',
                        valueField: 'id',
                        displayField: 'full_name',
                        allowBlank: false,
                        blankText: 'Your input is invalid.',
                        store : vstore_employee_names,
                        fieldLabel: 'Full Name',
                        width:250,
                        hideTrigger:true,
                        tpl: '<tpl for="."><div ext:qtip="{full_name} . {position}" class="x-combo-list-item"><div><img src="{photo}" style="float:left;width:32px"/> </div> {full_name} <br><b>{position}</b></div></tpl>'                       
                                    }]
                    });
		
                    var loginWindow = new Ext.Window({
                        title: 'Register on AbayERP System',
                        width: 360,
                        autoHeight: true,
                        layout: 'fit',
                        modal: false,
                        resizable: false,
                        closable: false,
                        plain: true,
                        bodyStyle:'padding:5px;',
                        buttonAlign: 'right',
                        defaultButton: 0,
                        items: loginForm,
                    
                        buttons: [{
                                text: 'Continue',
                                type: 'submit',
                                handler: function(btn){
                                    handleLogin();
                                }}]
                    });
		
                    function handleLogin() {
                        loginForm.getForm().submit({
                            waitMsg: "<?php __('Submitting your data...'); ?>",
                            waitTitle: "<?php __('Wait Please...'); ?>",
                            success: function(f,a){
                                Ext.Msg.show({
                                    title: "<?php __('AbayERP'); ?>",
                                    buttons: Ext.MessageBox.OK,
                                    msg: 'Loading Next Window',
                                    icon: Ext.MessageBox.INFO
                                });
                                loginWindow.hide();
                                location = "<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'confirmation')); ?>"+"/"+loginForm.getForm().findField('data[Employee][emp_id]').getValue();
                                exit();
                            },
                            failure: function(f,a){
                                Ext.Msg.show({
                                    title: "<?php __('Cannot Sign up!'); ?>",
                                    buttons: Ext.MessageBox.OK,
                                    msg: 'Cannot Sign up, Please contact HR Department!',
                                    icon: Ext.MessageBox.ERROR
                                });
                            }
                        });
                    }
                    loginWindow.show();
                }
            });
        </script>
    </head>
    <body>
        <form id="history-form" class="x-hidden">
            <input type="hidden" id="x-history-field" />
            <iframe id="x-history-frame"></iframe>
        </form>
        <span id="app-msg" class="x-hidden"></span>

        <?php
        echo $this->Html->script('extjs/ux/ux-all') . "\n";
        echo $this->Html->script('ext_validators') . "\n";
        echo $this->Html->script('calendar-all') . "\n";
        echo $this->Html->script('calendar-list') . "\n";

        echo $scripts_for_layout . "\n";
        ?>
    </body>
</html>