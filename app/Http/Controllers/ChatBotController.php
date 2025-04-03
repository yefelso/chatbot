<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatBotController extends Controller
{
    public function ask(Request $request)
{
    try {
        $request->validate([
            'question' => 'required|string',
        ]);

        Log::info("Usuario preguntó: " . $request->input('question'));

        // Enviar la solicitud a la API
        $response = Http::withOptions([
            'verify' => false
        ])->post('https://magicloops.dev/api/loop/735d0313-f85f-42af-bc92-db589062b69c/run', [
            'question' => $request->input('question')
        ]);

        $body = $response->body();
        Log::info("Respuesta de la API: " . $body);

        // Verificar si la respuesta es un JSON válido
        $data = json_decode($body, true);
        if (!is_array($data)) {
            Log::warning("La API devolvió un string en lugar de un JSON. Convirtiendo...");
            $data = ['mensaje' => trim($body, '"')]; 
        }

        return response()->json($data);

    } catch (\Exception $e) {
        Log::error("Error en ChatBotController: " . $e->getMessage());
        return response()->json(['error' => 'Ocurrió un error al procesar tu solicitud.'], 500);
    }
}

}
