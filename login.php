<html>
<head>
<title> </title>
<head>
<body>
<form id ='login' action='login.php' method='post' accept-charset='UTF-8'>
<input type='text' name='username' id='username' maxlength='20' />
<input type='password' name='password' id='password' maxlength='20' />
<input type='submit' name='submit' id='submit' />
<?php
$mysql = array(  'host' => 'bur.ccg2fbosv7le.us-west-2.rds.amazonaws.com',
    'port' => '3306',
    'database' => 'Bureaucrat',
    'username' => 'bmaple',
    'password' => 'security',);
function login(){
    if (!empty($_POST['username']))
    {
        $this->HandleError("Please enter a username");
    }
    if (!empty($_POST['password']))
    {
        $this->HandleError("Please enter a password");
    }
    $username($_POST['username']);
    $password($_POST['password']);
    if(!$this->auth($username, $password))
    {
        return false;
    }
    session_start();
    $_SESSION[$this->GetLoginSessionVar()] = $username;
    return true;
}
function auth($username, $password){
    if($this->DbConnec
}
}

function DbConnect(){
    $link = new mysqli($mysql['host'], $mysql['username'], $mysql['password'], $mysql['database'], $mysql['port']);                      
    if($link->connect_errno){
        return false;
    }
    return true;
}
?>
</form>
</body>
</html>
