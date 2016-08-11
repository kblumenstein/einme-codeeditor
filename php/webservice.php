<?php
// includes
require("config.inc.php");

$action = $_GET["action"];
$return;

switch($action){
	case "login":
		$return = login($_POST["user"], $_POST["password"], $_POST["loginOption"]);
	break;
	case "updateLektion":
		$return = updateLektion($_POST["user"], $_POST['lektion'], $_POST['html'], $_POST['css']);
	break;
	case "getLektion":
		//echo "user: ".$_POST["user"] ." lektion ". $_POST['lektion'];
		$return = getLektion($_POST["user"], $_POST['lektion']);
	break;
	case "resetLektion":
		$return = resetLektion($_POST["user"], $_POST['lektion']);
	break;
	case "setSnapFinal":
		$return = setSnapFinal($_GET["name"], $_GET["punkte"]);
		echo $return;
		die();
	break;
	case "setSnapFrage":
		$return = setSnapFrage($_GET["name"], $_GET["frage"], $_GET["antwort"], $_GET["richtig"]);
		echo $return;
		die();
	break;
	case "getSnapOverview":
		$return = getSnapOverview();
	break;
	case "getSnapMatrikelnummern":
		$return = setSnapMatrikelnummern();
	break;
	case "getSnapFragen":
		$return = getSnapFragen($_POST["user"]);
	break;
}

header('Content-type: application/json');
echo $return;

function login($username, $password, $loginOption){
	switch($loginOption){
		case "ldap": 
			$ds =ldap_connect(LDAP_SERVER,LDAP_SERVER_PORT);

			if ($ds) {
				// binde zum LDAP Server
				$search = ldap_search($ds, LDAP_BASE, '(sAMAccountName=' . $username . ')', array('cn', 'givenname', 'sn'));
				$entries = ldap_get_entries($ds, $search);
				ldap_free_result($search);
				$dn = $entries[0]['dn'];

				if (!$dn) {
					// Keine Benutzerdaten gefunden
					$antwort = '{"status" : -1, "statustext" : "Einloggen nicht möglich. Bitte überprüfe die Matrikelnummer-Passwort-Kombination!"}';
				}else{
					@$ldap_bind = ldap_bind($ds, $dn , $password);
					// Bindung überprüfen
					if ($ldap_bind){
						$matrikelnummer = $entries[0][cn][0];
						$name = $entries[0][givenname][0]. " " .$entries[0][sn][0];

						// TODO: hole alle gespeicherten Lektionen aus der DB
						
						$antwort = '{"status" : 0,"statustext" : "Login erfolgreich!", "user" : { "matrikelnummer" : "'.$matrikelnummer.'", "name" : "'.$name.'", "lektionen" : '.getAllLektionen($matrikelnummer).'}}';
						
						

					}else{
						$antwort = '{"status" : -1,	"statustext" : "Einloggen nicht möglich. Bitte überprüfe die Matrikelnummer-Passwort-Kombination!"}';
					}
				}
			}
		break;
		case "intern":
			if($username == "admin" && $password == "marimbas"){
				// TODO: hole alle gespeicherten Lektionen aus der DB
				
				$antwort = '{"status" : 0,"statustext" : "Login erfolgreich!", "user" : { "matrikelnummer" : "admin", "name" : "Administrator", "lektionen" : '.getAllLektionen($username).'}}';
			}
		break;
	}
	

   	return $antwort;
}

function getAllLektionen($username){
	$db = connectDB();
	
	try {
        $result = $db->prepare("SELECT * FROM lehre_einme WHERE matrikelnummer LIKE :matrikelnummer");
        $result->bindParam(':matrikelnummer', $username);
        $result->execute();
    }
    catch (PDOException $e) {
        echo '{"status" : -1,"statustext" : "Fehler bei der Datenbankabfrage, wegen: '.$e->getMessage().'"}';
        exit;
    }
	
	$res = $result->fetchAll(PDO::FETCH_ASSOC);
	
	disconnectDB($db);

	return json_encode($res);
}

function updateLektion($user, $lektion, $html, $css){
	$db = connectDB();
	
	try {
        $result = $db->prepare("UPDATE lehre_einme SET code_html=:html, code_css=:css WHERE matrikelnummer LIKE :matrikelnummer AND lektion LIKE :lektion");
        $result->bindParam(':matrikelnummer', $user);
        $result->bindParam(':lektion', $lektion);
        $result->bindParam(':html', $html);
        $result->bindParam(':css', $css);
        $result->execute();
    }
    catch (PDOException $e) {
        echo '{"status" : -1,"statustext" : "Fehler bei der Datenbankabfrage, wegen: '.$e->getMessage().'"}';
        exit;
    }

	$count = $result->rowCount();
	
	disconnectDB($db);
	
	if($count > 0){
		$antwort = '{"status" : 0,"statustext" : "Update erfolgreich!"}';
	}else{
		$antwort = '{"status" : -2,"statustext" : "Es konnten keine Änderungen am Datensatz festgestellt werden!"}';
	}
	
	return $antwort;

}

function getLektion($user, $lektion){
	$db = connectDB();
	
	try {
        $result = $db->prepare("SELECT * FROM lehre_einme WHERE matrikelnummer LIKE 'admin' AND lektion LIKE :lektion");
        $result->bindParam(':lektion', $lektion);
        $result->execute();
    }
    catch (PDOException $e) {
        echo '{"status" : -1,"statustext" : "Fehler bei der Datenbankabfrage1, wegen: '.$e->getMessage().'"}';
        exit;
    }

	$res = $result->fetchAll(PDO::FETCH_ASSOC);
	//var_dump($res[0]);
	
	if($user != "admin"){
		try {
       		$result2 = $db->prepare("INSERT INTO lehre_einme (matrikelnummer, lektion, code_html, code_css) VALUES (:matrikelnummer, :lektion, :html, :css)");
       		$result2->bindParam(':matrikelnummer', $user);
       		$result2->bindParam(':lektion', $res[0][lektion]);
       		$result2->bindParam(':html', $res[0][code_html]);
       		$result2->bindParam(':css', $res[0][code_css]);
       		$result2->execute();
	    }
	    catch (PDOException $e) {
        	echo '{"status" : -1,"statustext" : "Fehler bei der Datenbankabfrage2, wegen: '.$e->getMessage().'"}';
        	exit;
        }
        
        $count = $result2->rowCount();
        
        if($count > 0){
			$antwort = '{"status" : 0,"statustext" : "Insert erfolgreich!", "lektion" : '.json_encode($res).'}';
		}else{
			$antwort = '{"status" : -1,"statustext" : "Lektion konnte nicht angelegt werden!"}';
		}
	
	}else{
		$antwort = '{"status" : 0,"statustext" : "Laden erfolgreich - Admin!", "lektion" : '.json_encode($res).'}';
	}
	
	disconnectDB($db);
	
	
	return $antwort;
}

function resetLektion($user, $lektion){
	$db = connectDB();
	
	try {
        $result = $db->prepare("SELECT * FROM lehre_einme WHERE matrikelnummer LIKE 'admin' AND lektion LIKE :lektion");
        $result->bindParam(':lektion', $lektion);
        $result->execute();
    }
    catch (PDOException $e) {
        echo '{"status" : -1,"statustext" : "Fehler bei der Datenbankabfrage1, wegen: '.$e->getMessage().'"}';
        exit;
    }

	$res = $result->fetchAll(PDO::FETCH_ASSOC);
	//var_dump($res[0]);
	
	try {
    	$result2 = $db->prepare("UPDATE lehre_einme SET code_html=:html, code_css=:css WHERE matrikelnummer LIKE :matrikelnummer AND lektion LIKE :lektion");
       		
    	$result2->bindParam(':matrikelnummer', $user);
       	$result2->bindParam(':lektion', $res[0][lektion]);
       	$result2->bindParam(':html', $res[0][code_html]);
       	$result2->bindParam(':css', $res[0][code_css]);
       	$result2->execute();
	}
	catch (PDOException $e) {
       	echo '{"status" : -1,"statustext" : "Fehler bei der Datenbankabfrage2, wegen: '.$e->getMessage().'"}';
       	exit;
    }
        
    $count = $result2->rowCount();
        
    if($count > 0){
		$antwort = '{"status" : 0,"statustext" : "Lektion wurde zurückgesetzt!", "lektion" : '.json_encode($res).'}';
	}else{
		$antwort = '{"status" : -1,"statustext" : "Diese Lektion enthält bereits den Ausgangscode!"}';
	}
	
	disconnectDB($db);
	
	
	return $antwort;
}

function setSnapFinal($name, $punkte){
	$db = connectDB();
	
	try {
       		$result3 = $db->prepare("INSERT INTO lehre_snap (matrikelnummer, punkte) VALUES (:matrikelnummer, :punkte)");
       		$result3->bindParam(':matrikelnummer', $name);
       		$result3->bindParam(':punkte', $punkte);
       		$result3->execute();
	    }
	    catch (PDOException $e) {
        	echo '{"status" : -1,"statustext" : "Fehler bei der Datenbankabfrage3, wegen: '.$e->getMessage().'"}';
        	exit;
        }
        
        $count = $result3->rowCount();
        
        if($count > 0){
			$antwort = 0; //'{"status" : 0,"statustext" : "Insert erfolgreich!"}';
		}else{
			$antwort = -1; //'{"status" : -1,"statustext" : "Eintragen nicht erfolgreich!"}';
		}
	
	disconnectDB($db);
	
	
	return $antwort;
}

function setSnapFrage($name, $frage, $antwort, $richtig){
	$db = connectDB();
	
	try {
       		$result4 = $db->prepare("INSERT INTO lehre_snap_fragen (matrikelnummer, frage, antwort, richtig) VALUES (:matrikelnummer, :frage, :antwort, :richtig)");
       		$result4->bindParam(':matrikelnummer', $name);
       		$result4->bindParam(':frage', $frage);
       		$result4->bindParam(':antwort', $antwort);
       		$result4->bindParam(':richtig', $richtig);
       		$result4->execute();
	    }
	    catch (PDOException $e) {
        	echo '{"status" : -1,"statustext" : "Fehler bei der Datenbankabfrage4, wegen: '.$e->getMessage().'"}';
        	exit;
        }
        
        $count = $result4->rowCount();
        
        if($count > 0){
			$antwort = 0; //'{"status" : 0,"statustext" : "Insert erfolgreich!"}';
		}else{
			$antwort = -1; //'{"status" : -1,"statustext" : "Eintragen nicht erfolgreich!"}';
		}
	
	disconnectDB($db);
	
	
	return $antwort;
}


function getSnapOverview(){
	$db = connectDB();
	
	try {
       		$result5 = $db->prepare("SELECT * FROM lehre_snap ORDER BY punkte DESC");
       		$result5->execute();
	    }
	    catch (PDOException $e) {
        	echo '{"status" : -1,"statustext" : "Fehler bei der Datenbankabfrage5, wegen: '.$e->getMessage().'"}';
        	exit;
        }
        
        $count = $result5->rowCount();
        $res = $result5->fetchAll(PDO::FETCH_ASSOC);
        
        if($count > 0){
			$antwort = '{"status" : 0,"statustext" : "Get Snap Overview!", "snap" : '.json_encode($res).'}';
		}else{
			$antwort = '{"status" : -1,"statustext" : "Keine Daten vorhanden!"}';
		}
	
	disconnectDB($db);
	
	
	return $antwort;
}

function setSnapMatrikelnummern(){
	$db = connectDB();
	
	try {
       		$result5 = $db->prepare("SELECT matrikelnummer FROM lehre_snap ORDER BY matrikelnummer ASC");
       		$result5->execute();
	    }
	    catch (PDOException $e) {
        	echo '{"status" : -1,"statustext" : "Fehler bei der Datenbankabfrage5, wegen: '.$e->getMessage().'"}';
        	exit;
        }
        
        $count = $result5->rowCount();
        $res = $result5->fetchAll(PDO::FETCH_ASSOC);
        
        if($count > 0){
			$antwort = '{"status" : 0,"statustext" : "Get Snap Matrikelnummern!", "snap" : '.json_encode($res).'}';
		}else{
			$antwort = '{"status" : -1,"statustext" : "Keine Daten vorhanden!"}';
		}
	
	disconnectDB($db);
	
	
	return $antwort;
}

function getSnapFragen($matrikelnummer){
	$db = connectDB();
	
	try {
       		$result5 = $db->prepare("SELECT * FROM lehre_snap_fragen WHERE matrikelnummer LIKE :matrikelnummer");
       		$result5->bindParam(':matrikelnummer', $matrikelnummer);
       		$result5->execute();
	    }
	    catch (PDOException $e) {
        	echo '{"status" : -1,"statustext" : "Fehler bei der Datenbankabfrage5, wegen: '.$e->getMessage().'"}';
        	exit;
        }
        
        $count = $result5->rowCount();
        $res = $result5->fetchAll(PDO::FETCH_ASSOC);
        
        if($count > 0){
			$antwort = '{"status" : 0,"statustext" : "Get Snap Fragen!", "snap" : '.json_encode($res).'}';
		}else{
			$antwort = '{"status" : -1,"statustext" : "Keine Daten vorhanden!"}';
		}
	
	disconnectDB($db);
	
	
	return $antwort;
}