<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Shop</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" type="text/css" href="footer.css">
</head>
<body class="">
    <?php include 'header.php'; ?>
    
    <main>
        <div class="container">
            <header>
                <div class="title">PRODUCT LIST</div>
                <div class="icon-cart">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 15a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0h8m-8 0-1-4m9 4a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-9-4h10l2-7H3m2 7L3 4m0 0-.792-3H1"/>
                    </svg>
                    <span>0</span>
                </div>
            </header>
            <div class="listProduct">
                
            </div>
        </div>

        <div class="cartTab">
            <h1>Shopping Cart</h1>
            <div class="listCart">
               
            </div>
            <div class="btn">
                <button class="close">CLOSE</button>
                <button class="checkOut" onclick="window.location.href='checkout.php'">Check Out</button>

            </div>
        </div>
    </main>

    <script src="app.js"></script>
    
    <?php include 'footer.php'; ?>
</body>
</html>