<?php

function getMailBody($type, $name, $verificationLink = null)
{
    switch ($type) {
        case 'verification':
            return "
                <html>
                <head>
                <title>Email de vérification</title>
                </head>
                <body>
                <p>Bonjour $name,</p>
                <p>Merci de vous être inscrit. Veuillez cliquer sur le lien ci-dessous pour vérifier votre adresse mail et activer votre compte :</p>
                <a href='$verificationLink'>Vérifiez mon mail</a>
                <p>Ce lien expirera dans 2 heures et 15 minutes.</p>
                </body>
                </html>
            ";

        case 'adminNotification':
            return "
                <html>
                <head>
                <title>Information de création de compte</title>
                </head>
                <body>
                <p>Bonjour Admin,</p>
                <p>\"$name\" vient tout juste de créer son compte sur le site <a href='http://orbit.julien-synaeve.fr/'>O.R.B.I.T.</a></p>
                </body>
                </html>
            ";

        default:
            return "
                <html>
                <head>
                <title>Information</title>
                </head>
                <body>
                <p>Bonjour $name,</p>
                <p>Veuillez prendre note de ce message. Merci.</p>
                </body>
                </html>
            ";
    }
}
