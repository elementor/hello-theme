export const ActionLinks = ( { image, title, description, buttonText, link } ) => {
	return (
		<div className="hello_elementor__action_links">
			<img src={ image } alt="Promotion" />
			<p className="hello_elementor__action_links__title">{ title }</p>
			<p className="hello_elementor__action_links__description">{ description }</p>
			<a className="components-button is-secondary" href={ link } target="_blank" rel="noreferrer">{ buttonText }</a>
		</div>
	);
};
