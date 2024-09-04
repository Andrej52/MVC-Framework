<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-shop list</title>
</head>
<body>
    <div class="cart">
        <i class="cart-icon"><button onclick="showCart(true)"> <i class="cart-icon">kosik</i></button>
        <div class="cart-items">

        </div>
    </div>
        <div class="item"  data-product-id="11" data-product-name="7hjDaco" data-product-price="87">
            <img src="" alt="img">

            <div class="item-desc">

                <p>Item name: <span class="name">daco2</span></p>
                <p>Price: <span class="price">14</span> <span id="currency">€</span></p>

                <div class="buttons">
                    <div class="quantity-container">
                        <button class="quantity-button" onclick="handleAmount(this)">-</button>
                        <input type="number" id="quantity-1" class="quantity-input" value="1" min="1">
                        <button class="quantity-button"  onclick="handleAmount(this)">+</button>
                    </div>
                    <button class="add-item" id="rnd()" onclick="addToCartBtn(this)">Add to cart</button>
                </div>

            </div>
            <div class="payment-methods">
                <button id="onDelivery">Dobierka</button>
                <button id="QRCode" onclick="generateQRPayment()">QR code</button>
                <button id="PayPal">Paypal</button>
            </div>
            <div class="QRCodePayment">

            </div>
                    <!-- Paypal Platba 1 -->
            <div class="paypalPayemnt">
                <form action="https://www.paypal.com/us/cgi-bin/webscr" method="post" id="checkoutPayment">
                <input type="hidden" name="cmd" value="_cart">
                <input type="hidden" name="upload" value="1">
                <input type="hidden" name="business" value="andrejmrazik8@gmail.com">

                <!-- Item 1 -->
                <input type="hidden" class="CartItem" name="item_name_1" value="purchasedWithID1">
                <input type="hidden" class="ItemAmount" name="amount_1" value="5.00">
                <input type="hidden" class="itemQUantity" name="quantity_1" value="1">

                <!-- Item 2 -->
                <input type="hidden" class="CartItem" name="item_name_2" value="purchasedWithID2">
                <input type="hidden" class="ItemAmount" name="amount_2" value="10.00">
                <input type="hidden" class="itemQUantity"  name="quantity_2" value="1">

                <input type="hidden" name="currency_code" value="EUR">
                <input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
                </form>
            </div>
        </div>
</body>
</html>
<script>
            generateCartHtml();
            function updateQuantity(action,productValue,button,itemsLimit){
                if (button) action == "increment" ? productValue++ : productValue--; // if button is active
                if (productValue > itemsLimit) productValue =  itemsLimit ; // if input is more than what is in warehouse then set to max amount in warehouse
                if (productValue < 0) productValue = 0;
                return productValue;
            }

            function updatePrice(price,itemsNum){   
                return price * itemsNum;
            }


            function handleAmount(button)
            {
                const priceForItem  = parseFloat(button.closest('.item').dataset.productPrice);
                let quantityContainer = button.closest('.quantity-container');
                let quantityInputField = quantityContainer.querySelector('.quantity-input');
                let productAmnt = quantityInputField.value;
                let priceElem =  button.closest('.item-desc').querySelector(".price");
                let action = "decrement";
  
                if (button.innerHTML == '+' || button.textContent == '+') action = "increment";

                    productAmnt = updateQuantity(action,productAmnt,true,10);
                    quantityInputField.value = productAmnt;
                    priceElem.innerHTML  = updatePrice(priceForItem,productAmnt);
            }


        document.querySelectorAll('.quantity-input').forEach(inputField => {
            inputField.addEventListener('input', function() {
                let productAmnt =  inputField.value; 
                let itemContainer = inputField.closest('.item'); 
                let priceElement = itemContainer.querySelector('.price'); 
                let priceForItem = parseFloat(itemContainer.dataset.productPrice); // Base price stored in data attribute
 
                productAmnt = updateQuantity("any",inputField.value,false,10);
                inputField.value = productAmnt;
                priceElement.innerHTML = updatePrice(priceForItem, productAmnt);
            });
        });

        function addToCartBtn(btn){
            var item = btn.closest('.item');
            var itemID = item.dataset.productId; 
            var itemName = item.dataset.productName; 
            var productPrice = item.dataset.productPrice; 
            
            var quantityInput = item.querySelector('.quantity-input');
            var quantity = parseInt(quantityInput.value);
            let cart = JSON.parse(sessionStorage.getItem('CART')) || [];
            const itemIndex = cart.findIndex(item => item.itemID === itemID);
            if (itemIndex !== -1) {
                if (quantity == 0) {
                    cart.splice(itemIndex, 1);
                }
                else
                {
                    cart[itemIndex].itemID = item.dataset.productId;
                    cart[itemIndex].itemName = item.dataset.productName;
                    cart[itemIndex].amount = quantity;
                    cart[itemIndex].price = productPrice;
                    cart[itemIndex].priceForAmount = updatePrice(productPrice,quantity);
                }
            } else {
            cart.push({ itemID,itemName, amount: quantity,price: productPrice, priceForAmount: updatePrice(productPrice,quantity) });
            }
            sessionStorage.setItem('CART', JSON.stringify(cart));
            window.location.href = "public/itemseshop";
        }   

    // Function to send cart data to the server
    function sendCartToServer() {
        const cart = sessionStorage.getItem('CART');
    
        fetch('process_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            'cart': cart
        })
        })
        .then(response => response.text())
        .then(data => {
        console.log('Server response:', data);
        });
    }
    function generateQRPayment()
    {
        // Your bank transfer details
            const IBAN = "IBAN";
            const BIC = "GIBASKBX";
            const AMOUNT = "1.00"; // Amount in EUR
            const CURRENCY = "EUR";
            const RECIPIENT_NAME = "Your Business Name";
            const REFERENCE = "Order 12345";

    // Format: BIC, IBAN, amount, currency, recipient name, and payment reference
    const sepaPaymentData = `BCD\n002\n1\nSCT\n${BIC}\n${RECIPIENT_NAME}\n${IBAN}\n${AMOUNT}\n${CURRENCY}\n${REFERENCE}`;

    // Generate QR code using an API (e.g., goqr.me)
    const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?data=${encodeURIComponent(sepaPaymentData)}&size=200x200`;
    
    let img = document.createElement("img");
    img.src = qrCodeUrl;
    document.querySelector(".QRCodePayment").appendChild(img);
    }

    function generateCartHtml(){
        const cartJSON = sessionStorage.getItem('CART');
        const cartContainer = document.querySelector(".cart-items");
        var priceTotal  = 0;
        const cart = JSON.parse(cartJSON);

        if (cart && cart.length > 0) 
        {
            cart.forEach(item => {
                let container = document.createElement('div');
                container.classList.add('item');
                container.classList.add('cart-item');
                container.setAttribute("data-product-id", item.itemID);
                container.setAttribute("data-product-name", item.itemName);
                container.setAttribute("data-product-price", item.price);
                // Set HTML content
                container.innerHTML = `
                       <img src="" alt="img">
                    <div class="item-desc">
                        <h1>${item.itemName}</h1>
                        <p>Obj č.: ${item.itemID}</p>
                        <p>Cena za kus: <span> ${(item.price)}</span> €</p>
                        <p>Price:  <span class="price">${item.priceForAmount} </span>€</p>
                  
                        <div class="quantity-container">
                            <button class="quantity-button" onclick="handleAmount(this)">-</button>
                            <input type="number" id="${item.itemID}" class="quantity-input" value="${item.amount}" min="0">
                            <button class="quantity-button" onclick="handleAmount(this)">+</button>
                        </div> 
                        <button class="add-item" id="save"onclick="addToCartBtn(this)">Ulozit</button>
                    </div> 
                `;
                cartContainer.appendChild(container)
                priceTotal += item.priceForAmount;
            });

           // cartContainer.style.display = "none";

            const TotalPrice  = document.createElement('div');
            TotalPrice.innerHTML = `
            <p>Celková cena: ${priceTotal} <span>€</span></p> 
            `;
            cartContainer.appendChild(TotalPrice)
        }
        else
        {
            const TotalPrice  = document.createElement('div');
            TotalPrice.innerHTML = `
            <h3>Kosik je prazdny<h3>
            <p>Celková cena: ${priceTotal} <span>€</span></p>
             `;
            cartContainer.appendChild(TotalPrice)
                console.log('No items in cart.');
        }
    }

    function showCart(display) {
        if (display) 
        if (document.querySelector(".cart-items").style.display != "flex") 
            document.querySelector(".cart-items").style.display = "flex";
        else
        if (document.querySelector(".cart-items").style.display == "flex") 
            document.querySelector(".cart-items").style.display = "none";
    }

</script>
<style>
        .cart-items
        {
            display: flex;
            flex-direction: column;
        }
        .cart-items img
        {
            max-width:  100px;
            max-height: 100px;
            object-fit: cover;
        }

        .cart-item
        {
            display: flex;
            flex-direction: row;
        }
        .cart-item .item-desc
        {
            display: flex;
            flex-direction: row;
        }

        /*quantity inputs */
        .quantity-container {
            display: flex;
            align-items: center;
        }
        .quantity-button {
            background-color: #ddd;
            border: 1px solid #ccc;
            padding: 5px;
            cursor: pointer;
        }
        .quantity-input {
            text-align: center;
            width: 50px;
            padding: 5px;
            border: 1px solid #ccc;
            margin: 0 5px;
            -moz-appearance: textfield; /* Firefox */
            -webkit-appearance: none;   /* Chrome, Safari */
            appearance: none;          /* Modern browsers */
        }
        .quantity-input::-webkit-inner-spin-button,
        .quantity-input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>