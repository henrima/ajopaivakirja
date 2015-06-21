<?php

class Ajoneuvo extends BaseModel{
	public $id, $rekisterinumero, $merkki, $malli, $km_kokonais, $lisatiedot;

	public function __construct($attributes){
    	parent::__construct($attributes);
    	$this->validators = array('validate_duplicate_rekisterinumero');    	
  	}

  	public static function all(){
    	$query = DB::connection()->prepare('SELECT * FROM Ajoneuvo');
    	$query->execute();
    	$rows = $query->fetchAll();

    	$ajoneuvot = array();

    	// Käydään kyselyn tuottamat rivit läpi
    	foreach($rows as $row){
      		// Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
      		$ajoneuvot[] = new Ajoneuvo(array(
        		'id' => $row['id'],
        		'rekisterinumero' => $row['rekisterinumero'],
        		'merkki' => $row['merkki'],
        		'malli' => $row['malli'],
        		'km_kokonais' => $row['km_kokonais'],
        		'lisatiedot' => $row['lisatiedot']
      		));
    	}

    	return $ajoneuvot;
  	}

    public static function find($id){
      $query = DB::connection()->prepare('SELECT * FROM Ajoneuvo WHERE id = :id LIMIT 1');
      $query->execute(array('id' => $id));
      $row = $query->fetch();

      if($row){
        $ajoneuvo = new Ajoneuvo(array(
          'id' => $row['id'],
          'merkki' => $row['merkki'],
          'malli' => $row['malli'],
          'rekisterinumero' => $row['rekisterinumero'],
          'km_kokonais' => $row['km_kokonais'],
          'lisatiedot' => $row['lisatiedot']
        ));

        return $ajoneuvo;
      }

      return null;
    } 

    public function poista(){
      $id = $this->id;
      $query = DB::connection()->prepare('DELETE FROM Ajoneuvo WHERE id = :id');
      $query->execute(array('id' => $id));
      // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
      $row = $query->fetch();
  
      // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
      //$this->id = $row['id'];
    } 

    public function save(){
      // Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
      $query = DB::connection()->prepare('INSERT INTO Ajoneuvo (merkki, malli, rekisterinumero, km_kokonais, lisatiedot) VALUES (:merkki::text, :malli::text, :rekisterinumero::text, :km_kokonais::integer, :lisatiedot::text) RETURNING id');
      // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
      $query->execute(array('merkki' => $this->merkki, 'malli' => $this->malli, 'rekisterinumero' => $this->rekisterinumero, 'km_kokonais' => $this->km_kokonais, 'lisatiedot' => $this->lisatiedot));
      // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
      $row = $query->fetch();
  
      // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
      $this->id = $row['id'];
    }     

    public function paivita(){
      $query = DB::connection()->prepare('UPDATE Ajoneuvo SET id = :id, merkki = :merkki::text, malli = :malli::text, rekisterinumero = :rekisterinumero::text, km_kokonais = :km_kokonais::integer, lisatiedot = :lisatiedot::text WHERE id = :id');
      // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
      $query->execute(array('id' => $this->id, 'merkki' => $this->merkki, 'malli' => $this->malli, 'rekisterinumero' => $this->rekisterinumero, 'km_kokonais' => $this->km_kokonais, 'lisatiedot' => $this->lisatiedot));
      // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
      $row = $query->fetch();
  
      // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
      //$this->username = $row['username'];
    }


}