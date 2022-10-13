

//　
$(".reportContentCard").click(function() {

    if($(this).hasClass('close')){
        $(this).removeClass('close')
        $(this).next().slideDown(200);
    }else{
        $(this).addClass('close')
        $(this).next().slideUp(200);
    }

    // reportContentBody
    // const childId = id.replace('parentMenu', 'childMenu')
    // if ($(this).hasClass('open')) {
    //     $(this).removeClass('open')
    //     $('#' + childId).slideUp(200);
    // }else{
    //     $(this).addClass('open')
    //     $('#' + childId).slideToggle(200, function() {});
    // }
})


