document.getElementById('searchForm').addEventListener('submit', function(event) {
    event.preventDefault(); 

    const searchQuery = document.getElementById('searchInput').value.toLowerCase();
    const sections = document.querySelectorAll('main section');
    let found = false;

    sections.forEach(section => {
        if (section.id.includes(searchQuery) || section.innerText.toLowerCase().includes(searchQuery)) {
            section.scrollIntoView({ behavior: 'smooth' });
            found = true;
        }
    });

    if (!found) {
        alert('No matching content found.');
    }
});



const loginButton = document.getElementById('loginButton');
const authContainer = document.getElementById('authContainer');
const closeButton = document.querySelector('.close-button');
const formTitle = document.getElementById('form-title');
const emailGroup = document.getElementById('email-group');
const toggleText = document.getElementById('toggle-text');
let isLogin = true;


loginButton.addEventListener('click', () => {
authContainer.style.display = 'block';
});


closeButton.addEventListener('click', () => {
authContainer.style.display = 'none';
});


window.addEventListener('click', (event) => {
if (event.target === authContainer) {
authContainer.style.display = 'none';
}
});


toggleText.addEventListener('click', (event) => {
if (event.target.tagName === 'A') { 
event.preventDefault();
isLogin = !isLogin;
if (isLogin) {
    formTitle.textContent = 'Login';
    toggleText.innerHTML = "Don't have an account? <a href='#'>Sign up</a>";
    emailGroup.style.display = 'none';
} else {
    formTitle.textContent = 'Sign Up';
    toggleText.innerHTML = "Already have an account? <a href='#'>Login</a>";
    emailGroup.style.display = 'block';
}
}
});
// Select elements and initialize variables
const cartButtons = document.querySelectorAll('.cart-button');
const cartTab = document.querySelector('.cartTab');
const listCart = document.querySelector('.listCart');
const cartTotal = document.getElementById('cart-total');
const cartCount = document.getElementById('cart-count');
const closeCart = document.querySelector('.close');

let cart = [];

// Function to render the cart contents
function renderCart() {
    listCart.innerHTML = '';
    let total = 0;
    cart.forEach((item, index) => {
        const cartItem = document.createElement('div');
        cartItem.classList.add('cart-item');
        cartItem.innerHTML = `
            <p>${item.name}</p>
            <p>৳${item.price} x ${item.quantity}</p>
            <button class="remove" data-index="${index}">Remove</button>
        `;
        listCart.appendChild(cartItem);
        total += item.price * item.quantity;
    });
    cartTotal.textContent = total;
    cartCount.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);

    // Show the cart if it contains items
    if (cart.length > 0) {
        document.body.classList.add('showCart');
    } else {
        document.body.classList.remove('showCart');
    }

}

// Function to add items to the cart
function addToCart(product) {
    const existingProduct = cart.find(item => item.name === product.name);
    if (existingProduct) {
        existingProduct.quantity++;
    } else {
        cart.push({ ...product, quantity: 1 });
    }
    renderCart();
}

// Function to remove an item from the cart
function removeFromCart(index) {
    cart.splice(index, 1);
    renderCart();
}

// Event listeners for adding items to the cart
cartButtons.forEach(button => {
    button.addEventListener('click', () => {
        const productElement = button.closest('.product');
        const product = {
            name: productElement.getAttribute('data-name'),
            price: parseInt(productElement.getAttribute('data-price'))
        };
        addToCart(product);
    });
});

// Event listener for removing items from the cart
listCart.addEventListener('click', (event) => {
    if (event.target.classList.contains('remove')) {
        const index = event.target.getAttribute('data-index');
        removeFromCart(index);
    }
});

// Close the cart tab
closeCart.addEventListener('click', () => {
    document.body.classList.remove('showCart');
});

// JavaScript
function handleCartClick() {
    document.body.classList.add('showCart');
   
}


