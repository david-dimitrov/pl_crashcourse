<?php

class DB
{
    private static $DB = null;
    private $dbh = null;
    
    private function __construct(){
        $this->dbh = new PDO('mysql:host=localhost;dbname=pl_crashcourse', "root", "");
    }
    
    public function getInstance(){
        if (is_null(self::$DB))
        {
            self::$DB = new DB();
        }
        return self::$DB;
    }
    
/*    private function __destruct(){
    }
/**/        
    
    /**
     * Nimmt Parameter entgegen, stellt Verbindung mit Datenbank her
     * und überprüft, ob gefragte Nutzer in der Datenbank enthalten sind
     *
     * @param
     *            der angegebene Nutzername
     * @param
     *            das angegebene Passwort in Plaintext
     * @return NULL|boolean[]|string[]
     */
    function checkLogin($username, $password)
    {
        
        // erster Test der Nutzernamen
        if (! isset($username)) { // leerer Name
            return array(
                "boolLogin" => false,
                "returnMsg" => "Sie sind nicht eingeloggt.",
                "loginMsgStyle" => ""
            );
        } else { // XSS Gefahr
            $filteredUsername = strip_tags($username);
            if ($username != $filteredUsername) {
                return array(
                    "boolLogin" => false,
                    "returnMsg" => "Ihr Nutzername beinhaltet unerlaubte Syntax. Bitte verwenden sie einen anderen.",
                    "loginMsgStyle" => "class='loginMsgUserDoesntExist'"
                );
            }
        }
        
        // Aufbau der Datenbankverbindung
        // Abfrage ob Nutzer existiert
        $query = $this->dbh->prepare("SELECT uid,name,password FROM `user` WHERE name = ?");
        $query->execute(array(
            $username
        ));
        $userCount = $query->rowCount();
        $query = $query->fetch();
        
        // Passwort Prüfung
        if ($userCount == 1) {
            if ($query["name"] == $username && $query["password"] == $password) {
                return array(
                    "boolLogin" => true,
                    "returnMsg" => "Login erfolgreich",
                    "loginMsgStyle" => "class='loginMsgSuccess'"
                );
            } else {
                return array(
                    "boolLogin" => false,
                    "returnMsg" => "Nutzername existiert, aber das Passwort ist falsch.",
                    "loginMsgStyle" => "class='loginMsgPwFail'"
                );
            }
        } elseif ($userCount == 0) {
            return array(
                "boolLogin" => false,
                "returnMsg" => "Es exisiert kein solcher Nutzer",
                "loginMsgStyle" => "class='loginMsgUserDoesntExist'"
            );
        } else {
            return array(
                "boolLogin" => false,
                "returnMsg" => "Es existieren mehrere Nutzer mit diesem Namen.
                                                    <br>Das hätte nicht passieren dürfen!
                                                    <br>Bitte melden sie sich bei einem Admin oder dem Support.",
                "loginMsgStyle" => "class='loginMsgUserOverlap'"
            );
        }
    }

    /**
     * Legt neuen Nutzer an, falls alle entgegengenommenen Daten zulässig sind und der Nutzer noch nicht vergeben ist.
     *
     * @param
     *            Nutzername
     * @param
     *            Passwort
     * @return boolean[]|string[]
     */
    function register($username, $password)
    {
        // Aufbau der Datenbankverbindung
        $filteredUsername = strip_tags($username);
        
        if (! isset($username)) {
            return array(
                "boolLogin" => false,
                "returnMsg" => "Ihr Username muss eindeutig sein!",
                "loginMsgStyle" => ""
            );
        } elseif ($username != $filteredUsername) {
            return array(
                "boolLogin" => false,
                "returnMsg" => "Ihr Nutzername beinhaltet unerlaubte Syntax. Bitte verwenden sie einen anderen.",
                "loginMsgStyle" => "class='loginMsgUserDoesntExist'"
            );
        } elseif ($password == "d41d8cd98f00b204e9800998ecf8427e") {
            return array(
                "boolLogin" => false,
                "returnMsg" => "Ein leeres Passwort ist nicht sicher. Bitte wählen Sie ein anderes.",
                "loginMsgStyle" => ""
            );
        }
        
        // Abfrage ob Nutzer existiert
        $query = $this->dbh->prepare("SELECT uid FROM `user` WHERE name = ?");
        $query->execute(array(
            $username
        ));
        $userCount = $query->rowCount();
        $query = $query->fetch();
        
        // returns und neuen Eintrag setzen
        if ($userCount != 0) {
            // Nutzer bereits vorhanden
            $status = array(
                "boolLogin" => false,
                "returnMsg" => "Dieser Nutzername ist bereits vergeben.",
                "loginMsgStyle" => ""
            );
        } else {
            // Neuer Nutzer wird angelegt
            $query = $dbh->prepare("INSERT INTO `user`(`name`, `password`) VALUES (:name,:password)");
            $query->execute(array(
                "name" => $username,
                "password" => $password
            ));
            // return setzen
            $status = array(
                "boolLogin" => true,
                "returnMsg" => "Ihr Nutzerkonto wurde erfolgreich angelegt.",
                "loginMsgStyle" => ""
            );
        }
        
        // Ende der DB verbindung
        return $status;
    }

    /**
     * Stellt Verbindung mit Datenbank her und tut die Date, die für die Haupseite von Nöten sind fetchen.
     *
     * @return PDOStatement Liste der mögliche indizes für ein Item aus dem PDO:
     *         ?mid
     *         ?year
     *         ?title
     *         ?genre
     *         ?regisseur -> firstname; name
     *         ?actors -> [] -> firstname; name
     */
    function getContents()
    {
        // Liste aller Filme erfassen
        $find = $this->dbh->query("SELECT * FROM movie WHERE 1");
        
        // Schauspieler und Regisseure zuordnen
        $found = array();
        $findRegisseur = $this->dbh->prepare("SELECT people.firstname,people.name FROM `rel_movie_director`,`people` WHERE rel_movie_director.pid = people.pid AND rel_movie_director.mid = ?");
        $findActors = $this->dbh->prepare("SELECT people.firstname,people.name FROM `rel_movie_actor`,`people` WHERE rel_movie_actor.pid = people.pid AND rel_movie_actor.mid = ? ");
        foreach ($find as $set) {
            // raussuchen der mitwirkenden Personen für jeden Film
            $findRegisseur->execute(array(
                $set[0]
            ));
            $regisseur = $findRegisseur->fetch();
            $findActors->execute(array(
                $set[0]
            ));
            $actors = $findActors->fetchAll();
            // //hinzufügen der Mitwirkenden Personen in das Set für den Film
            $set["regisseur"] = $regisseur;
            $set["actors"] = $actors;
            
            $found[] = $set;
        }
        return $found;
    }

    /**
     * jada jada jada, Daten die für einen Film mitels Ajax nachgeladen werden
     *
     * @param
     *            Film-Id, wie in der angesteuerten Zeile verwiesen $mid
     * @param
     *            Derzeitiger Username aus der Session $username
     * @param
     *            Derzeitiges Passwort aus der Session $password
     * @return Liste der Daten - beinhaltet:
     *         "mid","title","genre","year",
     *         "regisseur"["firstname","name"],"actors"[auflistung der Schauspieler["firstname","name"]],
     *         "commentsUser"["text","name"],"commentNonuser["text","name"]
     */
    function getFilmDetailContents($mid)
    {        
        // Film Daten erheben
        $find = $this->dbh->prepare("SELECT * FROM movie WHERE mid = ?");
        $findRegisseur = $this->dbh->prepare("SELECT people.firstname,people.name FROM `rel_movie_director`,`people` WHERE rel_movie_director.pid = people.pid AND rel_movie_director.mid = ?");
        $findActors = $this->dbh->prepare("SELECT people.firstname,people.name FROM `rel_movie_actor`,`people` WHERE rel_movie_actor.pid = people.pid AND rel_movie_actor.mid = ? ");
        // suchen
        $midArr = array(
            $mid
        );
        $find->execute($midArr);
        $findRegisseur->execute($midArr);
        $findActors->execute($midArr);
        // verarbeiten
        $find = $find->fetch();
        $findRegisseur = $findRegisseur->fetch();
        $findActors = $findActors->fetchAll();
        
        $find["regisseur"] = $findRegisseur;
        $find["actors"] = $findActors;
        
        return $find;
    }

    function getFilmComments($mid, $username, $password)
    {
        // unangemeldeten Nutzern wird "" zugewiesen, damit für sie keine CommentsUser angezeigt werden
        $logedin = $this->checkLogin($username, $password)["boolLogin"];
        $find["logedin"] = $logedin;
        if (! $logedin) {
            $username = "";
        }
        
        // Kommentar Daten erheben
        $findCommentsUser = $this->dbh->prepare("SELECT `comment`.`cid`,`comment`.`text` FROM `comment`,`user` WHERE `mid` = ? AND `user`.`name` = ? AND `comment`.`uid` = `user`.`uid`");
        $findCommentsNonuser = $this->dbh->prepare("SELECT `comment`.`text`,`user`.`name` FROM `comment`,`user` WHERE `mid` = ? AND `user`.`name` != ? AND `comment`.`uid` = `user`.`uid`");
        // suchen
        $findCommentsUser->execute(array(
            $mid,
            $username
        ));
        $findCommentsNonuser->execute(array(
            $mid,
            $username
        ));
        // verarbeiten
        $findCommentsUser = $findCommentsUser->fetchAll();
        $findCommentsNonuser = $findCommentsNonuser->fetchAll();
        
        $find["commentsUser"] = $findCommentsUser;
        $find["commentsNonuser"] = $findCommentsNonuser;
        
        return $find;
    }

    /**
     * Übernimmt die Prüfung und die Speicherung von neuen, geänderten oder gelöschten Kommentaren.
     *
     * @param unknown $username            
     * @param unknown $password            
     * @param unknown $plaintext            
     * @param unknown $mid            
     * @param unknown $cid            
     * @param unknown $del            
     * @return number
     */
    function editComment($username, $password, $plaintext, $mid, $cid, $del)
    {
        $logedin = $this->checkLogin($username, $password);
        if ($logedin["boolLogin"]) {
            if ($cid == "none") {
                // neuer Kommentar
                // Daten erheben 'uid'
                $find = $this->dbh->prepare("SELECT uid FROM `user` WHERE name = ?");
                $find->execute(array(
                    $username
                ));
                $uid = $find->fetch()["uid"];
                
                // mid, uid, text
                $find = $this->dbh->prepare("INSERT INTO `comment`(`cid`, `mid`, `uid`, `text`) VALUES ('',?,?,?)");
                $plaintext = strip_tags($plaintext); // gegen xss
                $find->execute(array(
                    $mid,
                    $uid,
                    $plaintext
                ));
                
                return 0;
            } else {
                // edit || delete
                // überprüfe die Rechte
                $find = $this->dbh->prepare("SELECT COUNT(*) FROM `comment`,`user` WHERE `comment`.`cid`=? AND `comment`.`uid`= `user`.`uid` AND `user`.`name` = ?");
                $find->execute(array(
                    $cid,
                    $username
                ));
                $hasRight = $find->fetch()[0];
                
                if (! $hasRight) {
                    return 3;
                }
                
                $plaintext = strip_tags($plaintext); // gegen xss
                                                     // löschen oder bearbeiten
                if (! ($del == "true")) {
                    // bearbeiten
                    $find = $this->dbh->prepare("UPDATE `comment` SET `text`= ? WHERE `comment`.`cid` = ?");
                    $find->execute(array(
                        $plaintext,
                        $cid
                    ));
                    return 1;
                } else {
                    // löschen
                    $find = $this->dbh->prepare("DELETE FROM `comment` WHERE `comment`.`cid` = ?");
                    $find->execute(array(
                        $cid
                    ));
                    return 4;
                }
            }
        } else {
            return 2;
        }
    }
}
?>