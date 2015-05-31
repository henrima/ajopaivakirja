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

    public static function sandbox() {
      $pete = Kayttaja::find('hcmalkki');
      $jores = Kayttaja::all();
      // Kint-luokan dump-metodi tulostaa muuttujan arvon
      Kint::dump($pete);
      Kint::dump($jores);
    }

}
