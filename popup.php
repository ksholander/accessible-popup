<?php

namespace CG_Blocks;

/**
 * Implements an ACF custom block for an accessible popup.
 * @link https://www.advancedcustomfields.com/resources/blocks/
 */
class Popup
{
    private static $obj = null;

    /**
     * This function will create a singleton object of the class
     * if one does not already exist.
     * @return Popup
     */
    public static function init()
    {
        if (!isset(self::$obj)) {
            self::$obj = new self();
        }
        return self::$obj;
    }

    private final function __construct()
    {
        // register the block with WordPress
        add_action('init', function () {
            register_block_type(__DIR__);
        });

        // register the JSON file for ACF
        add_filter('acf/settings/load_json', [$this, 'acf_register_json_files'], 10, 1);
    }

    /**
     * Register the JSON files for ACF
     */
    function acf_register_json_files($paths): array
    {
        $paths[] = __DIR__ . '/acf-json';
        return $paths;
    }

    /**
     * Decode the spacing settings from Gutenberg
     * spacing value can either be a css variable or it can be absolute css numbers
     * @param string $spacing - spacing value from gutenberg
     * @return string
     **/
    private function decodeSpacing($spacing) {
        preg_match("/^var:preset\|([^|]*)\|([^|]*)$/", $spacing, $matches);
        if ($matches) {
            // if it is a variable then return the variable
            return "var(--wp--preset--" . $matches[1] . "--" . $matches[2] . ")";
        }
        // not a variable so just pass the value through
        return $spacing;
    }

    /**
     * This is the render function for the block.
     * It will add the button and the popup to the page.
     * @param array $block The block settings and attributes
     * @param string $content The block content
     * @param bool $is_preview True during AJAX preview
     * @param int $post_id The post ID
     * @param array $context The context
     */
    public function display_block($block, $content = '', $is_preview = false, $post_id = 0, $context = [])
    {
        $id = !empty($block['anchor']) ? $block['anchor'] : wp_unique_id();
        $class = 'popup ';
        $class .= !empty($block['className']) ? $block['className'] : "";
        $class .= $is_preview ? ' popup-editor' : '';
        $label = get_field('button_label');
        $title = get_field('popup_title') ?? "Accessible Popup";

        $style = "";
        if (!empty($block['style']['spacing']['padding'])) {
            $padding = $block['style']['spacing']['padding'];
            foreach($padding as $side => $spacing) {
                $style .= "padding-{$side}: " . $this->decodeSpacing($spacing) . ";";
            }
        }
?>
        <div class="wp-block-buttons is-layout-flex">
            <div class="wp-block-button">
                <button
                   id="<?= $id ?>-button" 
                   aria-haspopup="dialog" 
                   aria-expanded="false" 
                   aria-controls="popup-<?= $id ?>"
                   class="wp-block-button__link wp-element-button popup-open-button">
                    <?= $label ?>
                </button>
            </div>
        </div>

        <dialog 
            id="popup-<?= $id ?>" 
            class="<?= $class ?>" 
            aria-labelledby="<?= $id ?>-title" 
            <?= $is_preview ? " open='true'" : "" ?>>
            <button autofocus class='close-popup-button' aria-label="close popup">
                <svg aria-hidden="true" fill="#000000" height="24px" width="24px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 512 512" xml:space="preserve">
                    <g>
                        <g>
                            <polygon points="512,59.076 452.922,0 256,196.922 59.076,0 0,59.076 196.922,256 0,452.922 59.076,512 256,315.076 452.922,512
                                512,452.922 315.076,256         "/>
                        </g>
                    </g>
                </svg>
            </button>
            <?php
            if (!$is_preview) {
                ?>
                <h2 id="<?= $id ?>-title" class='popup-title'><?= $title ?></h2>
                <?php
            } else {
                ?>
                <h2 id="<?= $id ?>-title" class='popup-title'>Build your popup here:</h2>
                <?php
            }
            ?>
            <div 
                class="popup-content"
                style="<?= $style ?> ">
                <InnerBlocks templateLock="false" />
            </div>
        </dialog>
<?php
    }
}

Popup::init();
