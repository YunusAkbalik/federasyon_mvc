/*!
 * dashmix - v5.4.0
 * @author pixelcave - https://pixelcave.com
 * Copyright (c) 2022
 */
Dashmix.onLoad((() => class {
    static initValidation() {
        Dashmix.helpers("jq-validation"),
            jQuery(".js-validation").validate({
                ignore: [],
                rules: {
                    "yoklama_tarih": { required: !0 },
                    "yoklama_ders": { required: !0 },
                },
                messages: {
                    "yoklama_tarih": "Lütfen tarih girin!",
                    "yoklama_ders": "Lütfen ders seçin!",
                }
            }), jQuery(".js-select2").on("change", (e => {
                jQuery(e.currentTarget).valid()
            }))
    }
    static init() { this.initValidation() }
}.init()));