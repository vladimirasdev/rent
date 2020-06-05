$(document).ready(function() {
    function isMobile() {
        return ( "ontouchstart" in window || navigator.maxTouchPoints );
    }
    
    if (!isMobile()) {
        $(".dropdown, .btn-group").hover(
            function() {
            $(".dropdown-menu", this).stop( true, true ).fadeIn("fast");
                $(this).addClass("show");
            },
            function() {
            $(".dropdown-menu", this).stop( true, true ).fadeOut("fast");
                $(this).removeClass("show");
            }
        );
    }

    $("#search-button").mouseover(function () {
        $("#search-input").focus();
    });
    $("button.navbar-toggler").click(function () {
        $("#search-input").css({"width": "15rem", "background": "#FFF", "margin-right": "-35px", "padding-right": "35px", "border-style": "solid", "outline": "none", "box-shadow": "none"});
        $("#search-input").focus();
    });

    $("input[id='in']").click(function () {
        $("#numList").removeClass("badge-secondary badge-warning text-dark").addClass("badge-info text-white");
    });
    $("input[id='hold']").click(function () {
        $("#numList").removeClass("badge-info badge-warning text-dark").addClass("badge-secondary text-white");
    });
    $("input[id='out']").click(function () {
        $("#numList").removeClass("badge-secondary badge-info text-white").addClass("badge-warning text-dark");
    });

});

function copyToClipboard(selector) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(selector).text()).select();
    document.execCommand("copy");
    $temp.remove();
}