<?php
$user = array();
$users = $this->db->select('users');
foreach($users as $u) {
	if ($u['id']==$this->userid) {
		$user = $u;
		}
	}
$this->add(TH4('Edit User Info'));
$form = o('edituser', TForm());
$table = TTable();
$table->add(TI('User Name: '), o('edituser_name', TEdit($this->parm('edituser_name', $user['name']), '[User Name]')));
$table->add(TI('Email (optional): '), o('edituser_email', TEdit($this->parm('edituser_email', $user['email']))));
$form->add($table);

$pwform = o('passwordchange', TForm());
$pwtable = TTable();
$pwtable->add(TI('Password: '), o('edituser_password', TPassword($this->parm('edituser_password', ''))));
$pwtable->add(TI('Confirm Password: '), o('edituser_password2', TPassword($this->parm('edituser_password2', ''))));
$pwform->add($pwtable);

if (isset($this->parameters['edituser_name'])) {
	$isok = true;
	if (trim($this->parm('edituser_name'))=='') {
		$this->adderror('You must provide a user name.');
		$isok = false;
		}else{
		foreach($users as $u) {
			if ($u['id']!=$this->userid) {
				if(trim(strtolower($u['name']))==trim(strtolower($this->parm('edituser_name')))) {
					$this->adderror('The user name ' . TTT($this->parm('edituser_name')) . ' is already in use. Please choose another name.');
					$isok = false;
					}
				}
			}
		}
	if ($isok) {
		$_SESSION['username'] = $this->parm('edituser_name');
		$this->db->update(
			'users', 
			array(
				'name' => $this->parm('edituser_name'),
				'email' => $this->parm('edituser_email')
				),
			"id = {$this->userid}"
			);
		$this->redirect('index.php?c=user');
		}
	}else if (isset($this->parameters['edituser_password'])) {
	$isok = true;
	if (trim($this->parm('edituser_password'))=='') {
		$this->adderror('You must provide a password.');
		$isok = false;
		}
	if ($this->parm('edituser_password')!=$this->parm('edituser_password2')) {
		$this->adderror('The provided passwords do not match.');
		$isok = false;
		}
	if ($isok) {
		$_SESSION['password'] = password_hash($this->parm('edituser_password'), PASSWORD_DEFAULT);
		$this->db->update(
			'users', 
			array(
				'password' => password_hash($this->parm('edituser_password'), PASSWORD_DEFAULT)
				),
			"id = {$this->userid}"
			);
		$this->redirect('index.php?c=user');
		}
	}
$this->add($form);
$this->add(TH4('Change Password'));
$this->add($pwform);