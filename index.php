<?php
require_once("DB.php");

$db = new DB("fdb21.awardspace.net", "2731756_users", "2731756_users", "bruno52545856");
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json;');

if ($_SERVER['REQUEST_METHOD'] == "GET") {

	if ($_GET['url'] == "clientes") {
		echo json_encode(($db->query("SELECT * FROM users")));
		http_response_code(200);
	}

} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
	
	if ($_GET['url'] == "clientes") {
		$postBody = file_get_contents("php://input");
		$postBody = json_decode($postBody);
                
                foreach ($postBody as $cmp => $val) {
                        if ($cmp == 'pass') {
                                $val = md5($val);
                        }
                        $cmp_str .= $cmp . ",";
                        $val_str .= "\"$val\",";        
                }
                
                $size = strlen($cmp_str);
                $cmp = substr($cmp_str,0, $size-1);
                
                $size = strlen($val_str);
                $val = substr($val_str,0, $size-1);
                
                $name = (isset($postBody->name)) ? $postBody->name : '';
                $login= (isset($postBody->login)) ? $postBody->login : '';
                $pass = (isset($postBody->pass)) ? $postBody->pass : '';
                
                //$ret = $db->query("INSERT INTO users ($cmp) VALUES ($val)", true);
                $ret = $db->query('INSERT INTO users (name, login, pass) VALUES (:name, :login, :pass)', array(':name'=>$name, ':login'=>$login, ':pass'=>md5($pass)), true);
                if ($ret) {
                        echo 'Registro inserido com sucesso!';
                } else {
                        echo 'Erro ao inserir o resgistro';
                }
		
		// $username = $postBody->username;
		// $password = $postBody->password;

		// if ($db->query('SELECT usuario FROM usr WHERE usuario=:username', array(':username' => $username))) {
		// 	if (password_verify($password, $db->query('SELECT senha FROM usr WHERE usuario=:username', array(':username' => $username))[0]['password'])) {
		// 		$cstrong = true;
		// 		$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
		// 		$user_id = $db->query('SELECT id FROM usr WHERE usuario=:username', array(':username'=>$username))[0]['id'];
		// 		$db->query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token),':user_id'=>$user_id));
		// 		echo '{ "Token" : "'.$token.'" }';
		// 	} else {
		// 		http_response_code(401);
		// 	}
		// }
	}

} else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {

	if ($_GET['url'] == "clientes") {

	}

} else {
	http_response_code(405);
}
