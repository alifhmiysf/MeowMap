<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatSpotting;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminAnalyticsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $days = (int) $request->query('days', 30);

        if (!in_array($days, [7, 30, 90], true)) {
            return response()->json([
                'message' => 'Parameter days harus 7, 30, atau 90.',
            ], 422);
        }

        $today = Carbon::today();
        $start = $today->copy()->subDays($days - 1);
        $previousStart = $start->copy()->subDays($days);
        $previousEnd = $start->copy()->subSecond();

        $baseQuery = CatSpotting::query();

        $currentTotal = (clone $baseQuery)
            ->where('created_at', '>=', $start)
            ->where('created_at', '<', $today->copy()->addDay())
            ->count();

        $previousTotal = (clone $baseQuery)
            ->where('created_at', '>=', $previousStart)
            ->where('created_at', '<=', $previousEnd)
            ->count();

        $growthPercentage = $previousTotal > 0
            ? round(
                (($currentTotal - $previousTotal) / $previousTotal) * 100,
                2
            )
            : null;

        $dailyCounts = (clone $baseQuery)
            ->where('created_at', '>=', $start)
            ->where('created_at', '<', $today->copy()->addDay())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupByRaw('DATE(created_at)')
            ->orderBy('date')
            ->pluck('total', 'date');

        $trend = [];

        for ($i = 0; $i < $days; $i++) {
            $date = $start->copy()->addDays($i)->toDateString();

            $trend[] = [
                'date' => $date,
                'total' => (int) ($dailyCounts[$date] ?? 0),
            ];
        }

        $statuses = (clone $baseQuery)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $districts = (clone $baseQuery)
            ->selectRaw("
                COALESCE(NULLIF(district, ''), 'Belum diketahui') as district,
                COUNT(*) as total
            ")
            ->groupBy('district')
            ->orderByDesc('total')
            ->get();

        return response()->json([
            'period_days' => $days,
            'summary' => [
                'total_reports' => (clone $baseQuery)->count(),
                'pending' => (int) ($statuses['pending'] ?? 0),
                'approved' => (int) ($statuses['approved'] ?? 0),
                'rejected' => (int) ($statuses['rejected'] ?? 0),
                'current_period' => $currentTotal,
                'previous_period' => $previousTotal,
                'growth_percentage' => $growthPercentage,
            ],
            'trend' => $trend,
            'districts' => $districts,
        ]);
    }
}
