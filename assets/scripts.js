(function($) {
    $(function() {

        // select + or - buttons
        $(".cfs_input").on('click', '.cfs_numeric button', button_click);

        // select clear buttons
        $(".cfs_input").on('click', '.cfs_numeric a', clear_click);
        
        // event handler
        function button_click(e){

            // $(this).siblings("input[type='number']").val('')


            var button_type = e.target.textContent;
            var max = toNum($(this).siblings("input[type='number']").attr('max'));
            var min = toNum($(this).siblings("input[type='number']").attr('min'));
            var step = toNum($(this).siblings("input[type='number']").data("cfs-numeric-step"));
            var current_value = toNum($(this).siblings("input[type='number']").val());

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
                    $(this).siblings("input[type='number']").val(min === undefined ? 0 : min);
                } else {
                    // check is there is a limit and if it is reached
                    if(min === undefined || (current_value - step) >= min) {
                        $(this).siblings("input[type='number']").val(current_value - step);
                    } else {
                        // limit reached
                        $(this).siblings("input[type='number']").val(min);
                    }
                }
            }

            // + button
            if(button_type === "+"){
                // empty field
                if(current_value === ""){
                    $(this).siblings("input[type='number']").val(max === undefined ? 0 : max);
                } else {
                    // check is there is a limit and if it is reached
                    if(max === undefined || (current_value + step) <= max) {
                        $(this).siblings("input[type='number']").val(current_value + step);
                    } else {
                        // limit reached
                        $(this).siblings("input[type='number']").val(max);
                    }
                }
            }
        }

        // clear event handler
        function clear_click(e){
            $(this).siblings("input[type='number']").val('');
            return false;
        }

        function toNum(value){
            if(value === undefined){
                return undefined;
            }
            return parseFloat(value, 10);
        }

    });
})(jQuery);