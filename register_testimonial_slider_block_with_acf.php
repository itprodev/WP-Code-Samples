<?php
function register_testimonial_slider_block() {
    if (!function_exists('acf_register_block_type')) {
        return; // ACF plugin is required.
    }

    // Register the custom block.
    acf_register_block_type(array(
        'name'              => 'testimonial-slider',
        'title'             => __('Testimonial Slider'),
        'description'       => __('A custom slider to display client testimonials.'),
        'render_callback'   => 'render_testimonial_slider_block',
        'category'          => 'formatting',
        'icon'              => 'slides',
        'keywords'          => array('testimonial', 'slider', 'acf'),
        'supports'          => array(
            'align' => true, // Supports wide and full alignments.
        ),
        'enqueue_assets'    => function() {
            wp_enqueue_script(
                'testimonial-slider-script',
                get_template_directory_uri() . '/assets/js/testimonial-slider.js',
                array('jquery'),
                filemtime(get_template_directory() . '/assets/js/testimonial-slider.js'),
                true
            );
            wp_enqueue_style(
                'testimonial-slider-style',
                get_template_directory_uri() . '/assets/css/testimonial-slider.css',
                array(),
                filemtime(get_template_directory() . '/assets/css/testimonial-slider.css')
            );
        },
    ));
}
add_action('acf/init', 'register_testimonial_slider_block');

// Callback to render the block.
function render_testimonial_slider_block($block) {
    // Fetch ACF fields for the block.
    $testimonials = get_field('testimonials'); // Repeater field containing testimonials.
    if (!$testimonials) {
        return '<p>' . __('Please add testimonials in the block settings.', 'textdomain') . '</p>';
    }

    // Block content output.
    ob_start(); ?>
    <div class="testimonial-slider">
        <?php foreach ($testimonials as $testimonial): ?>
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
