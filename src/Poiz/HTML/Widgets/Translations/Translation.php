<?php
/**
 * Created by PhpStorm.
 * User: Poiz
 * Date: 26/11/14
 * Time: 08:05
 */

    namespace  App\Poiz\HTML\Widgets\Translations;
    
    class Translation{}
    $global_store                                   = array();

	/*** AGB COMPLIANCE TEXT ***/
	$global_store['agb_compliance']                 = array();

    /*** PRODUCTS ***/
    $global_store['products']                       = array();

    /*** FORM-FIELDS ***/
    $global_store['form']                           = array();

    /*** MAIL RELATED ***/
    $global_store['mail']                           = array();

	/*** MESSAGE ***/
	$global_store['message']                        = array();

	/*** ERROR ***/
	$global_store['error']                          = array();
	
    /*** LANGUAGES ***/
    $global_store['lang']                           = "en";
    $global_store['active_lang']                    = "en";


    //MESSAGE:: DE
	$global_store['message']['success']['de']       = "Vielen Dank...<br />Ihre Bestellung wurde erfolgreich gespeichert.<br />Sie sollten in Kürze per E-Mail eine Bestätigung erhalten.";
	$global_store['message']['failure']['de']       = "Es gab ein Problem bei Abwicklung Ihrer Bestellung.<br />Bitte klicken Sie hier, um es erneut zu versuchen.";
	$global_store['message']['feedback']['de']      = "Feedback";

    //MESSAGE:: FR
	$global_store['message']['success']['fr']       = "Merci beaucoup...<br />Votre commande a été enregistré avec reussit.<br />Vous devriez recevoir une confirmation par courriel dans quelque minutes.";
	$global_store['message']['failure']['fr']       = "Nous n'avons pas pu traiter votre commande.<br />Veuillez cliquer <a href=''>ici</a> pour ressayer de nouveau.";
	$global_store['message']['feedback']['fr']      = "Feedback";

    //MESSAGE:: EN
	$global_store['message']['success']['en']       = "Thank You...<br />Your Order has been successfully saved.<br />You should be receiving a confirmation by email shortly.";
	$global_store['message']['failure']['en']       = "There was a Problem processing your Order.<br /> Please try click <a href=''>here</a> to try again.";
	$global_store['message']['feedback']['en']      = "Feedback";




    //ERRORS:: DE
	$global_store['error']['raw']['de']             = "";
	$global_store['error']['regex']['de']           = "Input value does not match the Validation Regular Expression.";
	$global_store['error']['num']['de']             = "Nicht numerische Zeichen oder leere Zeichenfolge in der anstelle einer Zahl gefunden.";
	$global_store['error']['tel']['de']             = "Telefonnummer wurde entweder falsch formatiert oder leer.";
	$global_store['error']['date']['de']            = "Datum wurde entweder nicht richtig formatiert oder leer.";
	$global_store['error']['bool']['de']            = "";
	$global_store['error']['html']['de']            = "";
	$global_store['error']['email']['de']           = "Leere Email Wert oder E-Mail wurde nicht richtig formatiert.";
	$global_store['error']['string']['de']          = "Leerer Wert oder fremde Zeichen im Formularfeld eingebettet. String oder alphanumerische Zeichen erwartet.";
	$global_store['error']['errors']['de']          = "Fehlern";
	$global_store['error']['from']['de']            = "Der Parameter <strong>\"from\"</strong> wurde nicht richtig formatiert. <br/>Das richtige Format ist <strong>YYYY-MM-DD</strong>.";
	$global_store['error']['till']['de']            = "Der Parameter <strong>\"to\"</strong> wurde nicht korrekt formatiert. <br/>Das richtige Format ist <strong>YYYY-MM-DD</strong>";
    $global_store['error']['out_of_bounds']['de']   = "Datum: außerhalb der Grenzen! Die angegebenen Daten des Aufenthaltes sind nicht im akzeptablen Bereich.";
    $global_store['error']['recheck_data']['de']    = "Bitte überprüfen Sie die markierten Texte/Felder unten für mögliche Fehlern.";
    $global_store['error']['param']['de']           = "Parameterfehler";
	$global_store['error']['recaptcha_error']['de'] = "reCAPTCHA was either empty or incorrectly entered.";
	$global_store['error']['alnum']['de']           = "Alphanumeric Characters expected, empty or foreign characters found.";
	$global_store['error']['misc']['de']            = "Alphanumeric Characters expected, empty or foreign characters found.";
	$global_store['error']['pass_mismatch']['de']   = "Passwords do not match.";
	$global_store['error']['username_in_use']['de'] = "This Username already exists. Please try another combination.";
	$global_store['error']['non_empty']['de']       = "Leeres Werte sind nicht erlaubt.";
	$global_store['error']['url']['de']             = "Einen gültigem «URL» sieht so aus: http://domain.tld";
	$global_store['error']['hex']['de']             = "Einen gültigem «HEX» Wert sieht  so aus: #FF0000";
	$global_store['error']['rgb']['de']             = "Einen gültigem «RGBA» Wert sieht  so aus: RGBA(255, 0, 0, 1)";



	//ERRORS:: FR
	$global_store['error']['raw']['fr']             = "";
	$global_store['error']['regex']['fr']           = "Input value does not match the Validation Regular Expression.";
	$global_store['error']['num']['fr']             = "Contrôler ";
	$global_store['error']['tel']['fr']             = "Soit le Numéro de téléphone etait vide ou pas correctement formatée.";
	$global_store['error']['date']['fr']            = "Soit le Champ est vide soit la date n'a pas été correctement formaté.";
	$global_store['error']['bool']['fr']            = "";
	$global_store['error']['html']['fr']            = "";
	$global_store['error']['email']['fr']           = "Verifier que le champ <em>Email</em> n'est ni vide ni mal formatée.";
	$global_store['error']['string']['fr']          = "Caractères Alphanumériques attendus. Aucune Caractères ou Caractères étrangers trouvés.";
	$global_store['error']['errors']['fr']          = "Erreurs";
    $global_store['error']['from']['fr']            = "Le paramètre <strong>\"from\"</strong> n'etait pas formaté correctement. <br/>Le format requis est: <strong>YYYY-MM-DD</strong>.";
    $global_store['error']['till']['fr']            = "Le paramètre <strong>\"to\"</strong> n'etait pas formaté correctement. <br/>Le format requis est: <strong>YYYY-MM-DD</strong>.";
    $global_store['error']['out_of_bounds']['fr']   = "Date: hors limites! Les dates indiquées ne sont pas dans la plage acceptable.";
    $global_store['error']['recheck_data']['fr']    = "Veuillez, s'il vous plaît, re-vérifier les textes/champs soulignés ci-dessous pour des erreurs possibles!";
    $global_store['error']['param']['fr']           = "Erreurs de Paramètres";
	$global_store['error']['recaptcha_error']['fr'] = "reCAPTCHA was either empty or incorrectly entered.";
	$global_store['error']['alnum']['fr']           = "Alphanumeric Characters expected, empty or foreign characters found.";
	$global_store['error']['misc']['fr']            = "Alphanumeric Characters expected, empty or foreign characters found.";
	$global_store['error']['pass_mismatch']['fr']   = "Passwords do not match.";
	$global_store['error']['username_in_use']['fr'] = "This Username already exists. Please try another combination.";
    $global_store['error']['non_empty']['fr']       = "Valeurs vides n'ont pas permit.";
    $global_store['error']['url']['fr']             = "Einen gültigem «URL» sieht so aus: http://domain.tld";
    $global_store['error']['hex']['fr']             = "Einen gültigem «HEX» Wert sieht  so aus: #FF0000";
    $global_store['error']['rgb']['fr']             = "Einen gültigem «RGBA» Wert sieht  so aus: RGBA(255, 0, 0, 1)";




	//ERRORS:: EN
	$global_store['error']['raw']['en']             = "";
	$global_store['error']['regex']['en']           = "Input value does not match the Validation Regular Expression.";
	$global_store['error']['num']['en']             = "A Non-Numeric Character or Empty String was found in the Place of a NUMBER.";
	$global_store['error']['tel']['en']             = "Telephone Number was either not Properly Formatted or Empty.";
	$global_store['error']['date']['en']            = "Empty Value or Date was not Properly Formatted.";
	$global_store['error']['bool']['en']            = "";
	$global_store['error']['html']['en']            = "";
	$global_store['error']['email']['en']           = "Empty Email value or Email was not Properly Formatted.";
	$global_store['error']['string']['en']          = "Empty Value or foreign character(s) embedded within Form field. STRING/Alphanumeric Characters expected.";
	$global_store['error']['errors']['en']          = "Errors";
    $global_store['error']['from']['en']            = "The Parameter <strong>\"from\"</strong> was not correctly formatted. <br/>The expected Format is <strong>YYYY-MM-DD</strong>.";
    $global_store['error']['till']['en']            = "The Parameter <strong>\"to\"</strong> was not correctly formatted. <br/>The expected Format is <strong>YYYY-MM-DD</strong>.";
    $global_store['error']['recheck_data']['en']    = "Please re-check the Highlighted Texts/Fields below for Possible Errors!";
    $global_store['error']['out_of_bounds']['en']   = "Date: out of bounds! The given dates are not within acceptable range.";
    $global_store['error']['param']['en']           = "Parameter Errors";
	$global_store['error']['recaptcha_error']['en'] = "reCAPTCHA was either empty or incorrectly entered.";
	$global_store['error']['alnum']['en']           = "Alphanumeric Characters expected, empty or foreign characters found.";
	$global_store['error']['misc']['en']            = "Alphanumeric Characters expected, empty or foreign characters found.";
	$global_store['error']['pass_mismatch']['en']   = "Passwords do not match.";
	$global_store['error']['username_in_use']['en'] = "This Username already exists. Please try another combination.";
    $global_store['error']['non_empty']['en']       = "Empty values are not allowed.";
    $global_store['error']['url']['en']             = "Einen gültigem «URL» sieht so aus: http://domain.tld";
    $global_store['error']['hex']['en']             = "Einen gültigem «HEX» Wert sieht  so aus: #FF0000";
    $global_store['error']['rgb']['en']             = "Einen gültigem «RGBA» Wert sieht  so aus: RGBA(255, 0, 0, 1)";



