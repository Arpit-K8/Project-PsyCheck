<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body style="margin:0; padding:0; background:#f8ebf1; font-family: Arial, sans-serif; color:#1f2937;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f8ebf1; padding:32px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="max-width:600px; width:100%; background:#ffffff; border-radius:24px; overflow:hidden; box-shadow:0 20px 50px rgba(89, 29, 63, 0.16);">
                    <tr>
                        <td style="padding:32px 32px 16px; text-align:center; border-bottom:1px solid #f5d7e5;">
                            <img src="{{ $message->embed(public_path('images/Logo.png')) }}" alt="PsyCheck Logo" width="96" style="display:inline-block; width:96px; max-width:96px; height:auto; border:0; outline:none; text-decoration:none; border-radius:18px;">
                            <h1 style="margin:18px 0 0; font-size:26px; line-height:1.2; color:#be185d;">Reset Password</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px; font-size:16px; line-height:1.7; color:#334155;">
                            <p style="margin:0 0 16px;">You are receiving this email because we received a password reset request for your account.</p>

                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" style="margin:0 auto 24px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $resetUrl }}" style="display:inline-block; background:#be185d; color:#ffffff; text-decoration:none; padding:14px 24px; border-radius:999px; font-weight:bold;">Reset Password</a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 16px;">This password reset link will expire in {{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire') }} minutes.</p>

                            <p style="margin:0;">If you did not request a password reset, no further action is required.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>