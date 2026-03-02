<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class WmsApiController extends Controller
{
    private const BASE_URL = 'https://bridge.tokosda.com/wms.php';

    /**
     * GET /api/wms/summary
     * Ringkasan: jumlah rak dan total item.
     */
    public function summary()
    {
        return $this->proxyGet([]);
    }

    /**
     * GET /api/wms/racks
     * Semua rak dikelompokkan (all_grouped_by_rack=true).
     */
    public function allRacks()
    {
        return $this->proxyGet(['all_grouped_by_rack' => 'true']);
    }

    /**
     * GET /api/wms/rack/{code}
     * Cari item berdasarkan kode rak.
     */
    public function byRack(string $code)
    {
        return $this->proxyGet(['rack_number' => $code]);
    }

    /**
     * GET /api/wms/product/{code}
     * Cari rak berdasarkan kode/nama produk.
     */
    public function byProduct(string $code)
    {
        return $this->proxyGet(['product_number' => $code]);
    }

    /**
     * Proxy helper: forward request ke API eksternal dan return JSON response.
     */
    private function proxyGet(array $params)
    {
        try {
            $response = Http::timeout(15)->get(self::BASE_URL, $params);

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'API eksternal mengembalikan error: ' . $response->status(),
                ], 502);
            }

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal terhubung ke API: ' . $e->getMessage(),
            ], 503);
        }
    }
}
