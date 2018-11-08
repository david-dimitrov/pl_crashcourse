<?php
$user = "root";
$pass = "";

$dbh = new PDO('mysql:host=localhost;dbname=pl_crashcourse', $user, $pass);

$found = $dbh->query("SELECT title FROM movie WHERE year < 1999");

echo "<a href='reset.php'>Datensätze entfernen</a><br>Filme, die vor 1999 erschienen:<br><br>";
foreach ($found as $row)
{
    echo $row["title"]."<br>";
}

$found = $dbh->prepare("SELECT movie.genre FROM movie,people,rel_movie_actor WHERE rel_movie_actor.mid = movie.mid AND rel_movie_actor.pid = people.pid AND people.firstname = ? AND people.name = ? GROUP BY genre ");
$found->execute(array("Brad","Pitt"));
echo "<br><br>Genres in denen Brad Pitt spielte:<br><br>";
while ($row = $found->fetch())
{
    echo $row["genre"]."<br>";
}

$found = $dbh->query("SELECT COUNT(people.pid) FROM rel_movie_actor,rel_movie_director,people WHERE people.pid = rel_movie_director.pid AND rel_movie_director.mid = rel_movie_actor.mid AND rel_movie_actor.pid = 7");

echo "<br><br>Anzahl der Regisseure unter denen Brad Pitt arbeitete:<br><br>".$found->fetch()[0]."<br><br>";

$found = $dbh->query("SELECT MAX(uid) FROM `user`");

$insertID = $found->fetch()[0] + 1;
$insertName = "PatrickN";
$insertPW = "123";
$insertPW = md5($insertPW);

$found = $dbh->prepare("INSERT INTO `user`(`uid`, `name`, `password`) VALUES (?,?,?)");
$found->execute(array($insertID,$insertName,$insertPW));
$newUser = $dbh->lastInsertId();
echo $newUser."<br><br>";

$found = $dbh->prepare("SELECT * FROM movie");
$found->execute() or die("SQL Error in: ".$found->queryString." - ".$found->errorInfo()[2]);

while ($row = $found->fetch()){
    echo $row["title"]."<br>";
}

$dbh = null;
?>