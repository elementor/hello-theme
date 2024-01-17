export const ActionLinks = ( { image, alt, title, message, button, link } ) => {
	return (
		<div className="hello_elementor__action_links">
			<img src={ image } alt={ alt } />
			<p className="hello_elementor__action_links__title">{ title }</p>
			<p className="hello_elementor__action_links__message">{ message }</p>
			<a className="components-button is-secondary" href={ link } target="_blank" rel="noreferrer">{ button }</a>
		</div>
	);
};
