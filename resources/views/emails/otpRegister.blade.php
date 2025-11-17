<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Email Template</title>

  <!-- gaya dasar (dipertahankan sederhana agar kompatibel dengan email client) -->
  <style>
    /* Reset sederhana */
    body, table, td, a { -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; }
    table { border-collapse: collapse !important; }
    img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; display: block; }

    /* Responsif: breakpoint sederhana */
    @media only screen and (max-width: 600px) {
      .container { width: 100% !important; padding: 16px !important; }
      .content { padding: 16px !important; }
      .footer td { font-size: 12px !important; }
    }
  </style>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4; font-family: Arial, Helvetica, sans-serif;">

  <!-- Wrapper -->
  <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#f4f4f4; padding: 24px 0; margin-top: 30px;">
    <tr>
      <td align="center">

        <!-- Container (fixed width for desktop, fluid for mobile) -->
        <table class="container" width="600" cellpadding="0" cellspacing="0" role="presentation" style="width:600px; max-width:600px; background-color:#ffffff; border-radius:8px; overflow:hidden;">
          
          <!-- Header: logo tengah -->
          <tr>
            <td style="padding:24px 24px 0 24px; text-align:center; background-color: #ffffff;">
              <!-- Ganti src dengan URL logo Anda -->
              <img src="https://anxietive.com/images/logo/anxietive_logo.PNG" alt="anxietive.com" width="160" style="display:block; margin:0 auto; max-width:160px; height:auto;">
            </td>
          </tr>

          <!-- Divider tipis -->
          <tr>
            <td style="padding:12px 24px 0 24px;">
              <hr style="border:none; border-top:1px solid #eeeeee; margin:0;">
            </td>
          </tr>

          <!-- Body content -->
          <tr>
            <td class="content" style="padding:24px; color:#333333; font-size:15px; line-height:1.6;">
              <h5 style="margin:0 0 12px 0; font-size:16px; color:#111111;">Halo, {{ $fullname }}</h2>
              
              <p style="margin:0 0 12px 0;">
                Berikut adalah <b>kode OTP</b> untuk verifikasi akun Anda: <br>
                <center><b style="font-size: 24px;">{{ $otp_code }}</b></center>

                <br>

                Kode ini hanya berlaku selama 24 jam. Jangan bagikan kode ini kepada siapa pun demi keamanan akun Anda.
                
                <br>
                <br> Terima kasih,
                <br> Anxietive
              </p>


            </td>
          </tr>

          <!-- Spacer -->
          <tr><td style="padding-bottom:0;"></td></tr>

        <!-- Footer: background hitam rata tengah -->
        <tr>
        <td class="footer" style="background-color:#000000; padding:24px; color:#ffffff; text-align:center;">
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td style="font-size:13px; color:#ffffff; text-align:center;">

                <strong>Anxietive Self Photo</strong><br>
                Jl. Cempedak I No.3, Pekanbaru, Riau.<br>
                <span style="color:#bfbfbf; font-size:12px;">&copy; 2025 All Rights Reserved</span>

                <!-- Spasi -->
                <div style="height:14px;"></div>

                <!-- Ikon Sosial (SVG inline, rata tengah) -->
                <table cellpadding="0" cellspacing="0" align="center" role="presentation" style="margin:0 auto;">
                    <tr>
                    <!-- Instagram -->
                    <td style="padding:0 8px;">
                        <a href="#" style="text-decoration:none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 24 24">
                            <path d="M7.5 2h9A5.5 5.5 0 0 1 22 7.5v9A5.5 5.5 0 0 1 16.5 22h-9A5.5 5.5 0 0 1 2 16.5v-9A5.5 5.5 0 0 1 7.5 2zm0 2A3.5 3.5 0 0 0 4 7.5v9A3.5 3.5 0 0 0 7.5 20h9a3.5 3.5 0 0 0 3.5-3.5v-9A3.5 3.5 0 0 0 16.5 4h-9zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6zm4.75-2.75a.75.75 0 1 1 0 1.5.75.75 0 0 1 0-1.5z"/>
                        </svg>
                        </a>
                    </td>

                    <!-- Facebook -->
                    <td style="padding:0 8px;">
                        <a href="#" style="text-decoration:none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 24 24">
                            <path d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2v-2.9h2V9.8c0-2 1.2-3.1 3-3.1.9 0 1.8.2 1.8.2v2h-1c-1 0-1.3.6-1.3 1.2v1.5h2.3l-.4 2.9h-1.9v7A10 10 0 0 0 22 12z"/>
                        </svg>
                        </a>
                    </td>

                    <!-- TikTok -->
                    <td style="padding:0 8px;">
                        <a href="#" style="text-decoration:none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 24 24">
                            <path d="M12.9 2h2.1a5.6 5.6 0 0 0 5.5 5.5V9a7.7 7.7 0 0 1-4.5-1.4v6.6a6.2 6.2 0 1 1-6.2-6.2c.2 0 .3 0 .5.1v2.1a3.8 3.8 0 1 0 2.1 3.4V2z"/>
                        </svg>
                        </a>
                    </td>
                    </tr>
                </table>

                <!-- Spasi -->
                <div style="height:14px;"></div>

                <!-- Unsubscribe -->
                <a href="#" style="color:#bfbfbf; text-decoration:underline; font-size:12px;">Unsubscribe</a>

                </td>
            </tr>
            </table>
        </td>
        </tr>


        </table>
        <!-- end container -->

      </td>
    </tr>
  </table>

</body>
</html>
