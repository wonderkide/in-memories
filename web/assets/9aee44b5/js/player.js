//var video_height = $('#player').height();
$('.vertical-video .video-wrapper').css("max-height","505px");
        
var items = $('#count-items').val();
var HzItemWidth = $(".horizontal-video .video-item").width();
$(".horizontal-video .video-slider-block").width(items*HzItemWidth);
console.log(HzItemWidth);
var video_wrapper = $('.video-wrapper.horizontal-video').width();
var video_block = $(".horizontal-video .video-slider-block").width();
        
var VtItemHeight = $(".vertical-video .video-item").height();
var vertical_wrapper = $('.vertical-video .video-wrapper').height();
var vertical_block = $(".vertical-video .video-slider-block").height();
        
if(video_block <= video_wrapper){
    $('.scroll-bar').hide();
}
$(window).on('resize', function(){
    video_wrapper = $('.video-wrapper.horizontal-video').width();
    video_block = $(".horizontal-video .video-slider-block").width();
    vertical_wrapper = $('.vertical-video .video-wrapper').height();
    vertical_block = $(".vertical-video .video-slider-block").height();
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
                    count(typecount, marginlast);
                }, 5);
            } else {
                interv = setInterval(function() {
                    count(typecount, allwidth);
                }, 5);
            }
        } else if (typecount == 2) {
            var marginlast = posnow - numli;
            if (marginlast > 0) {
                interv = setInterval(function() {
                    count(typecount, marginlast);
                }, 5);
            } else {
                interv = setInterval(function() {
                    count(typecount, 0);
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
});
$('#button-slider-bottom').on("click", function(e) {
    incrementVT(1);
});
        
function incrementVT(typecount) {
    if ($("#status-vt").val() == 3) {
        $("#status-vt").val(typecount);
        var numli = $('.vertical-video .video-wrapper').height();
        var allwidth = $(".vertical-video .video-slider-block").height();
        var posnow = Math.abs($('#marginnow-vt').val());
        if (typecount == 1) {
            var marginlast = posnow + numli;
            if ((marginlast + numli) < allwidth) {
                interv_vt = setInterval(function() {
                    countVT(typecount, marginlast);
                }, 5);
            } else {
                interv_vt = setInterval(function() {
                    countVT(typecount, allwidth);
                }, 5);
            }
        } else if (typecount == 2) {
            var marginlast = posnow - numli;
            if (marginlast > 0) {
                interv_vt = setInterval(function() {
                    countVT(typecount, marginlast);
                }, 5);
            } else {
                interv_vt = setInterval(function() {
                    countVT(typecount, 0);
                }, 5);
            }
        }
    } else {
        if (typecount == 3) {
            clearInterval(interv_vt);
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

function sliderItem(item){
    var count_item = $('#count-items').val();
    var HzWrapperWidth = video_wrapper;
    var HzAllWidth = video_block;
    
    if(video_block > video_wrapper){
        if(parseInt(item) !== 0 && parseInt(item) !== 1){
            var margin_max = (HzAllWidth-HzWrapperWidth)*-1;
            var margin = (item - 1)*HzItemWidth*-1;
            if(parseInt(count_item) === (parseInt(item)+1) || parseInt(margin_max) > parseInt(margin)){
                $("#marginnow").val(margin_max);
                $(".horizontal-video .video-slider-block").css("margin-left", margin_max + "px");
                $("#counter").val(100);
                $(".ui-slider-handle").css("left", "100%");
            }
            else{
                $("#marginnow").val(margin);
                $(".horizontal-video .video-slider-block").css("margin-left", margin + "px");

                var percent = Math.floor(HzItemWidth*100/HzAllWidth)*2;
                var percent_for_item = percent*((parseInt(item)-1));

                $("#counter").val(percent_for_item);
                $(".ui-slider-handle").css("left", percent_for_item + "%");
            }
            
        }
        else{
            $("#marginnow").val(0);
            $(".horizontal-video .video-slider-block").css("margin-left", 0 + "px");
            $("#counter").val(0);
            $(".ui-slider-handle").css("left", "0%");
        }
    }
    if(vertical_block > vertical_wrapper){
        if(parseInt(item) !== 0 && parseInt(item) !== 1){
            var margin_max = (vertical_block-vertical_wrapper)*-1;
            var margin = (item - 1)*VtItemHeight*-1;
            if(parseInt(count_item) === (parseInt(item)+1) || parseInt(margin_max) > parseInt(margin)){
                $("#counter-vt").val(100);
                $("#marginnow-vt").val(margin_max);
                $(".vertical-video .video-slider-block").css("margin-top", margin_max + "px");
            }
            else{
                var percent = Math.floor(VtItemHeight*100/vertical_wrapper)*2;
                var percent_for_item = percent*((parseInt(item)-1));

                $("#counter-vt").val(100);
                $("#marginnow-vt").val(margin);
                $(".vertical-video .video-slider-block").css("margin-top", margin + "px");
            }
            
        }
        else{
            $("#counter-vt").val(0);
            $("#marginnow-vt").val(0);
            $(".vertical-video .video-slider-block").css("margin-top", 0 + "px");
        }
    }
}