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
                    "signup-terms": {
                        required: !0,
                    },
                },
                messages: {
                    "tc_kimlik": {
                        required: "Lütfen T.C Kimlik numaranızı girin",
                        minlength: "Lütfen 11 haneli T.C Kimlik numaranızı girin",
                        maxlength: "Lütfen 11 haneli T.C Kimlik numaranızı girin",
                    },
                    "ad": "Lütfen isminizi girin",
                    "soyad": "Lütfen soyisminizi girin",
                    "email": "Lütfen geçerli bir e-posta adresi girin",
                    "gsm_no": "10 Haneli telefon numaranızı başında 0 olmadan girin",
                    "dogum_tarihi": "Lütfen doğum tarihinizi girin",
                    "signup-terms": "Üye olmak için şartları ve koşulları kabul etmek zorundasınız!"
                }
            })
    }
    static init() { this.initValidation() }
}.init()));