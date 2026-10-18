<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatSpotting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminCatSpottingController extends Controller
{
    /**
     * Menampilkan daftar laporan untuk dashboard admin.
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'status' => [
                'sometimes',
                'required',
                'in:pending,approved,rejected',
            ],
        ]);

        $query = CatSpotting::query()
            ->with([
                'user:id,name,email',
            ])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->paginate(10);

        return response()->json($reports);
    }

    /**
     * Menampilkan detail satu laporan.
     */
    public function show(CatSpotting $catSpotting): JsonResponse
    {
        $catSpotting->load([
            'user:id,name,email',
        ]);

        return response()->json([
            'data' => $catSpotting,
        ]);
    }

    /**
     * Mengubah status laporan.
     */
    public function updateStatus(
        Request $request,
        CatSpotting $catSpotting
    ): JsonResponse {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:approved,rejected',
            ],
        ]);

        $catSpotting->update([
            'status' => $validated['status'],
        ]);

        $catSpotting->load([
            'user:id,name,email',
        ]);

        return response()->json([
            'message' => 'Status laporan berhasil diperbarui.',
            'data' => $catSpotting,
        ]);
    }

    /**
     * Menghapus laporan.
     */
    public function destroy(
        CatSpotting $catSpotting
    ): JsonResponse {
        $id = $catSpotting->id;

        $catSpotting->delete();

        return response()->json([
            'message' => 'Laporan berhasil dihapus.',
            'id' => $id,
        ]);
    }
}