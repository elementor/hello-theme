export const ActionLinks = ( { image, title, description, buttonText, link } ) => {
	return (
		<div className="hello_elementor__action_link">
			<img src={ image } alt="Promotion" />
			<p className="action_link_title">{ title }</p>
			<p className="action_link_description">{ description }</p>
			<a className="components-button is-secondary" href={ link } target="_blank" rel="noreferrer">{ buttonText }</a>
		</div>
	);
};
