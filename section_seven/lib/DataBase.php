<?php
class DB{
    /**
     * Nimmt Parameter entgegen, stellt Verbindung mit Datenbank her
     * und überprüft, ob gefragte Nutzer in der Datenbank enthalten sind
     * 
     * @param String $username | der angegebene Nutzername
     * @param String $password | das angegebene Passwort in Plaintext
     * @return NULL|boolean[]|string[]
     */
    function checkLogin($username, $password)
    {
        $password = md5($password);
        //Aufbau der Datenbankverbindung
        $dbh = new PDO('mysql:host=localhost;dbname=pl_crashcourse', "root", "");
        
        if (!isset($username))
        {
            $status = array("boolLogin"     => false,
                            "returnMsg"     => "Sie sind nicht eingeloggt.",
                            "loginMsgStyle" => "");
        }
        
        //Abfrage ob Nutzer existiert
        $querry = $dbh->prepare("SELECT uid,name,password FROM `user` WHERE name = ?");
        $querry->execute(array($username));
        $userCount = $querry->rowCount();
        $querry = $querry->fetch();
        //Ende der DB verbindung
        $dbh = null;
        
        //Passwort Prüfung
        $return = null;
        if ($userCount == 1)
        {
            if ($querry["name"] == $username && $querry["password"] == $password)
            {
                $return = array("boolLogin"     => true,
                                "returnMsg"     => "Login erfolgreich",
                                "loginMsgStyle" => "class='loginMsgSuccess'");
            }
            else
            {
                $return = array("boolLogin"     => false,
                                "returnMsg"     => "Nutzername existiert, aber das Passwort ist falsch.",
                                "loginMsgStyle" => "class='loginMsgPwFail'");
            }
        }
        elseif ($userCount == 0)
        {
                $return = array("boolLogin"     => false,
                                "returnMsg"     => "Es exisiert kein solcher Nutzer",
                                "loginMsgStyle" => "class='loginMsgUserDoesntExist'");
        }
        else 
        {
                $return = array("boolLogin"     => false,
                                "returnMsg"     =>  "Es existieren mehrere Nutzer mit diesem Namen.
                                                    <br>Das hätte nicht passieren dürfen!
                                                    <br>Bitte melden sie sich bei einem Admin oder dem Support.",
                                "loginMsgStyle" => "class='loginMsgUserOverlap'");
        }
        return  $return;
    }
    
    function register($username, $password)
    {
        $password = md5($password);
        //Aufbau der Datenbankverbindung
        $dbh = new PDO('mysql:host=localhost;dbname=pl_crashcourse', "root", "");
        
        if (!isset($username))
        {
            $status = array("boolLogin"     => false,
                "returnMsg"     => "Ihr Username muss eindeutig sein!",
                "loginMsgStyle" => "");
        }
        
        //Abfrage ob Nutzer existiert
        $querry = $dbh->prepare("SELECT uid,name,password FROM `user` WHERE name = ?");
        $querry->execute(array($username));
        $userCount = $querry->rowCount();
        $querry = $querry->fetch();

        //
        
        //Ende der DB verbindung
        $dbh = null;
        return $status;
    }
    
    /**
     * Stellt Verbindung mit Datenbank her und tut die Date, die für die Haupseite von Nöten sind fetchen.
     * @return PDOStatement Liste der mögliche indizes für ein Item aus dem PDO:
     *      ?mid
     *      ?year
     *      ?title
     *      ?genre
     *      ?regisseur  -> firstname; name
     *      ?actors     -> [] -> firstname; name
     */
    function getContents()
    {
        //Liste aller Filme erfassen
        $dbh = new PDO('mysql:host=localhost;dbname=pl_crashcourse','root','');
        $find = $dbh->query("SELECT * FROM movie WHERE 1");
        
        //Schauspieler und Regisseure zuordnen
        $found = array();
        $findRegisseur  = $dbh->prepare("SELECT people.firstname,people.name FROM `rel_movie_director`,`people` WHERE rel_movie_director.pid = people.pid AND rel_movie_director.mid = ?");
        $findActors     = $dbh->prepare("SELECT people.firstname,people.name FROM `rel_movie_actor`,`people` WHERE rel_movie_actor.pid = people.pid AND rel_movie_actor.mid = ? ");
        foreach ($find as $set)
        {
            //raussuchen der mitwirkenden Personen für jeden Film
            $findRegisseur->execute(array($set[0]));
            $regisseur = $findRegisseur->fetch();
            $findActors->execute(array($set[0]));
            $actors = $findActors->fetchAll();
            ////hinzufügen der Mitwirkenden Personen in das Set für den Film
            $set["regisseur"] = $regisseur;
            $set["actors"] = $actors;
            
            $found[] = $set;
        }        
        $dbh = null;
        return $found;
    }
    
    /**
     * jada jada jada, Daten die für einen Film mitels Ajax nachgeladen werden 
     * @param Film-Id, wie in der angesteuerten Zeile verwiesen $mid
     * @param Derzeitiger Username aus der Session $username
     * @param Derzeitiges Passwort aus der Session $password
     * @return Liste der Daten - beinhaltet:
     *      "mid","title","genre","year",
     *      "regisseur"["firstname","name"],"actors"[auflistung der Schauspieler["firstname","name"]],
     *      "commentsUser"["text","name"],"commentNonuser["text","name"]
     */
    function getFilmDetailContents($mid, $username, $password)
    {
        $dbh = new PDO('mysql:host=localhost;dbname=pl_crashcourse','root','');

        //Film Daten erheben
        $find           = $dbh->prepare("SELECT * FROM movie WHERE mid = ?");
        $findRegisseur  = $dbh->prepare("SELECT people.firstname,people.name FROM `rel_movie_director`,`people` WHERE rel_movie_director.pid = people.pid AND rel_movie_director.mid = ?");
        $findActors     = $dbh->prepare("SELECT people.firstname,people.name FROM `rel_movie_actor`,`people` WHERE rel_movie_actor.pid = people.pid AND rel_movie_actor.mid = ? ");
        //suchen
        $midArr = array($mid);
        $find           ->execute($midArr);
        $findRegisseur  ->execute($midArr);
        $findActors     ->execute($midArr);
        //verarbeiten
        $find           = $find->fetch();
        $findRegisseur  = $findRegisseur->fetch();
        $findActors     = $findActors->fetchAll();
        
        $find["regisseur"] = $findRegisseur;
        $find["actors"] = $findActors;
        
        //unangemeldeten Nutzern wird "" zugewiesen, damit für sie keine CommentsUser angezeigt werden
        $logedin = $this->checkLogin($username, $password)["boolLogin"];
        $find["logedin"] = $logedin;
        if (!$logedin){
            $username = "";
        }
        
        //Kommentar Daten erheben
        $findCommentsUser       = $dbh->prepare("SELECT `comment`.`cid`,`comment`.`text` FROM `comment`,`user` WHERE `mid` = ? AND `user`.`name` = ? AND `comment`.`uid` = `user`.`uid`");
        $findCommentsNonuser    = $dbh->prepare("SELECT `comment`.`text`,`user`.`name` FROM `comment`,`user` WHERE `mid` = ? AND `user`.`name` != ? AND `comment`.`uid` = `user`.`uid`");
        //suchen
        $findCommentsUser       ->execute(array($mid, $username));
        $findCommentsNonuser    ->execute(array($mid, $username));
        //verarbeiten
        $findCommentsUser       = $findCommentsUser->fetchAll();
        $findCommentsNonuser    = $findCommentsNonuser->fetchAll();
        
        $find["commentsUser"]   = $findCommentsUser;
        $find["commentsNonuser"]= $findCommentsNonuser;
        
        
        $dbh = null;
        return  $find;
    }
    
    /**
     * Übernimmt die Prüfung und die Speicherung von neuen, geänderten oder gelöschten Kommentaren.
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
        if ($logedin["boolLogin"])
        {
            $dbh = new PDO('mysql:host=localhost;dbname=pl_crashcourse','root','');
            if ($cid == "none")
            {
                //neuer Kommentar
                //Daten erheben 'uid'
                $find = $dbh->prepare("SELECT uid FROM `user` WHERE name = ?");
                $find->execute(array($username));
                $uid = $find->fetch()["uid"];
                
                //mid, uid, text
                $find = $dbh->prepare("INSERT INTO `comment`(`cid`, `mid`, `uid`, `text`) VALUES ('',?,?,?)");
                $find->execute(array($mid,$uid,$plaintext));
                
                $dbh = null;
                return 0;
            }
            else
            {
                //edit || delete
                //überprüfe die Rechte
                $find = $dbh->prepare("SELECT COUNT(*) FROM `comment`,`user` WHERE `comment`.`cid`=? AND `comment`.`uid`= `user`.`uid` AND `user`.`name` = ?");
                $find->execute(array($cid,$username));
                $hasRight = $find->fetch()[0];
                
                if(!$hasRight)
                {
                    return 3;
                }
                
                //löschen oder bearbeiten
                if (!($del == "true")){
                    //bearbeiten
                    $find = $dbh->prepare("UPDATE `comment` SET `text`= ? WHERE `comment`.`cid` = ?");
                    $find->execute(array($plaintext,$cid));
                    return 1;
                }
                else
                {
                    //löschen
                    $find = $dbh->prepare("DELETE FROM `comment` WHERE `comment`.`cid` = ?");
                    $find->execute(array($cid));
                    return 4;
                }
            }
        }
        else
        {
            return 2;
        }
    }
}