<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $services = [
            [
                "name" => "Reception 24 ore su 24",
                "description" => "Il personale della reception è disponibile 24 ore su 24 per assistervi con ogni vostra esigenza.",
                "icon" => "fas fa-hotel"
            ],
            [
                "name" => "Servizio concierge",
                "description" => "Il concierge dell'hotel è disponibile per aiutarvi con prenotazioni di ristoranti, biglietti per spettacoli e altre attività locali.",
                "icon" => "fas fa-user"
            ],
            [
                "name" => "Servizio in camera",
                "description" => "Godetevi il comfort della vostra camera ordinando il cibo e le bevande del menu del servizio in camera.",
                "icon" => "fas fa-concierge-bell"
            ],
            [
                "name" => "Servizio di pulizia giornaliero",
                "description" => "La vostra camera verrà pulita e rifatta ogni giorno per garantirvi un soggiorno confortevole.",
                "icon" => "fas fa-broom"
            ],
            [
                "name" => "Servizio lavanderia",
                "description" => "L'hotel offre un servizio di lavanderia per i vostri vestiti e tessuti personali.",
                "icon" => "fas fa-shirt"
            ],
            [
                "name" => "Wi-Fi gratuito",
                "description" => "La connessione Wi-Fi è gratuita in tutte le aree dell'hotel.",
                "icon" => "fas fa-wifi"
            ],
            [
                "name" => "Piscina",
                "description" => "Rilassatevi a bordo piscina e godetevi il sole durante la vostra vacanza.",
                "icon" => "fas fa-water-ladder"
            ],
            [
                "name" => "Centro fitness",
                "description" => "L'hotel dispone di un centro fitness completamente attrezzato per mantenervi in forma durante il vostro soggiorno.",
                "icon" => "fas fa-dumbbell"
            ],
            [
                "name" => "Spa",
                "description" => "Rilassatevi e lasciatevi coccolare presso la spa dell'hotel.",
                "icon" => "fas fa-spa"
            ],
            [
                "name" => "Ristorante",
                "description" => "L'hotel offre un ristorante dove potrete gustare piatti locali e internazionali.",
                "icon" => "fas fa-utensils"
            ],
            [
                "name" => "Bar",
                "description" => "Il bar dell'hotel è il luogo ideale per sorseggiare un drink o un cocktail.",
                "icon" => "fas fa-martini-glass-citrus"
            ],
            [
                "name" => "Sale riunioni",
                "description" => "L'hotel dispone di sale riunioni completamente attrezzate per ospitare eventi e riunioni di lavoro.",
                "icon" => "fas fa-handshake"

            ],
            [
                "name" => "Centro business",
                "description" => "Il centro business dell'hotel offre servizi come la stampa e la copia di documenti e la connessione internet ad alta velocità.",
                "icon" => "fas fa-briefcase"
            ],
            [
                "name" => "Navetta per l'aeroporto",
                "description" => "L'hotel offre un servizio navetta per l'aeroporto per i propri ospiti.",
                "icon" => "fas fa-plane-departure"
            ],
            [
                "name" => "Autonoleggio",
                "description" => "L'hotel offre un servizio di autonoleggio per i propri ospiti.",
                "icon" => "fas fa-car"
            ],
            [
                "name" => "Tour desk",
                "description" => "Il tour desk dell'hotel è a vostra disposizione per aiutarvi a pianificare escursioni e attività locali.",
                "icon" => "fas fa-person-hiking"
            ],
        ];

        foreach ($services as $singleservice) {
            $service = new Service();
            $service->name = $singleservice['name'];
            $service->description = $singleservice['description'];
            $service->icon = $singleservice['icon'];
            $service->save();
        };
    }
}
