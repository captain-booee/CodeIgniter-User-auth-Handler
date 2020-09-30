###################
CodeIgniter - PHP
###################

###################
LOGIN - REGISTER - FORGETPASS
###################


*******************
include:
*******************

**csfr control**

**Google Recaptcha to requset control**

**ip check : 1:n relation => one user is allowed to have many ip BUT one ip is just owned by one user. ability to block the user that entered with multi account.**

**email validation send => smtp**

**resend email validation**





*******************
Hint
*******************

set these configs in register controller:

'smtp_user' => 'email@gmail.com'

'smtp_pass' => '****'

recaptcha.php in config folder:

$config['re_keys'] = array(
	'site_key'		=> '****************************************',
	
	'secret_key'	=> '****************************************')
  
  
  SQL file included necessary tables is added: .sql
