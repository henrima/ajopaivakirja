<?php
class Kayttaja extends BaseModel{
  public $username, $password, $name, $email;

  public function __construct($attributes){
    parent::__construct($attributes);
  }

  public static function all(){
    // Alustetaan kysely tietokantayhteydellämme
    $query = DB::connection()->prepare('SELECT * FROM Kayttaja');
    // Suoritetaan kysely
    $query->execute();
    // Haetaan kyselyn tuottamat rivit
    $rows = $query->fetchAll();
    $games = array();

    // Käydään kyselyn tuottamat rivit läpi
    foreach($rows as $row){
      // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
      $games[] = new Kayttaja(array(
        'username' => $row['username'],
        'password' => $row['password'],
        'name' => $row['name'],
        'email' => $row['email']
      ));
    }

    return $games;
  }

  public static function find($username){
    $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE username = :username LIMIT 1');
    $query->execute(array('username' => $username));
    $row = $query->fetch();

    if($row){
      $kayttaja = new Kayttaja(array(
        'username' => $row['username'],
        'password' => $row['password'],
        'name' => $row['name'],
        'email' => $row['email']
      ));

      return $kayttaja;
    }

    return null;
  }
}
