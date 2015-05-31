<?php

class KayttajaController extends BaseController{

	public static function index(){
		// kaikki
		$kayttajat = Kayttaja::all();

		// views/kayttaja index.html $kayttajat listaus
		View::make('kayttaja/index.html', array('kayttajat' => $kayttajat));
	}	

    public static function login() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('kayttaja/login.html');
    }

	public static function rekisteroidy(){
		View::make('kayttaja/rekisteroidy.html');
	}


 	public static function tallenna(){
    	// POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
    	$params = $_POST;
    	// Alustetaan uusi Kayttaja-luokan olio käyttäjän syöttämillä arvoilla
    	

    	$kayttaja = new Kayttaja(array(
      		'username' => $params['username'],
      		'password' => $params['password'],
      		'name' => $params['name'],
    		'email' => $params['email']
    	));

    	$kayttaja->save();

    	Redirect::to('/', array('message' => 'Käyttäjä on lisätty tietokantaan.'));
    }


    public static function nayta($username){
    	$kayttaja = Kayttaja::find($username);
    	View::make('kayttaja/nayta.html', array('kayttaja' => $kayttaja));
    }

}