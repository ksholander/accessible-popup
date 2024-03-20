<?php

namespace CG_Blocks;

/**
 * This class builds an ACF custom Gutenberg Block.
 * The block consists of a button with a label that can be set with an ACF field
 * and a popup container which supports innerblocks for building out the popup content
 *
 * The register_block method is used to setup the block configuration and register it
 * with ACF
 * The display_block method is used to generate the html of the block from the supplied
 * settings
 */

class Popup
{
    private static $obj = null;

    public static function init()
    {
        if (!isset(self::$obj)) {
            self::$obj = new self();
        }
    }

    private final function __construct()
    {
        $this->register_block();
    }

    /**
     * register_block
     * method to define the configuration of the block
     * and register it using acf_register_block_type()
     */
    protected function register_block()
    {
        add_action('acf/init', function () {
            if (function_exists('acf_register_block_type')) {
                acf_register_block_type([
                    'name'          => 'cg-popup',
                    'title'         => 'popup',
                    'description'   => 'adds a button and connected popup',
                    'render_callback' => [$this, 'display_block'],
                    'category'      => 'codegeek',
                    'icon'          => 'page',
                    'keywords'      => ['popup', 'button'],
                    'mode'          => 'preview',
                    'supports'      => [
                        'align'     => false,
                        'anchor'    => false,
                        'customClassName' => false,
                        'jsx'       => true,
                    ]
                ]);
            }
        });
    }

    /**
     * display_block
     * method to render the block html using the supplied settings
     */
    public function display_block($block, $content = '', $is_preview = false, $post_id = 0)
    {
        global $post;

        $id = wp_unique_id();
        $label = get_field('button_label');

        /* determine whether to display the block as backend editor or frontend */
        /* the popup contents are obviously hidden on the frontend, but we need */
        /* to make the popup visible on the backend so its contents can be edited */
        if (!function_exists('\get_current_screen')) {
            require_once ABSPATH . '/wp-admin/includes/screen.php';
        }
        $class = (\get_current_screen()) ? 'popup-editor' : 'popup';

?>
        <!-- popup open button -->
        <div class="wp-block-buttons is-layout-flex">
            <div class="wp-block-button">
                <a id="<?= $id ?>-button" 
                   class="wp-block-button__link wp-element-button popup-open-button" 
                   data-popup="popup-<?= $id ?>">
                    <?= $label ?>
                </a>
            </div>
        </div>

        <!-- popup -->
        <div class="<?= $class ?>" id="popup-<?= $id ?>">
            <button class='close-popup-button'>&times;</button>
            <p class='instructions'>Build your popup here:</p>
            <div class="popup-content">
                <InnerBlocks templateLock="false" />
            </div>
        </div>
<?php
    }
}

Popup::init();
