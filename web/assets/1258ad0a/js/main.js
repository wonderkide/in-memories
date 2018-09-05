/*document.onreadystatechange = function(e)
{
if(document.readyState=="interactive")
{
var all = document.getElementsByTagName("*");
document.getElementById("progress_div").style.display="block";
for (var i=0, max=all.length; i < max; i++) 
{
	set_ele(all[i]);
}
}
};
function check_element(ele)
{
	var all = document.getElementsByTagName("*");
	var totalele=all.length;
	var per_inc=100/(all.length);

    if($(ele).on())
	{
		var prog_width=per_inc+Number(document.getElementById("progress_width").value);
		document.getElementById("progress_width").value=prog_width;
		$("#bar1").animate({width:prog_width+"%"},10,function(){
			if(document.getElementById("bar1").style.width=="100%")
			{
				$(".progress").fadeOut("slow");
			}
		});
		
		

	}
	else	
	{
		set_ele(ele);
	}
        console.log(all.length);
}
function set_ele(set_element)
{
	check_element(set_element);
}*/

$("document").ready(function($){

    $(document).on("click", function(e) {
        if ($(e.target).is(".notify-dropdown") === false) {
          $('.notify-dropdown').parent().removeClass("open");
        }
    });
    $('#menu-nav .notify-list').on('click', function(e){
        $('.notify-dropdown').parent().toggleClass('open');
        e.stopPropagation();
    });

    //$( ".widget-content .image-gallery" ).show( "scale", 500 );
    
    //changeNavActive();
    
    /*var nav = $('#mainMenu');
    var check = nav.offset().top;
    $(window).scroll(function () {
        if ($(this).scrollTop() > check) {
            nav.addClass("navbar-fixed-top");
        } else {
            nav.removeClass("navbar-fixed-top");
        }
    });
    
    if ($('#back-to-top').length) {
        var scrollTrigger = 100, // px
            backToTop = function () {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('#back-to-top').addClass('show');
                } else {
                    $('#back-to-top').removeClass('show');
                }
            };
        backToTop();
        $(window).on('scroll', function () {
            backToTop();
        });
        $('#back-to-top').on('click', function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: 0
            }, 700);
        });
    }*/
    $('img#crop-profile-img').imgAreaSelect({ 
        aspectRatio: '1:1',
        //maxWidth: 200, 
        //maxHeight: 150, 
        handles: true ,
        onSelectEnd: function (img, selection) {
            $('input[name="x1"]').val(selection.x1);
            $('input[name="y1"]').val(selection.y1);
            $('input[name="x2"]').val(selection.x2);
            $('input[name="y2"]').val(selection.y2);
        }
    });
    
    //click gallery to show view all
    $('.filtr-item').click( function (e) {
        slug =  $(this).attr('data-selected');
        window.location = "/gallery/view/"+slug;
    });
    
    //var check_double = 0;
    $("#update-drag-item").change(function(){
        var check = $("#update-drag-item-sortable > li").length;
        var data = [];
        for(i=0;i<check;i++){
            data[i] = document.getElementsByName("data-selected")[i].value;
        }
        var link = $("#link-to").val();
        updateDragSort(data.join(), link);
        
    });
    
    $('.gallery-sort .action .edit-caption').click( function (e) {

        data = $(this).attr("data-selected");
        getCaption(data, 'gallery');
    });
    $('.video-model-manage .edit-caption').click( function (e) {

        data = $(this).attr("data-selected");
        getCaption(data, 'video');
    });
    
    //personal show edit profile
    $('#show-profile .btn').click( function (e) {

        $('#show-profile').hide();
        $('#edit-profile').show();
    });
    $('#edit-profile #back-show-profile').click( function (e) {
        $('#edit-profile').hide();
        $('#show-profile').show();
    });
    
    //close nofify
    $('.close-notify').click( function (e) {
        clearNotify();
    });
    
    //update read alert content
    $('.read-checked').click( function (e) {
        var id = $(this).attr('data-selected');
        var action = $(this).attr('data-action');
        changeRead(id, action);
    });
    
    $('.gallery-filter').click( function (e) {
        var to = $(this).attr('to');
        var check = $('#'+to).val();
        if(check == 1){
            $('#'+to).val(-1);
        }
        else{
            $('#'+to).val(1);
        }
        $("form#search-gallery-box").submit();
    });
    
    /*$("form#search-gallery-box").submit(function(e){
        e.preventDefault();
        data = $("#data-search").val();
            //window.location = "/gallery?search="+data;
    });*/
    
    /*$('#date-expend-selected').change(function(){
        var select = $('#date-expend-selected').val();
        getExpend(select);
    });
    var select = $('#date-expend-selected').val();
    getExpend(select);*/
    
});
function clearusernotify(id){
    var url = "/notify/clearusernotify";
    $.ajax({
            type: "POST",
            url: url,
            data:"selected="+id,
            success: function(result){
                if(result==1){
                    $('.notify-badge').remove();
                }
            }
    });
}
function thaiDate(date){
    var now = new Date(date);
    var thday = new Array ("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัส","ศุกร์","เสาร์"); 
    var thmonth = new Array ("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    
    var newdate = "วัน" + thday[now.getDay()]+ "ที่ "+ now.getDate()+ " " + thmonth[now.getMonth()]+ " " + (0+now.getFullYear()+543);

    return newdate;

}
function getExpend(date){
    var url = "/expend/getdata";
        $.ajax({
            type: "POST",
            url: url,
            data:"date="+date,
            success: function(data){
                if(data == 1){
                    var newdate = thaiDate(date);
                    $("#for-date").text(newdate);
                    $(".expend-list").text('');
                    $(".expend-list").append('<p class="text-danger text-center">ไม่พบข้อมูล</p>');
                    $(".expend-list").append('<div class="text-center"><a href="/expend/create">เพิ่ม...</a></div>');
                }
                else if(data && data != 1){
                    var newdate = thaiDate(date);
                    $("#for-date").text(newdate);
                    $(".expend-list").text('');
                    $(".expend-list").append('<ul class="list-group"></ul>');
                    for(i=0;i<data.length;i++){
                        var theme;
                        if(data[i].status===1){
                            theme = "success";
                        }
                        else{
                            theme = "danger";
                        }
                        $(".expend-list ul").append('<li class="list-group-item list-group-item-'+theme+'"><div class="row"><div class="col-xs-6">'+data[i].tag+'</div><div class="col-xs-6">จำนวน '+data[i].price+' บาท</div></div></li>');
                    }
                    $(".expend-list").append('<div class="text-center"><a href="/expend/?date='+date+'">รายละเอียด</a></div>');
                }
                else{
                    //alert("เกิดข้อผิดพลาด! การเชื่อมต่อล้มเหลว");
                    bootboxalert("small", "<i class='fa fa-times-circle' aria-hidden='true'></i> มีบางอย่างผิดพลาด", "การเชื่อมต่อล้มเหลว", null);
                }
                
            }
    });
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

//active NavBar another controller
function changeNavActive(){
    
    data = $("#nav-data-action").val();
    if(data != "wonder" && data != "site"){
        $("#mainMenu li").removeClass("active");
        $('#'+data).parent().parent().addClass('active');
    }
    
}

function checkZenyBet(val) {
    if(isNaN(val)){
        //alert("กรุณากรอกจำนวนเงินเป็นตัวเลข!");
        bootboxalert("small", "<i class='fa fa-times-circle' aria-hidden='true'></i> มีบางอย่างผิดพลาด", "กรุณากรอกจำนวนเงินเป็นตัวเลข!", null);
        document.getElementById("zenybet").value = "";
    }
}


function updateZeny(id){
    bootbox.confirm({ 
        size: "small",
        message: "ท่านต้องการจะรับเงินเลยใช่ไหม?", 
        buttons: {
            confirm: {
                label: 'ใช่',
                className: 'btn-danger'
            },
            cancel: {
                label: 'ไม่',
                className: 'btn-default'
            }
        },
        callback: function(result){ 
            if(result){
                var url = "/games/updatezeny?log="+id;
                $.ajax({
                    type: "GET",
                    url: url,
                    cache: false,
                    success: function(msg){
                        if(msg==1){
                            //alert("เงินทั้งหมดได้เข้าบัญชีคุญเรียบร้อยแล้ว!");
                            bootboxalert("small", "<i class='fa fa-check-circle' aria-hidden='true'></i> เรียบร้อย", "เงินทั้งหมดได้เข้าบัญชีคุญเรียบร้อยแล้ว", "reload");
                            //window.location.reload();
                        }
                        else{
                            alertMessege(msg);
                        }
                    }
                });
            }
        }
    });
}



function alertMessege(status){
    
    /******check validate****/
    if(status==1)
        //alert('ท่านจำเป็นต้องลงชื่อเข้าใช้ระบบก่อนที่จะเล่นเกมส์'); //login
        bootboxalert("null", "<i class='fa fa-times-circle' aria-hidden='true'></i> มีบางอย่างผิดพลาด", "ท่านจำเป็นต้องลงชื่อเข้าใช้ระบบก่อนที่จะเล่นเกมส์", null);
    else if(status==0)
        //alert('กรุณาเลือกทีมที่ต้องการเล่นก่อนทำรายการ');  //selected
        bootboxalert("null", "<i class='fa fa-times-circle' aria-hidden='true'></i> มีบางอย่างผิดพลาด", "กรุณาเลือกทีมที่ต้องการเล่นก่อนทำรายการ", null);
    else if(status==37)
        //alert("กรุณาเลือกทีมอย่างน้อย 3 ทีม แต่ไม่เกิน 7 ทีม"); //select 3-10
        bootboxalert("null", "<i class='fa fa-times-circle' aria-hidden='true'></i> มีบางอย่างผิดพลาด", "กรุณาเลือกทีมอย่างน้อย 3 ทีม แต่ไม่เกิน 7 ทีม", null);
    else if(status==101)
        //alert('ท่านยังไม่สามารถเลือกการเล่นคู่นี้ได้ในขณะนี้'); //not post
        bootboxalert("null", "<i class='fa fa-times-circle' aria-hidden='true'></i> มีบางอย่างผิดพลาด", "ท่านยังไม่สามารถเลือกการเล่นคู่นี้ได้ในขณะนี้", null);
    else if(status==201)
        //alert('ไม่มีสเต็ปที่ยังไม่ประมวลผล'); //check step log
        bootboxalert("null", "<i class='fa fa-times-circle' aria-hidden='true'></i> มีบางอย่างผิดพลาด", "ไม่มีสเต็ปที่ยังไม่ประมวลผล", null);
    
    /******server*****/
    else if(status==501)
        //alert('เกิดข้อผิดพลาดในการเชื่อมต่อ server');//server error
        bootboxalert("null", "<i class='fa fa-times-circle' aria-hidden='true'></i> มีบางอย่างผิดพลาด", "เกิดข้อผิดพลาดในการเชื่อมต่อ server", null);
    
    else if(status==500)
        //alert('ขาดการเชื่อมต่อกับ server โปรดลองใหม่อีกครั้ง'); //server error
        bootboxalert("null", "<i class='fa fa-times-circle' aria-hidden='true'></i> มีบางอย่างผิดพลาด", "ขาดการเชื่อมต่อกับ server โปรดลองใหม่อีกครั้ง", null);
    
    /*******zeny******/
    else if(status==8)
        //alert('zeny ของคุณมีไม่พอ\nต้องการ zeny เพิ่มหรือ?\nขอร้องกูซิ LOL'); //not zeny
        bootboxalert("null", "<i class='fa fa-times-circle' aria-hidden='true'></i> มีบางอย่างผิดพลาด", "zeny ของคุณมีไม่พอ ต้องการ zeny เพิ่มหรือ? ขอร้อง Admin ซิ :)", null);
    else if(status==88)
        //alert('กรุณาใส่จำนวนเงิน zeny'); //not zeny
        bootboxalert("null", "<i class='fa fa-times-circle' aria-hidden='true'></i> มีบางอย่างผิดพลาด", "กรุณาใส่จำนวนเงิน zeny", null);
    else if(status==888)
        //alert('กรุณาใส่จำนวนเงิน zeny ขั้นต่ำ 50 แต่ไม่เกิน 10,000'); //zeny min max
        bootboxalert("null", "<i class='fa fa-times-circle' aria-hidden='true'></i> มีบางอย่างผิดพลาด", "กรุณาใส่จำนวนเงิน zeny ขั้นต่ำ 50 แต่ไม่เกิน 10,000", null);
    
    else if(status==300)
        //alert('ท่านไม่สามารถเล่นเกมส์ได้เนื่องจากอยู่นอกเวลา 12.00 - 03.00');
        bootboxalert("null", "<i class='fa fa-times-circle' aria-hidden='true'></i> มีบางอย่างผิดพลาด", "ท่านไม่สามารถเล่นเกมส์ได้เนื่องจากอยู่นอกเวลา 12.00 - 03.00", null);
    else if(status==301)
        //alert('คู่ที่ท่านเลือกไม่ได้เปิดให้เล่นในวันนี้');
        bootboxalert("null", "<i class='fa fa-times-circle' aria-hidden='true'></i> มีบางอย่างผิดพลาด", "คู่ที่ท่านเลือกไม่ได้เปิดให้เล่นในวันนี้", null);
    else if(status==302)
        //alert('คู่ที่ท่านเลือกได้ทำการเริ่มแข่งแล้ว');
        bootboxalert("null", "<i class='fa fa-times-circle' aria-hidden='true'></i> มีบางอย่างผิดพลาด", "คู่ที่ท่านเลือกได้เริ่มแข่งไปแล้ว", null);
    else if(status==999)
        //alert('ทำรายการเสร็จสิ้น!'); //error add
        bootboxalert("null", "<i class='fa fa-check-circle' aria-hidden='true'></i> เรียบร้อย", "ทำรายการเสร็จสิ้น", "reload");
    
    else if(status==191)
        //alert('Mother fucker!!!'); //WTF
        bootboxalert("null", "<i class='fa fa-times-circle' aria-hidden='true'></i> มีบางอย่างผิดพลาด", "Mother fucker!!!", null);
}

function imageCrop(){

    var pic = $("#crop-profile-img").attr('src');
    var x = $("#x1").val();
    var y = $("#y1").val();

    var width = $("#x2").val()-$("#x1").val();
    var height = $("#y2").val()-$("#y1").val();
    var mem_id = $("#mem_id").val();
    //alert(x);
    $.ajax({
        type: "POST",
        url: "/personal/cropimg",
        data:"x="+x+'&y='+y+'&width='+width+'&height='+height+'&pic='+pic+'&mem_id='+mem_id,
        success: function(r){

                if(r == 1){
                    //alert('เปลี่ยนรูปโปรไฟล์สำเร็จ!');
                    bootboxalert("small", "<i class='fa fa-check-circle' aria-hidden='true'></i> เรียบร้อย", "เปลี่ยนรูปโปรไฟล์สำเร็จ", "/personal");
                    //window.location = "/personal";
                }
        }
    });
}

function changeTag(action) {
    var action = $("#checkAc").val();
    var stat = $("#stat").val();
    var acUrl;
    if(action == "add"){
        acUrl = "addnote";
    }
    else{
        acUrl = "editnote";
    }
    
    var url = "/wonder/"+acUrl+"?stat="+stat;
    alert(acUrl+stat);
    $.ajax({
        type: "GET",
        url: url,
        success: function(r){
                if(r == 1){
                    //alert('เปลี่ยนรูปโปรไฟล์สำเร็จ!');
                    bootboxalert("small", "<i class='fa fa-check-circle' aria-hidden='true'></i> เรียบร้อย", "อัพเดทข้อมูลสำเร็จ", null);
                }
        }
    });
}

function getCaption(data, link){
    var url = "/"+link+"/getcaption";
        $.ajax({
            type: "POST",
            url: url,
            data:"selected="+data,
            success: function(image){
                if(image==0){
                    //alert("เกิดข้อผิดพลาด! กรุณาลองใหม่อีครั้งภายหลัง");
                    bootboxalert("small", "<i class='fa fa-times-circle' aria-hidden='true'></i> เกิดข้อผิดพลาด!", "กรุณาลองใหม่อีครั้งภายหลัง", null);
                }
                else{
                    cut = image.split(",");
                    $('#caption_selected').val(cut[0]);
                    $('#caption_title').val(cut[1]);
                    $('#caption_detail').val(cut[2]);
                    $('#CaptionModal').modal('show');
                }
            }
        });
}

function updateCaption(){
    data = $('#caption_selected').val();
    title = $('#caption_title').val();
    detail = $('#caption_detail').val();
    to = $('#link-to').val();
    var url = "/"+to+"/updatecaption";
        $.ajax({
            type: "POST",
            url: url,
            data:"selected="+data+'&title='+title+'&detail='+detail,
            success: function(image){
                $('#CaptionModal').modal('hide');
                if(image==1){
                    if(title.length > 20){
                        title = title.substring(0, 20)+"...";
                    }
                    if(detail.length > 20){
                        detail = detail.substring(0, 20)+"...";
                    }
                    $('#caption-'+data+' .title').text(title);
                    $('#caption-'+data+' .detail').text(detail);
                    action = "success";
                    title = "เรียบร้อย!";
                    content = "แก้ไขข้อมูลเรียบร้อย";
                    notifyAnimate(action, title, content);
                }
                else{
                    action = "danger";
                    title = "เกิดข้อผิดพลาด!";
                    content = "กรุณาลองใหม่ภายหลัง";
                    notifyAnimate(action, title, content);
                }
            }
        });
}

function updateDragSort(data, link){
        var url = "/"+link+"/updatesort";
        $.ajax({
            type: "POST",
            url: url,
            data:"data="+data,
            success: function(msg){
                if(msg==0){
                    //alert("เกิดข้อผิดพลาด! กรุณาลองใหม่อีครั้งภายหลัง");
                    bootboxalert("small", "<i class='fa fa-times-circle' aria-hidden='true'></i> เกิดข้อผิดพลาด!", "กรุณาลองใหม่อีครั้งภายหลัง", null);
                }
                return;

            }
        });
}

function changeRead(data, action){
    var url = "/"+action+"/changeread";
        $.ajax({
            type: "POST",
            url: url,
            data:"selected="+data,
            success: function(success){
                if(success==0){
                    //alert("เกิดข้อผิดพลาด! กรุณาลองใหม่อีครั้งภายหลัง");
                    bootboxalert("small", "<i class='fa fa-times-circle' aria-hidden='true'></i> เกิดข้อผิดพลาด!", "กรุณาลองใหม่อีครั้งภายหลัง", null);
                }
                else{
                    return;
                }
            }
        });
}

function showeditprofile(){
    $('#show-profile').hide();
    $('#edit-profile').show();
}

function notifyAnimate(action, title, content){
    selectedEffect = "blind";
    options = null;
    if(action == "success"){
        $( "#notify-access-caption" ).addClass("bg-success text-success");
        $( "#notify-access-caption #icon-notify" ).addClass("glyphicon glyphicon-ok-circle");
    }
    if(action == "danger"){
        $( "#notify-access-caption" ).addClass("bg-danger text-danger");
        $( "#notify-access-caption #icon-notify" ).addClass("glyphicon glyphicon-remove-circle");
    }
    if(action == "info"){
        $( "#notify-access-caption" ).addClass("bg-info text-info");
        $( "#notify-access-caption #icon-notify" ).addClass("glyphicon glyphicon-info-sign");
    }
    if(action == "primary"){
        $( "#notify-access-caption" ).addClass("bg-primary text-primary");
        $( "#notify-access-caption #icon-notify" ).addClass("glyphicon glyphicon-info-sign");
    }
    if(action == "warning"){
        $( "#notify-access-caption" ).addClass("bg-warning text-warning");
        $( "#notify-access-caption #icon-notify" ).addClass("glyphicon glyphicon-exclamation-sign");
    }
    if(action == "default" || !action){
        $( "#notify-access-caption" ).addClass("bg-info text-info");
        $( "#notify-access-caption #icon-notify" ).addClass("glyphicon glyphicon-info-sign");
    }
    $( "#notify-access-caption .title" ).html(title);
    $( "#notify-access-caption .content" ).html(content);
    $( "#notify-access-caption" ).show( selectedEffect, options, 500 );
    setTimeout(function(){
        clearNotify();
    }, 3000);
}
function clearNotify(){
    $( "#notify-access-caption" ).hide( selectedEffect, options, 500 );
}
function bootboxalert(size, title, message, callback){
    bootbox.alert({ 
        size: size,
        title: title,
        message: message, 
        buttons: {
            ok: {
                label: 'ตกลง',
                className: 'btn-danger'
            }
        },
        callback: function(){ 
            if(callback){
                if(callback=="reload"){
                    window.location.reload();
                }
                else{
                    window.location = callback;
                }
            }
        }
    });
}