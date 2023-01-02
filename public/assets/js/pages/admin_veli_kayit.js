/*!
 * dashmix - v5.4.0
 * @author pixelcave - https://pixelcave.com
 * Copyright (c) 2022
 */
Dashmix.onLoad((() => class {
    static initValidation() {
        Dashmix.helpers("jq-validation"),
            jQuery(".js-validation-signup").validate({
                rules: {
                    "tc_kimlik": {
                        required: !0,
                        minlength: 11,
                        maxlength: 11,
                    },
                    "ogrenci_tc": {
                        minlength: 11,
                        maxlength: 11,
                    },
                    "email": {
                        required: !0,
                        emailWithDot: !0
                    },
                    "ad": {
                        required: !0,
                    },
                    "soyad": {
                        required: !0,
                    },

                    "dogum_tarihi": {
                        required: !0,
                    },
                    "gsm_no": {
                        minlength: 10,
                        maxlength: 10,
                        required: !0
                    },

                },
                messages: {
                    "tc_kimlik": {
                        required: "Lütfen T.C Kimlik numarası girin",
                        minlength: "Lütfen 11 haneli T.C Kimlik numarası girin",
                        maxlength: "Lütfen 11 haneli T.C Kimlik numarası girin",
                    },
                    "ad": "Lütfen isim girin",
                    "soyad": "Lütfen soyisim girin",
                    "email": "Lütfen geçerli bir e-posta adresi girin",
                    "gsm_no": "10 Haneli telefon numarasını başında 0 olmadan girin",
                    "dogum_tarihi": "Lütfen doğum tarihi girin",
                    'ogrenci_tc': "Lütfen geçerli bir T.C Kimlik numarası girin",
                }
            })
    }
    static init() { this.initValidation() }
}.init()));

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