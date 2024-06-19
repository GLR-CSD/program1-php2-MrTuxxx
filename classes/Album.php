<?php

declare(strict_types=1);
class Album
{
    /** @var int|null Het ID */
    private ?int $ID;

    /**
     * @return int|null
     */
    public function getID(): ?int
    {
        return $this->ID;
    }

    /**
     * @param int|null $ID
     */
    public function setID(?int $ID): void
    {
        $this->ID = $ID;
    }

    /**
     * @return string|null
     */
    public function getNaam(): ?string
    {
        return $this->Naam;
    }

    /**
     * @param string|null $Naam
     */
    public function setNaam(?string $Naam): void
    {
        $this->Naam = $Naam;
    }

    /**
     * @return string
     */
    public function getArtiesten(): string
    {
        return $this->Artiesten;
    }

    /**
     * @param string $Artiesten
     */
    public function setArtiesten(string $Artiesten): void
    {
        $this->Artiesten = $Artiesten;
    }

    /**
     * @return string
     */
    public function getReleaseDatum(): string
    {
        return $this->Release_datum;
    }

    /**
     * @param string $Release_datum
     */
    public function setReleaseDatum(string $Release_datum): void
    {
        $this->Release_datum = $Release_datum;
    }

    /**
     * @return string
     */
    public function getURL(): string
    {
        return $this->URL;
    }

    /**
     * @param string $URL
     */
    public function setURL(string $URL): void
    {
        $this->URL = $URL;
    }

    /**
     * @return string
     */
    public function getAfbeelding(): string
    {
        return $this->Afbeelding;
    }

    /**
     * @param string $Afbeelding
     */
    public function setAfbeelding(string $Afbeelding): void
    {
        $this->Afbeelding = $Afbeelding;
    }

    /**
     * @return string
     */
    public function getPrijs(): string
    {
        return $this->Prijs;
    }

    /**
     * @param string $Prijs
     */
    public function setPrijs(string $Prijs): void
    {
        $this->Prijs = $Prijs;
    }

    /** @var string De naam van de album */
    private ?string $Naam;

    /** @var string De naam van de artiest*/
    private string $Artiesten;

    /** @var string|null Release datum*/
    private string $Release_datum;

    /** @var string|null De album link youtube*/
    private string $URL;

    /** @var string|null afbeelding link */
    private string $Afbeelding;

    /** @var string|null Prijs van de album */
    private string $Prijs;

    /**
     * @param int|null $ID
     * @param string|null $Naam
     * @param string $Artiesten
     * @param string|null $Release_datum
     * @param string|null $URL
     * @param string|null $Afbeelding
     * @param string|null $Prijs
     */
    public function __construct(?int $ID, ?string $Naam, string $Artiesten, string $Release_datum, string $URL, string $Afbeelding, string $Prijs)
    {
        $this->ID = $ID;
        $this->Naam = $Naam;
        $this->Artiesten = $Artiesten;
        $this->Release_datum = $Release_datum;
        $this->URL = $URL;
        $this->Afbeelding = $Afbeelding;
        $this->Prijs = $Prijs;
    }

    public static function getAll(PDO $db): array
    {
        // Voorbereiden van de query
        $stmt = $db->query("SELECT * FROM Album");

        // Array om albums op te slaan
        $albums = [];

        // Itereren over de resultaten en personen toevoegen aan de array
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $album = new Album(
                $row['ID'],
                $row['Naam'],
                $row['Artiesten'],
                $row['Release_datum'],
                $row['URL'],
                $row['Afbeelding'],
                $row['Prijs']
            );
            $albums[] = $album;
        }

        // Retourneer array met personen
        return $albums;
    }

    // Methode om een nieuwe persoon toe te voegen aan de database
//    public function save(PDO $db): void
//    {
//        // Voorbereiden van de query
//        $stmt = $db->prepare("INSERT INTO Album (Naam, Artiesten, Release_datum, URL, Afbeelding, Prijs) VALUES (:Naam, :Artiesten, :Release_datum, :URL, :Afbeelding, :Prijs)");
//        $stmt->bindParam(':Naam', $this->voornaam);
//        $stmt->bindParam(':Artiesten', $this->achternaam);
//        $stmt->bindParam(':Release_datum', $this->Release_datum);
//        $stmt->bindParam(':URL', $this->URL);
//        $stmt->bindParam(':Afbeelding', $this->Afbeelding);
//        $stmt->bindParam(':Prijs', $this->Prijs);
////        $stmt->execute();
//    }
    public function save(PDO $db): void
    {
        // Voorbereiden van de query
        $stmt = $db->prepare("INSERT INTO Album (Naam, Artiesten, Release_datum, URL, Afbeelding, Prijs) VALUES (:Naam, :Artiesten, :Release_datum, :URL, :Afbeelding, :Prijs)");

        // Correcte attributen van de klasse binden
        $stmt->bindParam(':Naam', $this->Naam);
        $stmt->bindParam(':Artiesten', $this->Artiesten);
        $stmt->bindParam(':Release_datum', $this->Release_datum);
        $stmt->bindParam(':URL', $this->URL);
        $stmt->bindParam(':Afbeelding', $this->Afbeelding);
        $stmt->bindParam(':Prijs', $this->Prijs);

        // Execute de query
        $stmt->execute();
    }

}
