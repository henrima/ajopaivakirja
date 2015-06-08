<?php

  class BaseController{

    public static function get_user_logged_in(){
      if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $kayttaja = Kayttaja::find($username);
        return $kayttaja;
      }
      return null;
    }

    public static function check_logged_in(){
      $errors = array();
      $errors[] = 'Tämä toiminto vaatii kirjautumisen.';
      if(!isset($_SESSION['username'])){
        Redirect::to('/login', array('errors' => $errors));
      }

    }

  }
