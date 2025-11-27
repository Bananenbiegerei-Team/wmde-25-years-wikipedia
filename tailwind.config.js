const plugin = require('tailwindcss/plugin');

module.exports = {
	content: [
		'./**/*.php',
		'./blocks/**/render.php',
		'./bb-blocks/**/render.php', // Explicitly include block templates
	],
	safelist: [
		{
			pattern: /justify-/,
			variants: ['sm', 'md', 'lg'],
		},
		{
			pattern: /text-(xs|sm|lg|xl)/,
		},
		{
			pattern: /(bg|text|border)-(white|black|primary|secondary|neutral|accent|warning|success|error)/,
		},
		{
            pattern: /shadow-(images|xl|2xl)/,
        },
		{
			pattern: /animate-(wiggle|jump|bounce|fade|spin|ping|pulse|shake|flip|roll)/,
		},
		{
			pattern: /animate-(once|twice|infinite|delay|duration|ease)/,
		},
	],
	theme: {
		screens: {
			xxs: '120px',
			xs: '320px',
			sm: '640px',
			md: '768px',
			lg: '1024px',
			xl: '1280px',
			'2xl': '1536px',
		},
		// Helper pixel to rem calc: https://nekocalc.com/de/px-zu-rem-umrechner
		fontSize: {
			xs: '0.75rem', // 12px
			sm: '0.875rem', // 14px
			base: '1rem', // 16px
			lg: '1.125rem', // 18px
			xl: '1.25rem', // 20px
			'2xl': '1.5rem', // 24px
			'3xl': '2rem', // 32px
			'4xl': '2.5rem', // 40px
			'5xl': '3.5rem', // 56px
			'6xl': '4rem', // 64px
			'3vw': '10vw',
		},
		fontFamily: {
			headings: ['Headings', 'sans-serif'],
			texts: ['Texts', 'sans-serif'],
			menus: ['Menus', 'sans-serif'],
		},
		fontWeight: {
			normal: 300,
			medium: 500,
			bold: 700,
		},
		extend: {
			dropShadow: {
				navbar: ['0px 3px 8px rgba(0, 0, 0, 0.24)'],
			},
			boxShadow: {
				xl: '0 0px 60px -15px rgba(0, 0, 0, 0.3)',
				navbar: '0 8px 30px rgba(0, 0, 0, 0.12)',
				hard: '-10px 10px 0 0 rgba(0, 0, 0, 1)',
				images: '0px 0px 24px 0px rgba(0, 0, 0, 0.25)',
			},
			maxWidth: {
				32: '8rem',
			},
			minHeight: {
				32: '8rem',
			},
			height: {
				specialscreen: 'calc(100vh - 5rem)',
			},
			maxHeight: {
				'screen-80': '80vh',
				'screen-1/2': '50vh',
				specialscreen: 'calc(100vh - 5rem)',
			},
			scale: {
				cards: '1.01',
			},
			containers: {
				'2xs': '13.125rem', // 210px
			},
		},
	},
	corePlugins: {
		aspectRatio: false,
	},
	plugins: [
		require('@tailwindcss/aspect-ratio'),
		require('@tailwindcss/container-queries'),
		require('tailwindcss-animated'),
		// plugin(function ({ addBase }) {
		// 	addBase({
		// 		//				html: { fontSize: '6px' },
		// 	});
		// }),
		require('@tailwindcss/forms'),
		require('tailwindcss-themer')({
			defaultTheme: {
				extend: {
					colors: {
						black: {
							DEFAULT: 'black',
						},
						white: {
							DEFAULT: 'white',
						},
						primary: {
							light: '#c0e6ff',
							DEFAULT: '#049dff',
							dark: '#15314e',
						},
						secondary: {
							light: '#FBEEBF',
							DEFAULT: '#F0BC00',
							dark: '#60341a',
						},
						neutral: {
							light: '#f6f6f6',
							DEFAULT: '#a2a9b1',
							dark: '#5e5e5e',
						},
						accent: {
							light: '#F9DDE9',
							DEFAULT: '#E679A6',
							dark: '#6b2235',
						},
						error: {
							light: '#fcd9d9',
							DEFAULT: '#e24949',
							dark: '#751212',
						},
						success: {
							light: '#cfe7cf',
							DEFAULT: '#3a903c',
							dark: '#062d07',
						},
						warning: {
							light: '#fbdfc5',
							DEFAULT: '#EE8019',
							dark: '#682517',
						},
					},
				},
			},
		}),
	],
};
