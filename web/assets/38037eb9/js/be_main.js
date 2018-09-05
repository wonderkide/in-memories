function closeMatch(id){
        //var urlTicket = "<?php //echo $this->createUrl('/admin/default/selectleague') ?>/?id="+id;
        if(confirm("ท่านต้องการปิดผลการแข่งขันคู่นี้?")){
            var url = "/wonderkide/match/cancelmatch?id="+id;
            $.ajax({
                type: "GET",
                url: url,
                cache: false,
                success: function(msg){
                    alertMessege(msg);
                    window.location.reload();
                }
            });
        }
    }


function alertMessege(status){
    
    /******check validate****/
    if(status==1)
        alert('ท่านจำเป็นต้องลงชื่อเข้าใช้ระบบก่อนที่จะเล่นเกมส์'); //login
    else if(status==0)
        alert('กรุณาเลือกทีมที่ต้องการเล่นก่อนทำรายการ');  //selected
    else if(status==37)
        alert("กรุณาเลือกทีมอย่างน้อย 3 ทีม แต่ไม่เกิน 7 ทีม"); //select 3-10
    else if(status==101)
        alert('ท่านยังไม่สามารถเลือกการเล่นคู่นี้ได้ในขณะนี้'); //not post
    else if(status==201)
        alert('ไม่มีสเต็ปที่ยังไม่ประมวลผล'); //check step log
    
    /******server*****/
    else if(status==501)
        alert('เกิดข้อผิดพลาดในการเชื่อมต่อ server');//server error
    
    else if(status==500)
        alert('ขาดการเชื่อมต่อกับ server โปรดลองใหม่อีกครั้ง'); //server error
    
    /*******zeny******/
    else if(status==8)
        alert('zeny ของคุณมีไม่พอ\nต้องการ zeny เพิ่มหรือ?\nขอร้องกูซิ LOL'); //not zeny
    else if(status==88)
        alert('กรุณาใส่จำนวนเงิน zeny'); //not zeny
    else if(status==888)
        alert('กรุณาใส่จำนวนเงิน zeny ขั้นต่ำ 50 แต่ไม่เกิน 10,000'); //zeny min max
    
    else if(status==300)
        alert('ท่านไม่สามารถเล่นเกมส์ได้เนื่องจากอยู่นอกเวลา 12.00 - 03.00');
    else if(status==301)
        alert('คู่ที่ท่านเลือกไม่ได้เปิดให้เล่นในวันนี้');
    else if(status==302)
        alert('คู่ที่ท่านเลือกได้ทำการเริ่มแข่งแล้ว');
    else if(status==999)
        alert('ทำรายการเสร็จสิ้น!')    ; //error add
    
    
    else if(status==191)
        alert('Mother fucker!!!')    ; //WTF
}