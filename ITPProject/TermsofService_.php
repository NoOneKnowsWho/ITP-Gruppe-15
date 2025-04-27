<?php

// Terms of Service, Impressum, Datenschutz und Logo für Coffee Delivery Website (in German)

echo "<header style=\"text-align:center; margin-bottom:30px;\">";
echo "<img src='Coffee Webshop.png' alt='Coffee Delivery Logo' style=\"width:150px;\">";
echo "<h1>Allgemeine Geschäftsbedingungen (AGB)</h1>";
echo "<nav style=\"margin-top:20px;\">";
echo "<a href='#agb' class='nav-button'>AGB</a>";
echo "<a href='#impressum' class='nav-button'>Impressum</a>";
echo "<a href='#datenschutz' class='nav-button'>Datenschutz</a>";
echo "</nav>";
echo "</header>";

echo "<section id='agb' style=\"padding: 20px;\">";
// Inhalte AGB

echo "<section id='impressum' style=\"margin-top:50px; padding: 20px;\">";
// Inhalte Impressum

echo "<section id='datenschutz' style=\"margin-top:50px; padding: 20px;\">";
// Inhalte Datenschutz

echo "<style>
    .nav-button {
        margin: 0 10px;
        padding: 10px 20px;
        background-color: #6f4e37;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
    }
    .nav-button:hover {
        background-color: #8b5e3c;
    }
</style>";

echo "<script>
    document.querySelectorAll('a[href^=\'#\']').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>";

?>