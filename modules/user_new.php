<?php
$this->add(TH4('New User Registration'));
$form = o('newuser', TForm());
$table = TTable();
$table->add(TI('User Name: '), o('newuser_name', TEdit($this->parm('newuser_name'), '[User Name]')));
$table->add(TI('Password: '), o('newuser_password', TPassword($this->parm('newuser_password'))));
$table->add(TI('Confirm Password: '), o('newuser_password2', TPassword($this->parm('newuser_password2'))));
$table->add(TI('Email (optional): '), o('newuser_email', TEdit($this->parm('newuser_email'))));
$form->add($table);

if (isset($this->parameters['newuser_name'])) {
	$isok = true;
	if (trim($this->parm('newuser_name'))=='') {
		$this->adderror('You must provide a user name.');
		$isok = false;
		}else{
		$users = $this->db->select('users');
		foreach($users as $u) {
			if(trim(strtolower($u['name']))==trim(strtolower($this->parm('newuser_name')))) {
				$this->adderror('The user name ' . TTT($this->parm('newuser_name')) . ' is already in use. Please choose another name.');
				$isok = false;
				}
			}
		}
	if (trim($this->parm('newuser_password'))=='') {
		$this->adderror('You must provide a password.');
		$isok = false;
		}
	if ($this->parm('newuser_password')!=$this->parm('newuser_password2')) {
		$this->adderror('The provided passwords do not match.');
		$isok = false;
		}
	if ($isok) {
		$this->db->insert(
			'users', 
			array(
				'name' => $this->parm('newuser_name'),
				'email' => $this->parm('newuser_email'),
				'password' => password_hash($this->parm('newuser_password'), PASSWORD_DEFAULT),
				'createkey' => uniqid('', true)
				)
			);
		$this->redirect('index.php?c=home&m=newuseradded');
		}
	}
$this->add($form);
