import React, { useState, useEffect } from 'react';

const componentMap = {
	BrandElementorIcon: () => import('../icons/elementor.tsx'),
};

const DynamicIcon = ({ componentName, ...rest }) => {
	const [Component, setComponent] = useState(null);

	useEffect(() => {
		if (componentMap[componentName]) {
			componentMap[componentName]().then((module) => {
				setComponent(() => module.default);
			});
		}
	}, [componentName]);

	if (!Component) {
		return null;
	}

	return <Component {...rest} />;
};

export default DynamicIcon;
