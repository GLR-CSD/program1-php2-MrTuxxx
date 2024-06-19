<?php
// Start de sessie
// Deze gaan we gebruiken om de form values en de errors op te slaan
session_start();

// Controleer of het verzoek via POST is gedaan
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Valideer de ingediende gegevens
    $errors = [];
    $formValues = [
        'Naam' => $_POST['Naam'] ?? '',
        'Artiest' => $_POST['Artiest'] ?? '',
        'Release_datum' => $_POST['Release_datum'] ?? '',
        'URL' => $_POST['URL'] ?? '',
        'Afbeelding' => $_POST['Afbeelding'] ?? '',
    ];

    // Valideer voornaam
    if (empty($_POST['Naam'])) {
        $errors['Naam'] = "Naam is verplicht!.";
    }

    // Valideer achternaam
    if (empty($_POST['Artiest'])) {
        $errors['Artiest'] = "Artiest is verplicht.";
    }

    // Valideer e-mailadres
    if (!empty($_POST['Release_datum']) && !filter_var($_POST['Release_datum'], FILTER_VALIDATE_EMAIL)) {
        $errors['Release_datum'] = "Ongeldig e-mailadres.";
    }

    // Valideer telefoonnummer (NL-formaat)
    if (!empty($_POST['telefoonnummer']) && !preg_match("/^(\\+31|0|0031)[1-9][0-9]{8}$/", $_POST['telefoonnummer'])) {
        $errors['telefoonnummer'] = "Ongeldig telefoonnummer. Voer een geldig Nederlands telefoonnummer in.";
    }

    // Als er geen validatiefouten zijn, voeg de persoon toe aan de database
    if (empty($errors)) {
        require_once 'db.php';
        require_once 'classes/Album.php';

        // Maak een nieuw Persoon object met de ingediende gegevens
        $persoon = new Persoon(
            null,
            $_POST['voornaam'],
            $_POST['achternaam'],
            $_POST['telefoonnummer'],
            $_POST['email'],
            $_POST['opmerkingen']
        );

        // Voeg de persoon toe aan de database
        $persoon->save($db);

    } else {
        // Sla de fouten en formulier waarden op in sessievariabelen
        $_SESSION['errors'] = $errors;
        $_SESSION['formValues'] = $formValues;
    }

    // Stuur de gebruiker terug naar de index.php
    header("Location: index.php");
    exit;

} else {
    header("Location: index.php");
}