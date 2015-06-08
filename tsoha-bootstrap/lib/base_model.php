<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }

    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();

      foreach($this->validators as $validator){
        $metodi = $validator;
        $errors = array_merge($errors, $this->{$metodi}());
      }

      return $errors;
    }


    public function validate_name(){
      $errors = array();
      if($this->name =='' || $this->name == null) {
        $errors[] = 'Nimi ei saa olla tyhjä!';
      }
      if (strlen($this->name) < 5) {
        $errors[] = "Nimen pitää olla vähintään 5 merkkiä pitkä!";
      }      
      return $errors;
    }

    public function validate_username(){
      $errors = array();
      if($this->username =='' || $this->username == null) {
        $errors[] = 'Käyttäjänimi ei saa olla tyhjä!';
      }
      if (strlen($this->username) < 3) {
        $errors[] = "Käyttäjänimen pitää olla vähintään 3 merkkiä pitkä!";
      } 
      return $errors;
    }

    public function validate_password(){
      $errors = array();
      if($this->password =='' || $this->password == null) {
        $errors[] = 'Salasana ei voi olla tyhjä!';
      }
      if($this->password != $this->pwd_again) {
        $errors[] = 'Varmista salasanan uudelleenkirjoitus!';
      }  
    if (strlen($this->password) < 8) {
        $errors[] = "Salasana on liian lyhyt!";
    }

    if (!preg_match("#[0-9]+#", $this->password)) {
        $errors[] = "Salasanassa pitää olla vähintään yksi numero!";
    }

    if (!preg_match("#[a-zA-Z]+#", $this->password)) {
        $errors[] = "Salasanassa on oltava vähintään yksi kirjain!";
    }      
      return $errors;
    }

    public function validate_email(){
      $errors = array();
      if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Tarkasta sähköpostiosoite!";
      }
      return $errors;
    }

  }


