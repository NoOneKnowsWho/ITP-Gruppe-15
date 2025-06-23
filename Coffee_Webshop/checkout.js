let products = [];
let cart = [];

const checkoutContainer = document.getElementById('checkoutContainer');
const totalSumElement = document.getElementById('totalSum');

// Schritt 1: Lade Daten
const initCheckout = () => {
  fetch('products.json')
    .then((res) => res.json())
    .then((data) => {
      products = data;

      // Schritt 2: Warenkorb aus localStorage laden
      const cartData = localStorage.getItem('cart');
      if (cartData) {
        cart = JSON.parse(cartData);
        displayCartItems();
      } else {
        checkoutContainer.innerHTML = "<p>Der Warenkorb ist leer.</p>";
        totalSumElement.innerHTML = ''; // clear total sum if empty
      }
    });
};

// Schritt 3: Produkte anzeigen
const displayCartItems = () => {
  checkoutContainer.innerHTML = ''; // leeren

  let totalPrice = 0;

  cart.forEach((item) => {
    const product = products.find((p) => p.id == item.product_id);
    if (product) {
      const itemDiv = document.createElement('div');
      itemDiv.classList.add('checkout-item');

      const itemTotal = product.price * item.quantity;
      totalPrice += itemTotal;

      // Use template literals (backticks) to create the HTML string
      itemDiv.innerHTML = `
        <img src="${product.image}" alt="${product.name}">
        <strong>${product.name}</strong> - ${item.quantity} × $${product.price} = <strong>$${itemTotal.toFixed(2)}</strong>
      `;

      checkoutContainer.appendChild(itemDiv);
    }
  });

  // Also wrap total sum in backticks and quotes
  totalSumElement.innerHTML = `<h3>Gesamtsumme: $${totalPrice.toFixed(2)}</h3>`;
};

initCheckout();

