
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
