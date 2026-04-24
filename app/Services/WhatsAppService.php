<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $client;
    protected $whatsappNumber;

    public function __construct()
    {
        $accountSid = config('services.twilio.account_sid');
        $authToken = config('services.twilio.auth_token');

        if (!$accountSid || !$authToken) {
            throw new \Exception('Twilio credentials not configured in .env file');
        }

        $this->client = new Client($accountSid, $authToken);
        $this->whatsappNumber = config('services.twilio.whatsapp_number');
    }

    /**
     * Send WhatsApp message to student with credentials
     * 
     * @param string $phoneNumber - Student phone number (format: 62812345678 for Indonesia)
     * @param string $username - Generated username
     * @param string $password - Generated password
     * @param string $studentName - Student name
     * @return bool
     */
    public static function sendCredentials($phoneNumber, $username, $password, $studentName)
    {
        try {
            $service = new self();

            // Format message
            $message = "Halo {$studentName}! 👋\n\n";
            $message .= "Akun Anda telah berhasil dibuat di Sistem Perpustakaan Sekolah.\n\n";
            $message .= "📱 *Data Login Anda:*\n";
            $message .= "Username: *{$username}*\n";
            $message .= "Password: *{$password}*\n\n";
            $message .= "⚠️ Harap jaga kerahasiaan password Anda!\n";
            $message .= "🔗 Akses sistem di: http://your-domain.com\n\n";
            $message .= "Jika ada pertanyaan, hubungi admin perpustakaan.";

            // Format phone number with whatsapp prefix
            $formattedPhone = 'whatsapp:+' . $phoneNumber;

            // Send message via Twilio
            $service->client->messages->create(
                $formattedPhone,
                [
                    'from' => 'whatsapp:' . $service->whatsappNumber,
                    'body' => $message
                ]
            );

            Log::info('WhatsApp credentials sent', [
                'phone' => $phoneNumber,
                'student_name' => $studentName,
                'timestamp' => now()
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp notification', [
                'phone' => $phoneNumber,
                'error' => $e->getMessage(),
                'timestamp' => now()
            ]);

            throw $e;
        }
    }

    /**
     * Send generic WhatsApp message
     * 
     * @param string $phoneNumber - Recipient phone number
     * @param string $message - Message content
     * @return bool
     */
    public static function send($phoneNumber, $message)
    {
        try {
            $service = new self();

            $formattedPhone = 'whatsapp:+' . $phoneNumber;

            $service->client->messages->create(
                $formattedPhone,
                [
                    'from' => 'whatsapp:' . $service->whatsappNumber,
                    'body' => $message
                ]
            );

            Log::info('WhatsApp message sent', [
                'phone' => $phoneNumber,
                'timestamp' => now()
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp message', [
                'phone' => $phoneNumber,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }
}
