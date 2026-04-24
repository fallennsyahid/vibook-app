# 📱 Setup WhatsApp Notifications dengan Twilio

## Panduan Lengkap Integrasi Twilio WhatsApp

### 1. Persiapan Awal

**Requirement:**

- Akun Twilio (gratis dengan trial credits)
- No telepon aktif untuk verifikasi
- PHP Composer untuk install dependencies

---

## 2. Langkah Setup Twilio

### A. Buat Account Twilio

1. Kunjungi: https://www.twilio.com/try-twilio
2. Sign up dengan email
3. Verifikasi via SMS dengan nomor telepon
4. Dashboard akan terbuka

### B. Dapatkan Credentials

1. Masuk ke Twilio Console: https://console.twilio.com
2. Copy **Account SID** dan **Auth Token** (lihat di section "Account")
3. Simpen di tempat aman (akan dipakai di .env)

### C. Setup WhatsApp Sandbox

1. Pergi ke: https://console.twilio.com/sms/whatsapp/learn
2. Di section "Sandbox Settings":
    - Copy **Sandbox Number** (misalnya: +1234567890)
    - Simpen nomor ini

3. Untuk **testing**, add recipient:
    - Buka https://console.twilio.com/sms/whatsapp/sandbox
    - Di "Sandbox Participants", join dengan WhatsApp:
        - Send pesan ke Sandbox Number dari WhatsApp Anda
        - Text: `join [code]` (code tertera di dashboard)
    - Setelah join, Anda bisa terima test messages

### D. Production Setup (Optional - untuk production)

Jika ingin production (bukan sandbox):

1. Pergi ke: https://console.twilio.com/sms/whatsapp/senders
2. Request akses WhatsApp Business API
3. Tunggu approval dari Meta/Twilio (biasanya 1-2 hari)
4. Setup Business Account Anda

---

## 3. Instalasi Dependencies

### Install Twilio SDK

```bash
composer require twilio/sdk
```

### Verify installation

```bash
php artisan tinker
> use Twilio\Rest\Client;
> exit
```

---

## 4. Konfigurasi Environment (.env)

Tambahkan ke file `.env` Anda:

```env
# Twilio WhatsApp Configuration
TWILIO_ACCOUNT_SID=your_account_sid_here
TWILIO_AUTH_TOKEN=your_auth_token_here
TWILIO_WHATSAPP_NUMBER=+1234567890
```

**Ganti dengan credentials Anda:**

- `TWILIO_ACCOUNT_SID` → Dari Twilio Console Account SID
- `TWILIO_AUTH_TOKEN` → Dari Twilio Console Auth Token
- `TWILIO_WHATSAPP_NUMBER` → Sandbox Number dari WhatsApp Sandbox Settings

### Contoh (.env):

```env
TWILIO_ACCOUNT_SID=ACa1234567890abcdefg
TWILIO_AUTH_TOKEN=auth_token_abcdefghijklmnop
TWILIO_WHATSAPP_NUMBER=+1987654321
```

---

## 5. Testing WhatsApp Integration

### Test di Local

```bash
php artisan tinker
```

Paste code berikut:

```php
use App\Services\WhatsAppService;

// Format nomor: gunakan 62 untuk Indonesia
// Contoh: 62812345678 atau +62812345678
$phone = "62812345678";  // Ganti dengan nomor Anda
$username = "budi_siswa";
$password = "SecurePass123";
$name = "Budi Setiawan";

WhatsAppService::sendCredentials($phone, $username, $password, $name);
```

Jika berhasil, akan terima WhatsApp di nomor Anda dengan format:

```
Halo Budi Setiawan! 👋

Akun Anda telah berhasil dibuat di Sistem Perpustakaan Sekolah.

📱 Data Login Anda:
Username: budi_siswa
Password: SecurePass123

⚠️ Harap jaga kerahasiaan password Anda!
🔗 Akses sistem di: http://your-domain.com

Jika ada pertanyaan, hubungi admin perpustakaan.
```

---

## 6. Format Nomor Telepon

**Penting:** Twilio membutuhkan format nomor internasional!

### Indonesia

- ❌ Salah: `0812345678`
- ✅ Benar: `62812345678` atau `+62812345678`

### Cara Konversi

```
0812345678 → 62812345678
(hilangkan 0, tambah 62)
```

**System otomatis normalize nomor:**

- Input `0812345678` → Auto convert ke `62812345678` ✅

---

## 7. Troubleshooting

### Error: "Credentials not configured in .env file"

**Solusi:**

- Pastikan `.env` sudah punya `TWILIO_ACCOUNT_SID`, `TWILIO_AUTH_TOKEN`, `TWILIO_WHATSAPP_NUMBER`
- Run: `php artisan config:clear`
- Restart server: `php artisan serve`

### Error: "Authentication token was invalid"

**Solusi:**

- Copy ulang Auth Token dari https://console.twilio.com
- Pastikan tidak ada space atau karakter tambahan
- Update `.env` dan run `php artisan config:clear`

### Pesan tidak terkirim ke nomor

**Solusi:**

1. Cek format nomor (harus 62xxx untuk Indonesia)
2. Pastikan nomor sudah join WhatsApp Sandbox (untuk testing)
3. Cek Twilio Logs: https://console.twilio.com/sms/logs

### Production: Pesan tidak terkirim

**Solusi:**

- Pastikan sudah upgrade dari Sandbox ke Production
- Verify Business Account dengan Meta
- Update `TWILIO_WHATSAPP_NUMBER` dengan production number

---

## 8. Cek Log Pesan

Lihat history pengiriman di Laravel logs:

```bash
tail -f storage/logs/laravel.log
```

Atau di Twilio Console:
https://console.twilio.com/sms/logs

---

## 9. Biaya & Limits

### Twilio Sandbox (Testing)

- ✅ GRATIS untuk testing
- Max 100 participants
- Messages hanya ke yang sudah join
- Lifetime (tidak expire)

### Twilio Production

- Biaya per pesan (~$0.005 - $0.01 per SMS)
- Atau beli credit prepaid
- Bisa handle unlimited recipients

---

## 10. Integrasi ke Aplikasi

Setelah setup selesai, sistem otomatis akan:

1. ✅ Generate username & password untuk siswa baru
2. ✅ Kirim via WhatsApp otomatis saat admin buat akun
3. ✅ Format pesan professional dengan instruksi login

**Di Halaman Admin Manajemen Siswa:**

- Admin input data siswa
- Sistem auto-generate credentials
- Pesan WhatsApp dikirim otomatis
- Siswa bisa langsung login dengan credentials yang diterima

---

## 11. Keamanan

**Best Practice:**

- ✅ Jangan commit `.env` ke git
- ✅ Password di-hash di database, hanya ditampilkan saat pembuatan
- ✅ Gunakan HTTPS di production
- ✅ Setup rate limiting untuk prevent abuse
- ✅ Monitor WhatsApp API usage

---

## 12. Pertanyaan Umum

**Q: Berapa lama setup?**
A: ~15 menit jika semua lancar

**Q: Biayanya berapa?**
A: Gratis untuk testing (Sandbox). Production tergantung volume.

**Q: Bisa ganti provider WhatsApp?**
A: Ya, tapi perlu kode custom. Saat ini setup untuk Twilio saja.

**Q: Bagaimana jika Twilio down?**
A: Akun tetap terbuat, notifikasi WhatsApp gagal tapi tidak block proses.

---

## Support

Untuk pertanyaan lebih lanjut:

- Twilio Docs: https://www.twilio.com/docs/whatsapp
- Laravel Docs: https://laravel.com/docs
- Chat dengan Twilio Support: https://support.twilio.com
