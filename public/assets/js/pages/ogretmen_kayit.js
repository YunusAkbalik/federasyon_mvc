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
                    "photo": {
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
                    "password": {
                        required: !0,
                        minlength: 8,
                        maxlength: 8
                    },
                    "password_again": {
                        required: !0,
                        equalTo: '#password'
                    },
                    "signup-terms": {
                        required: !0,
                    },
                    "okul": {
                        required: !0,
                    },
                    "bolum": {
                        required: !0,
                    },
                    "mezun_tarihi": {
                        required: !0,
                    },
                    "sertifikalar": {
                        required: !0,
                    },
                    "oncekiisler": {
                        required: !0,
                    },

                },
                messages: {
                    "tc_kimlik": {
                        required: "Lütfen T.C Kimlik numaranızı girin",
                        minlength: "Lütfen 11 haneli T.C Kimlik numaranızı girin",
                        maxlength: "Lütfen 11 haneli T.C Kimlik numaranızı girin",
                    },
                    "password": {
                        required: "Lütfen parola belirleyin",
                        minlength: "Parolanız 8 haneli ve rakamlardan oluşmalıdır",
                        maxlength: "Parolanız 8 haneli ve rakamlardan oluşmalıdır",
                        number: "Lütfen sadece rakamlardan oluşan bir parola belirleyin",
                    },
                    "password_again": {
                        required: "Lütfen parolanızı tekrar girin",
                        equalTo: "Parolanız uyuşmuyor",
                        number: "Lütfen sadece rakamlardan oluşan bir parola belirleyin",
                    },
                    "ad": "Lütfen isminizi girin",
                    "soyad": "Lütfen soyisminizi girin",
                    "email": "Lütfen geçerli bir e-posta adresi girin",
                    "gsm_no": "10 Haneli telefon numaranızı başında 0 olmadan girin",
                    "dogum_tarihi": "Lütfen doğum tarihinizi girin",
                    "photo": "Lütfen profil fotoğrafı yükleyin",
                    "signup-terms": "Üye olmak için şartları ve koşulları kabul etmek zorundasınız!",
                    "okul": "Lütfen bu alanı doldurun",
                    "bolum": "Lütfen bu alanı doldurun",
                    "mezun_tarihi": "Lütfen bu alanı doldurun",
                    "sertifikalar": "Lütfen bu alanı doldurun",
                    "oncekiisler": "Lütfen bu alanı doldurun",

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