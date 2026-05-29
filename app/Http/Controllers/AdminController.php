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

    /**
     * View all registered users and their statistics.
     */
    public function users(Request $request): View
    {
        $users = User::withCount('perjalanans')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users', compact('users'));
    }

    /**
     * Delete a registered user and their associated data.
     */
    public function destroyUser(User $user): RedirectResponse
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Akun Administrator tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'Akun pengguna dan seluruh catatan perjalanannya berhasil dihapus.');
    }

    /**
     * Open a clean, printer-friendly view of the filtered travel logs.
     */
    public function print(Request $request): View
    {
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

        return view('admin.print', compact('perjalanans', 'search', 'filterSuhu', 'filterTanggal'));
    }
}
