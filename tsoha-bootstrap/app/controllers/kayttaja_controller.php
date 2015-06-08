<?php

class KayttajaController extends BaseController{

	public static function index(){
		// kaikki
		$kayttajat = Kayttaja::all();

		// views/kayttaja index.html $kayttajat listaus
		View::make('kayttaja/index.html', array('kayttajat' => $kayttajat));
	}	

    public static function login() {
        View::make('kayttaja/login.html');
    }

    public static function logout(){
      $_SESSION['username'] = null;
      Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }
    
    public static function kasittele_login() {
        $params = $_POST;

        $kayttaja = Kayttaja::tunnista($params['username'], $params['password']);

        if (!$kayttaja){
            View::make('user/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'username' => $params['username']));
        } else {
            $_SESSION['username'] = $kayttaja->username;
            Redirect::to('/kuluvakk', array('message' => 'Tervetuloa takaisin ' . $kayttaja->name . '!'));
        }
    }

	public static function rekisteroidy(){
		View::make('kayttaja/rekisteroidy.html');
	}


 	public static function tallenna(){
    	// POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
    	$params = $_POST;
    	
    	$attributes = array(
      		'username' => $params['username'],
      		'password' => $params['password'],
            'pwd_again' => $params['pwd_again'],
      		'name' => $params['name'],
    		'email' => $params['email']
    	);
        $kayttaja = new Kayttaja($attributes);
        $errors = $kayttaja->errors();

        if(count($errors) < 1){
            $kayttaja->save();
            View::make('kayttaja/login.html', array('message' => 'Käyttäjä on lisätty tietokantaan.'));
        } else {
            View::make('kayttaja/rekisteroidy.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    	
 	
    }


    public static function nayta($username){
    	$kayttaja = Kayttaja::find($username);
    	View::make('kayttaja/nayta.html', array('kayttaja' => $kayttaja));
    }

    public static function muokkaa($username) {
        $kayttaja = Kayttaja::find($username);
        View::make('kayttaja/muokkaa.html', array('kayttaja' => $kayttaja));
    }

    public static function paivita($username) {
        $params = $_POST;
        $vanha = Kayttaja::find($username);

        $attributes  = array(
            'username' => $params['username'],
            'password'=> $params['password'],
            'pwd_again' => $params['pwd_again'],
            'name' => $params['name'],
            'email' => $params['email']
        );

        $kayttaja = new Kayttaja($attributes);
        $errors = $kayttaja->errors();
        Kint::dump($kayttaja);

        if($vanha->password != $params['pwd_old']) {
            $errors[] = 'Tarkasta vanha salasanasi!';
        }        

        if(count($errors) < 1){            
            $kayttaja->paivita();
            Redirect::to('/kayttaja/' . $kayttaja->username, array('message' => 'Käyttäjätietoja muokattu onnistuneesti!'));
        } else {
            View::make('kayttaja/muokkaa.html', array('errors' => $errors, 'kayttaja' => $kayttaja));
        }


    }

    public static function poista($username) {
        $kayttaja = new Kayttaja(array('username' => $username));
        $kayttaja->poista();

        Redirect::to('/', array('message' => 'Käyttäjä poistettu onnistuneesti!'));
    }

}