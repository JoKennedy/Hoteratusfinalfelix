class Restaurant {
    async loadProducts(ID) {
        let data = {
            "TO": "Restaurant",
            "FOR": "loadProducts",
            "ACTION": "view",
            "id": ID
        }
        let datos = await GetInformation(data);
    }
    static holdProduct(ITEM) {
        let idProduct = $(ITEM).attr("data-id");
        let productName = $(ITEM).find(".name-product").text();
        let priceProduct = $(ITEM).find(".price-product").attr("data-price");
        let ifexist = $("#restaurant .products #table-products tbody").find(`tr[data-id='${idProduct}']`);
        let quantity = "";
        let total = 0;
        let row =
            `<tr data-id='${idProduct}'>
                <td>${productName}</td>
                <td>${idProduct}</td>
                <td class="text-success font-weight-bold price" data-price='${priceProduct}'>$${priceProduct}</td>
                <td class="d-flex">
                    <input type="number" id="quantity" class="form-control w-75" value='1'>
                    <button id="remove-product" class="btn btn-outline-primary btn-sm w-25" data-id='${idProduct}'><i class="fas fa-trash"></i></button>
                </td>
            </tr>`;
        if (ifexist.length != 0) {
            quantity = parseInt($(ifexist).find("#quantity").val());
            $(ifexist).find("#quantity").val(quantity + 1)
        }
        else {
            $("#restaurant .products #table-products tbody").append(row);
        }
        $("#restaurant .products #table-products tbody tr").each(function () {
            let price = parseFloat($(this).find('.price').attr("data-price"));
            let quantityP = parseFloat($(this).find("#quantity").val());
            total += price * quantityP;
        });
        total = parseToDecimal(total);
        $("#restaurant .products #table-products tfoot #totalPrice span").text(total);
    }
    static onChangeAmount(){
        
        let discount = 0;
        let subTotal = 0;
        let total = 0;
        $("#newOrder1 #tableTotalAmount tbody tr").each(function(){
            var price = parseFloat($(this).find('#totalPrice input').val());
            var quantityP = $(this).find("#quantity input").val();
            var discount = parseFloat($(this).find("#discount").attr("data-discount"));
            subTotal += price - discount;
            total += price;
        });
        
        console.log(total+"-"+subTotal);
        $("#newOrder1 #tablePrices #subTotal span").text(subTotal);
        $("#newOrder1 #tablePrices #amount span").text(total);
        $("#newOrder1 #tablePrices #totalAmount span").text(total)
    }
}


$(document).ready(function () {

    $("#restaurant").on("click", ".category-product #products-category", function () {
        new Restaurant().loadProducts($(this).attr("data-id"));
    });
    $("#restaurant").on("click", ".products .list-products .item-product", function () {
        Restaurant.holdProduct(this);
    });

    //Operaciones
    $("#restaurant #table-products tbody").on("click change keyup", "tr #quantity", function () {
        let total = 0;
        $("#restaurant .products #table-products tbody tr").each(function () {
            let price = parseFloat($(this).find('.price').attr("data-price"));
            let quantityP = parseFloat($(this).find("#quantity").val());
            total += price * quantityP;
        });
        total = parseToDecimal(total);
        $("#restaurant .products #table-products tfoot #totalPrice span").text(total);
    });
    $("#restaurant #table-products").on("click", "tr #remove-product", function () {
        $(this).closest("tr").remove();
        let total = 0;
        $("#restaurant .products #table-products tbody tr").each(function () {
            let price = parseFloat($(this).find('.price').attr("data-price"));
            let quantityP = parseFloat($(this).find("#quantity").val());
            total += price * quantityP;
        });
        total = parseToDecimal(total);
        $("#restaurant .products #table-products tfoot #totalPrice span").text(total);
    });

    //Table Amount
    //agregar el producto desde el BOX al table TotalAmount
    $("#restaurant").on("click", ".dropdown-menu .list-group-item", function () {
        let id = $(this).attr("data-id");
        let nameProduct = $(this).find("#nameProduct").text();
        let codeProduct = $(this).find("#codeProduct").text();
        let priceProduct = $(this).find("#priceProduct").attr("data-price");
        $(this).closest("tr").attr("data-id", id);
        $(`#restaurant #newOrder1 #tableTotalAmount tfoot #dropdownNameProduct`).val(nameProduct);
        $(`#restaurant #newOrder1 #tableTotalAmount tfoot #price span`).text(priceProduct);
        $(`#restaurant #newOrder1 #tableTotalAmount tfoot #price`).attr("data-price", priceProduct);
    });
    
    $("#restaurant #addNewProduct").on("click", "#add-product", function () {
        let id = $("#restaurant #newOrder1 #tableTotalAmount tfoot #addNewProduct").attr("data-id");
        let nameProduct = $(`#restaurant #newOrder1 #tableTotalAmount tfoot #dropdownNameProduct`).val();
        let priceProduct = $(`#restaurant #newOrder1 #tableTotalAmount tfoot #price`).attr("data-price");
        let quantity = $(`#restaurant #newOrder1 #tableTotalAmount tfoot #units input`).val();
        let ifexist = $("#restaurant #newOrder1 #tableTotalAmount tbody").find(`tr[data-id='${id}']`);
        let totalPrice = quantity * priceProduct;
        parseToDecimal(totalPrice);
        if (ifexist.length == 0) {
            if (nameProduct.length > 0 && priceProduct.length > 0) {
                row =
                    `<tr data-id='${id}'>
                        <td id="name">${nameProduct}</td>
                        <td id="price" data-price='${priceProduct}'>$<span>${priceProduct}</span></td>
                        <td id="quantity"><input type="number" class="form-control" value="${quantity}"></td>
                        <td id="discount" class="cursor-pointer text-primary" data-discount="0.00">Discount</td>
                        <td id="totalPrice" class="d-flex text-primary">$ <input type="text" class="border-0" value="${totalPrice}"></td>
                        <td><button id="remove-product" class="btn btn-outline-primary"><i class="fas fa-trash"></i></button></td>
                    </tr>`;
                $("#restaurant #newOrder1 #tableTotalAmount tbody").append(row);

                $(`#restaurant #newOrder1 #tableTotalAmount tfoot #dropdownNameProduct`).val("");
                $(`#restaurant #newOrder1 #tableTotalAmount tfoot #price span`).text("--");
                $(`#restaurant #newOrder1 #tableTotalAmount tfoot #units input`).val("");
                $("#restaurant #newOrder1 #tableTotalAmount tfoot #addNewProduct").removeAttr("data-id");
                Restaurant.onChangeAmount();
            }
        }
        else{
            $("#restaurant #newOrder1 #tableTotalAmount tfoot #alertProduct").animate({
                display: "toggle",
                opacity: "toggle",
                display : "toggle"
              }, 2000);
        }
    });
    $("#restaurant #tableTotalAmount tbody").on("click change keyup", "tr #quantity", function () {
        let total = 0;
        $($(this).closest("tr")).each(function () {
            let price = parseFloat($(this).find('#price').attr("data-price"));
            let quantityP = parseFloat($(this).find("#quantity input").val());
            total += price * quantityP;
        });
        total = parseToDecimal(total);
        $(this).closest("tr").find("#totalPrice input").val(total);
        Restaurant.onChangeAmount();
        console.log(clientIdActive)
    });
});