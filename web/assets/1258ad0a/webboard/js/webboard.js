$("document").ready(function($){
    /*$('.btn-like').click( function (e) {
        $(this).toggleClass("plus");
        $('.btn-unlike').removeClass("plus");
    });
    $('.btn-unlike').click( function (e) {
        $(this).toggleClass("plus");
        $('.btn-like').removeClass("plus");
    });*/
    $(".btn-popover-style").on("click", function() {
        $(this).find("span").remove();
    });
    $("form#search-box").submit(function(e){
        e.preventDefault();
        data = $("#data-search").val();
        if(data ==''){
            
            krajeeDialogDanger.alert("กรุณากรอกข้อมูลกระทู้ที่ท่านต้องการค้นหา");
            
        }else{
            window.location = "/board/search?search="+data;
        }
    });
    $(".noti-comment-item").on("click", function() {
        $('#popup-noti-comment').popoverX('hide'); //clear popup after click noti
            updateCommentReading($(this).attr("data-target"));
            if (window.location.hash != null && window.location.hash != ''){
                $('body').animate({
                    scrollTop: $(window.location.hash).offset().top - $('#mainMenu').height()*2 //clear height from mainMenu
                }, 1500);
                //console.log($(window.location.hash).offset().top - $('#mainMenu').height());
            }
    });
    checkScroll(); //scroll to position ID after redirect
    
});

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

function autoBorder(){
    var user = $(".user-data").height();
    var comment = $(".post-content").height();
    //alert(user);
    if(user > comment){
        //alert(user+"user");
        $(".user-data").css({"border-right-width": "1px", "border-right-style": "solid", "border-right-color": "rgb(150, 150, 150)"});
    }
    else{
        alert(comment+"comment");
        $(".post-content").css("border-left-width: 1px; border-left-style: solid; border-left-color: rgb(150, 150, 150)");
    }
    //alert($(".user-data").height());
}

//scroll to position ID after redirect
function checkScroll(){
    //alert();
    if (window.location.hash != null && window.location.hash != ''){
            $('body').animate({
                scrollTop: $(window.location.hash).offset().top - $('#mainMenu').height()*2 //clear height from mainMenu
            }, 1500);
    }
}

//update after click noti
function updateCommentReading(data){
    var url = "/board/update-comment-reading";
        $.ajax({
            type: "POST",
            url: url,
            data:"selected="+data,
            success: function(success){
                if(success==1){
                    //console.log("ok");
                }
                else{
                    //console.log("fuck");
                }
            }
        });
}