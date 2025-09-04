import fs from 'fs';
import path from 'path';

// File to store page URL
const urlStorePath = path.join( __dirname, '..', 'temp-form-page-url.txt' );

/**
 * Gets the page URL from the file storage
 *
 * @return {string} The stored page URL or empty string if not found
 */
export const getPageUrl = (): string => {
	try {
		return fs.readFileSync( urlStorePath, 'utf8' );
	} catch ( e ) {
		return '';
	}
};

/**
 * Saves a page URL to the file storage
 *
 * @param {string} url - The URL to save
 */
export const savePageUrl = ( url: string ): void => {
	fs.writeFileSync( urlStorePath, url );
};
