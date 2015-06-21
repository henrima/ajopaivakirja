<?php

class AjotapahtumaController extends BaseController {

    public static function kuluvakk() {
		$ajotapahtumat = Ajotapahtuma::kuluvakk();
        $ajoneuvot = Ajoneuvo::all();
		View::make('ajotapahtuma/kuluvakk.html', array('ajotapahtumat' => $ajotapahtumat, 'ajoneuvot' => $ajoneuvot));
    }


 	public static function tallenna(){
    	// POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
    	$params = $_POST;

    	$attributes = array(
        	'pvm' => $params['pvm'],
        	'reitti' => $params['reitti'],
            'km_lopussa' => $params['km_lopussa'],
        	'fk_reknro' => $params['fk_reknro'],
        	'tarkoitus' => $params['tarkoitus'],
        	'lisatiedot' => $params['lisatiedot']
    	);
        $ajotapahtuma = new Ajotapahtuma($attributes);
        $errors = $ajotapahtuma->errors();

        if(count($errors) < 1){
            $ajotapahtuma->save();
            $ajotapahtumat = Ajotapahtuma::kuluvakk();
            View::make('ajotapahtuma/kuluvakk.html', array('message' => 'Ajotapahtuma on lisätty tietokantaan.', 'ajotapahtumat' => $ajotapahtumat));
        } else {
            View::make('ajotapahtuma/kuluvakk.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function muokkaa($id) {
        $ajotapahtuma = Ajotapahtuma::find($id);
        
        View::make('ajotapahtuma/muokkaa.html', array('ajotapahtuma' => $ajotapahtuma));
    }

    public static function paivita($id) {
        $params = $_POST;
        $vanha = Ajotapahtuma::find($id);

        $attributes  = array(
            'id' => $id,
            'pvm' => $params['pvm'],
            'reitti' => $params['reitti'],
            'km_lopussa' => $params['km_lopussa'],
            'fk_reknro' => $params['fk_reknro'],
            'tarkoitus' => $params['tarkoitus'],
            'lisatiedot' => $params['lisatiedot']
        );

        $ajotapahtuma = new Ajotapahtuma($attributes);
        $errors = $ajotapahtuma->errors();       

        if(count($errors) < 1){            
            $ajotapahtuma->paivita();
            Redirect::to('/kuluvakk', array('message' => 'Ajotapahtumaa muokattu onnistuneesti!'));
        } else {
            View::make('ajotapahtuma/muokkaa.html', array('errors' => $errors, 'ajotapahtuma' => $ajotapahtuma));
        }


    }

    public static function poista($id) {
        $ajotapahtuma = new Ajotapahtuma(array('id' => $id));
        $ajotapahtuma->poista();

        Redirect::to('/kuluvakk', array('message' => 'Ajotapahtuma poistettu onnistuneesti!'));
    }
 	   

}