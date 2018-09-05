var current_selected;
var current_played;
var eat = false;

$("document").ready(function($){
    
    $('#1_1').append('<div class="play play-1"></div>');
    $('#1_2').append('<div class="play play-1"></div>');
    $('#1_3').append('<div class="play play-1"></div>');
    $('#1_4').append('<div class="play play-1"></div>');
    
    $('#2_1').append('<div class="play play-1"></div>');
    $('#2_2').append('<div class="play play-1"></div>');
    $('#2_3').append('<div class="play play-1"></div>');
    $('#2_4').append('<div class="play play-1"></div>');
    
    $('#7_1').append('<div class="play-2"></div>');
    $('#7_2').append('<div class="play-2"></div>');
    $('#7_3').append('<div class="play-2"></div>');
    $('#7_4').append('<div class="play-2"></div>');
    
    $('#8_1').append('<div class="play-2"></div>');
    $('#8_2').append('<div class="play-2"></div>');
    $('#8_3').append('<div class="play-2"></div>');
    $('#8_4').append('<div class="play-2"></div>');
    
    //$('#4_2').append('<div class="play play-1 big-chip"></div>');
    //$('#5_2').append('<div class="play play-1 big-chip"></div>');

    $(document).on('click', ".play.play-1", function() {
        play($(this), 1);
    });
    $(document).on('click', ".play.play-2", function() {
        play($(this), 2);
    });
    
    $(document).on('click', ".next-walk", function() {
        var block_removed;
        var swap = true;
        
        $(this).append('<div class="play play-'+current_played+'"></div>');
        
        if($('#'+current_selected+' div').hasClass('big-chip')){
            $(this).children('div').addClass('big-chip');
        }
        $('table td').removeClass('next-walk');
        $('#'+current_selected+' div').remove();
        
        if(eat){

            if($(this).hasClass('right')){
                block_removed = "right";
            }
            else if($(this).hasClass('left')){
                block_removed = "left";
            }
            else if($(this).hasClass('down_left')){
                block_removed = "down_left";
            }
            else if($(this).hasClass('top_left')){
                block_removed = "top_left";
            }
            else if($(this).hasClass('down_right')){
                block_removed = "down_right";
            }
            else if($(this).hasClass('top_right')){
                block_removed = "top_right";
            }
            else{
                block_removed = "null";
            }

            $('.eat-walk.'+block_removed).children('div').remove();
            $('table td').removeClass('eat-walk left right down_left top_left down_right top_right');
            
            if(!checkNextEat($(this).attr('id'),current_played)){
                swap = true;
                eat = false;
            }
            else{
                
                swap = false;
            }
        }
        
        
        if(checkUpgradechip($(this),current_played)){
            swap = true;
            eat = false;
        }
        win = checkWin();
        if(win){
            //alert notify
            action = "success";
            title = 'จบเกม!';
            content = 'ผู้เล่นที่  '+win+' เป็นฝ่ายชนะ!!!';
            notifyAnimate(action, title, content);
        }
        if(swap && !win){
            
            if(current_played == 1){
                
                //alert notify
                next_player = 2;
                action = "info";
                title = 'จบเทิร์น';
                content = 'ถึงเวลาผู้เล่นที่ '+next_player+' เดินเกม';
                notifyAnimate(action, title, content);
                
                $('.play-1').removeClass('play');
                $('.play-2').addClass('play');
            }
            else{
                
                //alert notify
                next_player = 1;
                action = "info";
                title = 'จบเทิร์น';
                content = 'ถึงเวลาผู้เล่นที่ '+next_player+' เดินเกม';
                notifyAnimate(action, title, content);
                
                $('.play-2').removeClass('play');
                $('.play-1').addClass('play');
            }
        }
    });
    
});
function play(element, player){
    
    checkEat(player);

    $('table td').removeClass('next-walk');
    $('.play-'+player).removeClass('active');
    block_class = element.attr('class');
    block_id = element.parent().attr('id');
    element.addClass('active');
    current_selected = block_id;
    current_played = player;
    
    if(element.hasClass('big-chip')){
        console.log('your select a big-chip');
        nextBigChip(element, player);
    }
    else{
        can_work = findNextWalk(block_id, player);
    }

}

function findNextWalk(id, player){
    var current = id.split("_");
    current_row = parseInt(current[0]);
    current_block = parseInt(current[1]);
    if(player==2){
        next_row = current_row-1; 
    }
    else{
        next_row = current_row+1;
    }
    if(current_row%2 == 0){
            if(current_block==1){
                next_block = current_block;
                
            }
            else{
                next_block = [current_block-1,current_block];
            }
        }
        else{
            if(current_block==4){
                next_block = current_block;
                
            }
            else{
                next_block = [current_block,current_block+1];
            }
        }
        if(next_block.constructor === Array){
            for(i=0;i<2;i++){
                addEat(current_block, next_row, next_block[i]);
            }
            if(!eat){
                for(i=0;i<2;i++){
                    addWalk($("#"+next_row+"_"+next_block[i]));
                }
            }
        }
        else{

            addEat(current_block, next_row, next_block);
            if(!eat){
                addWalk($("#"+next_row+"_"+next_block));
            }
        }
}

function addEat(current_block, next_row, next_block){
    block = $("#"+next_row+"_"+next_block);

    if(current_played == 1 && block.children('div.play-2').length == 1){
        if(next_row%2==0){
            if(current_block==next_block){
                if(checkNull($("#"+(next_row+1)+"_"+(next_block-1)))){
                    eat = true;
                    block.addClass("eat-walk left");
                    $("#"+(next_row+1)+"_"+(next_block-1)).addClass("next-walk left");
                }
            }
            else{
                if(checkNull($("#"+(next_row+1)+"_"+next_block))){
                    eat = true;
                    block.addClass("eat-walk right");
                    $("#"+(next_row+1)+"_"+next_block).addClass("next-walk right");
                }
            }
        }
        else{
            if(current_block==next_block){
                if(checkNull($("#"+(next_row+1)+"_"+(next_block+1)))){
                    eat = true;
                    block.addClass("eat-walk right");
                    $("#"+(next_row+1)+"_"+(next_block+1)).addClass("next-walk right");
                }
            }
            else{
                if(checkNull($("#"+(next_row+1)+"_"+next_block))){
                    eat = true;
                    block.addClass("eat-walk left");
                    $("#"+(next_row+1)+"_"+next_block).addClass("next-walk left");
                }
            }
        }
    }
    if(current_played == 2 && block.children('div.play-1').length == 1){
            if(next_row%2==0 ){
                if(current_block==next_block){
                    if(checkNull($("#"+(next_row-1)+"_"+(next_block-1)))){
                        eat = true;
                        block.addClass("eat-walk left");
                        $("#"+(next_row-1)+"_"+(next_block-1)).addClass("next-walk left");
                    }
                }
                else{
                    if(checkNull($("#"+(next_row-1)+"_"+next_block))){
                        eat = true;
                        block.addClass("eat-walk right");
                        $("#"+(next_row-1)+"_"+next_block).addClass("next-walk right");
                    }
                }
            }
            else{
                if(current_block==next_block){
                    if(checkNull($("#"+(next_row-1)+"_"+(next_block+1)))){
                        eat = true;
                        block.addClass("eat-walk right");
                        $("#"+(next_row-1)+"_"+(next_block+1)).addClass("next-walk right");
                    }
                }
                else{
                    if(checkNull($("#"+(next_row-1)+"_"+next_block))){
                        eat = true;
                        block.addClass("eat-walk left");
                        $("#"+(next_row-1)+"_"+next_block).addClass("next-walk left");
                    }
                }
            }
    }
    
}

function addWalk(block){
    if(block.children('div.play').length == 0 && checkNull(block)){
        block.addClass("next-walk");
    }
}

function checkNull(go_block){
    if(go_block.children('div.play-1').length == 1 || go_block.children('div.play-2').length == 1 || go_block.length == 0){
        return false;
    }
    return true;
}

function checkEat(player){
    all = $('td').find('.play-'+player);

    calBigChipEat(player);
    for(i=0;i<all.length;i++){

        element = all[i].parentElement.id;
        cut = element.split("_");

        current_row = parseInt(cut[0]);
        current_block = parseInt(cut[1]);
        if(player==2){
            next_row = current_row-1; 
        }
        else{
            next_row = current_row+1;
        }
        if(current_row%2 == 0){
            if(current_block==1){
                next_block = current_block;
                
            }
            else{
                next_block = [current_block-1,current_block];
            }
        }
        else{
            if(current_block==4){
                next_block = current_block;
                
            }
            else{
                next_block = [current_block,current_block+1];
            }
        }
        if(next_block.constructor === Array){
            for(j=0;j<2;j++){
                updateEat(current_block, next_row, next_block[j], player);
            }
        }
        else{
            updateEat(current_block, next_row, next_block, player);
        }
        
    }
    
}

function updateEat(current_block, next_row, next_block, player){
    block = $("#"+next_row+"_"+next_block);
        if(player == 1 && block.children('div.play-2').length == 1){
            if(next_row%2==0){
                if(current_block==next_block){
                    if(checkNull($("#"+(next_row+1)+"_"+(next_block-1)))){
                        eat = true;
                        block.addClass("eat-walk");
                    }
                }
                else{
                    if(checkNull($("#"+(next_row+1)+"_"+next_block))){
                        eat = true;
                        block.addClass("eat-walk");
                    }
                }
            }
            else{
                if(current_block==next_block){
                    if(checkNull($("#"+(next_row+1)+"_"+(next_block+1)))){
                        eat = true;
                        block.addClass("eat-walk");
                    }
                }
                else{
                    if(checkNull($("#"+(next_row+1)+"_"+next_block))){
                        eat = true;
                        block.addClass("eat-walk");
                    }
                }
            }
        }
        if(player == 2 && block.children('div.play-1').length == 1){
                if(next_row%2==0 ){
                    if(current_block==next_block){
                        if(checkNull($("#"+(next_row-1)+"_"+(next_block-1)))){
                            
                            eat = true;
                            block.addClass("eat-walk");
                        }
                    }
                    else{
                        if(checkNull($("#"+(next_row-1)+"_"+next_block))){
                            eat = true;
                            block.addClass("eat-walk");
                        }
                    }
                }
                else{
                    if(current_block==next_block){
                        if(checkNull($("#"+(next_row-1)+"_"+(next_block+1)))){
                            eat = true;
                            block.addClass("eat-walk");
                        }
                    }
                    else{
                        if(checkNull($("#"+(next_row-1)+"_"+next_block))){
                            eat = true;
                            block.addClass("eat-walk");
                        }
                    }
                }
        }
}

function checkNextEat(id, player){
    console.log("check next eat");

    if($("#"+id).children('div.big-chip').length == 1){
        
        if(calNextBigChipEat(id, player)){
            return true;
        }
    }
    
    var current = id.split("_");
    current_row = parseInt(current[0]);
    current_block = parseInt(current[1]);
    if(player==2){
        next_row = current_row-1;
    }
    else{
        next_row = current_row+1;
    }
    if(current_row%2 == 0){
            if(current_block==1){
                next_block = current_block;
                
            }
            else{
                next_block = [current_block-1,current_block];
            }
        }
        else{
            if(current_block==4){
                next_block = current_block;
                
            }
            else{
                next_block = [current_block,current_block+1];
            }
        }
        if(next_block.constructor === Array){
            for(i=0;i<2;i++){
                if(checkSelectedNextEat(current_block, next_row, next_block[i])){
                    return true;
                }
            }
        }
        else{
            if(checkSelectedNextEat(current_block, next_row, next_block)){
                return true;
            }
        }
        return false;
}

function checkSelectedNextEat(current_block, next_row, next_block){
    block = $("#"+next_row+"_"+next_block);

    if(current_played == 1 && block.children('div.play-2').length == 1){
        if(next_row%2==0){
            if(current_block==next_block){
                if(checkNull($("#"+(next_row+1)+"_"+(next_block-1)))){
                    return true;
                }
            }
            else{
                if(checkNull($("#"+(next_row+1)+"_"+next_block))){
                    return true;
                }
            }
        }
        else{
            if(current_block==next_block){
                if(checkNull($("#"+(next_row+1)+"_"+(next_block+1)))){
                    return true;
                }
            }
            else{
                if(checkNull($("#"+(next_row+1)+"_"+next_block))){
                    return true;
                }
            }
        }
    }
    if(current_played == 2 && block.children('div.play-1').length == 1){
            if(next_row%2==0 ){
                if(current_block==next_block){
                    if(checkNull($("#"+(next_row-1)+"_"+(next_block-1)))){
                        return true;
                    }
                }
                else{
                    if(checkNull($("#"+(next_row-1)+"_"+next_block))){
                        return true;
                    }
                }
            }
            else{
                if(current_block==next_block){
                    if(checkNull($("#"+(next_row-1)+"_"+(next_block+1)))){
                        return true;
                    }
                }
                else{
                    if(checkNull($("#"+(next_row-1)+"_"+next_block))){
                        return true;
                    }
                }
            }
    }
    return false;
    
}

function calBigChipEat(player){
    all_big = $('td').find('.play-'+player+'.big-chip');
    
    if(all_big.length>0){
        for(t=0;t<all_big.length;t++){

            element = all_big[t].parentElement.id;

            position = getPositionNextBigChip(element);

            down_right = position[0];
            down_left = position[1];
            top_right = position[2];
            top_left = position[3];
            
            if(down_right.length>0){
                stop_position = checkEatBigChip(down_right, player);

                if(stop_position[0] && stop_position[1]){
                    walk_position = 'down_right';
                    genBigChipEat(stop_position[0], stop_position[1], walk_position);
                }
            }
            if(down_left.length>0){
                stop_position = checkEatBigChip(down_left, player);

                if(stop_position[0] && stop_position[1]){
                    walk_position = 'down_left';
                    genBigChipEat(stop_position[0], stop_position[1], walk_position);
                }
            }
            if(top_right.length>0){
                stop_position = checkEatBigChip(top_right, player);

                if(stop_position[0] && stop_position[1]){
                    walk_position = 'top_right';
                    genBigChipEat(stop_position[0], stop_position[1], walk_position);
                }
            }
            if(top_left.length>0){
                stop_position = checkEatBigChip(top_left, player);

                if(stop_position[0] && stop_position[1]){
                    walk_position = 'top_left';
                    genBigChipEat(stop_position[0], stop_position[1], walk_position);
                }
            }
        }
    }
}

function calNextBigChipEat(id, player){
            console.log('calNextBigChipEat');
            position = getPositionNextBigChip(id);
            
            down_right = position[0];
            down_left = position[1];
            top_right = position[2];
            top_left = position[3];
            
            if(down_right.length>0){
                stop_position = checkEatBigChip(down_right, player);

                if(stop_position[0] && stop_position[1]){
                    walk_position = 'down_right';
                    genBigChipEat(stop_position[0], stop_position[1], walk_position);
                    return true;
                }
            }
            if(down_left.length>0){
                stop_position = checkEatBigChip(down_left, player);

                if(stop_position[0] && stop_position[1]){
                    walk_position = 'down_left';
                    genBigChipEat(stop_position[0], stop_position[1], walk_position);
                    return true;
                }
            }
            if(top_right.length>0){
                stop_position = checkEatBigChip(top_right, player);

                if(stop_position[0] && stop_position[1]){
                    walk_position = 'top_right';
                    genBigChipEat(stop_position[0], stop_position[1], walk_position);
                    return true;
                }
            }
            if(top_left.length>0){
                stop_position = checkEatBigChip(top_left, player);

                if(stop_position[0] && stop_position[1]){
                    walk_position = 'top_left';
                    genBigChipEat(stop_position[0], stop_position[1], walk_position);
                    return true;
                }
            }
            return false;
}

function checkUpgradechip(last, player){
    id = last.attr('id');
    var current = id.split("_");
    current_row = parseInt(current[0]);
    current_block = parseInt(current[1]);
    if(player == 1 && current_row == 8){
        last.children('div').addClass('big-chip');
        return true;
    }
    if(player == 2 && current_row == 1){
        last.children('div').addClass('big-chip');
        return true;
    }
}

function nextBigChip(element, player){
    position = getPositionNextBigChip(element.parent().attr('id')); //sent id position
    
    down_right = position[0];
    down_left = position[1];
    top_right = position[2];
    top_left = position[3];
    
    if(down_right.length>0){

        stop_position = checkEatBigChip(down_right, player);
        if(stop_position[0] && stop_position[1]){
            walk_position = 'down_right';
            genBigChipEat(stop_position[0], stop_position[1], walk_position);
        }
        else if(stop_position[0] && !stop_position[1]){
            if(stop_position[0] == -1){
                stop_position[0] = 0;
            }
            down_right = down_right.slice(0, stop_position[0]);
        }
        else{
            //console.log('null all');
        }
    }
    if(down_left.length>0){
        stop_position = checkEatBigChip(down_left, player);
        if(stop_position[0] && stop_position[1]){
            walk_position = 'down_left';
            genBigChipEat(stop_position[0], stop_position[1], walk_position);
        }
        else if(stop_position[0] && !stop_position[1]){
            if(stop_position[0] == -1){
                stop_position[0] = 0;
            }
            down_left = down_left.slice(0, stop_position[0]);
        }
        else{
            //console.log('null all');
        }
    }
    if(top_right.length>0){
        stop_position = checkEatBigChip(top_right, player);
        if(stop_position[0] && stop_position[1]){
            walk_position = 'top_right';
            genBigChipEat(stop_position[0], stop_position[1], walk_position);
        }
        else if(stop_position[0] && !stop_position[1]){
            if(stop_position[0] == -1){
                stop_position[0] = 0;
            }
            top_right = top_right.slice(0, stop_position[0]);
        }
        else{
            //console.log('null all');
        }
    }
    if(top_left.length>0){
        stop_position = checkEatBigChip(top_left, player);
        if(stop_position[0] && stop_position[1]){
            walk_position = 'top_left';
            genBigChipEat(stop_position[0], stop_position[1], walk_position);
        }
        else if(stop_position[0] && !stop_position[1]){
            if(stop_position[0] == -1){
                stop_position[0] = 0;
            }
            top_left = top_left.slice(0, stop_position[0]);
        }
        else{
            //console.log('null all');
        }
    }
    
    if(!eat){
        genBigChipWalk(down_right, down_left, top_right, top_left);
    }
}

function getPositionNextBigChip(element){

    var current = element.split("_");
    current_row = parseInt(current[0]);
    current_block = parseInt(current[1]);
    
    down_right = [];
    down_right_count = 0;
    down_left = [];
    down_left_count = 0;
    top_right = [];
    top_right_count = 0;
    top_left = [];
    top_left_count = 0;

        //= and + or - and =
        //left -> -and = |||| right = and +
        
        //down left and right
        if(current_row<8){
            next_block_right = current_block;
            next_block_left = current_block;
            for(i=(current_row+1);i<=8;i++){
                if(i%2!=0){
                    if(next_block_right<=4 && next_block_right>0){
                        down_right[down_right_count] = i+'_'+next_block_right;
                        down_right_count++;
                    }
                    next_block_left -= 1;
                    if(next_block_left<=4 && next_block_left>0){
                        down_left[down_left_count] = i+'_'+next_block_left;
                        down_left_count++;
                    }
                    /*if((next_block_left-1)<=4 && next_block_left>=0){
                        next_block_left -= 1;
                        if(next_block_left>0){
                            down_left[down_left_count] = i+'_'+next_block_left;
                            down_left_count++;
                        }
                    }*/
                }
                else{
                    next_block_right += 1;
                    if(next_block_right<=4 && next_block_right>0){
                        down_right[down_right_count] = i+'_'+(next_block_right);
                        down_right_count++;
                    }
                    if(next_block_left<=4 && next_block_left>0){
                        down_left[down_left_count] = i+'_'+next_block_left;
                        down_left_count++;
                    }
                }
            }
        }
        
        //up left and right
        if(current_row>1){
            next_block_right = current_block;
            next_block_left = current_block;
            for(i=(current_row-1);i>0;i--){
                if(i%2!=0){
                    if(next_block_right<=4 && next_block_right>0){
                        top_right[top_right_count] = i+'_'+next_block_right;
                        top_right_count++;
                    }
                    next_block_left -= 1;
                    if(next_block_left<=4 && next_block_left>0){
                        top_left[top_left_count] = i+'_'+next_block_left;
                        top_left_count++;
                    }
                }
                else{
                    next_block_right += 1;
                    if(next_block_right<=4 && next_block_right>0){
                        top_right[top_right_count] = i+'_'+(next_block_right);
                        top_right_count++;
                    }
                    if(next_block_left<=4 && next_block_left>0){
                        top_left[top_left_count] = i+'_'+next_block_left;
                        top_left_count++;
                    }
                }
            }
        }
    return [down_right,down_left,top_right,top_left];
}

function checkEatBigChip(array, player){

    if(player==1){
        can_eat = 2;
    }
    else{
        can_eat = 1;
    }
    for(i=0;i<array.length;i++){
        if($("#"+array[i]).children('div.play-'+player).length == 1){

            if(i==0){
                return [-1, false];
            }
            return [i, false];
        }
        if($("#"+array[i]).children('div.play-'+can_eat).length == 1){
            if(checkCanEat(array, i)){
                return [array[i], array[i+1]];
            }
            else{
                if(i==0){
                    return [-1, false];
                }
                return [i, false];
            }
        }
    }
    return [false, false];
    
}

function  checkCanEat(array, i){
    i += 1;
    if(array[i]){
        if($("#"+array[i]).children('div').length == 0){
            return true;
        }
    }
    return false;
}

function genBigChipEat(eat_chip, stop_chip, walk_position){
    $("#"+eat_chip).addClass("eat-walk "+walk_position);
    $("#"+stop_chip).addClass("next-walk "+walk_position);
    eat = true;
}

function genBigChipWalk(down_right, down_left, top_right, top_left){
    if(down_right.length>0){
        for(i=0;i<down_right.length;i++){
            $("#"+down_right[i]).addClass("next-walk");
        }
    }
    if(down_left.length>0){
        for(i=0;i<down_left.length;i++){
            $("#"+down_left[i]).addClass("next-walk");
        }
    }
    if(top_right.length>0){
        for(i=0;i<top_right.length;i++){
            $("#"+top_right[i]).addClass("next-walk");
        }
    }
    if(top_left.length>0){
        for(i=0;i<top_left.length;i++){
            $("#"+top_left[i]).addClass("next-walk");
        }
    }
}

function checkWin(){
    chip_1 = $('td').find('.play-1');
    chip_2 = $('td').find('.play-2');
    if(chip_1.length==0){
        return 2;
    }
    if(chip_2.length==0){
        return 1;
    }
    return false;
}