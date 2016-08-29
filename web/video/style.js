$("document").ready(function () {

    $("#30secButton").click(function () {
        $("#videoLength").val("short");
        $(this).addClass("active");
        $("#10minButton").removeClass("active");
    })

    $("#10minButton").click(function () {
        $("#videoLength").val("long");
        $(this).addClass("active");
        $("#30secButton").removeClass("active");
    })

    var $videoSelectBox = $("#videoSelectBox").find("option");
    $("#videoCheckAllButton").click(function () {
        $videoSelectBox.prop("selected", true);
    });

    $("#videoCheckNoneButton").click(function () {
        $videoSelectBox.prop("selected", false);
    });

    var bigPayload = "";
    $("#videoPastePayload").click(function () {
         jQuery.get("/audio/bigPayload.txt", function (response) {
            bigPayload = response;
            $("#videoPayload").val(bigPayload);
        });
    });

    function checkMaxLengths() {
        if($("#videoPayload").val().length > 1268) {
            $("option[value='podcastURL']").attr("disabled", "disabled");
            $("option[value='podcastGUID']").attr("disabled", "disabled");
            $("option[value='lyrics']").attr("disabled", "disabled");
        }
        else if ($("#videoPayload").val().length > 256) {
            $("option[value='lyrics']").attr("disabled", "disabled");


            // REMOVE bigger disabled ones
            $("option[value='podcastURL']").removeAttr("disabled");
            $("option[value='podcastGUID']").removeAttr("disabled");
        }
        else {
            $("option[value='lyrics']").removeAttr("disabled");
            $("option[value='podcastURL']").removeAttr("disabled");
            $("option[value='podcastGUID']").removeAttr("disabled");
        }
    }

    $("#videoPayload").change(function () {
        checkMaxLengths();
    });

});