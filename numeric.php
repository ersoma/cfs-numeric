<?php

class cfs_numeric extends cfs_field
{
    function __construct() {
        $this->name = 'numeric';
        $this->label = __( 'Numeric', 'cfs-numeric' );
    }

    function html( $field ) {
        if ( empty( $field->value ) || ( ! isset($field->value)) ) {
            $field->value = 0;
        }
    ?>
        <script>
        (function($) {
            $(function() {

                
            });
        })(jQuery);
        </script>
        <input type="text" id="<?php echo $field->input_name; ?>" name="" value="<?php echo $field->value; ?>" />
    <?php
    }

    function options_html( $key, $field ) {
        $this->load_assets();

        $min_value = $this->get_option( $field, 'min_value' ) !== "" ? $this->get_option( $field, 'min_value' ) : "0";
        $max_value = $this->get_option( $field, 'max_value' ) !== "" ? $this->get_option( $field, 'max_value' ) : "100";
        $default_value = $this->get_option( $field, 'default_value' ) !== "" ? $this->get_option( $field, 'default_value' ) : "0";
        $step = $this->get_option( $field, 'step' ) !== "" ? $this->get_option( $field, 'step' ) : "1";
        $precision = $this->get_option( $field, 'precision' ) !== "" ? $this->get_option( $field, 'precision' ) : "1";

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
        /*error_log( "pre_save" );
        error_log( print_r( $value, true) );
        if ( is_array( $value )) {
            $value = $value[0];
        }
        */
        return serialize( $value );
    }

    function prepare_value( $value, $field = null ) {
        return unserialize( $value[0] );
    }

    function format_value_for_api( $value, $field = null ) {
        $output = 0;
        if ( isset($value) ) {
            $output = $value;
        }
        return $output;
    }

    function load_assets() {
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
