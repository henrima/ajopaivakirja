<?php

class Ajotapahtuma extends BaseModel{
	public $id, $pvm, $reitti, $kilometrit, $fk_reknro, $tarkoitus, $lisatiedot;

  public function __construct($attributes){
    parent::__construct($attributes);
    $this->validators = array();
  }	


  public static function all(){
    // Alustetaan kysely tietokantayhteydellämme
    $query = DB::connection()->prepare('SELECT * FROM Ajotapahtuma');
    //$kilometrit = DB::connection()->prepare('SELECT kilometrit FROM Ajoneuvo WHERE Ajoneuvo.fk_id = Ajotapahtuma.id');

    // Suoritetaan kysely
    $query->execute();
    //$kilometrit->execute();

    // Haetaan kyselyn tuottamat rivit
    $rows = $query->fetchAll();
    //$km = $kilometrit->fetchAll();

    $ajotapahtumat = array();

    // Käydään kyselyn tuottamat rivit läpi
    foreach($rows as $row){
      // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
      $ajotapahtumat[] = new Ajotapahtuma(array(
        'id' => $row['id'],
        'pvm' => $row['pvm'],
        'reitti' => $row['reitti'],
        //'kilometrit' => $kilometrit,
        'fk_reknro' => $row['fk_reknro'],
        'tarkoitus' => $row['tarkoitus'],
        'lisatiedot' => $row['lisatiedot']
      ));
    }
    //Kint::dump($ajotapahtumat);
    return $ajotapahtumat;
  }

  public static function find($id){
    $query = DB::connection()->prepare('SELECT * FROM Ajotapahtuma WHERE id = :id LIMIT 1');
    $query->execute(array('id' => $id));
    $row = $query->fetch();

    if($row){
      $ajotapahtuma = new Ajotapahtuma(array(
        'id' => $row['id'],
        'pvm' => $row['pvm'],
        'reitti' => $row['reitti'],
        //'kilometrit' => $row['kilometrit'],
        'fk_reknro' => $row['fk_reknro'],
        'tarkoitus' => $row['tarkoitus'],
        'lisatiedot' => $row['lisatiedot']
      ));

      return $ajotapahtuma;
    }

    return null;
  } 

  public function save(){
    // Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
    $query = DB::connection()->prepare('INSERT INTO Ajotapahtuma (pvm, reitti, fk_reknro, tarkoitus, lisatiedot) VALUES (:pvm::date, :reitti::text, :fk_reknro::text, :tarkoitus::text, :lisatiedot::text) RETURNING id');
    // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
    $query->execute(array('pvm' => $this->pvm, 'reitti' => $this->reitti, 'fk_reknro' => $this->fk_reknro, 'tarkoitus' => $this->tarkoitus, 'lisatiedot' => $this->lisatiedot));
    // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
    $row = $query->fetch();
  
    // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
    $this->id = $row['id'];
  }  

  public function poista(){
    $id = $this->id;
    $query = DB::connection()->prepare('DELETE FROM Ajotapahtuma WHERE id = :id');
    $query->execute(array('id' => $id));
    // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
    $row = $query->fetch();
  
    // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
    //$this->id = $row['id'];
  }  

  public function paivita(){
      $query = DB::connection()->prepare('UPDATE Ajotapahtuma SET id = :id, pvm = :pvm::date, reitti = :reitti::text, fk_reknro = :fk_reknro::text, tarkoitus = :tarkoitus::text, lisatiedot = :lisatiedot::text WHERE id = :id');
      // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
      $query->execute(array('id' => $this->id, 'pvm' => $this->pvm, 'reitti' => $this->reitti, 'fk_reknro' => $this->fk_reknro, 'tarkoitus' => $this->tarkoitus, 'lisatiedot' => $this->lisatiedot));
      // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
      $row = $query->fetch();
  
      // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
      //$this->username = $row['username'];
  }

}
