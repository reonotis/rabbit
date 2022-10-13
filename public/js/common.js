$(function() {
    $('.flash-message-box-close').click(function() {
        $(this).parent().toggleClass('flash-message-hidden').slideUp();
    })
})

//　サイドメニューの開閉
$(".parentMenu").click(function() {
    const id = $(this).attr('id')
    const childId = id.replace('parentMenu', 'childMenu')
    if ($(this).hasClass('open')) {
        $(this).removeClass('open')
        $('#' + childId).slideUp(200);
    }else{
        $(this).addClass('open')
        $('#' + childId).slideToggle(200, function() {});
    }
})


