<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #640875;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        h1, h2, h3 {
            color: #444;
        }

        .hero h1 {
            color: #9f23b5;
        }        

        .hero {
            background-color: #2d1c30;
            color: #fff;
            padding: 50px 20px;
            text-align: center;
        }

        .contact-form {
            margin: 20px 0;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .contact-form h2 {
            margin-top: 0;
        }

        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .contact-form button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

    </style>
    <title>Nous contacter - Onzeur</title>
</head>
<body>
    <div class="hero">
        <h1>Nous contacter</h1>
        <p>N'hésitez pas à nous contacter pour toute question ou demande.</p>
    </div>

    <div class="container">
        <div class="contact-form">
            <h2>Formulaire de contact</h2>
            <form action="<?php echo site_url('contact/send_detailed_message'); ?>" method="post" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Votre nom" required><br>
                <input type="email" name="email" placeholder="Votre email" required><br>
                <textarea name="message" rows="5" placeholder="Votre message" required></textarea><br>
                <input type="file" name="attachment"><br>
                <button type="submit">Envoyer</button>
            </form>
        </div>
    </div>
</body>
</html>
