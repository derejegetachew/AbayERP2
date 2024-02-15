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
//header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (60 * 60 * 24 * 5))); // 1 hour

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <?php echo $this->Html->charset(); ?>
    <title>
            <?php __('AbayERP&trade;'); ?>
    </title>
    <style>
        /* style rows on mouseover */
        .x-grid3-row-over .x-grid3-cell-inner {
            font-weight: bold;
        }
    </style>
	<?php
		echo $this->Html->meta('icon');
		
		echo $this->Html->css('default') . "\n";
        echo $this->Html->css('extjs/resources/css/ext-all') . "\n";
		//echo $this->Html->css('extjs/resources/css/yourtheme') . "\n";
		echo $this->Html->css('extjs/resources/css/xtheme-gray') . "\n";
        echo $this->Html->css('extjs/resources/css/RowEditor') . "\n";
        //echo $this->Html->css('extjs/resources/css/xtheme-access') . "\n";
		echo $this->Html->css('extjs/ux/css/ux-all') . "\n";
		
		echo $this->Html->script('extjs/adapter/ext/ext-base') . "\n";
		echo $this->Html->script('extjs/ext-all') . "\n";
        echo $this->Html->script('extjs/RowEditor') . "\n";
	    echo $this->Html->script('handleamharic') . "\n";
		
		//neccessary for DMS
		echo $this->Html->css('extjs/ux/css/data-view') . "\n";
		echo $this->Html->css('extjs/ux/css/Ext.ux.form.FileUploadField') . "\n";
		echo $this->Html->css('extjs/ux/css/AwesomeUploader') . "\n";
		echo $this->Html->css('extjs/SuperBoxSelect/superboxselect') . "\n";
		
		echo $this->Html->script('extjs/ux/DataView-more') . "\n";
		echo $this->Html->script('extjs/upload/Ext.ux.form.FileUploadField') . "\n";
		echo $this->Html->script('extjs/upload/Ext.ux.XHRUpload') . "\n";
		echo $this->Html->script('extjs/upload/swfupload') . "\n";
		echo $this->Html->script('extjs/upload/swfupload.swfobject') . "\n";
		echo $this->Html->script('extjs/upload/AwesomeUploader') . "\n";
		echo $this->Html->script('extjs/SuperBoxSelect/SuperBoxSelect') . "\n";
		//echo $scripts_for_layout . "\n";
	?>
	<script type='text/javascript'>
		var timeouts = [];
		var s_ajaxListener = new Object();
		s_ajaxListener.tempOpen = XMLHttpRequest.prototype.open;
		s_ajaxListener.tempSend = XMLHttpRequest.prototype.send;
		s_ajaxListener.callback = function () {
			for (var i = 0; i < timeouts.length; i++) {
				clearTimeout(timeouts[i]);
			}
			//quick reset of the timer array you just cleared
			timeouts = [];
			timeouts.push(setTimeout(function(){ location.href = "<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'login')); ?>"; }, <?php echo Configure::read('Session.timeout')*60000;?>));
		  // this.method :the ajax method used
		  // this.url    :the url of the requested script (including query string, if any) (urlencoded) 
		  // this.data   :the data sent, if any ex: foo=bar&a=b (urlencoded)
		}

		XMLHttpRequest.prototype.open = function(a,b) {
		  if (!a) var a='';
		  if (!b) var b='';
		  s_ajaxListener.tempOpen.apply(this, arguments);
		  s_ajaxListener.method = a;  
		  s_ajaxListener.url = b;
		  if (a.toLowerCase() == 'get') {
			s_ajaxListener.data = b.split('?');
			s_ajaxListener.data = s_ajaxListener.data[1];
		  }
		}

		XMLHttpRequest.prototype.send = function(a,b) {
		  if (!a) var a='';
		  if (!b) var b='';
		  s_ajaxListener.tempSend.apply(this, arguments);
		  if(s_ajaxListener.method.toLowerCase() == 'post')s_ajaxListener.data = a;
		  s_ajaxListener.callback();
		}
		</script>
	<script>
	var myApp ={} //for message reply and forward function
	Ext.onReady(function() {
	
	
	
		Ext.QuickTips.init();
		Ext.History.init();
		
		var list_size = 40;
		var view_list_size = 10;
		var editWin = null;
		
		Ext.override(Ext.data.Connection, {	timeout: 2600000	});
		//Ext.override(Ext.data.proxy.Ajax, { timeout: 2600000 });
		//Ext.override(Ext.form.action.Action, { timeout: 2600000 });
		Ext.Ajax.timeout = 2600000;
        
		Ext.apply(Ext.form.VTypes, {
			Currency:  function(v) {
				return /^\d+\.\d{2}$/.test(v);
			},
			CurrencyText: 'Must be an amount of money.',
			CurrencyMask: /[\d\.]/i
		});
		
		Ext.apply(Ext.form.VTypes, {
			Currency1:  function(v) {
				return /^\d+\.\d{4}$/.test(v);
			},
			Currency1Text: 'Must be a four digit Decimal.',
			Currency1Mask: /[\d\.]/i
		});
		
		Ext.apply(Ext.form.VTypes, {
			Decimal:  function(v) {
				return /^\d+\.?\d*$/.test(v);
			},
			DecimalText: 'Must be a decimal.',
			DecimalMask: /[\d\.]/i
		});
		Ext.apply(Ext.form.VTypes, {
			Decimal1:  function(v) {
				return /^\d+\.\d{2}$/.test(v);
			},
			Decimal1Text: 'Must be a two digit decimal.',
			Decimal1Mask: /[0-9.]/i
		});

		function RefreshTopToolbar() {
			Ext.Ajax.request({
				url: "<?php echo $this->Html->url(array('controller' => 'pages', 'action' => 'toptoolbar')); ?>",
				success: function(response, opts) {
					var toolbar_data = response.responseText;
					var mytoolbar = Ext.getCmp('mainViewPort').findById('north-panel').getBottomToolbar();
					
					eval(toolbar_data);
					
					Ext.getCmp('mainViewPort').findById('north-panel').getBottomToolbar().doLayout();
					Ext.getCmp('mainViewPort').doLayout();
				},
				failure: function(response, opts) {
					Ext.Msg.alert('Error', 'Cannot get the toolbar data. Error code: ' + response.status);
				}
			});
		}
		
		function BuildContainer() {
			Ext.Ajax.request({
				url: "<?php echo $this->Html->url(array('controller' => 'containers', 'action' => 'active_containers')); ?>",
				success: function(response, opts) {
					var container_data = response.responseText;
					var mycontainer_panel = Ext.getCmp('mainViewPort').findById('west-panel');
					
					eval(container_data);
					
					if(Ext.getCmp('west-panel').getRootNode().hasChildNodes())
						Ext.getCmp('west-panel').getRootNode().item(0).expand();
						
					Ext.getCmp('mainViewPort').findById('west-panel').doLayout();
					Ext.getCmp('mainViewPort').doLayout();
				},
				failure: function(response, opts) {
					Ext.Msg.alert('Error', 'Cannot get the menu data. Error code: ' + response.status);
				}
			});
		}
		
		function getUrl(function_name) {
			switch (function_name) {
<?php foreach($permittedContainers as $permittedContainer) { ?>
<?php 		foreach($permittedContainer['links'] as $clink) { ?>
				case "<?php echo $clink['function_name']; ?>":
					return "<?php echo $this->Html->url(array('controller' => $clink['controller'], 'action' => $clink['action'], $clink['parameter'])); ?>";
					break;
<?php 		} ?>
<?php } ?>
				default : return function_name;
			}
		}

		function getFunctionName(url) {
			switch (url) {
<?php foreach($permittedContainers as $permittedContainer) { ?>
<?php 		foreach($permittedContainer['links'] as $clink) { ?>
				case "<?php echo $this->Html->url(array('controller' => $clink['controller'], 'action' => $clink['action'], $clink['parameter'])); ?>":
					return "<?php echo $clink['function_name']; ?>";
					break;
<?php 		} ?>
<?php } ?>
				default : return url;
			}
		}		
		
		var loginForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 55,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'login')); ?>',
			defaultType: 'textfield',

			items: [{
				fieldLabel: 'Username',
				name: 'data[User][username]',
				allowBlank: false,
				anchor:'100%'
			},{
				inputType: 'password',
				fieldLabel: 'Password',
				name: 'data[User][passwd]',
				allowBlank: false,
				anchor: '100%',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							handleLogin();
						}
					}
				}
			}]
		});
		
		var loginWindow = new Ext.Window({
			title: 'Login',
			width: 260,
			height:130,
			minWidth: 260,
			minHeight: 130,
			layout: 'fit',
			modal: true,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
			defaultButton: 0,
			items: loginForm,
			
			buttons: [{
				text: 'Login',
				type: 'submit',
				handler: function(btn){
					handleLogin();
				}
			}, {
				text: 'Cancel',
				handler: function(btn){
					loginWindow.hide();
				}
			}]
		});
		
		function handleLogin() {
                    loginForm.getForm().submit({
                        waitMsg: '<?php __('Submitting your data...'); ?>',
                        waitTitle: '<?php __('Wait Please...'); ?>',
                        success: function(f,a){
                            Ext.Msg.show({
                                title: '<?php __('Welcome'); ?>',
                                buttons: Ext.MessageBox.OK,
                                msg: 'Welcome!',
                                icon: Ext.MessageBox.INFO
                            });
                            loginWindow.hide();
                            location = '<?php echo $this->Html->url(array('controller' => 'pages', 'action' => 'display')); ?>';
                            exit();
                        },
                        failure: function(f,a){
                            Ext.Msg.show({
                                title: '<?php __('Cannot Be Logged In'); ?>',
                                buttons: Ext.MessageBox.OK,
                                msg: 'Incorrect username or password!',
                                icon: Ext.MessageBox.ERROR
                            });
                        }
                    });
		}
		
		var forgotPasswordForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 55,
			url:'<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'forgot_pwd')); ?>',
			defaultType: 'textfield',

			items: [{
				fieldLabel: 'Username',
				name: 'data[User][username]',
				allowBlank: false,
				anchor:'80%'
			}, {
				fieldLabel: 'Question',
				name: 'data[User][security_question]',
				allowBlank: false,
				anchor:'100%'
			}, {
				fieldLabel: 'Answer',
				name: 'data[User][security_answer]',
				allowBlank: false,
				anchor:'80%'
			}],
			buttons: [{
				text: 'Sumbit',
				type: 'submit',
				handler: function(btn){
					forgotPasswordForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Well!'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: 'We have sent you your new password. Please check your email.',
                                icon: Ext.MessageBox.INFO
							});
							forgotPasswordWindow.hide();
						},
						failure: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Cannot Be Logged In'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: 'We cannot resolve the request. Please contact the web admin!',
								icon: Ext.MessageBox.ERROR
							});
						}
					});
				}
			}, {
				text: 'Cancel',
				handler: function(btn){
					forgotPasswordWindow.hide();
				}
			}]
		});
		
		var forgotPasswordWindow = new Ext.Window({
			title: 'Forgot Password?',
			width: 400,
			height: 165,
			layout: 'fit',
			modal: true,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
			defaultButton: 0,
			items: forgotPasswordForm
		});
		
		var viewport = new Ext.Viewport({
			layout: "border",
			id: 'mainViewPort',
			renderTo: Ext.getBody(),
			items: [{
				region: "north",
				xtype: 'panel',
				id: 'north-panel',
				html: '<div id="header">&nbsp;<div>',
				height: 28,
				bbar: new Ext.Toolbar({
					id: 'top-toolbar',
					items: [
					]
				})
			}, {
				xtype: 'treepanel',
				id:'west-panel',
				region:'west',
				title: '<?php __('Main Menu'); ?>',
				split:true,
				width: 175,
				minSize: 175,
				maxSize: 300,
				collapsible: true,
				margins:'0 0 5 5',
				cmargins:'0 5 5 5',
				rootVisible:false,
				lines:false,
				autoScroll:true,
				root: new Ext.tree.TreeNode('Main Menu'),
				collapseFirst:false,
				singleExpand: true,
				animate: true,
				useArrows: true
			}, {
				region: 'center',
				id: 'centerPanel',
				xtype: 'tabpanel',
				resizeTabs: true,
				minTabWidth: 150,
				tabWidth:150,
				enableTabScroll:true,
				margins: '0 0 0 0',
				plugins: new Ext.ux.TabCloseMenu(),
				activeTab: 0,
				items: [<?php echo $content_for_layout; ?>]
			}, {
				region: 'south',
				xtype: 'panel',
				html: '<center>Abay Bank &copy <?php echo date('Y')?> - www.abaybank.com.et</center>'
			}]
		}); 
		
		RefreshTopToolbar();
		BuildContainer();
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