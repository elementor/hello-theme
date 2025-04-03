import Box from '@elementor/ui/Box';
import Tab from '@elementor/ui/Tab';
import TabPanel from '@elementor/ui/TabPanel';
import Tabs from '@elementor/ui/Tabs';
import { __ } from '@wordpress/i18n';
import useTabs from '@elementor/ui/useTabs';
import Typography from '@elementor/ui/Typography';
import { Seo } from './seo';
import { store as noticesStore } from '@wordpress/notices';
import { useDispatch, useSelect } from '@wordpress/data';
import Snackbar from '@elementor/ui/Snackbar';
import Alert from '@elementor/ui/Alert';
import { useEffect, useState } from 'react';
import { Structure } from './structure';
import { Theme } from './theme';
import { useSettingsContext } from './use-settings-context';
import Paper from '@elementor/ui/Paper';
import { styled } from '@elementor/ui/styles';
import Link from '@elementor/ui/Link';
import Stack from '@elementor/ui/Stack';
import Modal from '@elementor/ui/Modal';
import Update from './update';

const Notices = () => {
	const notices = useSelect(
		( select ) =>
			select( noticesStore )
				.getNotices()
				.filter( ( notice ) => 'snackbar' === notice.type ),
		[],
	);

	useEffect( () => {
		setOpen( true );
	}, [ notices ] );

	const [ open, setOpen ] = useState( true );
	const { removeNotice } = useDispatch( noticesStore );

	const onClose = () => {
		removeNotice();
		setOpen( false );
	};

	return (
		notices.map( ( notice ) => {
			const { content, id, status } = notice;

			return (
				<Snackbar
					open={ open }
					key={ id }
					autoHideDuration={ 3000 }
					onClose={ onClose }
					anchorOrigin={ { vertical: 'bottom', horizontal: 'right' } }
				>
					<Alert onClose={ onClose } severity={ status } sx={ { width: '100%' } }>
						{ content }
					</Alert>
				</Snackbar>
			);
		} )
	);
};

const StyledTab = styled( Tab )( () => ( {
	'&.Mui-selected': {
		color: '#C00BB9',
	},
} ) );

const StyledTabs = styled( Tabs )( () => ( {
	'& .MuiTabs-indicator': {
		backgroundColor: '#C00BB9',
	},
} ) );

const style = {
	position: 'absolute',
	top: '50%',
	left: '50%',
	transform: 'translate(-50%, -50%)',
	bgcolor: 'background.paper',
	border: '1px solid #000',
	boxShadow: 24,
	p: 2,
	maxHeight: '80vh',
	overflowY: 'auto',
};

export const SettingsPage = () => {
	const { whatsNew } = useSettingsContext();
	const { getTabsProps, getTabProps, getTabPanelProps } = useTabs( 'one' );
	const [ open, setOpen ] = useState( false );

	const handleOpen = ( event ) => {
		event.preventDefault();
		setOpen( true );
	};

	const handleClose = () => setOpen( false );

	return (
		<>

			<Paper elevation={ 1 } sx={ { px: 4, py: 3, maxWidth: 750 } }>
				<Box sx={ { width: '100%' } }>
					<Stack justifyContent={ 'space-between' } direction={ 'row' } alignItems={ 'center' }>
						<Typography variant="h4" gutterBottom>
							{ __( 'Advanced theme settings', 'hello-elementor' ) }
						</Typography>
						<Link href="#" onClick={ ( event ) => handleOpen( event ) } color={ 'primary' }>
							{ __( 'Changelog', 'hello-elementor' ) }
						</Link>
					</Stack>
					<Typography variant="body2" component="div" sx={ { mb: 4 } }>
						{ __( 'Advanced settings are available for experienced users and developers. If you\'re unsure about a setting, we recommend keeping the default option.', 'hello-elementor' ) }
					</Typography>
					<Box>
						<Notices />
					</Box>
					<Box sx={ { borderBottom: 1, borderColor: 'divider' } }>
						<StyledTabs { ...getTabsProps() } aria-label="basic tabs example">
							<StyledTab label={ __( 'SEO and accessibility', 'hello-elementor' ) } { ...getTabProps( 'one' ) } />
							<StyledTab label={ __( 'Structure and layout', 'hello-elementor' ) } { ...getTabProps( 'two' ) } />
							<StyledTab label={ __( 'CSS and styling control', 'hello-elementor' ) } { ...getTabProps( 'three' ) } />
						</StyledTabs>
					</Box>
					<TabPanel { ...getTabPanelProps( 'one' ) }><Seo /></TabPanel>
					<TabPanel { ...getTabPanelProps( 'two' ) }><Structure /></TabPanel>
					<TabPanel { ...getTabPanelProps( 'three' ) }><Theme /></TabPanel>
				</Box>
			</Paper>
			<Modal
				open={ open }
				onClose={ handleClose }
				aria-labelledby="modal-modal-title"
				aria-describedby="modal-modal-description"
	>
				<Box sx={ style }>
					<Typography variant={ 'h4' }>{ __( 'Changelog', 'hello-plus' ) }</Typography>
					<Stack direction={ 'column' } gap={ 1 } sx={ { mt: 2 } }>
						{ whatsNew.map( ( item ) => <Update key={ item.id } { ...item } /> ) }
					</Stack>
				</Box>
			</Modal>
		</>
	);
};
