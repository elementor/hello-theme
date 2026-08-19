import apiFetch from '@wordpress/api-fetch';
import { createRoot } from 'react-dom/client';
import { useLayoutEffect } from 'react';
import { ThemeProvider } from '@elementor/ui/styles';
import { Welcome } from './components/paper/welcome';
import { AdminProvider } from './providers/admin-provider';

const App = ({ config, container }) => {
	useLayoutEffect(() => {
		container.style.visibility = 'visible';
	}, [container]);

	return (
		<ThemeProvider colorScheme="light">
			<AdminProvider initialSettings={config}>
				<Welcome
					sx={{
						mt: 2,
						mr: 2,
						mb: 1,
						width: '100%',
						px: 4,
						py: 3,
						position: 'relative',
					}}
					dismissable
				/>
			</AdminProvider>
		</ThemeProvider>
	);
};

const insertBanner = (container, placement) => {
	const { beforeWrap = false, selector, before = false } = placement;

	if (beforeWrap) {
		const wrapElement = document.querySelector('.wrap');

		if (!wrapElement) {
			return false;
		}

		wrapElement.insertAdjacentElement('beforebegin', container);
		return true;
	}

	if (before) {
		const anchor = document.querySelector(selector);

		if (!anchor) {
			return false;
		}

		anchor.insertAdjacentElement('beforebegin', container);
		return true;
	}

	const pageTitleAction = document.querySelector('.wrap .page-title-action');

	if (pageTitleAction) {
		pageTitleAction.insertAdjacentElement('afterend', container);
		return true;
	}

	const headerEnd = document.querySelector(selector);

	if (!headerEnd) {
		return false;
	}

	headerEnd.insertAdjacentElement('afterend', container);
	return true;
};

const init = async () => {
	if ('undefined' === typeof window.ehe_cb) {
		return;
	}

	let config;

	try {
		const response = await apiFetch({
			path: '/elementor-hello-elementor/v1/admin-settings',
		});
		config = response.config;
	} catch (e) {
		return;
	}

	if (!config?.welcome?.title) {
		return;
	}

	const { beforeWrap = false } = window.ehe_cb;
	const { selector, before = false } = window.ehe_cb.data;

	const container = document.createElement('div');
	container.id = 'ehe-admin-cb';
	container.className = 'ehe-admin-cb';
	container.style.visibility = 'hidden';

	if (!insertBanner(container, { beforeWrap, selector, before })) {
		return;
	}

	const root = createRoot(container);
	root.render(<App config={config} container={container} />);
};

if ('loading' === document.readyState) {
	document.addEventListener('DOMContentLoaded', init);
} else {
	init();
}
