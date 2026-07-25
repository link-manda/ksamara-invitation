<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Verifikasi - Samara Invitation</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f4f4f5; margin: 0; padding: 24px 16px; color: #18181b;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 520px; background-color: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e4e4e7; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); margin: 0 auto;">
        <!-- Header -->
        <tr>
            <td style="background-color: #09090b; padding: 24px; text-align: center; border-bottom: 3px solid #f59e0b;">
                <h1 style="color: #ffffff; font-size: 20px; margin: 0; font-weight: 700; letter-spacing: 0.5px;">
                    Samara<span style="color: #f59e0b;">Invitation</span>
                </h1>
            </td>
        </tr>

        <!-- Content -->
        <tr>
            <td style="padding: 32px 28px;">
                <h2 style="font-size: 18px; font-weight: 700; color: #09090b; margin-top: 0; margin-bottom: 16px;">
                    Halo, {{ $name }}!
                </h2>

                <p style="font-size: 14px; line-height: 1.6; color: #3f3f46; margin-bottom: 20px;">
                    Terima kasih telah mendaftar di <strong>Samara Invitation</strong>. Gunakan 6-digit kode OTP di bawah ini untuk memverifikasi alamat email Anda:
                </p>

                <!-- OTP Box -->
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 28px 0;">
                    <tr>
                        <td align="center">
                            <div style="background-color: #fef3c7; border: 2px dashed #f59e0b; padding: 18px 28px; border-radius: 14px; display: inline-block;">
                                <span style="font-family: 'Courier New', Courier, monospace; font-size: 32px; font-weight: 800; letter-spacing: 8px; color: #b45309; display: block;">
                                    {{ $otpCode }}
                                </span>
                            </div>
                        </td>
                    </tr>
                </table>

                <div style="background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 12px 16px; border-radius: 6px; margin-bottom: 24px;">
                    <p style="font-size: 12px; color: #92400e; margin: 0; line-height: 1.5;">
                        <strong>Catatan Keamanan:</strong> Kode OTP ini hanya berlaku selama <strong>10 menit</strong>. Mohon jaga kerahasiaan kode ini dan jangan berikan kepada pihak mana pun.
                    </p>
                </div>

                <p style="font-size: 13px; color: #71717a; margin-bottom: 0;">
                    Jika Anda tidak merasa mendaftar di Samara Invitation, Anda dapat mengabaikan email ini.
                </p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color: #fafafa; padding: 16px 28px; text-align: center; border-top: 1px solid #f4f4f5;">
                <p style="font-size: 12px; color: #a1a1aa; margin: 0;">
                    &copy; {{ date('Y') }} Samara Invitation. All rights reserved.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
