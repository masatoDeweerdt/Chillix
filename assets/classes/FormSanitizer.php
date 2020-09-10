<?php
    class FormSanitizer {
 // créer une fonction qui bloque l'imput de tag html, on sanitize, Important pour la securité.
 //strip_tags() est une fonction prédefinis pour sela
    public static function sanitizeFormString($inputText){
        $inputText =strip_tags($inputText);
        //retirer les espace avec str_replace
        $inputText =str_replace("" ,"",$inputText);
        //uppercase la premiere lettre apres avoir mis tout en minuscule, pour recuperer les donées tout de la meme facon
        $inputText =strtolower($inputText);
        $inputText =ucfirst ($inputText);
        return $inputText;
    }

    public static function sanitizeFormUsername($inputText){
        $inputText =strip_tags($inputText);
        //retirer les espace avec str_replace
        $inputText =str_replace("" ,"",$inputText);
        return $inputText;
    }

    public static function sanitizeFormPassword($inputText){
        $inputText =strip_tags($inputText);
        return $inputText;
    }

    public static function sanitizeFormEmail($inputText){
        $inputText =strip_tags($inputText);
        //retirer les espace avec str_replace
        $inputText =str_replace("" ,"",$inputText);
        return $inputText;
    }
    }

?>