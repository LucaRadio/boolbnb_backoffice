<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            "title" => "required|min:1|max:255|string",
            "n_rooms" => "required|min:1|max:255|numeric",
            "n_bathrooms" => "required|min:1|max:255|numeric",
            "n_beds" => "required|min:1|max:255|numeric",
            "square_meters" => "required|max:16777215|min:10",
            "address" => "required|string|max:255",
            "visibility" => "string",
            "img_cover" => "required|max:255|file",
            "description" => "required|max: 65,535|string"
        ];
    }

    public function messages()
    {
        return [

            "title.required" => "Il titolo è obbligatorio",
            "title.max" => "Hai superato la lunghezza massima per il titolo.",
            "title.string" => "Il titolo deve essere del testo.",
            "n_bathrooms.required" => "Il numero dei bagni è obbligatorio.",
            "n_bathrooms.max" => "Hai superato il numero di bagni massimo.",
            "n_bathrooms.numeric" => "Il numero di bagni deve essere un numero.",
            "n_beds.required" => "Il numero dei letti è obbligatorio.",
            "n_beds.max" => "Hai superato il numero di letti massimo.",
            "n_beds.numeric" => "Il numero di letti deve essere un numero.",
            "n_rooms.required" => "Il numero di stanze è obbligatorio.",
            "n_rooms.max" => "Hai superato il numero di stanze massimo.",
            "n_rooms.numeric" => "Il numero delle stanze deve essere un numero.",
            "square_meter.required" => "Il numero di metri quadrati è obbligatorio",
            "square_meter.max" => "Hai superato il numero di metri quadrati massimi",
            "square_meters.min" => "Sei sotto il numero di metri quadrati minimi.",
            "address.required" => "L'indirizzo è obbligatorio.",
            "address.string" => "L'indirizzo deve essere del testo.",
            "address.max" => "L'indirizzo deve essere più corto.",
            "visibility.required" => "La visibilità deve essere inserita.",
            "img_cover.required" => "L'immagine è obbligatoria.",
            "img_cover.file" => "L'immagine deve essere un file.",
            "description.required" => "La descrizione deve essere unserita.",
            "description.string" => "La descrizione deve essere del testo.",
            "description.max" => "Hai superato la lunghezza massima per la descrizione."

        ];
    }
}
