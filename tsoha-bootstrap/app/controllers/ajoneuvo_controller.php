<?php

class AjoneuvoController extends BaseController {

	public static function index(){
		$ajoneuvot = Ajoneuvo::all();

		View::make('ajoneuvo/index.html', array('ajoneuvot' => $ajoneuvot));
	}	

 	public static function tallenna(){
    	// POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
    	$params = $_POST;

    	$attributes = array(
        	'merkki' => $params['merkki'],
        	'malli' => $params['malli'],
            'rekisterinumero' => $params['rekisterinumero'],
        	'km_kokonais' => $params['km_kokonais'],
        	'lisatiedot' => $params['lisatiedot']
    	);
        $ajoneuvo = new Ajoneuvo($attributes);
        $errors = $ajoneuvo->errors();

        if(count($errors) < 1 ){
            $ajoneuvo->save();
            $ajoneuvot = Ajoneuvo::all();
            View::make('ajoneuvo/index.html', array('message' => 'Ajoneuvo on lisätty tietokantaan.', 'ajoneuvot' => $ajoneuvot));
        } else {
        	$ajoneuvot = Ajoneuvo::all();
            View::make('ajoneuvo/index.html', array('ajoneuvot' => $ajoneuvot, 'errors' => $errors, 'attributes' => $attributes));
        }
    }	

    public static function muokkaa($id) {
        $ajoneuvo = Ajoneuvo::find($id);
        
        View::make('ajoneuvo/muokkaa.html', array('ajoneuvo' => $ajoneuvo));
    }

    public static function paivita($id) {
        $params = $_POST;
        $vanha = Ajoneuvo::find($id);

        $attributes = array(
            'id' => $id,
            'merkki' => $params['merkki'],
            'malli' => $params['malli'],
            'rekisterinumero' => $params['rekisterinumero'],
            'km_kokonais' => $params['km_kokonais'],
            'lisatiedot' => $params['lisatiedot']
        );

        $ajoneuvo = new Ajoneuvo($attributes);
        //$errors = $ajoneuvo->errors();       
        $errors = null;

        if(count($errors) < 1){            
            $ajoneuvo->paivita();
            Redirect::to('/ajoneuvot', array('message' => 'Ajoneuvoa muokattu onnistuneesti!'));
        } else {
            View::make('ajoneuvo/muokkaa.html', array('errors' => $errors, 'ajoneuvo' => $ajoneuvo));
        }


    }    

    public static function poista($id) {
        $ajoneuvo = new Ajoneuvo(array('id' => $id));
        $ajoneuvo->poista();

        Redirect::to('/ajoneuvot', array('message' => 'Ajoneuvo poistettu onnistuneesti!'));
    }    

}