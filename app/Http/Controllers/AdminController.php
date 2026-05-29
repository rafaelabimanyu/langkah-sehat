<?php

namespace App\Http\Controllers;

use App\Models\Perjalanan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display the admin monitoring dashboard.
     */
    public function index(Request $request): View
    {
        // 1. Calculate Analytics
        $totalUsers = User::count();
        $totalLogs = Perjalanan::count();
        $highTempCount = Perjalanan::where('suhu_tubuh', '>=', 37.5)->count();

        // 2. Fetch Global Logs with Owner Info
        $search = $request->input('search');
        $filterSuhu = $request->input('filter_suhu');
        $filterTanggal = $request->input('filter_tanggal');

        $query = Perjalanan::with('user');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('lokasi', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%')
                               ->orWhere('email', 'like', '%' . $search . '%');
                  });
            });
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

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalLogs',
            'highTempCount',
            'perjalanans',
            'search',
            'filterSuhu',
            'filterTanggal'
        ));
    }

    /**
     * Delete an anomalous log.
     */
    public function destroy(Perjalanan $perjalanan): RedirectResponse
    {
        $perjalanan->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Catatan perjalanan anomalus berhasil dihapus oleh Admin!');
    }
}
