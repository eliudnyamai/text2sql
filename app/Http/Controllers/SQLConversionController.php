<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SQLConversionController extends Controller
{
    public function convert(Request $request)
    {
        $sql_query = trim($request->input('sql_query'));
        $OPENAI_API_KEY = "";

        $response = Http::withHeaders([
            "Authorization" => "Bearer $OPENAI_API_KEY",
            "Content-Type" => "application/json",
        ])->post("https://api.openai.com/v1/completions", [
            "model" => "text-davinci-003",
            "prompt" => "convert this to a sql query." . $sql_query,
            "temperature" => 0.3,
            "max_tokens" => 100,
            "top_p" => 1,
            "frequency_penalty" => 0,
            "presence_penalty" => 0,
        ]);

        if ($response->failed()) {
            $data = [
                "error" => "Failed to fetch response from OpenAI.",
                "success" => false,
            ];
            return response()->json($data, 500);
        }

        $responseData = $response->json();
        $sql = $responseData['choices'][0]['text'];

        $data = [
            "success" => true,
            "sql" => $sql,
        ];
        return response()->json($data);
        return view ('welcome',compact("sql"));
    
    }
}

