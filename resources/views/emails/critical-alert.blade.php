<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urgent Wellness Alert</title>
</head>
<body style="margin:0; padding:0; background:#f8ebf1; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color:#1f2937;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f8ebf1; padding:32px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="max-width:600px; width:100%; background:#ffffff; border-radius:28px; overflow:hidden; box-shadow:0 24px 60px rgba(89, 29, 63, 0.14);">
                    <!-- Header Banner -->
                    <tr>
                        <td style="padding:40px 32px 20px; text-align:center; border-bottom:1px solid #f5d7e5; background: linear-gradient(135deg, #fff7fb 0%, #fff1f6 100%);">
                            @if(file_exists(public_path('images/Logo.png')))
                                <img src="{{ $message->embed(public_path('images/Logo.png')) }}" alt="PsyCheck Logo" width="80" style="display:inline-block; width:80px; max-width:80px; height:auto; border-radius:18px;">
                            @endif
                            <h1 style="margin:16px 0 0; font-size:24px; font-weight:800; line-height:1.2; color:#be185d; text-transform:uppercase; tracking:0.05em;">Support Circle Alert</h1>
                            <p style="margin:6px 0 0; font-size:14px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:0.15em;">PsyCheck Wellness Safeguard</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding:40px 32px; font-size:16px; line-height:1.8; color:#334155;">
                            <p style="margin:0 0 18px; font-weight:600; font-size:18px; color:#0f172a;">Hello,</p>
                            
                            <p style="margin:0 0 20px;">
                                You are receiving this notification because <strong>{{ $name }}</strong> has added you as their trusted support contact on their <strong>PsyCheck Holistic Wellbeing Account</strong>.
                            </p>
                            
                            <!-- Urgent Alert Card -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin:28px 0; width:100%;">
                                <tr>
                                    <td style="padding:28px 24px; background: linear-gradient(135deg, #e11d48 0%, #be123c 100%); border-radius:20px; box-shadow: 0 10px 25px rgba(225, 29, 72, 0.25);">
                                        <h3 style="margin:0 0 10px; font-size:13px; font-weight:800; color:#ffe4e6; text-transform:uppercase; letter-spacing:0.12em;">Urgent Status Update</h3>
                                        <p style="margin:0; font-size:16px; font-weight:600; color:#ffffff; line-height:1.6; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);">
                                            Your <strong>{{ $name }}</strong> has a serious issue. Please give some attention, as they need urgent counseling.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 20px;">
                                <strong>{{ $name }}</strong> recently completed a <strong>{{ ucfirst($track) }} Assessment</strong> and scored <strong>{{ $score }}%</strong> (wellness index), which represents a critically high level of stress, exhaustion, or somatic tension.
                            </p>

                            <p style="margin:0 0 28px;">
                                A score in this range suggests they might be going through extreme pressure, severe burnout, or emotional distress. Your support and presence could make a huge difference to them right now.
                            </p>

                            <!-- Call to Action Recommendation -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin:0 0 24px; width:100%;">
                                <tr>
                                    <td style="padding:20px; background:#fdf2f8; border-radius:16px; border:1px solid #fbcfe8; text-align:center;">
                                        <p style="margin:0 0 10px; font-size:14px; font-weight:700; color:#be185d; text-transform:uppercase; letter-spacing:0.05em;">Recommended Next Steps</p>
                                        <p style="margin:0; font-size:14px; color:#475569; line-height:1.6;">
                                            We recommend giving them a phone call, sending a warm message, or arranging to meet in person to check in on how they are holding up.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0; font-size:14px; color:#64748b;">
                                Thank you for being a part of {{ $name }}'s Support Circle. Let's make wellness a shared path.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="padding:24px 32px; background:#f8fafc; border-top:1px solid #f1f5f9; text-align:center; font-size:12px; color:#94a3b8; line-height:1.5;">
                            <p style="margin:0 0 6px; font-weight:600; color:#64748b;">PsyCheck © {{ date('Y') }}</p>
                            <p style="margin:0;">This is an automated alert sent on behalf of a user who designated you as a support contact. If you believe this is an error, please ignore this email.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
