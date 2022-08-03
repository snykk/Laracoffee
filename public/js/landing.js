$(".masthead").mousemove(function (event) {
    var mouseX = (event.pageX * -1) / 150;
    var mouseY = (event.pageY * -1) / 150;

    $(this).css("background-position", mouseX, mouseY);
});
