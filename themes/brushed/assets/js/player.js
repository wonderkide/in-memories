//var video_height = $('#player').height();
$('.vertical-video .video-wrapper').css("max-height","505px");
        
var items = $('#count-items').val();
$(".horizontal-video .video-slider-block").width(items*200);
var video_wrapper = $('.video-wrapper.horizontal-video').width();
var video_block = $(".horizontal-video .video-slider-block").width();
        
var vertical_wrapper = $('.vertical-video .video-wrapper').height();
var vertical_block = $(".vertical-video .video-slider-block").height();
        
if(video_block <= video_wrapper){
    $('.scroll-bar').hide();
}
$(window).on('resize', function(){
    video_wrapper = $('.video-wrapper.horizontal-video').width();
    video_block = $(".horizontal-video .video-slider-block").width();
    if(video_block <= video_wrapper){
        $('.scroll-bar').hide();
    }
    else{
        $('.scroll-bar').show();
    }
});

$(".video-wrapper.horizontal-video").mouseenter(function() {
    if(video_wrapper < video_block){
        showButtonSliderHz();
    }
}).mouseleave(function() {
    hideButtonSliderHz();
});
$(".vertical-video .video-wrapper").mouseenter(function() {
    if(vertical_wrapper < vertical_block){
        showButtonSliderVt();
    }
}).mouseleave(function() {
    hideButtonSliderVt();
});
function showButtonSliderHz() {
    $('#button-slider-left').show();
    $('#button-slider-right').show();
}
function hideButtonSliderHz() {
    $('#button-slider-left').hide();
    $('#button-slider-right').hide();
}
function showButtonSliderVt() {
    $('#button-slider-top').show();
    $('#button-slider-bottom').show();
}
function hideButtonSliderVt() {
    $('#button-slider-top').hide();
    $('#button-slider-bottom').hide();
}
        
$(".video-item").mouseenter(function() {
    $(this).find('.play-icon').show();
}).mouseleave(function() {
    if($(this).attr('item') != $(".video-player").attr('item')){
        $(this).find('.play-icon').hide();
    }
});

        
var interv;
$("#counter").val(0);
$("#marginnow").val(0);
$("#status").val(3);
        
$('#button-slider-left').on("click", function(e) {
    increment(2);
});
$('#button-slider-right').on("click", function(e) {
    increment(1);
});
        
function increment(typecount) {
    if ($("#status").val() == 3) {
        $("#status").val(typecount);
        var numli = $('.video-wrapper.horizontal-video').width();
        var allwidth = $(".horizontal-video .video-slider-block").width();
        var posnow = Math.abs($('#marginnow').val());
        if (typecount == 1) {
            var marginlast = posnow + numli;
            if ((marginlast + numli) < allwidth) {
                interv = setInterval(function() {
                    count(typecount, marginlast)
                }, 5);
            } else {
                interv = setInterval(function() {
                    count(typecount, allwidth)
                }, 5);
            }
        } else if (typecount == 2) {
            var marginlast = posnow - numli;
            if (marginlast > 0) {
                interv = setInterval(function() {
                    count(typecount, marginlast)
                }, 5);
            } else {
                interv = setInterval(function() {
                    count(typecount, 0)
                }, 5);
            }
        }
    } else {
        if (typecount == 3) {
            clearInterval(interv)
            $("#status").val(3);
        }
    }
}
function count(intv, marginlast) {
    var d = $("#counter").val();
    var l = $("#marginnow").val();
    if (intv == 1 && d < 100 && (l > marginlast * -1 || l == 0)) {
        var t = ++d;
        $("#counter").val(t);
        $(".ui-slider-handle").css("left", t + "%");
        var margin = Math.round(t / 100 * ($(".video-wrapper.horizontal-video").width() - $(".horizontal-video .video-slider-block").width()));
        $("#marginnow").val(margin);
        $(".horizontal-video .video-slider-block").css("margin-left", margin + "px");
    } else if (intv == 2 && d > 0 && l < marginlast * -1) {
        var t = --d;
        $("#counter").val(t);
        $(".ui-slider-handle").css("left", t + "%");
        var margin = Math.round(t / 100 * ($(".video-wrapper.horizontal-video").width() - $(".horizontal-video .video-slider-block").width()));
        $("#marginnow").val(margin);
        $(".horizontal-video .video-slider-block").css("margin-left", margin + "px");
    } else {
        increment(3);
    }
}

$(".scroll-bar").slider({
    max: 100,
    slide: function( event, ui ) {
        var margin = Math.round( ui.value / 100 * ($(".video-wrapper.horizontal-video").width() - $(".horizontal-video .video-slider-block").width()));
        $(".horizontal-video .video-slider-block").css("margin-left", margin + "px");
        $("#counter").val(ui.value);
        $("#marginnow").val(margin);
    }
});
        
var interv_vt;
$("#counter-vt").val(0);
$("#marginnow-vt").val(0);
$("#status-vt").val(3);
        
$('#button-slider-top').on("click", function(e) {
    incrementVT(2);
        console.log('#button-slider-top');
});
$('#button-slider-bottom').on("click", function(e) {
    incrementVT(1);
});
        
function incrementVT(typecount) {
        console.log(typecount);
    if ($("#status-vt").val() == 3) {
        $("#status-vt").val(typecount);
        var numli = $('.vertical-video .video-wrapper').height();
        var allwidth = $(".vertical-video .video-slider-block").height();
        var posnow = Math.abs($('#marginnow-vt').val());
        if (typecount == 1) {
            var marginlast = posnow + numli;
            if ((marginlast + numli) < allwidth) {
                interv_vt = setInterval(function() {
                    countVT(typecount, marginlast)
                }, 5);
            } else {
                interv_vt = setInterval(function() {
                    countVT(typecount, allwidth)
                }, 5);
            }
        } else if (typecount == 2) {
            var marginlast = posnow - numli;
            if (marginlast > 0) {
                interv_vt = setInterval(function() {
                    countVT(typecount, marginlast)
                }, 5);
            } else {
                interv_vt = setInterval(function() {
                    countVT(typecount, 0)
                }, 5);
            }
        }
    } else {
        if (typecount == 3) {
            clearInterval(interv_vt)
            $("#status-vt").val(3);
        }
    }
}
function countVT(intv, marginlast) {
    var d = $("#counter-vt").val();
    var l = $("#marginnow-vt").val();
    if (intv == 1 && d < 100 && (l > marginlast * -1 || l == 0)) {
        var t = ++d;
        $("#counter-vt").val(t);
        //$(".ui-slider-handle").css("left", t + "%");
        var margin = Math.round(t / 100 * ($(".vertical-video .video-wrapper").height() - $(".vertical-video .video-slider-block").height()));
        $("#marginnow-vt").val(margin);
        $(".vertical-video .video-slider-block").css("margin-top", margin + "px");
    } else if (intv == 2 && d > 0 && l < marginlast * -1) {
        var t = --d;
        $("#counter-vt").val(t);
        //$(".ui-slider-handle").css("left", t + "%");
        var margin = Math.round(t / 100 * ($(".vertical-video .video-wrapper").height() - $(".vertical-video .video-slider-block").height()));
        $("#marginnow-vt").val(margin);
        $(".vertical-video .video-slider-block").css("margin-top", margin + "px");
    } else {
        incrementVT(3);
    }
}