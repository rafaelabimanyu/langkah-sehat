<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerjalananRequest;
use App\Models\Perjalanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Carbon\Carbon;

class MasyarakatController extends Controller
{
    /**
     * =========================================================================
     * SECURITY: Centralized Ownership Authorization Guard
     * =========================================================================
     * Ensures the authenticated user owns the requested Perjalanan record.
     * This prevents IDOR (Insecure Direct Object Reference) attacks where
     * a user could manipulate URL parameters to access another user's data.
     *
     * @param  \App\Models\Perjalanan  $perjalanan
     * @return void
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    private function authorizeOwnership(Perjalanan $perjalanan): void
    {
        if ($perjalanan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengelola data ini.');
        }
    }

    /**
     * Display the main dashboard with quick overview and health analytics.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        
        // Calculate Analytics
        $totalLogs = $user->perjalanans()->count();
        $avgTemp = $user->perjalanans()->avg('suhu_tubuh') ?? 0;
        
        // Latest log to determine status
        $latestLog = $user->perjalanans()->orderBy('tanggal', 'desc')->orderBy('jam', 'desc')->first();
        $healthStatus = 'Normal';
        if (!$latestLog) {
            $healthStatus = 'Belum Ada Data';
        } elseif ($latestLog->suhu_tubuh >= 37.5) {
            $healthStatus = 'Demam (Butuh Istirahat)';
        }

        // Weekly temperature trend data (last 7 days)
        $weeklyTemps = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dayAvg = $user->perjalanans()
                ->whereDate('tanggal', $date)
                ->avg('suhu_tubuh');
            $weeklyTemps[] = [
                'day' => $date->translatedFormat('D'),
                'date' => $date->translatedFormat('d M'),
                'temp' => $dayAvg ? round($dayAvg, 1) : null,
            ];
        }

        // Recent 3 logs for quick glance
        $recentLogs = $user->perjalanans()
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->take(3)
            ->get();

        return view('masyarakat.dashboard', compact(
            'totalLogs',
            'avgTemp',
            'healthStatus',
            'weeklyTemps',
            'recentLogs'
        ));
    }

    /**
     * Show the dedicated travel input form page.
     */
    public function create(): View
    {
        return view('masyarakat.create');
    }

    /**
     * Display the full travel history with filters and analysis.
     * SECURITY: All queries are scoped to Auth::user()->perjalanans()
     * so users can never see other users' data.
     */
    public function riwayat(Request $request): View
    {
        $search = $request->input('search');
        $filterSuhu = $request->input('filter_suhu');
        $filterTanggal = $request->input('filter_tanggal');

        $user = Auth::user();
        
        // Analytics for the history page (scoped to current user only)
        $totalLogs = $user->perjalanans()->count();
        $avgTemp = $user->perjalanans()->avg('suhu_tubuh') ?? 0;
        $highTempCount = $user->perjalanans()->where('suhu_tubuh', '>=', 37.5)->count();
        
        // Query Logs for Table (scoped to current user only)
        $query = $user->perjalanans();

        if ($search) {
            $query->where('lokasi', 'like', '%' . $search . '%');
        }

        if ($filterSuhu) {
            if ($filterSuhu === 'normal') {
                $query->where('suhu_tubuh', '<', 37.5);
            } elseif ($filterSuhu === 'demam') {
                $query->where('suhu_tubuh', '>=', 37.5);
            }
        }

        if ($filterTanggal) {
            $query->whereDate('tanggal', $filterTanggal);
        }

        $perjalanans = $query->orderBy('tanggal', 'desc')
                             ->orderBy('jam', 'desc')
                             ->get();

        return view('masyarakat.riwayat', compact(
            'perjalanans', 
            'search', 
            'filterSuhu', 
            'filterTanggal',
            'totalLogs',
            'avgTemp',
            'highTempCount'
        ));
    }

    /**
     * Print-friendly view for personal travel logs.
     * SECURITY: Scoped to authenticated user's records only.
     */
    public function print(Request $request): View
    {
        $search = $request->input('search');
        $filterSuhu = $request->input('filter_suhu');
        $filterTanggal = $request->input('filter_tanggal');

        $user = Auth::user();
        $query = $user->perjalanans();

        if ($search) {
            $query->where('lokasi', 'like', '%' . $search . '%');
        }

        if ($filterSuhu) {
            if ($filterSuhu === 'normal') {
                $query->where('suhu_tubuh', '<', 37.5);
            } elseif ($filterSuhu === 'demam') {
                $query->where('suhu_tubuh', '>=', 37.5);
            }
        }

        if ($filterTanggal) {
            $query->whereDate('tanggal', $filterTanggal);
        }

        $perjalanans = $query->orderBy('tanggal', 'desc')
                             ->orderBy('jam', 'desc')
                             ->get();

        return view('masyarakat.print', compact('perjalanans', 'search', 'filterSuhu', 'filterTanggal'));
    }

    /**
     * Store a newly created travel log in storage.
     * SECURITY: Record is automatically associated with Auth::user()
     * via the relationship, preventing user_id spoofing.
     */
    public function store(PerjalananRequest $request): RedirectResponse
    {
        Auth::user()->perjalanans()->create($request->validated());

        return redirect()->route('perjalanan.riwayat')
            ->with('success', 'Catatan perjalanan baru berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified travel log.
     * SECURITY: Ownership verified via authorizeOwnership() guard.
     */
    public function edit(Perjalanan $perjalanan): View
    {
        $this->authorizeOwnership($perjalanan);

        return view('masyarakat.edit', compact('perjalanan'));
    }

    /**
     * Update the specified travel log in storage.
     * SECURITY: Ownership verified via authorizeOwnership() guard.
     */
    public function update(PerjalananRequest $request, Perjalanan $perjalanan): RedirectResponse
    {
        $this->authorizeOwnership($perjalanan);

        $perjalanan->update($request->validated());

        return redirect()->route('perjalanan.riwayat')
            ->with('success', 'Catatan perjalanan berhasil diperbarui!');
    }

    /**
     * Remove the specified travel log from storage.
     * SECURITY: Ownership verified via authorizeOwnership() guard.
     */
    public function destroy(Perjalanan $perjalanan): RedirectResponse
    {
        $this->authorizeOwnership($perjalanan);

        $perjalanan->delete();

        return redirect()->route('perjalanan.riwayat')
            ->with('success', 'Catatan perjalanan berhasil dihapus!');
    }
}
