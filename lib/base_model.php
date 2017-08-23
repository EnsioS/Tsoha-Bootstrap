<?php

class BaseModel {

    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    public function errors() {
        // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
        $errors = array();

        foreach ($this->validators as $validator) {
            // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon            
            $validator_errors = $this->{$validator}();            
            $errors = array_merge($errors, $validator_errors);
        }

        return $errors;
    }

    public function validate_string_length($valitaded, $string, $minlength, $maxlength) {
        $errors = array();
        
        if ($string == '' || $string == null) {
            $errors[] = $valitaded.' ei saa olla tyhjä!';
        }
        
        if (strlen($string) < $minlength) {
            $errors[] = $valitaded. ' ei saa olla '. $minlength. ' merkkiä lyhyempi!';
        }
        
        if (strlen($string) > $maxlength) {
            $errors[] = $valitaded. ' ei saa olla '. $maxlength. ' merkkiä pidempi';
        }
        
        return $errors;
    }
    
    public function validate_timestamp($valitaded, $timestamp) {
        $errors = array();
       
        if ($timestamp == '' || $timestamp == null) {
            return $errors;
        }
        
        if (strlen($timestamp) < 10) {
            $errors[] = 'Ilmoita päivämäärä kohtaan esim. muodossa YYYY-mm-dd HH:ii:ss';
            return $errors;
        }
        
        try {
            $time = new DateTime($timestamp);
        } catch (Exception $ex) {
            $errors[] = 'Ilmoita päivämäärä kohtaan "'. $valitaded .'" esim. muodossa YYYY-mm-dd HH:ii:ss';
        }
        
        return $errors;
    }

}
