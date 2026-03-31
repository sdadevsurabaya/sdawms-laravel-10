<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RakitanApiController extends Controller
{
    /**
     * Proxy function to fetch detailed Rakitan data from external API.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData(Request $request)
    {
        $id = $request->query('id');

        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter ID is required.'
            ], 400);
        }

        $endpoint = env('RAKITAN_QR_ENDPOINT', 'https://bridge.tokosda.com/api-v2/endpoints/rakitan_qr.php');

        try {
            // Forward parameters if necessary, here we only need 'id'
            $response = Http::get($endpoint, [
                'id' => $id
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch data from remote server.',
                'status' => $response->status()
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while connecting to the remote server.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
