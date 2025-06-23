<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Vielen Dank!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background-color: #f7f7f7;
            overflow: hidden;
        }

        .thank-you-message {
            font-size: 24px;
            color: #333;
            margin-bottom: 40px;
            z-index: 1;
            position: relative;
        }

        .images {
            display: flex;
            justify-content: center;
            gap: 30px;
            z-index: 1;
            position: relative;
        }

        .images img {
            max-width: 300px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        /* Confetti styles */
        .confetti {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .confetti-piece {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: red;
            opacity: 0.7;
            animation: fall linear infinite;
        }

        @keyframes fall {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="thank-you-message">
        <?php
            echo "Vielen Dank für die Nutzung unserer Website!";
        ?>
    </div>

    <div class="images">
        <img src="image/Michi.jpg" alt="Bild 1">
        <img src="image/Clown.jpg" alt="Bild 2">
    </div>

    <!-- Confetti container -->
    <div class="confetti" id="confetti-container"></div>

    <script>
        const confettiContainer = document.getElementById('confetti-container');
        const colors = ['#ff0', '#f0f', '#0ff', '#0f0', '#f00', '#00f'];

        function createConfettiPiece() {
            const piece = document.createElement('div');
            piece.classList.add('confetti-piece');
            piece.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            piece.style.left = Math.random() * 100 + 'vw';
            piece.style.animationDuration = (Math.random() * 3 + 2) + 's';
            piece.style.width = piece.style.height = (Math.random() * 8 + 4) + 'px';
            confettiContainer.appendChild(piece);

            // Remove piece after animation
            setTimeout(() => {
                confettiContainer.removeChild(piece);
            }, 5000);
        }

        // Loop to generate confetti
        setInterval(() => {
            for (let i = 0; i < 5; i++) {
                createConfettiPiece();
            }
        }, 300);
    </script>
    <?php include 'footer.php'; ?>

</body>
</html>

