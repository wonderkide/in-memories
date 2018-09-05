$("document").ready(function($){
    $('.btn-like').click( function (e) {
        cat_id = $(this).attr('data-cat');
        cat = $(this).attr('data-type');
        sub_cat = $(this).attr('data-sub-cat');
        owner = $(this).attr('data-owner');
        updateLike(cat_id, cat, sub_cat, owner, 1);
    });
    $('.btn-unlike').click( function (e) {
        cat_id = $(this).attr('data-cat');
        cat = $(this).attr('data-type');
        sub_cat = $(this).attr('data-sub-cat');
        owner = $(this).attr('data-owner');
        updateLike(cat_id, cat, sub_cat, owner, -1);
    });
});

function updateLike(id, cat, sub_cat, owner, val){
        var url = "/likebox/updatelike";
        var id_like = '#like-'+cat+'-'+id;
        var id_unlike = '#unlike-'+cat+'-'+id;
        $.ajax({
            type: "POST",
            url: url,
            data:"id="+id+'&cat='+cat+'&sub_cat='+sub_cat+'&owner='+owner+'&val='+val,
            success: function(success){
                if(success==0){
                    alert("เกิดข้อผิดพลาด! กรุณาลองใหม่อีครั้งภายหลัง");
                }
                else{
                    cut = success.split(",");
                    $(id_like+'.btn-like .badge').html(cut[0]);
                    $(id_unlike+'.btn-unlike .badge').html(cut[1]);
                    if(val == 1){
                        $(id_like+'.btn-like').toggleClass("plus");
                        $(id_unlike+'.btn-unlike').removeClass("plus");
                    }
                    if(val == -1){
                        $(id_unlike+'.btn-unlike').toggleClass("plus");
                        $(id_like+'.btn-like').removeClass("plus");
                    }
                }
            }
        });
}