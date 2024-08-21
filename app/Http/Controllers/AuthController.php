<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Kirim permintaan ke API dengan header yang benar
        $response = Http::withHeaders([
            'Client-Service' => 'gmedia-recruitment',
            'Auth-Key' => 'demo-admin',
            'Content-Type' => 'application/json',
        ])->post('http://gmedia.bz/DemoCase/auth/login', [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ]);

        // Ambil data dari respons API
        $data = $response->json();

        // Cek jika permintaan berhasil
        if ($response->successful()) {
            // Periksa apakah kunci token ada di dalam respons
            if (isset($data['response']['token'])) {
                // Simpan token atau UID ke session
                $request->session()->put('token', $data['response']['token']);
                return redirect('/');
            } else {
                // Jika token tidak ditemukan dalam respons
                return back()->withErrors(['login' => 'Token not found in response.']);
            }
        } else {
            // Tangani kasus kesalahan
            $errorMessage = $data['metadata']['message'] ?? 'Login failed, please try again.';
            return back()->withErrors(['login' => $errorMessage]);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('token');
        return redirect('/login');
    }
}
