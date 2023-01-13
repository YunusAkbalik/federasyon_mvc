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
                    "ad": {
                        required: !0,
                    },
                    "soyad": {
                        required: !0,
                    },
                    "unvan": {
                        required: !0,
                    },
                    "telefon": {
                        required: !0,
                        minlength: 10,
                        maxlength: 10,
                    },
                    "adres": {
                        required: !0,
                    },
                    "vergi_dairesi": {
                        required: !0,
                    },
                    "vergi_no": {
                        required: !0,
                    },
                    "yetkili_kisi": {
                        required: !0,
                    },
                    "yetkili_telefon": {
                        required: !0,
                        minlength: 10,
                        maxlength: 10,
                    },
                    "wp_hatti": {
                        minlength: 10,
                        maxlength: 10,
                    },
                },
                messages: {
                    "ad": "Lütfen isim girin",
                    "soyad": "Lütfen soyisim girin",
                    "tc_kimlik": "Lütfen 11 haneli T.C Kimlik numarası girin",
                    "unvan": "Lütfen ünvan girin",
                    "telefon": "Lütfen 10 haneli telefon numarası girin",
                    "adres": "Lütfen adres girin",
                    "vergi_dairesi": "Lütfen vergi dairesi girin",
                    "vergi_no": "Lütfen vergi no girin",
                    "yetkili_kisi": "Lütfen yetkili kişi girin",
                    "yetkili_telefon": "Lütfen 10 haneli telefon numarası girin",
                    "wp_hatti": "Lütfen 10 haneli telefon numarası girin",
                }
            })
    }
    static init() { this.initValidation() }
}.init()));