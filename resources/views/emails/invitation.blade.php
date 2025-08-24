<!-- <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invitation</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <p>Hi {{ $first_name }},</p>
    <p>Are you ready to kickstart your wellness journey and unlock amazing benefits with Woliba?</p>
    <p>
        <a href="{{ $url }}" 
           style="display:inline-block; padding:12px 24px; background:#FF4C4C; color:#fff; text-decoration:none; border-radius:6px;">
            Register Now
        </a>
    </p>
    <p>After you register, download the Woliba app and log in using your email and password created during registration.</p>
    <p>In Health & Wellness,<br> The Woliba Team</p>
</body>
</html> -->
<!-- <!DOCTYPE html>
   <html>
   <head>
       <meta charset="UTF-8">
       <title>Invitation</title>
   </head>
   <body style="font-family: Arial, sans-serif; color: #333;">
       <p>Hi {{ $first_name }},</p>
       <p>Are you ready to kickstart your wellness journey and unlock amazing benefits with Woliba?</p>
       <p>
           <a href="{{ $url }}" 
              style="display:inline-block; padding:12px 24px; background:#FF4C4C; color:#fff; text-decoration:none; border-radius:6px;">
               Register Now
           </a>
       </p>
       <p>After you register, download the Woliba app and log in using your email and password created during registration.</p>
       <p>In Health & Wellness,<br> The Woliba Team</p>
   </body>
   </html> -->
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <title>Invitation Email</title>
   </head>
   <body style="margin:0; padding:0; background:#f6f9fc; font-family:Arial,Helvetica,sans-serif;">
      <!-- Outer wrapper -->
       
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f6f9fc;">
         <tr>
            <td align="center" style="padding:24px 12px;">
               <!-- CARD: body (top) -->
               <table role="presentation" width="600" cellpadding="0" cellspacing="0" 
                  style="background:#ffffff; border-radius:12px 12px 0 0;">
                  <!-- Logo -->
                  <tr>
                     <td align="center" style="padding:30px 24px 10px;">
                        <img src="{{ asset('images/logo.png') }}" alt="Woliba" width="150" style="display:block; border:0; outline:none;">
                     </td>
                  </tr>
                  <!-- Greeting -->
                  <tr>
                     <td style="padding:16px 40px 0; font-size:16px; color:#184A61; line-height:1.5; font-weight:bold;">
                        <p style="margin:0;">Hi {{ $first_name }},</p>
                     </td>
                  </tr>
                  <!-- Message -->
                  <tr>
                     <td style="padding:10px 40px 10px; font-size:16px; color:#184A61; line-height:1.4;">
                        <p style="margin:0;">
                           Are you ready to kickstart your wellness journey and unlock amazing benefits with Woliba?
                        </p>
                        <p style="margin:0;">
                            Just click the button below to get started:
                        </p>
                     </td>
                  </tr>
                  <!-- Bulletproof CTA -->
                  <tr>
                     <td align="center" style="padding:16px 24px 20px;">
                        <table role="presentation" cellpadding="0" cellspacing="0">
                           <tr>
                              <td bgcolor="#F37A65" style="border-radius:6px;">
                                 <a href="{{ $url }}" 
                                    style="display:inline-block; padding:12px 26px; font-size:16px; font-weight:600;
                                    color:#ffffff; text-decoration:none; border-radius:6px;">
                                 Register Now
                                 </a>
                              </td>
                           </tr>
                        </table>
                     </td>
                  </tr>
                  <!-- Outro -->
                  <tr>
                     <td style="padding:0 40px 28px; font-size:14px; color:#184A61; line-height:1.7;">
                        <p style="margin:0;">
                           After you register, download the Woliba app then login using your email and password created during registration.
                        </p>
                        <p style="margin:16px 0 0; font-weight:bold; color:#184A61;">
                           In Health &amp; Wellness,<br>
                           The Woliba team
                        </p>
                     </td>
                  </tr>
               </table>
               <!-- CARD: footer (bottom) -->
               <table role="presentation" width="600" cellpadding="0" cellspacing="0" 
                  style="background:#0b2b45; color:#ffffff; border-radius:0 0 12px 12px;">
                  <tr>
                     <td style="padding:0;">
                        <!-- two-column row wrapped with an inner table for robust alignment -->
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                           <tr>
                              <!-- Left column -->
                              <td width="60%" valign="top" style="padding:22px 20px; text-align:left;">
                                 <p style="margin:0 0 6px; font-size:14px; font-weight:700;">Contact Us</p>
                                 <p style="margin:0 0 14px; font-size:14px;">Support@woliba.io</p>
                                 <p style="margin:0 0 6px; font-size:14px; font-weight:700;">Follow Us</p>
                                 <table role="presentation" cellpadding="0" cellspacing="0">
                                    <tr>
                                       <td style="padding-right:10px;"><a href="#"><img src="{{ asset('images/facebook.png') }}" width="22" alt="Facebook" style="display:block; border:0;"></a></td>
                                       <td style="padding-right:10px;"><a href="#"><img src="{{ asset('images/youtube.png') }}"  width="22" alt="YouTube"  style="display:block; border:0;"></a></td>
                                       <td style="padding-right:10px;"><a href="#"><img src="{{ asset('images/twitter.png') }}"  width="22" alt="Twitter"  style="display:block; border:0;"></a></td>
                                       <td style="padding-right:10px;"><a href="#"><img src="{{ asset('images/linkedin.png') }}" width="22" alt="LinkedIn" style="display:block; border:0;"></a></td>
                                       <td><a href="#"><img src="{{ asset('images/instagram.png') }}" width="22" alt="Instagram" style="display:block; border:0;"></a></td>
                                    </tr>
                                 </table>
                              </td>
                              <!-- Right column -->
                              <td valign="top" width="40%" style="padding:22px 20px; text-align:right;">
                                 <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="right">
                                    <tr>
                                       <td style="padding-bottom:10px;">
                                          <a href="#"><img src="{{ asset('images/googleplay.png') }}" alt="Get it on Google Play" width="140" style="display:block; max-width:140px; height:auto;"></a>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <a href="#"><img src="{{ asset('images/appstore.png') }}" alt="Download on the App Store" width="140" style="display:block; max-width:140px; height:auto;"></a>
                                       </td>
                                    </tr>
                                 </table>
                              </td>
                           </tr>
                        </table>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
   </body>
</html>
