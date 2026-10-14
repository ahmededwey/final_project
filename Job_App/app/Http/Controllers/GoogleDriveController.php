<?php

namespace App\Http\Controllers;

use App\Models\GoogleDriveCredential;
use App\Services\GoogleDriveException;
use App\Services\GoogleDriveService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GoogleDriveController extends Controller
{
    public function connect(Request $request, GoogleDriveService $googleDrive): RedirectResponse
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $state = Str::random(40);
        $request->session()->put('google_drive.oauth_state', $state);

        try {
            return redirect()->away($googleDrive->authorizationUrl($state));
        } catch (GoogleDriveException $exception) {
            return back()->withErrors(['google_drive' => $exception->getMessage()]);
        }
    }

    public function callback(Request $request, GoogleDriveService $googleDrive): RedirectResponse
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $expectedState = $request->session()->pull('google_drive.oauth_state');
        $providedState = $request->string('state')->toString();

        if (! is_string($expectedState) || $expectedState === '' || ! hash_equals($expectedState, $providedState)) {
            abort(403, 'Invalid Google Drive authorization state.');
        }

        if ($request->filled('error')) {
            return redirect()->route('dashboard')
                ->withErrors(['google_drive' => 'Google Drive authorization was cancelled.']);
        }

        $code = $request->string('code')->toString();

        if ($code === '') {
            return redirect()->route('dashboard')
                ->withErrors(['google_drive' => 'Google did not return an authorization code.']);
        }

        try {
            $tokens = $googleDrive->exchangeAuthorizationCode($code);
            $credential = GoogleDriveCredential::query()->firstOrNew(['id' => 'primary']);

            if ($tokens['refresh_token'] === null && ! $credential->refreshToken) {
                return redirect()->route('dashboard')
                    ->withErrors(['google_drive' => 'Google did not provide offline access. Please reconnect and approve Drive access.']);
            }

            $credential->connectedByUserId = $request->user()->id;
            $credential->accessToken = $tokens['access_token'];
            $credential->refreshToken = $tokens['refresh_token'] ?? $credential->refreshToken;
            $credential->expiresAt = now()->addSeconds($tokens['expires_in']);
            $credential->save();
        } catch (GoogleDriveException $exception) {
            Log::error('Google Drive authorization failed.', [
                'user_id' => $request->user()->id,
                'exception' => $exception,
            ]);

            return redirect()->route('dashboard')
                ->withErrors(['google_drive' => 'Google Drive could not be connected. Check the OAuth settings and try again.']);
        }

        return redirect()->route('dashboard')->with('status', 'Google Drive connected successfully.');
    }
}
