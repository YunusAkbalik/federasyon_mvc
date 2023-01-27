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
                    "veli_tc": {
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
                    "il": {
                        required: !0,
                    },
                    "ilce": {
                        required: !0,
                    },
                    "dogum_tarihi": {
                        required: !0,
                    },
                    "gsm_no": {
                        minlength: 10,
                        maxlength: 10,
                    },
                    "okul": {
                        required: !0,
                    },
                    "sinif": {
                        required: !0,
                    },
                    "sube": {
                        required: !0,
                    },
                    "kurum_sinif": {
                        required: !0,
                    },
                    "kurum_okul": {
                        required: !0,
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
                    "il": "Lütfen il seçin",
                    "ilce": "Lütfen ilçe seçin",
                    "okul": "Lütfen okul seçin",
                    "sinif": "Lütfen sınıf girin",
                    "sube": "Lütfen şube girin",
                    "veli_tc": "Lütfen geçerli bir t.c kimlik numarası girin",
                    "kurum_sinif": "Lütfen sınıf seçin",
                    "kurum_okul": "Lütfen okul seçin",
                }
            })
    }
    static init() { this.initValidation() }
}.init()));