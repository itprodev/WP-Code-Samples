<?php
function register_testimonial_slider_block() {
    wp_register_script(
        'testimonial-slider-block-editor-script',
        get_template_directory_uri() . '/blocks/testimonial-slider/block.js',
        array('wp-blocks', 'wp-element', 'wp-editor'),
        filemtime(get_template_directory() . '/blocks/testimonial-slider/block.js')
    );

    wp_register_style(
        'testimonial-slider-block-style',
        get_template_directory_uri() . '/blocks/testimonial-slider/style.css',
        array(),
        filemtime(get_template_directory() . '/blocks/testimonial-slider/style.css')
    );

    register_block_type('custom/testimonial-slider', array(
        'editor_script' => 'testimonial-slider-block-editor-script',
        'style'         => 'testimonial-slider-block-style',
        'render_callback' => 'render_testimonial_slider_block',
        'attributes'    => array(
            'testimonials' => array(
                'type'    => 'array',
                'default' => array(),
                'items'   => array(
                    'type' => 'object',
                    'properties' => array(
                        'quote' => array('type' => 'string', 'default' => ''),
                        'author' => array('type' => 'string', 'default' => ''),
                    ),
                ),
            ),
        ),
    ));
}
add_action('init', 'register_testimonial_slider_block');

// Callback function to render the block on the front end.
function render_testimonial_slider_block($attributes) {
    if (empty($attributes['testimonials'])) {
        return '<p>' . __('Add testimonials in the block settings.', 'textdomain') . '</p>';
    }

    ob_start(); ?>
    <div class="testimonial-slider">
        <?php foreach ($attributes['testimonials'] as $testimonial): ?>
            <div class="testimonial-item">
                <blockquote class="testimonial-quote">
                    <?php echo esc_html($testimonial['quote']); ?>
                </blockquote>
                <p class="testimonial-author">
                    - <?php echo esc_html($testimonial['author']); ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
