function setCustomCursor(cursor) {
    document.querySelectorAll('*').forEach(function(node) {
        node.style.cursor = cursor;
    });
}

custom_cursor_checkbox = document.getElementsByClassName("custom_cursor")[0];

if (typeof custom_cursor_checkbox != "undefined") {
    if (custom_cursor == 1 || $(".custom_cursor").is(":checked")) {
        custom_cursor_checkbox.checked = 1;
        setCustomCursor("url(images/cursor/cursor_32.png), auto");
    } else {
        custom_cursor_checkbox.checked = 0;
        setCustomCursor("auto");
    }
} else {
    if (custom_cursor == 1) {
        setCustomCursor("url(images/cursor/cursor_32.png), auto");
    } else {
        setCustomCursor("auto");
    }
}

$(document).ready(() => {
    $(".custom_cursor").click(() => {
        if ($(".custom_cursor").is(":checked")) {
            setCustomCursor("url(images/cursor/cursor_32.png), auto");
        } else {
            setCustomCursor("auto");
        }
    })
});