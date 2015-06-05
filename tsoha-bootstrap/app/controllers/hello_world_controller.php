<?php

class HelloWorldController extends BaseController {

    public static function kuluvakk() {
        echo View::make('kuluvakk.html');
    }

    public static function raportit() {
        echo View::make('raportit.html');
    }

    public static function ajoneuvot() {
        echo View::make('ajoneuvot.html');
    }

  public static function sandbox(){
    $jortma = new Kayttaja(array(
        'username' => 'jortma2',
        'password' => 'kekegugu',
        'name' => '',
        'email' => 'jortma@gugu.com' 
    ));
    $errors = $jortma->errors();

    Kint::dump($errors);
  }

}
