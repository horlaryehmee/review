/**
 * WordPress dependencies
 */
import { registerPlugin } from '@wordpress/plugins';
import { RichTextToolbarButton } from '@wordpress/block-editor';
import { registerFormatType, insert } from '@wordpress/rich-text';
import {
    Modal,
    TextControl,
    ToggleControl,
    Button,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { useState } from '@wordpress/element';
import {
    render,
    unmountComponentAtNode,
} from '@wordpress/element';

const SHORTCODE_NAME = 'wpdiscuz-feedback';

/**
 * Generate unique ID
 */
function generateId() {
    return Math.random().toString(36).substring(2, 12);
}

/**
 * Escape shortcode attributes
 */
function escapeAttribute(value) {
    return String(value)
        .replace(/"/g, '&quot;')
        .replace(/\]/g, '&#93;')
        .replace(/\[/g, '&#91;');
}

/**
 * Open modal helper
 */
function openFeedbackModal({ selectedText, value, onChange }) {
    const container = document.createElement('div');
    document.body.appendChild(container);

    const ModalApp = () => {
        const [question, setQuestion] = useState(selectedText);
        const [opened, setOpened] = useState(false);

        const close = () => {
            unmountComponentAtNode(container);
            document.body.removeChild(container);
        };

        const insertShortcode = () => {
            const shortcode =
                `[${SHORTCODE_NAME} ` +
                `id="${generateId()}" ` +
                `question="${escapeAttribute(question)}" ` +
                `opened="${opened ? 1 : 0}"]` +
                `${selectedText}` +
                `[/${SHORTCODE_NAME}]`;

            onChange(
                insert(value, shortcode, value.start, value.end)
            );

            close();
        };

        return (
            <Modal
                title={__('Inline Feedback', 'wpdiscuz')}
                onRequestClose={close}
            >
                <TextControl
                    label={__('Question', 'wpdiscuz')}
                    value={question}
                    onChange={setQuestion}
                />

                <ToggleControl
                    label={__('Opened by default', 'wpdiscuz')}
                    checked={opened}
                    onChange={setOpened}
                />

                <div style={{ marginTop: 16 }}>
                    <Button
                        variant="primary"
                        onClick={insertShortcode}
                    >
                        {__('Insert', 'wpdiscuz')}
                    </Button>

                    <Button
                        variant="secondary"
                        onClick={close}
                        style={{ marginLeft: 8 }}
                    >
                        {__('Cancel', 'wpdiscuz')}
                    </Button>
                </div>
            </Modal>
        );
    };

    render(<ModalApp />, container);
}

/**
 * Register RichText format
 */
registerFormatType('wpdiscuz/feedback', {
    title: __('Inline Feedback', 'wpdiscuz'),
    tagName: 'span',
    className: 'wpdiscuz-feedback-format',

    edit({ value, onChange }) {
        if (!value || value.start === value.end) {
            return null;
        }

        const selectedText =
            value.text?.slice(value.start, value.end) || '';

        if (!selectedText) {
            return null;
        }

        return (
            <RichTextToolbarButton
                icon="shortcode"
                title={__('Inline Feedback', 'wpdiscuz')}
                onClick={() =>
                    openFeedbackModal({
                        selectedText,
                        value,
                        onChange,
                    })
                }
            />
        );
    },
});

/**
 * Plugin registration
 */
registerPlugin('wpdiscuz-shortcode-inserter', {
    render: () => null,
});
