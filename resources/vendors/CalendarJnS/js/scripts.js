var orderNumber = 1;
class Restaurant {
    async loadProducts(ID) {
        let data = {
            "TO": "Restaurant",
            "FOR": "loadProducts",
            "ACTION": "view",
            "id": ID
        }
        let datos = await GetInformation(data);
        $("#restaurant #pointRestaurant .tab-content #list-products .list-products").html(datos["content"]);
    }
    async LoadContenSubmenu(VIEW) {
        let ifexist = $("#restaurant #myTabRestaurant").find(`#${VIEW}-tab`);
        if (ifexist.length == 0) {
            let data = {
                "TO": "SUBMENU",
                "ACTION": "view",
                "view": VIEW
            }
            let datos = await GetInformation(data);

            $("#restaurant #myTabRestaurant").append(datos["navTab"]);
            $("#restaurant #tab-content-restaurant").append(datos["tab-content"]);
            clientIdActive = `products`;
            $(`#restaurant #${VIEW}-tab`).tab("show");
            $(".dataTable").dataTable();
        }
        $(`#restaurant #${VIEW}-tab`).tab("show");
    }
    async AllocationDetails(ID) {

        let data = {
            "TO": "SUBMENU",
            "ACTION": "view",
            "view": "allocationDetails"
        }
        let datos = await GetInformation(data);
        $(`#myTabRestaurant .nav-item[data-remove='allocationDetails']`).remove();
        $(`#tab-content-restaurant #allocationDetails`).remove();

        $("#restaurant #myTabRestaurant").append(datos["navTab"]);
        $("#restaurant #tab-content-restaurant").append(datos["tab-content"]);
        clientIdActive = `allocationDetails`;
        $(`#restaurant #allocationDetails-tab`).tab("show");
        $(".dataTable").dataTable();
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
                <td id='nameProduct'>${productName}</td>
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
    static SumHoldProduct() {
        let total = 0;
        $("#restaurant .products #table-products tbody tr").each(function () {
            let price = parseFloat($(this).find('.price').attr("data-price"));
            let quantityP = parseFloat($(this).find("#quantity").val());
            total += price * quantityP;
        });
        total = parseToDecimal(total);
        $("#restaurant .products #table-products tfoot #totalPrice span").text(total);
    }
    static onChangeAmount() {
        let discount = 0;
        let subTotal = 0;
        let total = 0;
        $(`#${clientIdActive} #tableTotalAmount tbody tr`).each(function () {
            var price = parseFloat($(this).find('#totalPrice input').val());
            var quantityP = $(this).find("#quantity input").val();
            var typeDiscount = $(this).find("#discount").attr("data-typediscount");
            discount = parseFloat($(this).find("#discount").attr("data-discount"));
            if (typeDiscount == "%") {
                discount = (value * discount) / 100;
            }
            subTotal += price;
            total += price;
        });
        subTotal = parseToDecimal(subTotal);
        total = parseToDecimal(total);
        $(`#${clientIdActive} #tableBalance #subTotal span`).text(subTotal).attr("data-subTotal",subTotal);    
        /*--*/$(`#${clientIdActive} #tableBalance #fDiscount`).text("0.00").attr("data-fDiscount","0.00");
        /*--*/$(`#${clientIdActive} #tableBalance #packageOrCorporate`).text("0.00").attr("data-packageOrCorporate","0.00");
        /*--*/$(`#${clientIdActive} #tableBalance #taxes`).text("0.00").attr("data-taxes","0.00");
        $(`#${clientIdActive} #tableBalance #amount span`).text(total).attr("data-amount",amount);
        $(`#${clientIdActive} #tableBalance #totalAmount span`).text(total).attr("data-totalAmount",total);
        //hay que agregarle el TAX
        $(`#${clientIdActive} #tableBalance #totalAmount`).attr(
            {
                "data-value": total,
                "data-currency": "DOP"
            }
        );
        $(`#tab-content-restaurant #${clientIdActive} .payment-details #amount`).val(total);
    }
    async generateOrder() {
        orderNumber++;
        let rows = "";
        let listProducts = "";
        $("#restaurant .products #table-products tbody tr").each(function () {
            let id = $(this).attr("data-id");
            let nameProduct = $(this).find("#nameProduct").text();
            let priceProduct = parseFloat($(this).find('.price').attr("data-price"));
            let quantity = parseFloat($(this).find("#quantity").val());
            let totalPriceProduct = priceProduct * quantity;
            totalPriceProduct = parseToDecimal(totalPriceProduct);
            rows +=
                `<tr data-id='${id}'>
                    <td id="name">${nameProduct}</td>
                    <td id="price" data-price='${priceProduct}'>$<span>${priceProduct}</span></td>
                    <td id="quantity"><input type="number" class="form-control" value="${quantity}"></td>
                    <td id="discount" class="cursor-pointer text-primary" data-discount="0.00">Discount</td>
                    <td id="totalPrice" class="d-flex text-primary">$ <input type="text" class="border-0" value="${totalPriceProduct}" style="max-width: 60px;"></td>
                    <td><button id="remove-product" class="btn btn-outline-primary"><i class="fas fa-trash"></i></button></td>
                </tr>`;
        });
        let data = {
            "TO": "listProducts",
            "ACTION": "view"
        }
        let datos = await GetInformation(data);
        datos["products"].forEach(product => {
            listProducts +=
                `<li class="list-group-item list-group-item-action align-content-between align-items-center" data-id="${product["id"]}">
                <span class="w-50" id="nameProduct">${product["name"]}</span>
                <span class="w-25 px-1 mx-1 border-left border-right text-dark"
                    id="codeProduct">${product["code"]}</span>
                <span class="w-25 text-success" id="priceProduct"
                    data-price="15.00">$15.00</span>
            </li>`;
        });
        let navTab =
            `<li class="nav-item" data-remove="newOrder${orderNumber}">
            <a href="#newOrder${orderNumber}" id='newOrder${orderNumber}-tab' data-id="newOrder${orderNumber}" class="nav-link"  data-toggle="tab" role="tab" aria-controls="newOrder${orderNumber}"
                aria-selected="true">New Order#${orderNumber}(on hold)
                <button type="button" data-id="newOrder${orderNumber}" id="tabClose" class="close ml-1" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </a>
        </li>`
        let tabContent =
            `<div id="newOrder${orderNumber}" class="tab-pane" role="tabpanel" aria-labelledby="newOrder${orderNumber}-tab">
            <div class="row py-2">
                <div class="col-md-3">
                    <label for="name">Name</label>
                    <input type="text" id="name" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="roomHasReserved">Room #</label>
                    <select id="roomHasReserved" class="custom-select">
                        <option>STD 101</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="guestName">Guest Name</label>
                    <select id="guestName" class="custom-select"></select>
                </div>
            </div>
            <div class="row p-3">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" id="complementaryOrder${orderNumber}" class="custom-control-input"
                        autocomplete="off">
                    <label for='complementaryOrder${orderNumber}' class="custom-control-label">Complementary</label>
                </div>
            </div>
            <div class="row mt-3">
                <div class="table-responsive-phone w-100">
                    <table id="tableTotalAmount" class="table">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Code/Product Name</th>
                                <th>Unit Price</th>
                                <th>Units</th>
                                <th>Discount</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${rows}
                        </tbody>
                        <tfoot>
                            <tr id="alertProduct" class="alert alert-danger" style="display: none;"> 
                                <td colspan="6">This product exist</td>
                            </tr>
                            <tr id="addNewProduct">
                                <td id="name">
                                    <div class="dropdown w-100">
                                        <input class="form-control filter dropdown-toggle" type="text"
                                            id="dropdownNameProduct" placeholder="Product Name"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                            autocomplete="off">
                                        <div class="dropdown-menu w-100" aria-labelledby="dropdownNameProduct"
                                            style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 70px, 0px);"
                                            x-placement="bottom-start">
                                            <ul class="list-group list-group-flush overflow-auto cursor-pointer text-center" style="max-height:265px">
                                                ${listProducts}
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td id="price">$<span>--</span></td>
                                <td id="units"><input type="number" class="form-control" value="1"
                                        autocomplete="off"></td>
                                <td id="discount">--</td>
                                <td id="totalPrice" class="d-flex text-primary">$--</td>
                                <td><button id="add-product" class="btn btn-outline-primary"><i
                                            class="fas fa-plus"></i></button></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class='row'>
                        <button id='addCustomCharge' class='btn btn-primary'>Add Custom Charge</button>
                    </div>
                    <div class="row">
                        <label for="remark">Remark</label>
                        <textarea id="remark" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <table id="tableBalance" class="table text-right">
                        <tbody>
                            <tr>
                                <th>Sub Total</th>
                                <th id="subTotal" data-subTotoal=''>$ <span>0.00</span></th>
                            </tr>
                            <tr>
                                <td>Folio Discount</td>
                                <td id="fDiscount" data-fDiscount=''>$ <span>0.00</span></td>
                            </tr>
                            <tr>
                                <td>Package/Corporate Discount</td>
                                <td id="packageOrCorporate" data-packageOrCorporate=''>$ <span>0.00</span></td>
                            </tr>
                            <tr>
                                <th>Amount</th>
                                <th id="amount" data-amount=''>$ <span>0.00</span></th>
                            </tr>
                            <tr>
                                <td>Tax(es)</td>
                                <td id="taxes" data-taxes=''>$ <span>0.00</span></td>
                            </tr>
                            <tr class="bg-info text-white">
                                <th>Total Amount <br>
                                    <i style="font-size: 14px;">Total Paid</i>
                                </th>
                                <td id="totalAmount" data-value="0.00" data-currency="DOP">
                                    $ <span>0.00</span> <br>
                                    <i id='totalPaid'style="font-size: 14px;">$ 0.00</i>
                                </td>
                            </tr>
                            <tr class="bg-lightblue">
                                <th>Balance</th>
                                <th id="balance" data-balance=''>$ <span>0.00</span></th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button id='confirmOrder' class="btn btn-primary btn-lg w-100">Confirm Order</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="payment-details">
                <div id="payment" class="row">
                    <div class="col-sm-2 p-2 text-center bg-lightblue">
                        <h4>Payment</h4>
                    </div>
                    <div class="col-sm-10 p-2">
                        <span class="text-danger">Payment Gateway is no integrated. Credit Card will not be
                            charged</span>
                    </div>
                </div>
                <div class="row p-3 bg-lightblue">
                    <div class="col-md-2 px-1">
                        <label for="modePaid">Mode</label>
                        <select id="modePaid" class="custom-select"></select>
                    </div>
                    <div class="col-md-2 px-1">
                        <label for="type">Type</label>
                        <select id="type" class="custom-select"></select>
                    </div>
                    <div class="col-md-1 px-1">
                        <label for="amount">Amount</label>
                        <input type="text" id="amount" class="form-control">
                    </div>
                    <div class="col-md-2 px-1">
                        <label for="cc-chechequeNo">CC/Cheque No.</label>
                        <input type="text" id="cc-chequeNo" class="form-control">
                    </div>
                    <div class="col-md-2 px-1">
                        <label for="receip">Receip</label>
                        <input type="text" id="receip" class="form-control">
                    </div>
                    <div class="col-md-3 px-1">
                        <label for="description">Description</label>
                        <input type="text" id="description" class="form-control">
                    </div>
                </div>
                <div class="row bg-lightblue btn-group-space">
                    <div class="col-md-3 px-1">
                        <button id='paidNow' class="btn btn-success w-100">Pay Now</button>
                    </div>
                    <div class="col-md-3 px-1">
                        <button id="currencyConverter" class="btn btn-primary w-100"><i
                                class="fas fa-dollar-sign"></i> Converter</button>
                    </div>
                    <div class="col-md-3 px-1">
                        <button id='transferToRoom' class="btn btn-outline-dark w-100"><i class="fas fa-exchange-alt"></i> Transfer
                            to Room</button>
                    </div>
                    <div class="col-md-3 px-1">
                        <button id='transferCityLedger' class="btn btn-outline-danger w-100"><i class="fas fa-exchange-alt"></i> Transfer to
                            City Ledger</button>
                    </div>
                </div>
            </div>
        </div>`
        $("#restaurant #myTabRestaurant").append(navTab);
        $("#restaurant #tab-content-restaurant").append(tabContent);
        clientIdActive = `newOrder${orderNumber}`;
        $(`#restaurant #newOrder${orderNumber}-tab`).tab("show");
        Restaurant.onChangeAmount();

        $("#restaurant .products #table-products tbody").html("");
        Restaurant.SumHoldProduct();
    }
    async convertCurrency() {
        let amount = $("#modalConverterCurrency #amount").val();
        let currency = $("#modalConverterCurrency #currency").val();
        let convertTo = $("#modalConverterCurrency #convertTo").val();

        let data = {
            "TO": "PayBill",
            "FOR": "currency",
            "ACTION": "view",
            "currency": currency,
            "convertTo": convertTo
        }
        //let datos = await GetInformation(data);
        let datos = {
            "valueCurrency": "58.20"
        }
        let valueConvertTo = datos["valueCurrency"];
        let total = parseToDecimal(amount * valueConvertTo);

        $("#modalConverterCurrency #convertedCurrency").text("$ " + total);
        if ($("#modalConverterCurrency #convertApplyToPaid").val() == "on") {
            $(`#tab-content-restaurant #${clientIdActive} .payment-details #amount`).val(total);
        }
    }
    static Discount() {
        let id = $("#modalDiscount .modal-footer #save").attr("data-id");
        let percentOrvalue = "";
        let discount = $("#modalDiscount .modal-body #discount").val();
        let reason = $("#modalDiscount .modal-body #reason").val();

        let price = $(`#restaurant #${clientIdActive} #tableTotalAmount tbody tr[data-id='${id}'] #quantity input`).val();
        let quantity = $(`#restaurant #${clientIdActive} #tableTotalAmount tbody tr[data-id='${id}'] #price`).attr("data-price");
        let totalPrice = price * quantity;
        let totalUnChange = totalPrice;//valor sin cambio
        let discountUnchange = discount;//valor sin cambio
        if ($("#modalDiscount .modal-body #percent").is(":checked")) {
            percentOrvalue = "%";
            discount = (totalPrice * discount) / 100;
            totalPrice = totalPrice - discount;
        }
        else {
            percentOrvalue = "$";
            totalPrice = totalPrice - discount;
        }
        totalPrice = parseToDecimal(totalPrice);
        discount = parseToDecimal(discount);
        //Aplicar a los campos
        $(`#restaurant #${clientIdActive} #tableTotalAmount tbody tr[data-id='${id}'] #totalPrice input`).val(totalPrice)
        $(`#restaurant #${clientIdActive} #tableTotalAmount tbody tr[data-id='${id}'] #discount`).text("$ " + discount);
        $(`#restaurant #${clientIdActive} #tableTotalAmount tbody tr[data-id='${id}'] #discount`).attr("data-discount", discountUnchange);
        $(`#restaurant #${clientIdActive} #tableTotalAmount tbody tr[data-id='${id}'] #discount`).attr("data-typeDiscount", percentOrvalue);
        $(`#restaurant #${clientIdActive} #tableTotalAmount tbody tr[data-id='${id}'] #discount`).attr("data-reason", reason);
        this.onChangeAmount()
        $("#modalDiscount").modal("hide");
    }
    async invoiceOnHold(ID) {

        let ifexist = $("#restaurant #myTabRestaurant").find(`#orderNo${ID}-tab`);
        if (ifexist.length == 0) {
            let data = {
                "TO": "InvoiceOnHold",
                "ACTION": "view",
                "orderNo": ID,
                "id": ID
            }
            let datos = await GetInformation(data);
            $("#restaurant #myTabRestaurant").append(datos["navTab"]);
            $("#restaurant #tab-content-restaurant").append(datos["tab-content"]);
            $(`#restaurant #orderNo${ID}-tab`).tab("show");
            clientIdActive = `orderNo${ID}`;
            $(".dataTable").dataTable();
        }
        $(`#restaurant #orderNo${ID}-tab`).tab("show");
    }
    async searchFolioRefund(NUMBER) {
        let ifexist = $("#restaurant #myTabRestaurant").find(`#folioNo${NUMBER}-tab`);
        if (ifexist.length == 0) {
            let data = {
                "TO": "FolioRefund",
                "ACTION": "view",
                "folioNumber": NUMBER
            };
            let datos = await GetInformation(data);
            $("#restaurant #myTabRestaurant").append(datos["navTab"]);
            $("#restaurant #tab-content-restaurant").append(datos["tab-content"]);
            $(`#restaurant #folioNo${NUMBER}-tab`).tab("show");
            clientIdActive = `folioNo${NUMBER}`;
            $(".dataTable").dataTable();
        }
        $(`#restaurant #folioNo${NUMBER}-tab`).tab("show");
    }
    static onChangeModalCustomCharge() {
        let price = $("#modalAddCustomCharge #priceP").val();
        let quantity = $("#modalAddCustomCharge #quantityP").val();
        let discount = $("#modalAddCustomCharge #discountP").val();
        let typeDiscount = "";
        let totalPrice = price * quantity;
        let totalPriceUnChanche = price * quantity;
        totalPrice = parseToDecimal(totalPrice);
        if ($("#modalAddCustomCharge .modal-body #percent").is(":checked")) {
            typeDiscount = "%";
            discount = (totalPrice * discount) / 100;
            totalPrice = totalPrice - discount;
        }
        else {
            typeDiscount = "$";
            totalPrice = totalPrice - discount;
        }
        $("#modalAddCustomCharge #discountP").attr("data-typeDiscount", typeDiscount);
        $("#modalAddCustomCharge .modal-body #amountP").text(totalPrice);
        $("#modalAddCustomCharge .modal-body #amountP").attr("data-price", totalPrice);
    }
    static addCustomProduct() {
        let idProduct = "0";
        let productName = $("#modalAddCustomCharge #descriptionP").val();
        let priceProduct = $("#modalAddCustomCharge #priceP").val();
        let quantity = $("#modalAddCustomCharge #quantityP").val();
        let discount = $("#modalAddCustomCharge #discountP").val();
        let typeDiscount = $("#modalAddCustomCharge #discountP").attr("data-typeDiscount");
        let ifexist = $(`#restaurant #${clientIdActive} #tableTotalAmount tbody`).find("tr[data-id='0']");
        let totalPrice = priceProduct * quantity;
        let discountUnChange = discount;
        if ($("#modalAddCustomCharge .modal-body #percent").is(":checked")) {
            typeDiscount = "%";
            discount = (totalPrice * discount) / 100;
            totalPrice = totalPrice - discount;
        }
        else {
            typeDiscount = "$";
            totalPrice = totalPrice - discount;
        }
        let row = "";
        if (ifexist.length == 0) {
            if (productName.length > 0 && priceProduct.length > 0 && quantity.length > 0) {
                if (totalPrice > discount) {
                    row =
                        `<tr data-id='0'>
                        <td id="name">${productName}</td>
                        <td id="price" data-price='${priceProduct}'>$<span>${priceProduct}</span></td>
                        <td id="quantity"><input type="number" class="form-control" value="${quantity}"></td>
                        <td id="discount" class="cursor-pointer text-primary" data-discount="${discountUnChange}" data-typediscount="${typeDiscount}">$ ${discount}</td>
                        <td id="totalPrice" class="d-flex text-primary">$ <input type="text" class="border-0" value="${totalPrice}" style="max-width: 60px;"></td>
                        <td><button id="remove-product" class="btn btn-outline-primary"><i class="fas fa-trash"></i></button></td>
                    </tr>`;
                    $(`#restaurant #${clientIdActive} #tableTotalAmount tbody`).append(row);
                    Restaurant.onChangeAmount();
                    $("#modalAddCustomCharge").modal("hide");
                }
                else {
                    alert("You can no give discount more than total price");
                }
            }
        }
        else {
            alert("You can not add more of one custom charge");
        }
    }
}
class Restaurant_payment{
    async payNow(){
        let name = $(`#${clientIdActive} #name`).val();
        let lastName = $(`#${clientIdActive} #lastName`).val();
        let room  = $(`#${clientIdActive} #roomHasReserved`).val();
        let guestName = $(`#${clientIdActive} #guestName`).val();
        let complementaryOrder = $(`#${clientIdActive} #complementay_order`).val();
        
        let remark = $(`#${clientIdActive} #remark`).val();
        let subTotal = $(`#${clientIdActive} #tableBalance #subTotal`).attr("data-subTotal");
        let folioDiscount = $(`#${clientIdActive} #tableBalance #fDiscount`).attr("data-fDiscount");
        let packageOrCorporate = $(`#${clientIdActive} #tableBalance #packageOrCorporate`).attr("data-packageOrCorporate");
        let amount = $(`#${clientIdActive} #tableBalance #amount`).attr("data-amount");
        let taxes = $(`#${clientIdActive} #tableBalance #taxes`).attr("data-taxes");
        let totalAmount = $(`#${clientIdActive} #tableBalance #totalAmount`).attr("data-value");

        let modePaid = $(`#${clientIdActive} .payment-details #modePaid`).val();
        let type = $(`#${clientIdActive} .payment-details #type`).val();
        let amountToPaid = $(`#${clientIdActive} .payment-details #amount`).val();
        let chequeNo = $(`#${clientIdActive} .payment-details #cc-chequeNo`).val();
        let receip = $(`#${clientIdActive} .payment-details #receip`).val();
        let description = $(`#${clientIdActive} .payment-details #description`).val();
        let data = {
            "TO" : "Restaurant_payment",
            "FOR" : "PayNow",
            "ACTION" : "view",
            "name" : name,
            "lastName" : lastName,
            "room" : room,
            "guestName" : guestName,
            "complementaryOrder" : complementaryOrder,
            "remark" : remark,
            "subTotal" : subTotal,
            "folioDiscount" : folioDiscount,
            "packageOrCorporate" : packageOrCorporate,
            "amount" : amount,
            "taxes" : taxes,
            "totalAmount" : totalAmount,
            "modePaid" : modePaid,
            "type" : type,
            "amountToPaid" : amountToPaid,
            "chequeNo" : chequeNo,
            "receip" : receip,
            "description" : description
        };
        if(amountToPaid > 0){
            if(room.length < 0){
                let datos = await GetInformation(data);
            }
            else{
                alert("Infomation!",'Please selected "Transfer to room"');
            }
            
        }
        else{
            alert("Warning!",'The total value cannot be a negative value',"warning");
        }
    }
    async confirmOrder(){
        let name = $(`#${clientIdActive} #name`).val();
        let lastName = $(`#${clientIdActive} #lastName`).val();
        let room  = $(`#${clientIdActive} #roomHasReserved`).val();
        let guestName = $(`#${clientIdActive} #guestName`).val();
        let complementaryOrder = $(`#${clientIdActive} #complementay_order`).val();
        
        let products = [];
        $(`#${clientIdActive} #tableTotalAmount tbody tr`).each(function () {
            products.push({
                "id" : $(this).attr("data-id"),
                "price" : parseFloat($(this).find('#totalPrice input').val()),
                "quantity" : $(this).find("#quantity input").val(),
                "tipe_discount" : $(this).find("#discount").attr("data-typediscount"),
                "discount" : parseFloat($(this).find("#discount").attr("data-discount"))
            });
        });
        console.log(products)
        let remark = $(`#${clientIdActive} #remark`).val();
        let subTotal = $(`#${clientIdActive} #tableBalance #subTotal`).attr("data-subTotal");
        let folioDiscount = $(`#${clientIdActive} #tableBalance #fDiscount`).attr("data-fDiscount");
        let packageOrCorporate = $(`#${clientIdActive} #tableBalance #packageOrCorporate`).attr("data-packageOrCorporate");
        let amount = $(`#${clientIdActive} #tableBalance #amount`).attr("data-amount");
        let taxes = $(`#${clientIdActive} #tableBalance #taxes`).attr("data-taxes");
        let totalAmount = $(`#${clientIdActive} #tableBalance #totalAmount`).attr("data-value");
        
        let modePaid = $(`#${clientIdActive} .payment-details #modePaid`).val();
        let type = $(`#${clientIdActive} .payment-details #type`).val();
        let amountToPaid = $(`#${clientIdActive} .payment-details #amount`).val();
        let chequeNo = $(`#${clientIdActive} .payment-details #cc-chequeNo`).val();
        let receip = $(`#${clientIdActive} .payment-details #receip`).val();
        let description = $(`#${clientIdActive} .payment-details #description`).val();
        let data = {
            "TO" : "Restaurant_payment",
            "FOR" : "ConfirmOrder",
            "ACTION" : "view",
            "name" : name,
            "lastName" : lastName,
            "room" : room,
            "guestName" : guestName,
            "complementaryOrder" : complementaryOrder,
            "remark" : remark,
            "subTotal" : subTotal,
            "folioDiscount" : folioDiscount,
            "packageOrCorporate" : packageOrCorporate,
            "amount" : amount,
            "taxes" : taxes,
            "totalAmount" : totalAmount,
            "modePaid" : modePaid,
            "type" : type,
            "amountToPaid" : amountToPaid,
            "chequeNo" : chequeNo,
            "receip" : receip,
            "description" : description
        };
        if(amountToPaid > 0){
            let datos = await GetInformation(data);
            $("#restaurant #myTabRestaurant").append(datos["navTab"]);
            $("#restaurant #tab-content-restaurant").append(datos["tab-content"]);
            //remover el content de nueva orden
            $(`#restaurant #${clientIdActive}-tab`).closest("li").remove();
            $(`#restaurant #${clientIdActive}`).remove();

            clientIdActive = `orderNo${datos["orderNo"]}`;
            $(`#restaurant #orderNo${datos["orderNo"]}-tab`).tab("show");
        }
        else{
            alert("Warning!",'The total value cannot be a negative value',"warning");
        }
    }
}
function alert(title,message,type_alert ="primary"){
    $("#modalAlert .modal-body").addClass("alert-"+type_alert);
    $("#modalAlert .modal-body .alert-heading").text(title);
    $("#modalAlert .modal-body p").text(message);
    $("#modalAlert").modal();
}
/*
function GetInformation(datos, url = document.baseURI) {
    datos["_token"] = csrf_token
    url = url.endsWith("/")? url+"getinformation" : url+"/getinformation";
    console.log(url+"--sd")
    $(".loading-status").removeClass("hide");
    let result =
        $.ajax({
            type: 'post',
            url: url,
            dataType: "json",
            data: datos,
            success: function (res) {
                $(".loading-status").addClass("hide");
                console.log(res)
                result = res;
                return res;

            }, error: function (res) {
                $(".loading-status").addClass("hide");
                let error = `
                <div class="alert alert-danger alert-dismissible fade show mb-4 w-100" style="z-index:1060; left:10px;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <div class="alert-body">
                        <strong>An error has ocurred!</strong> Please try again, in a moment.
                    </div>
                </div>`;
                $("body #content-alert").append(error);
                return result = "";
            }
        });
    return Promise.resolve(result)
}*/

$(document).ready(function () {
    //Operaciones
    $("#restaurant #myTabRestaurant").on("click", ".nav-link", function () {
        clientIdActive = $(this).attr("data-id");
    });

    $("#myTabRestaurant").on("click", "#tabClose", function () {
        let id = $(this).attr("data-id");
        $(`#myTabRestaurant .nav-item[data-remove='${id}']`).remove();
        $(`#tab-content-restaurant #${id}`).remove();
        $("#pointRestaurant-tab").tab("show")
        clientIdActive = "pointRestaurant";
    });

    $("body").on("click", "#currencyConverter", function () {
        let amount = $(`#restaurant #${clientIdActive} #tableBalance #totalAmount`).attr("data-value");
        let currency = $(`#restaurant #${clientIdActive} #tableBalance #totalAmount`).attr("data-currency");
        $(`#modalConverterCurrency #currency option[value='${currency}']`).attr("selected", "selected");
        $("#modalConverterCurrency #amount").val(amount);
        $("#modalConverterCurrency").modal();
    });
    $("body").on("click", "#modalConverterCurrency #btnConverterCurrency", function () {
        new PayBill().convertCurrency()
    });
    $("#restaurant #subMenu #navbar-list-group").on("click", "a", function () {
        let view = $(this).attr("aria-controls");
        new Restaurant().LoadContenSubmenu(view);
    });
    $("#restaurant #subMenu #invoiceOnHold table tbody").on("click", "tr", function () {
        let id = $(this).attr("data-id");
        new Restaurant().invoiceOnHold(id);
    });
    $("#restaurant #subMenu #folioForRefund").on("click", "#btnSearch", function () {
        let number = $("#restaurant #subMenu #folioForRefund #fieldFolioRefund").val();
        new Restaurant().searchFolioRefund(number);
    });
    $("#restaurant #pointRestaurant #tableFolios tbody").on("click", "tr", function () {
        let number = $(this).attr("data-folioNumber");
        new Restaurant().searchFolioRefund(number);
    });
    $("#restaurant #modalAddCustomCharge").on("click change keyup", "#priceP,#quantityP,#discountP,#percent,#value", function () {
        Restaurant.onChangeModalCustomCharge();
    });
    $("#restaurant #modalAddCustomCharge .modal-footer").on("click", "#save", function () {
        Restaurant.addCustomProduct();
    });

    //TAB Restaurant
    $("#restaurant").on("click", ".products .list-products .item-product", function () {
        Restaurant.holdProduct(this);
    });
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
    $("#restaurant #table-products tbody").on("click", "tr #remove-product", function () {
        $(this).closest("tr").remove();
        Restaurant.SumHoldProduct();
    });
    $("#restaurant").on("click", "#pointRestaurant #generateOrder", function () {
        new Restaurant().generateOrder();
    });
    //Tab Product **
    $("#restaurant").on("click", ".category-product #products-category", function () {
        new Restaurant().loadProducts($(this).attr("data-id"));
    });
    //Table Amount
    //agregar el producto desde el BOX al table TotalAmount
    $("#restaurant").on("click", ".dropdown-menu .list-group-item", function () {
        let id = $(this).attr("data-id");
        let nameProduct = $(this).find("#nameProduct").text();
        let codeProduct = $(this).find("#codeProduct").text();
        let priceProduct = $(this).find("#priceProduct").attr("data-price");
        $(this).closest("tr").attr("data-id", id);
        $(`#restaurant #${clientIdActive} #tableTotalAmount tfoot #dropdownNameProduct`).val(nameProduct);
        $(`#restaurant #${clientIdActive} #tableTotalAmount tfoot #price span`).text(priceProduct);
        $(`#restaurant #${clientIdActive} #tableTotalAmount tfoot #price`).attr("data-price", priceProduct);
    });
    $("#restaurant").on("click", "#addNewProduct #add-product", function () {
        let id = $(`#restaurant #${clientIdActive} #tableTotalAmount tfoot #addNewProduct`).attr("data-id");
        let nameProduct = $(`#restaurant #${clientIdActive} #tableTotalAmount tfoot #dropdownNameProduct`).val();
        let priceProduct = $(`#restaurant #${clientIdActive} #tableTotalAmount tfoot #price`).attr("data-price");
        let quantity = $(`#restaurant #${clientIdActive} #tableTotalAmount tfoot #units input`).val();
        let ifexist = $(`#restaurant #${clientIdActive} #tableTotalAmount tbody`).find(`tr[data-id='${id}']`);
        let totalPrice = quantity * priceProduct;
        totalPrice = parseToDecimal(totalPrice);
        if (ifexist.length == 0) {
            if (nameProduct.length > 0 && priceProduct.length > 0) {
                row =
                    `<tr data-id='${id}'>
                        <td id="name">${nameProduct}</td>
                        <td id="price" data-price='${priceProduct}'>$<span>${priceProduct}</span></td>
                        <td id="quantity"><input type="number" class="form-control" value="${quantity}"></td>
                        <td id="discount" class="cursor-pointer text-primary" data-discount="0.00">Discount</td>
                        <td id="totalPrice" class="d-flex text-primary">$ <input type="text" class="border-0" value="${totalPrice}" style="max-width: 60px;"></td>
                        <td><button id="remove-product" class="btn btn-outline-primary"><i class="fas fa-trash"></i></button></td>
                    </tr>`;
                $(`#restaurant #${clientIdActive} #tableTotalAmount tbody`).append(row);

                $(`#restaurant #${clientIdActive} #tableTotalAmount tfoot #dropdownNameProduct`).val("");
                $(`#restaurant #${clientIdActive} #tableTotalAmount tfoot #price span`).text("--");
                $(`#restaurant #${clientIdActive} #tableTotalAmount tfoot #units input`).val("1");
                $(`#restaurant #${clientIdActive} #tableTotalAmount tfoot #addNewProduct`).removeAttr("data-id");
                Restaurant.onChangeAmount();
            }
        }
        else {
            $(`#restaurant #${clientIdActive} #tableTotalAmount tfoot #alertProduct`).animate({
                display: "toggle",
                opacity: "toggle",
                display: "toggle"
            }, 2000);
        }
    });
    $("#restaurant").on("keyup", ".filter", function () {
        let value = $(this).val().toLowerCase();
        $(".dropdown-menu li").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    //Cambiar la cantidad en la tabla TotalAmount
    $("#restaurant").on("click change keyup", "#tableTotalAmount tbody tr #quantity", function () {
        let total = 0;
        let discount = 0.00;
        $($(this).closest("tr")).each(function () {
            let price = parseFloat($(this).find('#price').attr("data-price"));
            let quantityP = parseFloat($(this).find("#quantity input").val());
            let typeDiscount = $(this).find("#discount").attr("data-typediscount");
            discount = parseFloat($(this).find("#discount").attr("data-discount"));

            total += (price * quantityP);
            if (typeDiscount == "%") {
                discount = (total * discount) / 100;
            }
            total = total - discount;
        });
        total = parseToDecimal(total);
        $(this).closest("tr").find("#discount").text("$ "+discount);
        $(this).closest("tr").find("#totalPrice input").val(total);
        Restaurant.onChangeAmount();
    });
    $("#restaurant").on("click", "#tableTotalAmount tbody tr #remove-product", function () {
        $(this).closest("tr").remove();
        Restaurant.onChangeAmount();
    });
    $("#restaurant #tab-content-restaurant").on("click", "#tableTotalAmount tbody tr #discount", function () {
        $("#modalDiscount").modal();
        id = $(this).closest("tr").attr("data-id");
        $("#modalDiscount .modal-footer #save").attr("data-id", id)
        //Descuento de la tabla TotalAmount
        let discount = $(`#restaurant #${clientIdActive} #tableTotalAmount tbody tr[data-id='${id}'] #discount`).attr("data-discount");
        let typeDiscount = $(`#restaurant #${clientIdActive} #tableTotalAmount tbody tr[data-id='${id}'] #discount`).attr("data-typeDiscount");
        let reason = $(`#restaurant #${clientIdActive} #tableTotalAmount tbody tr[data-id='${id}'] #discount`).attr("data-reason");

        $("#modalDiscount .modal-body #discount").val(discount);
        if (typeDiscount == "%") {
            $("#modalDiscount .modal-body #percent").prop("checked", "checked");
        }
        else {
            $("#modalDiscount .modal-body #value").prop("checked", "checked")
        }
        $("#modalDiscount .modal-body #reason").val(reason);
    });
    $("#restaurant #tab-content-restaurant").on("click", `#tableAllocationQuantity tbody tr`, function () {
        let id = $(this).attr("data-id");
        new Restaurant().AllocationDetails(id);
    });
    $("#modalDiscount .modal-footer #save").on("click", function () {
        Restaurant.Discount();
    })
    $("#restaurant #tab-content-restaurant").on("click", "#addCustomCharge", function () {
        $("#modalAddCustomCharge #descriptionP").val("");
        $("#modalAddCustomCharge #priceP").val("");
        $("#modalAddCustomCharge #quantityP").val(1);
        $("#modalAddCustomCharge #discountP").val("");
        $("#modalAddCustomCharge #taxP").text("0.00");
        $("#modalAddCustomCharge #amountP").text("0.00");
        $("#modalAddCustomCharge").modal("show");
    });
    $("#restaurant #tab-content-restaurant").on("click","#tableBalance #confirmOrder",function(){
        new Restaurant_payment().confirmOrder();
    });
    $("#restaurant #tab-content-restaurant").on("click",".tab-pane #paidNow",function(){
        new Restaurant_payment().payNow()
    });
});