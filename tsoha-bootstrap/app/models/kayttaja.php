<?php


class Kayttaja extends BaseModel{
  public $username, $password, $name, $email, $pwd_again;


  public function __construct($attributes){
    parent::__construct($attributes);
    $this->validators = array('validate_username', 'validate_name', 'validate_password', 'validate_email');
  }


  public function save(){
    // Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
    $query = DB::connection()->prepare('INSERT INTO Kayttaja (username, password, name, email) VALUES (:username, :password, :name, :email) RETURNING username');
    // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
    $query->execute(array('username' => $this->username, 'password' => $this->password, 'name' => $this->name, 'email' => $this->email));
    // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
    $row = $query->fetch();
  
    // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
    $this->username = $row['username'];
  }

  public static function all(){
    // Alustetaan kysely tietokantayhteydellämme
    $query = DB::connection()->prepare('SELECT * FROM Kayttaja');
    // Suoritetaan kysely
    $query->execute();
    // Haetaan kyselyn tuottamat rivit
    $rows = $query->fetchAll();
    $kayttajat = array();

    // Käydään kyselyn tuottamat rivit läpi
    foreach($rows as $row){
      // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
      $kayttajat[] = new Kayttaja(array(
        'username' => $row['username'],
        'password' => $row['password'],
        'name' => $row['name'],
        'email' => $row['email']
      ));
    }

    return $kayttajat;
  }

  public static function find($username){
    $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE username = :username');
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



  public function paivita(){
      $query = DB::connection()->prepare('UPDATE Kayttaja SET username = :username::text, password = :password::text, name = :name::text, email = :email::text WHERE username = :username::text');
      // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
      $query->execute(array('username' => $this->username, 'password' => $this->password, 'name' => $this->name, 'email' => $this->email));
      // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
      $row = $query->fetch();
  
      // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
      //$this->username = $row['username'];
  }

  public function poista(){
    $username = $this->username;
    $query = DB::connection()->prepare('DELETE FROM Kayttaja WHERE USERNAME = :username');
    $query->execute(array('username' => $username));
    // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
    //$row = $query->fetch();
  
    // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
    //$this->username = $row['username'];
  }

  public function tunnista($username, $password){ 
    $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE username = :username AND password = :password LIMIT 1');
    $query->execute(array('username' => $username, 'password' => $password));
    $row = $query->fetch();
    if ($row){
      $kayttaja = Kayttaja::find($username);
      // Käyttäjä löytyi, palautetaan löytynyt käyttäjä oliona
      return $kayttaja;
    } else {
      // Käyttäjää ei löytynyt, palautetaan null
      return null;
    }
  }  

}
