<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BlockHistory;
use App\Models\Antrean;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModerasiPelangganController extends Controller
{
    /**
     * Display a listing of customers with their risk level and blocking status.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = User::role('user');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_whatsapp', 'like', "%{$search}%");
            });
        }

        // We fetch users and we can sort or filter by risk or block status
        $users = $query->paginate(10)->withQueryString();

        return view('admin.moderasi.index', compact('users', 'search'));
    }

    /**
     * Display detailed customer info, queue/booking history, and block action history.
     */
    public function show($id)
    {
        // Find user with role user
        $user = User::role('user')->findOrFail($id);

        // Fetch bookings/queues history (this is automatically scoped by TenantScope)
        $bookings = $user->antreans()
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch block history
        $histories = $user->blockHistories()
            ->with('admin')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.moderasi.show', compact('user', 'bookings', 'histories'));
    }

    /**
     * Block customer account.
     */
    public function block(Request $request, $id)
    {
        $user = User::role('user')->findOrFail($id);

        $request->validate([
            'reason' => 'required|string|max:1000',
        ], [
            'reason.required' => 'Alasan pemblokiran wajib diisi.',
        ]);

        $user->update([
            'is_blocked' => true,
            'blocked_reason' => $request->reason,
            'blocked_at' => now(),
        ]);

        BlockHistory::create([
            'user_id' => $user->id,
            'admin_id' => Auth::id(),
            'action' => 'block',
            'reason' => $request->reason,
        ]);

        return redirect()->back()->with('success', 'Akun pelanggan berhasil diblokir.');
    }

    /**
     * Unblock customer account.
     */
    public function unblock(Request $request, $id)
    {
        $user = User::role('user')->findOrFail($id);

        $user->update([
            'is_blocked' => false,
            'blocked_reason' => null,
            'blocked_at' => null,
        ]);

        BlockHistory::create([
            'user_id' => $user->id,
            'admin_id' => Auth::id(),
            'action' => 'unblock',
            'reason' => 'Dibuka blokir oleh admin.',
        ]);

        return redirect()->back()->with('success', 'Blokir akun pelanggan berhasil dibuka.');
    }

    /**
     * Reset risk statistics for the customer.
     */
    public function resetRisk(Request $request, $id)
    {
        $user = User::role('user')->findOrFail($id);

        $user->update([
            'reset_risk_at' => now(),
        ]);

        BlockHistory::create([
            'user_id' => $user->id,
            'admin_id' => Auth::id(),
            'action' => 'reset_risk',
            'reason' => 'Risiko di-reset oleh admin.',
        ]);

        return redirect()->back()->with('success', 'Indikator risiko pelanggan berhasil di-reset.');
    }
}
