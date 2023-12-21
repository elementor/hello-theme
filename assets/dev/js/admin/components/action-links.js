export const ActionLinks = ( { image, title, message, button, link } ) => {
	return (
		<div className="hello_elementor__action_links">
			<img src={ image } alt="Elementor" />
			<p className="hello_elementor__action_links__title">{ title }</p>
			<p className="hello_elementor__action_links__message">{ message }</p>
			<a className="components-button is-secondary" href={ link } target="_blank" rel="noreferrer">{ button }</a>
		</div>
	);
};
