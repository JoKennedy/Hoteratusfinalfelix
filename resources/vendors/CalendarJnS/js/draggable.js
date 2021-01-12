var elementDragable = "";
    var containerDraggable = "";
$(document).ready(function () {
    /*=====================================================
    AGREGAR LA CLASE 'itemDraggable' A LOS ITEMS DRAGGABLES
    AGREGAR LA CLASE 'containerDraggable' A LOS CONTAINERS
    =====================================================*/
    
    $(document).on("dragstart", ".itemDraggable", function (e) {
        elementDragable = this;
    });
    $(document).on("drag", ".itemDraggable", function (e) {
        $(this).css({ "opacity": "0.8" });
    });
    $(document).on("dragover", ".containerDragable", function (e) {
        $(this).css({ "background": "#008b8b45" });
        if ($(this).find("span").length <= 0) {
            e.originalEvent.preventDefault();
        }
        else {
            $(this).css({ "background": "#ff000029" });
        }
    });
    $(document).on("dragleave", ".containerDragable", function () {
        $(this).css({ "background": "#fff" })
    });
    $(document).on("dragend", ".itemDraggable", function () {
        $(this).css({ "opacity": "1" });
    });
    $(document).on("drop", ".containerDragable", function (ev) {
        ev.originalEvent.preventDefault();
        let container = this;
        let position = $(this).position();
        $(elementDragable).css({ "position": "absolute" });
        $(elementDragable).animate({
            top: position.top + 117,
            left: position.left + 1,
            'position': 'static',
        },
            function () {
                //$(elementDragable).css({"position":"static"});
                //$(elementDragable).css({"top":"inherit"});
                //$(elementDragable).css({"left":"inherit"});
                let Id = $(elementDragable).attr("data-id");
                let from = formatDate($(container).attr("data-year"), $(container).attr("data-month"), $(container).attr("data-day"));
                let to = $(elementDragable).attr("data-stayTo");
                let parent = $(container).closest("tr");
                let roomNumber = parent.find("[data-index]").attr("data-index");
                let roomName = parent.attr("data-typeroomname")


                $("#modalUpdateRoom .modal-body #from").val(from);
                $("#modalUpdateRoom .modal-body #to").val(to);
                $("#modalUpdateRoom .modal-body #roomNumber").html(`<option>${roomNumber}</option>`);
                $("#modalUpdateRoom .modal-body #roomType").html(`<option>${roomName}</option>`);
                $("#modalUpdateRoom .modal-footer #btnUpdateRoom").attr("data-id", Id);

                modalUpdateReserv(elementDragable, container);
                //if (response) {
                    //llamar la function para reguistrar al dia movido y reellamar al calendario en la misma fecha que este
                    //$(elementDragable).appendTo(container)
                    containerDraggable = container;
                //}
            })
        $(this).css({ "background": "#fff" })
    });
});