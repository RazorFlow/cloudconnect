<?php

class JiraCredentials {
  protected $admin_username;
  protected $admin_password;

  public function setCredentials($username, $password) {
    $this->admin_username = $username;
    $this->admin_password = $password;
  }

  public function getAdminUserName () {
    return $this->admin_username;
  }

  public function getAdminPassword () {
    return $this->admin_password;
  }
}
?>