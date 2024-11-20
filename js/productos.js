$(document).ready(function() {
    let productIndex = 0;
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
                product_image: `img/productos/${producto.imagen}` // Asegúrate de que esta ruta sea correcta
            }));

            const productContainer = $("#product-list");

            // Iterar sobre productosSmartCart para crear los elementos HTML de cada producto
            productosSmartCart.forEach(product => {
                const productItem = `
                <div class="my-2">
                    <div class="card h-100 shadow-sm mb-4 p-2 sc-product-item thumbnail d-flex justify-content-between">
                        <div class="h-50 p-1 d-flex align-items.center"><img class="card-img-top img-fluid h-100" data-name="product_image" src="${product.product_image}" alt="${product.product_name}" style="max-height=50px"></div>
                        <h5 class="card-title text-center m-1 text-truncate" data-name="product_name">${product.product_name}</h5>
                        <p class="card-text m-1 text-wrap text-center" data-name="product_desc">${product.product_description}</p>
                        <div class="row row-cols-2 m-1">
                            <div class="col form-group2 d-flex justify-content-between align-items-center mb-0">
                                <input class="w-100 sc-cart-item-qty form-control" name="product_quantity" min="1" value="1" type="number">
                            </div>
                            <p class="col p-2 fw-bold fs-4 mb-0">$${product.product_price}</p>
                        </div>
                        <input name="product_price" value="${product.product_price}" type="hidden" />
                        <input name="product_id" value="${product.product_id}" type="hidden" />

                        <button class="m-2 sc-add-to-cart btn btn-warning">Agregar</button>
                    </div>
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
                    cartItemTemplate: 
                    '<h4 class="list-group-item-heading">{product_name}</h4> <input type="hidden" name="productos[${productIndex++}][producto_id]" value="{product_id}" /> <input type="hidden" name="productos[${productIndex++}][cantidad]" value="{display_quantity}"/>',    
                })
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar los productos:', error);
        }
    });
});
