
<?php
require_once "../config/database.php";
require_once "../classes/User.php";

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    $user->first_name = $_POST['first_name'];
    $user->last_name = $_POST['last_name'];
    $user->phone = $_POST['phone']; // Optional, nur wenn du es auch im DB-Schema hast

    if ($user->emailExists()) {
        $message = "❌ E-Mail existiert bereits.";
    } elseif ($user->register()) {
        $message = "✅ Registrierung erfolgreich!";
    } else {
        $message = "❌ Registrierung fehlgeschlagen.";
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrieren - Coffee Delivery</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', Arial, sans-serif;
            background: linear-gradient(135deg, #8B4513 0%, #D2691E 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }

        .auth-container {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
            position: relative;
            overflow: hidden;
            margin: 1rem;
        }

        .auth-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #8B4513, #D2691E, #CD853F);
        }

        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
        }

        .logo h1 {
            color: #5C4434;
            margin-top: 1rem;
            font-size: 1.5rem;
            font-weight: 300;
        }

        .form-row {
            display: flex;
            gap: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
            flex: 1;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .form-group input:focus {
            outline: none;
            border-color: #8B4513;
            background: white;
            box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1);
        }

        .form-group input:valid {
            border-color: #28a745;
        }

        .form-group input:invalid:not(:placeholder-shown) {
            border-color: #dc3545;
        }

        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.875rem;
        }

        .strength-bar {
            height: 4px;
            background: #e0e0e0;
            border-radius: 2px;
            overflow: hidden;
            margin-top: 0.25rem;
        }

        .strength-fill {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak { background: #dc3545; width: 25%; }
        .strength-fair { background: #ffc107; width: 50%; }
        .strength-good { background: #17a2b8; width: 75%; }
        .strength-strong { background: #28a745; width: 100%; }

        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .checkbox-group input[type="checkbox"] {
            margin-top: 0.25rem;
            transform: scale(1.2);
        }

        .checkbox-group label {
            font-size: 0.875rem;
            line-height: 1.4;
            color: #666;
        }

        .checkbox-group a {
            color: #8B4513;
            text-decoration: none;
        }

        .checkbox-group a:hover {
            text-decoration: underline;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #8B4513, #D2691E);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(139, 69, 19, 0.3);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .divider {
            text-align: center;
            margin: 2rem 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e0e0e0;
        }

        .divider span {
            background: white;
            padding: 0 1rem;
            color: #666;
        }

        .auth-links {
            text-align: center;
        }

        .auth-links a {
            color: #8B4513;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .auth-links a:hover {
            color: #D2691E;
            text-decoration: underline;
        }

        .error {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 1rem;
            border-left: 4px solid #c33;
            font-size: 0.875rem;
        }

        .success {
            background: #efe;
            color: #3c3;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 1rem;
            border-left: 4px solid #3c3;
            font-size: 0.875rem;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            user-select: none;
        }

        .back-home {
            position: fixed;
            top: 20px;
            left: 20px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .back-home:hover {
            transform: translateX(-5px);
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
            
            .auth-container {
                margin: 0.5rem;
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <a href="index.php" class="back-home">
        ← Zurück zum Shop
    </a>

    <div class="auth-container">
        <div class="logo">
            <img src="image/CoffeeWebshop.png" alt="Coffee Delivery Logo">
            <h1>Konto erstellen</h1>
        </div>

        <div id="error-message" class="error" style="display: none;"></div>
        <div id="success-message" class="success" style="display: none;"></div>

        <form id="registerForm" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">Vorname *</label>
                    <input type="text" id="first_name" name="first_name" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Nachname *</label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email">E-Mail-Adresse *</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Telefonnummer</label>
                <input type="tel" id="phone" name="phone" placeholder="+49 123 456789">
            </div>

            <div class="form-group" style="position: relative;">
                <label for="password">Passwort *</label>
                <input type="password" id="password" name="password" required minlength="8">
                <span class="password-toggle" onclick="togglePassword('password')">👁️</span>
                <div class="password-strength">
                    <div class="strength-text">Passwortstärke: <span id="strength-text">Schwach</span></div>
                    <div class="strength-bar">
                        <div id="strength-fill" class="strength-fill"></div>
                    </div>
                </div>
            </div>

            <div class="form-group" style="position: relative;">
                <label for="confirm_password">Passwort bestätigen *</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <span class="password-toggle" onclick="togglePassword('confirm_password')">👁️</span>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">
                    Ich akzeptiere die <a href="TermsofService.php" target="_blank">AGB</a> 
                    und die <a href="PrivacyPolicy.php" target="_blank">Datenschutzerklärung</a> *
                </label>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="newsletter" name="newsletter">
                <label for="newsletter">
                    Ich möchte den Newsletter erhalten und über neue Kaffee-Angebote informiert werden
                </label>
            </div>

            <button type="submit" class="btn" id="submitBtn" disabled>Konto erstellen</button>
        </form>

        <div class="divider">
            <span>oder</span>
        </div>

        <div class="auth-links">
            <p>Bereits ein Konto? <a href="login.php">Hier anmelden</a></p>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggle = passwordInput.nextElementSibling;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggle.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggle.textContent = '👁️';
            }
        }

        function checkPasswordStrength(password) {
            let strength = 0;
            let text = 'Schwach';
            let className = 'strength-weak';

            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            switch(strength) {
                case 0:
                case 1:
                    text = 'Schwach';
                    className = 'strength-weak';
                    break;
                case 2:
                    text = 'Mäßig';
                    className = 'strength-fair';
                    break;
                case 3:
                case 4:
                    text = 'Gut';
                    className = 'strength-good';
                    break;
                case 5:
                    text = 'Stark';
                    className = 'strength-strong';
                    break;
            }

            return { text, className };
        }

        function validateForm() {
            const form = document.getElementById('registerForm');
            const submitBtn = document.getElementById('submitBtn');
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const terms = document.getElementById('terms').checked;

            const isValid = form.checkValidity() && 
                           password === confirmPassword && 
                           password.length >= 8 && 
                           terms;

            submitBtn.disabled = !isValid;

            // Password match validation
            const confirmField = document.getElementById('confirm_password');
            if (confirmPassword && password !== confirmPassword) {
                confirmField.setCustomValidity('Passwörter stimmen nicht überein');
            } else {
                confirmField.setCustomValidity('');
            }
        }

        // Event listeners
        document.getElementById('password').addEventListener('input', function() {
            const strength = checkPasswordStrength(this.value);
            document.getElementById('strength-text').textContent = strength.text;
            document.getElementById('strength-fill').className = `strength-fill ${strength.className}`;
            validateForm();
        });

        document.getElementById('registerForm').addEventListener('input', validateForm);
        document.getElementById('registerForm').addEventListener('change', validateForm);

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('action', 'register');
            
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Wird erstellt...';
            
            fetch('auth_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('success', 'Konto erfolgreich erstellt! Sie werden weitergeleitet...');
                    setTimeout(() => {
                        window.location.href = 'login.php';
                    }, 2000);
                } else {
                    showMessage('error', data.message);
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Konto erstellen';
                }
            })
            .catch(error => {
                showMessage('error', 'Ein Fehler ist aufgetreten. Bitte versuchen Sie es später erneut.');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Konto erstellen';
            });
        });

        function showMessage(type, message) {
            const errorDiv = document.getElementById('error-message');
            const successDiv = document.getElementById('success-message');
            
            if (type === 'error') {
                errorDiv.textContent = message;
                error