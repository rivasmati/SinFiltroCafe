
$(document).ready(function () {

    const productContainer = $("#product-list");
    productos.forEach(product => {
        const productItem = `
            <div class="sc-product-item thumbnail mb-4">
                <img class="img-fluid" data-name="product_image" src="img/${product.Imagen}" alt="${product.Nombre}">
                <h5 class="mt-2" data-name="product_name">${product.Nombre}</h5>
                <p data-name="product_desc">${product.Descripcion}</p>
                <p>Precio: $${product.Precio}</p>
                <div class="form-group2">
                <input class="sc-cart-item-qty" name="product_quantity" min="1" value="1" type="number">
              </div>
                <input name="product_price" value="${product.Precio}" type="hidden" />
                <input name="product_id" value="${product.ID}" type="hidden" />

                <button class="sc-add-to-cart btn btn-primary">Agregar al Carrito</button>
            </div>
        `;
        productContainer.append(productItem);
    });


    $('#smartcart').smartCart({
        lang: {

            cartTitle: "Carrito",

            checkout: 'Comprar',

            clear: 'Borrar',

            subtotal: 'Subtotal:',

            cartRemove: '×',

            cartEmpty: 'Carrito vacío!<br />Elegí tus productos.'

        },
        
            
    })
});