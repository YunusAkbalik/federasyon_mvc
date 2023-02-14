/*!
 * dashmix - v5.4.0
 * @author pixelcave - https://pixelcave.com
 * Copyright (c) 2022
 */
Dashmix.onLoad((() => class {
    static initValidation() {
        Dashmix.helpers("jq-validation"),
            jQuery(".dersPlani").validate({
                ignore: [],
                rules: {
                    "ders_id": { required: !0 },
                    "siniflar[]": { required: !0 },
                    "konu": { required: !0 },
                    "dersin_islenisi": { required: !0 },
                },
                messages: {
                    "ders_id": "Lütfen ders seçimi yapın",
                    "siniflar[]": "Lütfen en az 1 sınıf yapın",
                    "konu": "Lütfen konuyu yazın",
                    "dersin_islenisi": "Lütfen dersin işlenişini yazın",
                }
            }), jQuery(".js-select2").on("change", (e => {
                jQuery(e.currentTarget).valid()
            }))
    }
    static init() { this.initValidation() }
}.init()));