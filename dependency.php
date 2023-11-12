<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Check if the class does not exits then only allow the file to add
 */
if( ! class_exists( 'buddypress' ) ) {
    class AcrossWP_BuddyPress_Platform_Dependency extends AcrossWP_Plugins_Dependency {

        /**
         * Load this function on plugin load hook
         * Example: _e('<strong>BuddyBoss Sorting Option In Network Search</strong></a> requires the BuddyPress plugin to work. Please <a href="https://wordpress.org/plugins/buddypress/" target="_blank">install BuddyPress</a> first.', 'sorting-option-in-network-search-for-buddyboss');
         */
        function constant_not_define_text(){
            printf( 
                __( 
                    '<strong>%s</strong></a> requires the BuddyPress plugin to work. Please <a href="https://wordpress.org/plugins/buddypress/" target="_blank">install BuddyPress</a> first.',
                    'acrosswp'
                ),
                $this->get_plugin_name()
            );
        }

        /**
         * Load this function on plugin load hook
         * Example: printf( __('<strong>BuddyBoss Sorting Option In Network Search</strong></a> requires BuddyPress plugin version %s or higher to work. Please update BuddyPress.', 'sorting-option-in-network-search-for-buddyboss'), $this->mini_version() );
         */
        function constant_mini_version_text() {
            printf( 
                __( 
                    '<strong>%s</strong></a> requires BuddyPress plugin version %s or higher to work. Please update BuddyPress.',
                    'acrosswp'
                ),
                $this->get_plugin_name(),
                $this->mini_version()
            );
        }

        /**
         * Load this function on plugin load hook
         * Example: printf( __('<strong>BuddyBoss Sorting Option In Network Search</strong></a> requires BuddyPress plugin version %s or higher to work. Please update BuddyPress.', 'sorting-option-in-network-search-for-buddyboss'), $this->mini_version() );
         */
        function component_required_text() {

            $bb_components = bp_core_get_components();
            $component_required = $this->component_required();
            $active_components = apply_filters( 'bp_active_components', bp_get_option( 'bp-active-components' ) );
            $component_required_label = array();

            foreach( $bb_components as $key => $bb_component ) {
                if( in_array( $key, $component_required ) ) {
                    $component_required_label[] = '<strong>' . $bb_component['title'] . '</strong>';
                }
            }

            if( count( $component_required_label ) > 1 ) {
                $last = array_pop( $component_required_label );
                $component_required_label = implode( ', ', $component_required_label ) . ' and ' . $last;
            } else {
                $component_required_label = $component_required_label[0];
            }

            printf( 
                __( 
                    '<strong>%s</strong></a> requires BuddyPress %s Component to work. Please Active the mentions Component.',
                    'acrosswp'
                ),
                $this->get_plugin_name(),
                $component_required_label
            );
        }

        /**
         * Load this function on plugin load hook
         */
        function constant_name(){
            return 'BP_VERSION';
        }

        /**
         * Load this function on plugin load hook
         */
        function mini_version(){
            return '11.3.1';
        }

        /**
         * Load this function on plugin load hook
         */
        public function component_required() {
            return array();
        }

        /**
         * Check if the Required Component is Active
         */
        public function required_component_is_active() {
            $is_active = false;
            $component_required = $this->component_required();

            // Active components.
            $active_components = apply_filters( 'bp_active_components', bp_get_option( 'bp-active-components' ) );

            foreach( $component_required as $component_require ) {
                if( isset( $active_components[ $component_require ] ) ) {
                    $is_active = true;
                } else {
                    $is_active = false;
                    break;
                }
            }

            return $is_active;

        }
    }
}