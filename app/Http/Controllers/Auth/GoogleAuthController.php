<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    /**
     * Mengarahkan pengguna ke halaman autentikasi Google.
     */
    public function redirect()
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    /**
     * Menangani callback dari Google.
     */
    public function callback()
    {
        try {
            $google = Socialite::driver('google')->user();

            $googleData = $google->user ?? [];

            $emailVerified = filter_var(
                data_get($googleData, 'email_verified', false),
                FILTER_VALIDATE_BOOLEAN
            );

            if (
                !$google->getId() ||
                !$google->getEmail() ||
                !$emailVerified
            ) {
                return redirect('/login')->with(
                    'error',
                    'Akun Google harus memiliki email terverifikasi.'
                );
            }

            $user = DB::transaction(function () use ($google) {
                $user = User::where(
                    'google_id',
                    $google->getId()
                )->first();

                if ($user) {
                    return $user;
                }

                $user = User::where(
                    'email',
                    $google->getEmail()
                )->first();

                // Jangan otomatis menghubungkan akun admin
                // dengan Google melalui alur login publik.
                if (
                    $user &&
                    $user->role === 'admin' &&
                    $user->google_id !== $google->getId()
                ) {
                    throw new \RuntimeException(
                        'Akun admin tidak dapat ditautkan melalui login Google publik.'
                    );
                }

                if (!$user) {
                    $user = new User();

                    $user->name = $google->getName()
                        ?: $google->getNickname()
                        ?: 'Pengguna MeowMap';

                    $user->email = $google->getEmail();
                    $user->password = Hash::make(
                        Str::random(48)
                    );

                    // Pendaftaran Google publik hanya untuk user.
                    $user->role = 'user';
                }

                $user->google_id = $google->getId();
                $user->save();

                return $user;
            });

            $token = $user->createToken(
                'meowmap-google'
            )->plainTextToken;

            session([
                'google_auth_token' => $token,
            ]);

            return redirect('/auth/google/complete');

        } catch (Throwable $exception) {
            Log::error('Google OAuth gagal', [
                'exception' => $exception::class,
                'message' => $exception->getMessage(),
            ]);

            return redirect('/login')->with(
                'error',
                'Login Google gagal. Silakan coba lagi.'
            );
        }
    }

    /**
     * Menyimpan token ke browser dan kembali ke halaman utama.
     */
    public function complete()
    {
        $token = session()->pull('google_auth_token');

        if (!$token) {
            return redirect('/login')->with(
                'error',
                'Sesi autentikasi Google tidak ditemukan. Silakan coba lagi.'
            );
        }

        return view('meowmap.google-complete', [
            'token' => $token,
        ]);
    }
}
