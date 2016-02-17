<?php

class cfs_numeric extends cfs_field
{
    function __construct() {
        $this->name = 'numeric';
        $this->label = __( 'Numeric', 'cfs-numeric' );
    }

    function html( $field ) {
        // value
        if ( empty( $field->value ) || ( ! isset($field->value['saved'])) ) {
            $field->value = array(
                'value'    => ($this->get_option( $field, 'default_value' ) !== "") ? $this->get_option( $field, 'default_value' ) : "0",
                'saved'     => 0,
            );
        }

        // min value
        $min_value = $this->get_option( $field, 'min_value' );
        $min_value_str = $min_value != "" ? 'min="' . $min_value . '" ' : '';

        // max value
        $max_value = $this->get_option( $field, 'max_value' );
        $max_value_str = $max_value != "" ? 'max="' . $max_value . '" ' : '';

        // step
        $step = $this->get_option( $field, 'step' );
        $step_str = $step != "" ? 'data-cfs-numeric-step="' . $step . '"' : '';

        // precision
        $precision = $this->get_option( $field, 'precision' );

        // parameters setup
        $parameters = array();
        if($min_value != ""){
            $parameters[] = __('Minimum value: ', 'cfs-numeric') . $min_value;
        }
        if($max_value != ""){
            $parameters[] = __('Maximum value: ', 'cfs-numeric') . $max_value;
        }
        if($precision != ""){
            $parameters[] = __('Value will be rounded to ', 'cfs-numeric') . $precision . __(' digit(s) after the decimal point.', 'cfs-numeric');
        }
    ?>
        <button type="button" class="button-secondary">-</button>
        <input type="number" id="<?php echo $field->input_name; ?>" name="<?php echo $field->input_name; ?>[value]" 
            value="<?php echo $field->value['value']; ?>" step="any" <?php echo $min_value_str . $max_value_str . $step_str ?>  />
        <button type="button" class="button-secondary">+</button>

        <input type="hidden" name="<?php echo $field->input_name; ?>[saved]" value="1">

        <?php if( $this->get_option( $field, 'required' ) == 0) { ?>
            <a href="#" class="button-secondary" style="float:right;"><?php _e('Clear', 'cfs-numeric'); ?></a>
        <?php } ?>

        <p class="description">
            <?php
                echo implode(", ", $parameters);
            ?>
        </p>

    <?php
    }

    function options_html( $key, $field ) {

        $this->load_option_assets();

        // Get values or defaults
        $min_value = $key == 'clone' ? "0" : $this->get_option( $field, 'min_value' );
        $max_value = $key == 'clone' ? "100" : $this->get_option( $field, 'max_value' );
        $default_value = $key == 'clone' ? "0" : $this->get_option( $field, 'default_value' );
        $step = $key == 'clone' ? "1" : $this->get_option( $field, 'step' );
        $precision = $key == 'clone' ? "1" : $this->get_option( $field, 'precision' );

        ?>
        <tr class="field_option field_option_<?php echo $this->name; ?>">
            <td class="label">
                <label><?php _e( 'Minimum value', 'cfs-numeric' ); ?></label>
                <div class="cfs_tooltip">
                    <div class="tooltip_inner"><?php _e( 'Must be smaller or equal to maximum value.', 'cfs-numeric' ); ?></div>
                </div>
            </td>
            <td>
                <input type="number" name="cfs[fields][<?php echo $key; ?>][options][min_value]" value="<?php echo $min_value; ?>" />
                <p class="description"> <?php _e('Leave empty to remove limit.', 'cfs-numeric'); ?> </p>
            </td>
        </tr>
        <tr class="field_option field_option_<?php echo $this->name; ?>">
            <td class="label">
                <label><?php _e( 'Maximum value', 'cfs-numeric' ); ?></label>
                <div class="cfs_tooltip">
                    <div class="tooltip_inner"><?php _e( 'Must be greater or equal to minimum value.', 'cfs-numeric' ); ?></div>
                </div>
            </td>
            <td>
                <input type="number" name="cfs[fields][<?php echo $key; ?>][options][max_value]" value="<?php echo $max_value; ?>" />
                <p class="description"> <?php _e('Leave empty to remove limit.', 'cfs-numeric'); ?> </p>
            </td>
        </tr>
        <tr class="field_option field_option_<?php echo $this->name; ?>">
            <td class="label">
                <label><?php _e( 'Default value', 'cfs-numeric' ); ?></label>
                <div class="cfs_tooltip">
                    <div class="tooltip_inner"><?php _e( 'Must be between minimum and maximum value.', 'cfs-numeric' ); ?></div>
                </div>
            </td>
            <td>
                <input type="number" name="cfs[fields][<?php echo $key; ?>][options][default_value]" value="<?php echo $default_value; ?>" />
            </td>
        </tr>
        <tr class="field_option field_option_<?php echo $this->name; ?>">
            <td class="label">
                <label><?php _e( 'Step', 'cfs-numeric' ); ?></label>
                <div class="cfs_tooltip">
                    <div class="tooltip_inner"><?php _e( 'The number to be added or subtracted with the helper buttons.', 'cfs-numeric' ); ?></div>
                </div>
            </td>
            <td>
                <input type="number" name="cfs[fields][<?php echo $key; ?>][options][step]" value="<?php echo $step; ?>" />
            </td>
        </tr>
        <tr class="field_option field_option_<?php echo $this->name; ?>">
            <td class="label">
                <label><?php _e( 'Precision', 'cfs-numeric' ); ?></label>
                <div class="cfs_tooltip">
                    <div class="tooltip_inner"><?php _e( 'Length of the fractional part in digits.', 'cfs-numeric' ); ?></div>
                </div>
            </td>
            <td>
                <input type="number" name="cfs[fields][<?php echo $key; ?>][options][precision]" value="<?php echo $precision; ?>" />
            </td>
        </tr>
        <tr class="field_option field_option_<?php echo $this->name; ?>">
            <td class="label">
                <label><?php cfs_e( 'Validation', 'cfs' ); ?></label>
            </td>
            <td>
                <?php
                    CFS()->create_field( array(
                        'type' => 'true_false',
                        'input_name' => "cfs[fields][$key][options][required]",
                        'input_class' => 'true_false',
                        'value' => $this->get_option( $field, 'required' ),
                        'options' => array( 'message' => cfs__( 'This is a required field', 'cfs' ) ),
                    ));
                ?>
            </td>
        </tr>
        <?php
    }

    function input_head( $field = null ) {
        $this->load_assets();
    }

    function pre_save( $value, $field = null ) {
        if ( isset( $value[0]['value'] ) && isset( $value[1]['saved'] ) ) {
            $value = array(
                    'value' => $value[0]['value'],
                    'saved' => $value[1]['saved'],
                ); 
        }
        return serialize( $value );
    }

    function prepare_value( $value, $field = null ) {
        return unserialize( $value[0] );
    }

    function format_value_for_input($value, $field = null) {
        return $value;
    }

    function format_value_for_api( $value, $field = null ) {
        $output = 0;
        if ( isset($value) ) {
            $precision = $field->options["precision"] !== "" ? $field->options["precision"] : 0;
            $output = $value['value'] != "" ? round($value['value'], $precision) : "";
        }
        return $output;
    }

    function load_assets() {
        wp_enqueue_style( 'cfs-numeric-styles', plugins_url( 'cfs-numeric' ) . '/assets/styles.css', array(), CFS_NUMERIC_VERSION );
        wp_enqueue_script( 'cfs-numeric-js', plugins_url( 'cfs-numeric' ) . '/assets/scripts.js', array( 'jquery' ), CFS_NUMERIC_VERSION );
    }
    function load_option_assets() {
        wp_enqueue_style( 'cfs-numeric-styles', plugins_url( 'cfs-numeric' ) . '/assets/styles.css', array(), CFS_NUMERIC_VERSION );
    }
}

// Wrappers for l10n functions in cfs domain
if ( ! function_exists( 'cfs__' ) ) {
    function cfs__( $string, $textdomain = 'cfs' ) {
        return __( $string, $textdomain );
    }
}
if ( ! function_exists( 'cfs_e' ) ) {
    function cfs_e( $string, $textdomain = 'cfs' ) {
        echo __( $string, $textdomain );
    }
}

?>
