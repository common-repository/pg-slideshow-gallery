/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @param {Object} [props]           Properties passed from the editor.
 * @param {string} [props.className] Class name generated for the block.
 *
 * @return {WPElement} Element to render.
 */
export default function Edit({ attributes, setAttributes, className, isSelected }) {
	// Creates a <p class='wp-block-cgb-block-f1reslider'></p>.

	function updateSlideshow(ev) {
		setAttributes({
			selectedSlideshow: ev.target.value,
		});
	}
	function updateSlideshowType(ev) {
		setAttributes({
			selectedType: ev.target.value,
		});
	}
	return (
		<div>
			<label>{__('Slideshow', 'portfolio-gallery')}:</label> <select onChange={updateSlideshow} value={attributes.selectedSlideshow}>
				{
					Object.values(globals.slideshows).map(slideshow => {
						return (
							<option value={slideshow.ID} key={slideshow.ID}>{slideshow.post_title}</option>
						);
					})
				}
			</select>
			<select onChange={updateSlideshowType} value={attributes.selectedType}>
				<option value=slideshow>Slideshow</option>
					<option value=gallery>Gallery</option><option value=skitter>Skitter(Images Only)</option>
			</select>
		</div>
	);
}
