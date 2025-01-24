const { registerBlockType } = wp.blocks;
const { TextControl, Button, PanelBody } = wp.components;
const { useBlockProps, InspectorControls } = wp.blockEditor;
const { Fragment, useState } = wp.element;

registerBlockType('custom/testimonial-slider', {
    title: 'Testimonial Slider',
    icon: 'slides',
    category: 'layout',
    attributes: {
        testimonials: {
            type: 'array',
            default: [],
        },
    },
    edit: ({ attributes, setAttributes }) => {
        const blockProps = useBlockProps();
        const { testimonials } = attributes;

        const addTestimonial = () => {
            const newTestimonial = { quote: '', author: '' };
            setAttributes({ testimonials: [...testimonials, newTestimonial] });
        };

        const updateTestimonial = (index, field, value) => {
            const updatedTestimonials = testimonials.map((testimonial, i) =>
                i === index ? { ...testimonial, [field]: value } : testimonial
            );
            setAttributes({ testimonials: updatedTestimonials });
        };

        const removeTestimonial = (index) => {
            const updatedTestimonials = testimonials.filter((_, i) => i !== index);
            setAttributes({ testimonials: updatedTestimonials });
        };

        return (
            <Fragment>
                <InspectorControls>
                    <PanelBody title="Testimonials Settings">
                        <Button isPrimary onClick={addTestimonial}>
                            Add Testimonial
                        </Button>
                    </PanelBody>
                </InspectorControls>
                <div {...blockProps}>
                    {testimonials.map((testimonial, index) => (
                        <div key={index} className="testimonial-item-editor">
                            <TextControl
                                label="Quote"
                                value={testimonial.quote}
                                onChange={(value) => updateTestimonial(index, 'quote', value)}
                            />
                            <TextControl
                                label="Author"
                                value={testimonial.author}
                                onChange={(value) => updateTestimonial(index, 'author', value)}
                            />
                            <Button
                                isDestructive
                                onClick={() => removeTestimonial(index)}
                            >
                                Remove Testimonial
                            </Button>
                        </div>
                    ))}
                </div>
            </Fragment>
        );
    },
    save: () => {
        // This block uses PHP rendering, so no save implementation is needed.
        return null;
    },
});
