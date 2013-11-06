(function($){
    $.widget('block.b-ajaxForm', {

        _create: function(){
            var block = this,
                $block = this.element;

            block.$success = $block.find('.b-ajaxForm__success');
            block.$error = $block.find('.b-ajaxForm__error');

            $block.ajaxForm({
                dataType: 'json',
                beforeSubmit: $.proxy(block.beforeSubmit, block),
                beforeSerialize: $.proxy(block.beforeSerialize, block),
                success: function(data){
                    block.buttonLoader(false);

                    if (data.status == "ok") {
                        block.onSuccess(data);
                    } else if (data.status == 'redirect') {
                        block.onRedirect(data);
                    } else {
                        block.showErrors(data);
                    }

                },
                error: function(data) {
                    block._error(data);
                }
            });

        },
        onSuccess: function(data){
            this.successMessage(data.data.data);
            this.clearFields();
        },

        successMessage: function(message) {
            var block = this;

            block.$success.find('.b-ajaxForm__successMessage').html(message);
            block.$success.fadeIn(300);

            clearTimeout(block.successTimeout);

            block.successTimeout = setTimeout(function(){
                block.$success.hide();
            }, 5000);
        },

        clearFields: function() {
        },

        onRedirect: function(data) {
            var timer = 0;
            if (data.timeout) {
                timer = data.timeout * 1000;
            }

            setTimeout(function() {
                if (data.url) {
                    location.href = data.url;
                } else {
                    location.reload(true);
                }
            }, timer);

        },

        showErrors: function(data){
            for (var field in data.message) {
                var $field = this.element.find('[name="'+field+'"]');
                var $error = $("<div />");
                $error.addClass("b-ajaxForm__errorText");
                $error.html(data.message[field]);
                $field.closest('.b-ajaxForm__row')
                    .addClass('b-ajaxForm__row_error')
                    .append($error);
            }
        },

        beforeSerialize: function(){
            this.element.find('.b-ajaxForm__errorText').hide();
            this.element.find('.b-ajaxForm__row_error').removeClass('b-ajaxForm__row_error');
        },

        beforeSubmit: function() {
            this.buttonLoader(true);
            this.checkRequired();
        },

        _error: function(data) {
            var response = $.parseJSON(data.responseText);
            alert(response.message);
            this.buttonLoader(false);
        },

        buttonLoader: function(status) {
            var $block = this.element;

            if (status) {
                $block.find('[type=submit]').prop('disabled', true).addClass('button_loading');
            } else {
                $block.find('[type=submit]').prop('disabled', false).removeClass('button_loading');
            }
        },

        checkRequired: function() {
            var block = this,
                $block = this.element,
                $required = $block.find('input[data-required=required]');

            var filled = $required.filter(function() {
                return $.trim(this.value).length;
            });

            if (!filled.length && $required.length) {
                var data = $block.data('validation');
                block.showErrors(data.message, data);
                block.buttonLoader(false);
            }
        }

    });
})(jQuery);