/*!
 * dashmix - v5.4.0
 * @author pixelcave - https://pixelcave.com
 * Copyright (c) 2022
 */
Dashmix.onLoad((() => class {
    static initValidation() {
        Dashmix.helpers('jq-validation'),
            jQuery('.js-validation').validate({
                rules: {
                    'okul_ad': { required: !0 },
                    'il_id': { required: !0 },
                    'ilce_id': { required: !0 },

                },
                messages: {
                    'okul_ad': 'Lütfen geçerli bir okul adı girin',
                    'ilce_id': 'Lütfen geçerli bir ilçe seçin',
                    'il_id': 'Lütfen geçerli bir il seçin',
                }
            })
    }

    static init() { this.initValidation() }
}.init()))
