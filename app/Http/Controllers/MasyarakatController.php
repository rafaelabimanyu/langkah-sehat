<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerjalananRequest;
use App\Models\Perjalanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MasyarakatController extends Controller
{
    /**
     * Display a listing of the user's travel logs.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $filterSuhu = $request->input('filter_suhu'); // 'normal' (<37.5) or 'demam' (>=37.5)
        $filterTanggal = $request->input('filter_tanggal');

        $query = Auth::user()->perjalanans();

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

        // Paginate or get logs sorted by newest
        $perjalanans = $query->orderBy('tanggal', 'desc')
                             ->orderBy('jam', 'desc')
                             ->get();

        return view('masyarakat.dashboard', compact('perjalanans', 'search', 'filterSuhu', 'filterTanggal'));
    }

    /**
     * Show the form for creating a new travel log.
     */
    public function create(): View
    {
        return view('masyarakat.create');
    }

    /**
     * Store a newly created travel log in storage.
     */
    public function store(PerjalananRequest $request): RedirectResponse
    {
        Auth::user()->perjalanans()->create($request->validated());

        return redirect()->route('masyarakat.dashboard')
            ->with('success', 'Catatan perjalanan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified travel log.
     */
    public function edit(Perjalanan $perjalanan): View
    {
        // Security check: ensure user owns the travel log
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
        // Security check: ensure user owns the travel log
        if ($perjalanan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $perjalanan->update($request->validated());

        return redirect()->route('masyarakat.dashboard')
            ->with('success', 'Catatan perjalanan berhasil diperbarui!');
    }

    /**
     * Remove the specified travel log from storage.
     */
    public function destroy(Perjalanan $perjalanan): RedirectResponse
    {
        // Security check: ensure user owns the travel log
        if ($perjalanan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $perjalanan->delete();

        return redirect()->route('masyarakat.dashboard')
            ->with('success', 'Catatan perjalanan berhasil dihapus!');
    }
}
