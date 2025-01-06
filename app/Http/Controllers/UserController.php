<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    //

    public function dashboard()
    {
        return view('auth.dashboard'); // Buat view sesuai kebutuhan
    }

    public function index()
    {
        $users = User::where('role', 'user')->paginate(5);

        return view('users.index', compact('users'));
    }

    // DataTables
    public function getData(Request $request)
    {
        $users = User::where('role', 'user')->select('users.*');

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($user) {
                return '
                    <div class="d-flex">
                        <a href="' . route('users.detail', $user->id) . '" class="btn btn-sm btn-dark mr-2"><i class="fa fa-eye"></i></a>
                    </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function showOrders($id)
    {
        $user = User::with('orders')->findOrFail($id);

        // Return data ke view
        return view('users.detail', compact('user'));
    }
}
