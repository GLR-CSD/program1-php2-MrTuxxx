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
        'Prijs' => $_POST['Prijs'] ?? '',
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
    if (empty($_POST['Release_datum'])) {
        $errors['Release_datum'] = "Release_datum is verplicht.";
    }


    // Valideer telefoonnummer (NL-formaat)
    if (empty($_POST['URL'])) {
        $errors['URL'] = "URL is verplicht.";
    }

    if (empty($_POST['Afbeelding'])) {
        $errors['Afbeelding'] = "Img is verplicht.";
    }
    if (empty($_POST['Prijs'])) {
        $errors['Prijs'] = "Prijs is verplicht.";
    }

    // Als er geen validatiefouten zijn, voeg de persoon toe aan de database
    if (empty($errors)) {
        require_once 'db.php';
        require_once 'classes/Album.php';

        // Maak een nieuw Persoon object met de ingediende gegevens
        $album = new Album(
            null,
            $_POST['Naam'],
            $_POST['Artiest'],
            $_POST['Release_datum'],
            $_POST['URL'],
            $_POST['Afbeelding'],
            $_POST['Prijs']
        );

        // Voeg de persoon toe aan de database
        $album->save($db);

    } else {
        // Sla de fouten en formulier waarden op in sessievariabelen
        $_SESSION['errors'] = $errors;
        $_SESSION['formValues'] = $formValues;
    }

    // Stuur de gebruiker terug naar de index.php
    header("Location: album.php");
    exit;

} else {
    header("Location: album.php");
}