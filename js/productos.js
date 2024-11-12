$(document).ready(function() {
    // Hacer una solicitud AJAX para obtener los productos de la base de datos
    $.ajax({
        url: './includes/obtener_productos.php', // Asegúrate de que esta ruta sea correcta
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                console.error(data.error);
                return;
            }

            // Transformar los productos en el formato requerido por SmartCart
            const productosSmartCart = data.map(producto => ({
                product_id: producto.id,
                product_name: producto.nombre,
                product_description: producto.descripcion,
                product_price: producto.precio,
                product_image: `img/${producto.Imagen}` // Asegúrate de que esta ruta sea correcta
            }));

            const productContainer = $("#product-list");

            // Iterar sobre productosSmartCart para crear los elementos HTML de cada producto
            productosSmartCart.forEach(product => {
                const productItem = `
                    <div class="sc-product-item thumbnail mb-4">
                        <img class="img-fluid" data-name="product_image" src="${product.product_image}" alt="${product.product_name}">
                        <h5 class="mt-2" data-name="product_name">${product.product_name}</h5>
                        <p data-name="product_desc">${product.product_description}</p>
                        <p>Precio: $${product.product_price}</p>
                        <div class="form-group2">
                            <input class="sc-cart-item-qty" name="product_quantity" min="1" value="1" type="number">
                        </div>
                        <input name="product_price" value="${product.product_price}" type="hidden" />
                        <input name="product_id" value="${product.product_id}" type="hidden" />

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
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar los productos:', error);
        }
    });
});
