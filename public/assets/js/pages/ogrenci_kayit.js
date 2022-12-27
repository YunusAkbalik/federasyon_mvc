function showPass(e) {
    if ($(e).prev().css('-webkit-text-security') == "disc") {
        $(e).children().removeClass();
        $(e).children().addClass('fa fa-eye-slash');
        $(e).prev().css('-webkit-text-security', 'none');
    } else {
        $(e).children().removeClass();
        $(e).children().addClass('fa fa-eye');
        $(e).prev().css('-webkit-text-security', 'disc');
    }
}