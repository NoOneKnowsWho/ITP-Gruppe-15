
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrewMaster Coffee Shop</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #8B4513, #D2691E, #CD853F);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="90" r="2.5" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="60" r="1.2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Auth Container Styles */
        .auth-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo h1 {
            color: #8B4513;
            font-size: 2.5em;
            margin-bottom: 5px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo p {
            color: #666;
            font-size: 0.9em;
            font-style: italic;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 0.95em;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-group input:focus {
            outline: none;
            border-color: #D2691E;
            box-shadow: 0 0 0 3px rgba(210, 105, 30, 0.1);
            transform: translateY(-2px);
        }

        .btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #D2691E, #8B4513);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 69, 19, 0.3);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .message {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .message.success {
            background: rgba(76, 175, 80, 0.1);
            border: 1px solid #4CAF50;
            color: #2E7D32;
        }

        .message.error {
            background: rgba(244, 67, 54, 0.1);
            border: 1px solid #f44336;
            color: #C62828;
        }

        .auth-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .auth-link a {
            color: #D2691E;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .auth-link a:hover {
            color: #8B4513;
        }

        .strength-meter {
            margin-top: 8px;
            height: 4px;
            background: #e0e0e0;
            border-radius: 2px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .strength-fill {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak { background: #f44336; width: 33%; }
        .strength-medium { background: #ff9800; width: 66%; }
        .strength-strong { background: #4caf50; width: 100%; }

        .requirement {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .requirement.met {
            color: #4caf50;
        }

        /* Shop Styles */
        .shop-container {
            display: none;
            background: rgba(255, 255, 255, 0.95);
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        .header {
            background: rgba(139, 69, 19, 0.95);
            color: white;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .nav {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .nav h1 {
            font-size: 2em;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .cart-count {
            background: #D2691E;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }

        .logout-btn {
            background: transparent;
            border: 2px solid white;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: white;
            color: #8B4513;
        }

        .shop-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .product-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #D2691E, #8B4513);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3em;
            margin-bottom: 20px;
        }

        .product-title {
            font-size: 1.3em;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .product-description {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .product-price {
            font-size: 1.5em;
            font-weight: bold;
            color: #D2691E;
            margin-bottom: 20px;
        }

        .add-to-cart {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #D2691E, #8B4513);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .add-to-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(139, 69, 19, 0.3);
        }

        .welcome-message {
            text-align: center;
            margin-bottom: 20px;
            padding: 20px;
            background: rgba(210, 105, 30, 0.1);
            border-radius: 10px;
            border-left: 4px solid #D2691E;
        }

        .page {
            display: none;
        }

        .page.active {
            display: block;
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
                margin: 20px;
            }
            
            .logo h1 {
                font-size: 2em;
            }

            .nav {
                flex-direction: column;
                gap: 15px;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Registration Page -->
    <div id="registerPage" class="page active">
        <div class="auth-container">
            <div class="container">
                <div class="logo">
                    <h1>☕ BrewMaster</h1>
                    <p>Premium Coffee Experience</p>
                </div>

                <div id="registerMessage" class="message" style="display: none;"></div>

                <form id="registrationForm">
                    <div class="form-group">
                        <label for="regUsername">Username</label>
                        <input type="text" id="regUsername" name="username" required minlength="3" maxlength="50">
                        <div class="requirement" id="usernameReq">Username must be 3-50 characters long</div>
                    </div>

                    <div class="form-group">
                        <label for="regPassword">Password</label>
                        <input type="password" id="regPassword" name="password" required minlength="6">
                        <div class="strength-meter">
                            <div class="strength-fill" id="strengthFill"></div>
                        </div>
                        <div class="requirement" id="passwordReq">Password must be at least 6 characters long</div>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" required>
                        <div class="requirement" id="confirmReq">Passwords must match</div>
                    </div>

                    <button type="submit" class="btn">Create Account</button>
                </form>

                <div class="auth-link">
                    Already have an account? <a href="#" id="showLoginBtn">Sign in here</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Page -->
    <div id="loginPage" class="page">
        <div class="auth-container">
            <div class="container">
                <div class="logo">
                    <h1>☕ BrewMaster</h1>
                    <p>Welcome Back!</p>
                </div>

                <div id="loginMessage" class="message" style="display: none;"></div>

                <form id="loginForm">
                    <div class="form-group">
                        <label for="loginUsername">Username</label>
                        <input type="text" id="loginUsername" name="username" required>
                    </div>

                    <div class="form-group">
                        <label for="loginPassword">Password</label>
                        <input type="password" id="loginPassword" name="password" required>
                    </div>

                    <button type="submit" class="btn">Sign In</button>
                </form>

                <div class="auth-link">
                    Don't have an account? <a href="#" id="showRegisterBtn">Create one here</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Shop Page -->
    <div id="shopPage" class="page">
        <div class="shop-container">
            <header class="header">
                <nav class="nav">
                    <h1>☕ BrewMaster Shop</h1>
                    <div class="user-info">
                        <span id="welcomeUser">Welcome, User!</span>
                        <div class="cart-count" id="cartCount">0</div>
                        <button class="logout-btn" id="logoutBtn">Logout</button>
                    </div>
                </nav>
            </header>

            <div class="shop-content">
                <div class="welcome-message">
                    <h2>Welcome to BrewMaster Coffee Shop!</h2>
                    <p>Discover our premium selection of coffee beans and brewing equipment.</p>
                </div>

                <div class="products-grid" id="productsGrid">
                    <!-- Products will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data storage and state management
        let users = JSON.parse(localStorage.getItem('coffee_users') || '[]');
        let currentUser = JSON.parse(localStorage.getItem('current_user') || 'null');
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');

        // Sample products
        const products = [
             {
        "id": 1,
        "name":" Kaffee Bohnen",
        "price": 50,
        "image": "image/coffeebeans.png"
    },
    {
        "id": 2,
        "name":" Filterkaffee",
        "price": 50,
        "image": "image/coffeefilter.png"
    },
    {
        "id": 3,
        "name":" Kaffee Filter",
        "price": 20,
        "image": "image/filter.png"
    }
        ];

        // DOM elements
        const pages = {
            register: document.getElementById('registerPage'),
            login: document.getElementById('loginPage'),
            shop: document.getElementById('shopPage')
        };

        // Navigation functions
        function showPage(pageName) {
            Object.values(pages).forEach(page => page.classList.remove('active'));
            pages[pageName].classList.add('active');
        }

        // Check if user is logged in on page load
        if (currentUser) {
            // User is already logged in, redirect to index.php
            window.location.href = 'index.php';
        }

        // Registration functionality
        const registrationForm = document.getElementById('registrationForm');
        const regUsernameInput = document.getElementById('regUsername');
        const regPasswordInput = document.getElementById('regPassword');
        const confirmPasswordInput = document.getElementById('confirmPassword');
        const strengthFill = document.getElementById('strengthFill');
        const usernameReq = document.getElementById('usernameReq');
        const passwordReq = document.getElementById('passwordReq');
        const confirmReq = document.getElementById('confirmReq');

        // Password strength checker
        function checkPasswordStrength(password) {
            let strength = 0;
            if (password.length >= 6) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            return strength;
        }

        // Real-time validation
        regPasswordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = checkPasswordStrength(password);
            
            strengthFill.className = 'strength-fill';
            
            if (password.length === 0) {
                strengthFill.style.width = '0%';
            } else if (strength <= 2) {
                strengthFill.classList.add('strength-weak');
            } else if (strength <= 3) {
                strengthFill.classList.add('strength-medium');
            } else {
                strengthFill.classList.add('strength-strong');
            }

            if (password.length >= 6) {
                passwordReq.classList.add('met');
                passwordReq.textContent = '✓ Password meets minimum requirements';
            } else {
                passwordReq.classList.remove('met');
                passwordReq.textContent = 'Password must be at least 6 characters long';
            }
        });

        regUsernameInput.addEventListener('input', function() {
            const username = this.value;
            if (username.length >= 3 && username.length <= 50) {
                usernameReq.classList.add('met');
                usernameReq.textContent = '✓ Username is valid';
            } else {
                usernameReq.classList.remove('met');
                usernameReq.textContent = 'Username must be 3-50 characters long';
            }
        });

        confirmPasswordInput.addEventListener('input', function() {
            const password = regPasswordInput.value;
            const confirmPassword = this.value;
            
            if (confirmPassword && password === confirmPassword) {
                confirmReq.classList.add('met');
                confirmReq.textContent = '✓ Passwords match';
            } else if (confirmPassword) {
                confirmReq.classList.remove('met');
                confirmReq.textContent = 'Passwords do not match';
            } else {
                confirmReq.classList.remove('met');
                confirmReq.textContent = 'Passwords must match';
            }
        });

        // Message functions
        function showMessage(elementId, text, type) {
            const messageEl = document.getElementById(elementId);
            messageEl.textContent = text;
            messageEl.className = `message ${type}`;
            messageEl.style.display = 'block';
            setTimeout(() => {
                messageEl.style.display = 'none';
            }, 5000);
        }

        // Password hashing
        function hashPassword(password) {
            let hash = 0;
            for (let i = 0; i < password.length; i++) {
                const char = password.charCodeAt(i);
                hash = ((hash << 5) - hash) + char;
                hash = hash & hash;
            }
            return hash.toString();
        }

        // Registration form submission
        registrationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const username = regUsernameInput.value.trim();
            const password = regPasswordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            if (username.length < 3 || username.length > 50) {
                showMessage('registerMessage', 'Username must be between 3 and 50 characters', 'error');
                return;
            }

            if (password.length < 6) {
                showMessage('registerMessage', 'Password must be at least 6 characters long', 'error');
                return;
            }

            if (password !== confirmPassword) {
                showMessage('registerMessage', 'Passwords do not match', 'error');
                return;
            }

            if (users.find(user => user.username === username)) {
                showMessage('registerMessage', 'Username already exists. Please choose a different one.', 'error');
                return;
            }

            const newUser = {
                id: Date.now(),
                username: username,
                password_hash: hashPassword(password),
                created_at: new Date().toISOString(),
                is_active: true
            };

            users.push(newUser);
            localStorage.setItem('coffee_users', JSON.stringify(users));

            showMessage('registerMessage', 'Account created successfully! Redirecting to login...', 'success');
            
            setTimeout(() => {
                registrationForm.reset();
                resetValidation();
                showPage('login');
            }, 2000);
        });

        // Reset validation indicators
        function resetValidation() {
            strengthFill.style.width = '0%';
            strengthFill.className = 'strength-fill';
            [usernameReq, passwordReq, confirmReq].forEach(req => {
                req.classList.remove('met');
            });
            usernameReq.textContent = 'Username must be 3-50 characters long';
            passwordReq.textContent = 'Password must be at least 6 characters long';
            confirmReq.textContent = 'Passwords must match';
        }

        // Login functionality
        const loginForm = document.getElementById('loginForm');
        const loginUsernameInput = document.getElementById('loginUsername');
        const loginPasswordInput = document.getElementById('loginPassword');

        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const username = loginUsernameInput.value.trim();
            const password = loginPasswordInput.value;

            if (!username || !password) {
                showMessage('loginMessage', 'Please enter both username and password', 'error');
                return;
            }

            const user = users.find(u => u.username === username && u.password_hash === hashPassword(password));

            if (user) {
                currentUser = { id: user.id, username: user.username };
                localStorage.setItem('current_user', JSON.stringify(currentUser));
                
                showMessage('loginMessage', 'Login successful! Redirecting to shop...', 'success');
                
                setTimeout(() => {
                    // Redirect to index.php after successful login
                    window.location.href = 'index.php';
                }, 1500);
            } else {
                showMessage('loginMessage', 'Invalid username or password', 'error');
            }
        });

        // Shop functionality
        function loadShop() {
            document.getElementById('welcomeUser').textContent = `Welcome, ${currentUser.username}!`;
            updateCartCount();
            displayProducts();
        }

        function displayProducts() {
            const productsGrid = document.getElementById('productsGrid');
            productsGrid.innerHTML = products.map(product => `
                <div class="product-card">
                    <div class="product-image">${product.emoji}</div>
                    <div class="product-title">${product.name}</div>
                    <div class="product-description">${product.description}</div>
                    <div class="product-price">$${product.price}</div>
                    <button class="add-to-cart" onclick="addToCart(${product.id})">Add to Cart</button>
                </div>
            `).join('');
        }

        function addToCart(productId) {
            const product = products.find(p => p.id === productId);
            const existingItem = cart.find(item => item.productId === productId);

            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    productId: productId,
                    name: product.name,
                    price: product.price,
                    quantity: 1
                });
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            
            // Show feedback
            const button = event.target;
            const originalText = button.textContent;
            button.textContent = 'Added!';
            button.style.background = '#4CAF50';
            
            setTimeout(() => {
                button.textContent = originalText;
                button.style.background = '';
            }, 1000);
        }

        function updateCartCount() {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById('cartCount').textContent = totalItems;
        }

        // Logout functionality
        document.getElementById('logoutBtn').addEventListener('click', function() {
            currentUser = null;
            localStorage.removeItem('current_user');
            cart = [];
            localStorage.removeItem('cart');
            showPage('login');
        });

        // Navigation between auth pages
        document.getElementById('showLoginBtn').addEventListener('click', function(e) {
            e.preventDefault();
            showPage('login');
        });

        document.getElementById('showRegisterBtn').addEventListener('click', function(e) {
            e.preventDefault();
            showPage('register');
        });

        // Debug info
        console.log('System initialized. Registered users:', users.length);
    </script>
</body>
</html>