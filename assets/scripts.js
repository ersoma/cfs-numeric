(function($) {
    $(function() {

        // select + or - buttons
        $(".cfs_numeric").each(function(){
            $(this).find("button").on('click', {field: $(this).find("input")}, button_click);
        })
        
        // event handler
        function button_click(e){
            var button_type = e.target.textContent;
            var max = toNum(e.data.field.attr('max'));
            var min = toNum(e.data.field.attr('min'));
            var step = toNum(e.data.field.data("cfs-numeric-step"));
            var current_value = toNum($(e.data.field).val());

            // set default value of step
            if(step == undefined) {
                step = 1;
            }

            // set default value of current_value
            if(isNaN(current_value)) {
                current_value = 0;
            }

            // - button
            if(button_type === "-"){
                // empty field
                if(current_value === ""){
                    $(e.data.field).val(min === undefined ? 0 : min);
                } else {
                    // check is there is a limit and if it is reached
                    if(min === undefined || (current_value - step) >= min) {
                        $(e.data.field).val(current_value - step);
                    } else {
                        // limit reached
                        $(e.data.field).val(min);
                    }
                }
            }

            // + button
            if(button_type === "+"){
                // empty field
                if(current_value === ""){
                    $(e.data.field).val(max === undefined ? 0 : max);
                } else {
                    // check is there is a limit and if it is reached
                    if(max === undefined || (current_value + step) <= max) {
                        $(e.data.field).val(current_value + step);
                    } else {
                        // limit reached
                        $(e.data.field).val(max);
                    }
                }
            }
        }

        function toNum(value){
            if(value === undefined){
                return undefined;
            }
            return parseFloat(value, 10);
        }

    });
})(jQuery);