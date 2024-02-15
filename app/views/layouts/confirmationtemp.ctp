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
function ConfirmationPasswords(val){
    msg = "";
    new_pwd = Ext.getCmp('data[User][new_password]').getValue();
    con_pwd = Ext.getCmp('data[User][confirm_password]').getValue();

    if(new_pwd != con_pwd)
        msg += 'New password and its confirmation must match.<br />';

    if(msg == '') {
        Ext.getCmp('data[User][new_password]').clearInvalid();
        Ext.getCmp('data[User][confirm_password]').clearInvalid();
        return true; 
    }
    else
        return msg; 
}
  <?php   echo "store_rows= new Ext.data.ArrayStore({
                                                            id: 0,
                                                            fields: ['id','name'],
                                                            data: [";
                                        foreach($rows as $row){
                                            echo "['".$row['User']['id']."','".$row['User']['username']."'],";
                                        }
                                        echo "  ]}); \n ";
                                 ?>
function UniqueCheck(val){
    var recordIndex = store_rows.findBy(
    function(record, id){
        if(record.get('name').toUpperCase() === val.toUpperCase()){
              return true;  // a record with this data exists
        }
        return false;  // there is no record in the store with this data
    }
);

if(recordIndex != -1){
    return 'Username already taken, try different username';
}
else return true;
}
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
                        labelWidth: 145,
                        labelAlign: 'right',
                        url: "<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'confirmationtemp')); ?>",
                        defaultType: 'textfield',
                        
                        items: [ 
                            {inputType:'hidden',
                                name: 'data[User][id]',
                                value:<?php echo $id; ?>
                            }
                                
                        ,
                            {
                                fieldLabel: 'Confirmation Code',
                                name: 'data[User][confirmation_code]',
								inputType:'hidden',
								value:'123456',
                                allowBlank: false,
                                anchor:'100%'
                            },{
                                fieldLabel: 'New User Name',
                                name: 'data[User][username]',
                                validator: UniqueCheck,
                                allowBlank: false,
                                anchor:'100%'
                            },{inputType: 'password',
                               validator: ConfirmationPasswords,
                                fieldLabel: 'New Password',
                                name: 'data[User][new_password]',
                                id:'data[User][new_password]',
                                allowBlank: false,
                                anchor:'100%'
                            },{inputType: 'password',
                                validator: ConfirmationPasswords,
                                fieldLabel: 'Confirm Password',
                                name: 'data[User][confirm_password]',
                                id: 'data[User][confirm_password]',
                                allowBlank: false,
                                anchor:'100%'
                            }]
                    });
		
                    var loginWindow = new Ext.Window({
                        title: 'Register on AbayERP System<br><hr>Please write your prefered username and password',
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
                                    title: "<?php __('Welcome'); ?>",
                                    buttons: Ext.MessageBox.OK,
                                    msg: 'Welcome to Abay Bank HR Management System',
                                    icon: Ext.MessageBox.INFO
                                });
                                loginWindow.hide();
                                location = "<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'login')); ?>";
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