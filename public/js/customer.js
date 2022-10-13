
// 顧客詳細画面のタブを押下したとき
$(".customer-menu-tab").click(function () {
    let menuIndex = $(this).index();
    $(".customer-menu-tab").each( function(index) {
        if(menuIndex === index){
            $(this).addClass('active')
        }else{
            $(this).removeClass('active')
        }
    });

    $(".customer-content").each( function(index) {
        if(menuIndex === index){
            $(this).slideDown(200);
        }else{
            $(this).slideUp(200);
        }
    });
});

function check_validation(){
    var errCount = 0;
    errCount += check_f_name();
    errCount += check_l_name();
    errCount += check_email();

    return (!errCount);
}

function check_f_name(){
    const f_name = $('#f_name');
    if (f_name.val() === "") {
        f_name.addClass("input-error");
        return 1;
    } else {
        f_name.removeClass("input-error");
        return 0;
    }
}

function check_l_name(){
    const l_name = $('#l_name');
    if (l_name.val() === "") {
        l_name.addClass("input-error");
        return 1;
    } else {
        l_name.removeClass("input-error");
        return 0;
    }
}

function check_email(){
    const email = $('#email');
    if (email.val() === "") {
        email.addClass("input-error");
        return 1;
    } else {
        email.removeClass("input-error");
        return 0;
    }
}

