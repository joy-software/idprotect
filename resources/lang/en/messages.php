<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pagination Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the paginator library to build
    | the simple pagination links. You are free to change them to anything
    | you want to customize your views to better match your application.
    |
    */

    'previous' => '&laquo; Previous',
    'next' => 'Next &raquo;',
    'emptyResultMessage' => 'No relevant results found.',
    'beforeResult' => 'About ',
    'afterResult' => ' result(s) among the most relevant.',
    'login1' =>  '"To be safe is to be able',
    'login2' =>  'To show oneself to the world',
    'login3' =>  ' without fear."',
    'login4' =>  'Remember me',
    'login5' =>  'Sign in with',
    'login6' =>  'Forgot password',
    'login7' =>  'Sign Up',
    'login8' =>  'Resend Code Activation',
    'register1' =>  'Your name',
    'register2' =>  'Confirmation Password',
    'register3' =>  'Login',
    'register4' =>  'Password',
    'register5' =>  'I agree with the ',
    'register6' =>  'Privacy Policy',
    'register7' =>  ' and commit me to the ',
    'register8' =>  'Terms and Conditions',
    'email' => 'Send Reset Link',
    'register' => [
        'success' => 'We sent you an activation code. Please check your email.',
        'already_activated' => 'This account is already activated',
        'not_found_activationKey' => 'We could not find a user with this activation key! Please register to get a valid key',
    ],

    'activationMail' => [
        'subject' => 'Your Account Activation Key',
        'line1' => 'You need to activate your email before you can start using all of our services.',
        'line2' => 'Click on the button below to activate.',
        'action' => 'Activate Your Account',
        'line3' => 'Thank you for using ',
    ],
    'activated' => [
        'already' => 'Your email is already activated.',
        'expire' => 'The provided activation key appears to be invalid',
        'success' => 'You successfully activated your email! You can now login',
        'missing' => 'We could not find this email in our system',
        'resend' => 'The activation email has been re-sent.',
    ],
    'loginController' => [
        'notActivated' => 'Can not access: Your account not validated. To access the application
                        Follow the validation link sent to the by e-mail at the address ',
    ],
    'email_blade' => [
        'salutation' => 'Regards',
        'footer 1'   =>  'If you’re having trouble clicking the ',
        'footer 2'   =>  'button, copy and paste the URL below into your web browser: ',
        'email_line1' => 'You are receiving this email because we received a password reset request for your account.',
        'email_line2' => 'Reset Password',
        'email_line3' => 'If you did not request a password reset, no further action is required.',
    ]
];
