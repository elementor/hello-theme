export type Image = {
    title: string,
    description?: string,
    altText?: string,
    caption?: string,
    extension: string,
    filePath?: string
}

export type User = {
	id?: string,
	username: string,
	password: string,
	email: string,
	roles?: string[],
}

export type LinkOptions = {
    targetBlank?: boolean,
    noFollow?: boolean,
    customAttributes?: {key:string, value: string },
    linkTo?: boolean,
    linkInpSelector?: string
}

export type WpPage = {
	title: {
		rendered?: string,
	}
	date?: string,
	dateGmt?: string,
	guid?: string,
	id?: string,
	link?: string,
	modified?: string,
	modifiedGmt?: string,
	slug: string,
	status?: 'publish' | 'future' | 'draft' | 'pending' | 'private',
	type?: string,
	password?: string,
	permalinkTemplate?: string,
	generatedSlug?: string,
	parent?: string,
	content: string,
	author?: string,
	excerpt?: string,
	featuredMedia?: string,
	commentStatus?: string,
	pingStatus?: string,
	menuOrder?: string,
	meta?: string,
	template?: string,
}

export type Post = {
	id?: string,
	date?: string,
	dateGmt?: string,
	slug?: string,
	status?: 'publish' | 'future' | 'draft' | 'pending' | 'private',
	password?: string,
	title?: string,
	content?: string,
	author?: number,
	excerpt?: string,
	featuredMedia?: number,
	commentStatus?: 'open' | 'closed',
	pingStatus?: 'open' | 'closed',
	format?: 'standard' | 'aside' | 'chat' | 'gallery' | 'link' | 'image' | 'quote' | 'status' | 'video' | 'audio',
	meta?: string,
	sticky?: boolean,
	template?: string,
	tags?: number
}

export type PageData = {
	id: string;
	url: string;
};

export type WindowType = Window & {
	$e?: {
		run: ( s: string, o: object )=> unknown
	}
	wpApiSettings?: { nonce: string }
	elementorNotifications?: {
		destroy: () => void
	},
	formWasSubmitted?: boolean
    formErrorDetected?: boolean
};
export type BackboneType = {
	Model: new ( o: {title: string} )=> unknown
};

export type $eType = {
	run: ( s: string, o: object )=> unknown
}

export type ElementorType = {
	navigator?: {
		isOpen: ()=> unknown
	},
	getContainer?: ( id: string )=> unknown,
	config?: {
		initialDocument:{
			id: string
		}
	},
	isDeviceModeActive?: () => unknown
}

export type Device = 'mobile' | 'mobile_extra' | 'tablet' | 'tablet_extra' | 'laptop' | 'desktop' | 'widescreen';

export type BreakpointEditableDevice = Exclude<Device, 'desktop'>;

export type GapControl = string | {
	column: string,
	row: string,
	unit?: string
}

export type ContainerType = 'flex' | 'grid';

export type ContainerPreset =
	| 'c100'
	| 'r100'
	| '50-50'
	| '33-66'
	| '25-25-25-25'
	| '25-50-25'
	| '50-50-50-50'
	| '50-50-100'
	| 'c100-c50-50'
	| '33-33-33-33-33-33'
	| '33-33-33-33-66'
	| '66-33-33-66'
