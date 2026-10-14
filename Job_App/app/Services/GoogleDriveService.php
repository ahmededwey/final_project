<?php

namespace App\Services;

use App\Models\GoogleDriveCredential;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GoogleDriveService
{
    private const string TOKEN_URL = 'https://oauth2.googleapis.com/token';

    private const string DRIVE_UPLOAD_URL = 'https://www.googleapis.com/upload/drive/v3/files';

    public function authorizationUrl(string $state): string
    {
        return 'https://accounts.google.com/o/oauth2/v2/auth?'.http_build_query([
            'client_id' => $this->clientId(),
            'redirect_uri' => config('services.google_drive.redirect_uri'),
            'response_type' => 'code',
            'scope' => 'https://www.googleapis.com/auth/drive.file',
            'access_type' => 'offline',
            'prompt' => 'consent',
            'state' => $state,
        ]);
    }

    /**
     * @return array{access_token: string, refresh_token: ?string, expires_in: int}
     */
    public function exchangeAuthorizationCode(string $code): array
    {
        return $this->requestToken([
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => config('services.google_drive.redirect_uri'),
        ]);
    }

    /**
     * @return array{id: string, name: string, webViewLink: ?string}
     */
    public function uploadResume(UploadedFile $file): array
    {
        $credential = GoogleDriveCredential::query()->find('primary');

        if (! $credential) {
            throw new GoogleDriveException('Google Drive has not been connected by an administrator.');
        }

        if ($credential->expiresAt === null || $credential->expiresAt->isPast()) {
            $tokens = $this->refreshAccessToken($credential);
            $credential->accessToken = $tokens['access_token'];
            $credential->expiresAt = now()->addSeconds($tokens['expires_in']);
            $credential->save();
        }

        $folderId = config('services.google_drive.folder_id');

        if (! is_string($folderId) || $folderId === '') {
            throw new GoogleDriveException('The Google Drive destination folder is not configured.');
        }

        $name = basename(str_replace('\\', '/', $file->getClientOriginalName()));
        $mimeType = $file->getMimeType() ?: 'application/octet-stream';
        $boundary = 'drive-'.Str::random(32);
        $metadata = json_encode([
            'name' => $name,
            'parents' => [$folderId],
        ], JSON_THROW_ON_ERROR);
        $body = "--{$boundary}\r\n".
            "Content-Type: application/json; charset=UTF-8\r\n\r\n".
            "{$metadata}\r\n".
            "--{$boundary}\r\n".
            "Content-Type: {$mimeType}\r\n\r\n".
            $file->getContent()."\r\n".
            "--{$boundary}--";

        try {
            $response = Http::withToken($credential->accessToken)
                ->acceptJson()
                ->withBody($body, "multipart/related; boundary={$boundary}")
                ->post(self::DRIVE_UPLOAD_URL.'?uploadType=multipart&fields=id,name,webViewLink');
        } catch (ConnectionException $exception) {
            throw new GoogleDriveException('Google Drive could not be reached. Please try again.', previous: $exception);
        }

        if (! $response->successful()) {
            throw new GoogleDriveException('Google Drive rejected the resume upload.');
        }

        $uploadedFile = $response->json();

        if (! is_array($uploadedFile) || ! is_string($uploadedFile['id'] ?? null)) {
            throw new GoogleDriveException('Google Drive returned an invalid upload response.');
        }

        return [
            'id' => $uploadedFile['id'],
            'name' => is_string($uploadedFile['name'] ?? null) ? $uploadedFile['name'] : $name,
            'webViewLink' => is_string($uploadedFile['webViewLink'] ?? null) ? $uploadedFile['webViewLink'] : null,
        ];
    }

    /**
     * @param  array<string, string>  $parameters
     * @return array{access_token: string, refresh_token: ?string, expires_in: int}
     */
    private function requestToken(array $parameters): array
    {
        $clientSecret = config('services.google_drive.client_secret');

        if (! is_string($clientSecret) || $clientSecret === '') {
            throw new GoogleDriveException('The Google Drive OAuth client secret is not configured.');
        }

        try {
            $response = Http::asForm()->acceptJson()->post(self::TOKEN_URL, [
                ...$parameters,
                'client_id' => $this->clientId(),
                'client_secret' => $clientSecret,
            ]);
        } catch (ConnectionException $exception) {
            throw new GoogleDriveException('Google authorization could not be reached. Please try again.', previous: $exception);
        }

        if (! $response->successful()) {
            throw new GoogleDriveException('Google authorization failed. Please check the OAuth configuration and try again.');
        }

        $tokens = $response->json();

        if (! is_array($tokens) || ! is_string($tokens['access_token'] ?? null)) {
            throw new GoogleDriveException('Google returned an invalid authorization response.');
        }

        return [
            'access_token' => $tokens['access_token'],
            'refresh_token' => is_string($tokens['refresh_token'] ?? null) ? $tokens['refresh_token'] : null,
            'expires_in' => is_numeric($tokens['expires_in'] ?? null) ? max(1, (int) $tokens['expires_in']) : 3600,
        ];
    }

    /**
     * @return array{access_token: string, refresh_token: ?string, expires_in: int}
     */
    private function refreshAccessToken(GoogleDriveCredential $credential): array
    {
        if (! $credential->refreshToken) {
            throw new GoogleDriveException('Reconnect Google Drive to restore upload access.');
        }

        return $this->requestToken([
            'refresh_token' => $credential->refreshToken,
            'grant_type' => 'refresh_token',
        ]);
    }

    private function clientId(): string
    {
        $clientId = config('services.google_drive.client_id');

        if (! is_string($clientId) || $clientId === '') {
            throw new GoogleDriveException('The Google Drive OAuth client ID is not configured.');
        }

        return $clientId;
    }
}
