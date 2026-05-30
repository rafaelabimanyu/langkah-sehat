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
     */
    public function riwayat(Request $request): View
    {
        $search = $request->input('search');
        $filterSuhu = $request->input('filter_suhu');
        $filterTanggal = $request->input('filter_tanggal');

        $user = Auth::user();
        
        // Analytics for the history page
        $totalLogs = $user->perjalanans()->count();
        $avgTemp = $user->perjalanans()->avg('suhu_tubuh') ?? 0;
        $highTempCount = $user->perjalanans()->where('suhu_tubuh', '>=', 37.5)->count();
        
        // Query Logs for Table
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
     */
    public function store(PerjalananRequest $request): RedirectResponse
    {
        Auth::user()->perjalanans()->create($request->validated());

        return redirect()->route('perjalanan.riwayat')
            ->with('success', 'Catatan perjalanan baru berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified travel log.
     */
    public function edit(Perjalanan $perjalanan): View
    {
        // Security check
        if ($perjalanan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        return view('masyarakat.edit', compact('perjalanan'));
    }

    /**
     * Update the specified travel log in storage.
     */
    public function update(PerjalananRequest $request, Perjalanan $perjalanan): RedirectResponse
    {
        // Security check
        if ($perjalanan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $perjalanan->update($request->validated());

        return redirect()->route('perjalanan.riwayat')
            ->with('success', 'Catatan perjalanan berhasil diperbarui!');
    }

    /**
     * Remove the specified travel log from storage.
     */
    public function destroy(Perjalanan $perjalanan): RedirectResponse
    {
        // Security check
        if ($perjalanan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $perjalanan->delete();

        return redirect()->route('perjalanan.riwayat')
            ->with('success', 'Catatan perjalanan berhasil dihapus!');
    }
}
