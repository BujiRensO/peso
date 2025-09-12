<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SupabaseOAuthController extends Controller
{
    /**
     * Redirect to Supabase Google OAuth
     */
    public function redirectToGoogle(): RedirectResponse
    {
        $supabaseUrl = config('services.supabase.url');
        $redirectUrl = url('/auth/callback');
        
        $params = [
            'provider' => 'google',
            'redirect_to' => $redirectUrl,
        ];
        
        $authUrl = $supabaseUrl . '/auth/v1/authorize?' . http_build_query($params);
        
        return redirect($authUrl);
    }

    /**
     * Handle Supabase OAuth callback
     */
    public function handleCallback(Request $request): RedirectResponse
    {
        try {
            // Get the access token from the request
            $accessToken = $request->get('access_token');
            $refreshToken = $request->get('refresh_token');
            
            if (!$accessToken) {
                Log::error('No access token received from Supabase');
                return redirect('/login')->with('error', 'Authentication failed. Please try again.');
            }

            // Verify the JWT token with Supabase
            $userData = $this->verifySupabaseToken($accessToken);
            
            if (!$userData) {
                Log::error('Failed to verify Supabase token');
                return redirect('/login')->with('error', 'Authentication failed. Please try again.');
            }

            // Find or create user
            $user = $this->findOrCreateUser($userData);
            
            // Log the user in
            Auth::login($user);
            
            // Store refresh token if provided
            if ($refreshToken) {
                session(['supabase_refresh_token' => $refreshToken]);
            }

            Log::info('User authenticated via Supabase OAuth', ['user_id' => $user->id, 'email' => $user->email]);
            
            return $this->redirectByRole($user->role);

        } catch (\Exception $e) {
            Log::error('Supabase OAuth callback error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Authentication failed. Please try again.');
        }
    }

    /**
     * Verify Supabase JWT token and get user data
     */
    private function verifySupabaseToken(string $accessToken): ?array
    {
        try {
            // Get user data from Supabase using the access token
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'apikey' => config('services.supabase.anon_key'),
            ])->get(config('services.supabase.url') . '/auth/v1/user');

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to get user data from Supabase', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('Error verifying Supabase token: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Find or create user from Supabase data
     */
    private function findOrCreateUser(array $supabaseUser): User
    {
        $email = $supabaseUser['email'] ?? null;
        $name = $supabaseUser['user_metadata']['full_name'] ?? 
                $supabaseUser['user_metadata']['name'] ?? 
                $supabaseUser['email'] ?? 
                'Unknown User';

        if (!$email) {
            throw new \Exception('No email found in Supabase user data');
        }

        // Find existing user by email
        $user = User::where('email', $email)->first();

        if ($user) {
            // Update existing user with latest data
            $user->update([
                'name' => $name,
                'email' => $email,
                // Ensure OAuth users are treated as verified
                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);
            
            Log::info('Updated existing user from Supabase OAuth', ['user_id' => $user->id]);
        } else {
            // Create new user
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt(str()->random(32)), // Random password since they'll use OAuth
                'role' => 'jobseeker', // Default role for OAuth users
                'email_verified_at' => now(),
            ]);
            
            Log::info('Created new user from Supabase OAuth', ['user_id' => $user->id]);
        }

        return $user;
    }

    /**
     * Redirect user based on their role
     */
    private function redirectByRole(?string $role): RedirectResponse
    {
        // Handle null or empty role by defaulting to jobseeker
        if (empty($role)) {
            $role = 'jobseeker';
        }

        if ($role === 'admin') {
            return redirect(route('admin.dashboard', absolute: false));
        }

        if ($role === 'superadmin') {
            return redirect(route('superadmin.dashboard', absolute: false));
        }

        if ($role === 'employer') {
            return redirect(route('employer.dashboard', absolute: false));
        }

        // Default redirect for jobseeker, user, or any other role
        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Logout and redirect to Supabase logout
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();
        
        // Clear Supabase session
        session()->forget('supabase_refresh_token');
        
        // Redirect to Supabase logout
        $supabaseUrl = config('services.supabase.url');
        $logoutUrl = $supabaseUrl . '/auth/v1/logout';
        
        return redirect($logoutUrl);
    }
}
