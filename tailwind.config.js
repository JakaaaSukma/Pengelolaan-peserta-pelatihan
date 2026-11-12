/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        // Red Dominant Theme (Executive Ruby & Crimson Dark Palette)
        "surface": "#0d090b",
        "surface-dim": "#0a0608",
        "surface-bright": "#221318",
        "surface-container-lowest": "#060405",
        "surface-container-low": "#130c0f",
        "surface-container": "#1a1014",
        "surface-container-high": "#24151c",
        "surface-container-highest": "#301b24",
        "on-surface": "#fce7ea",
        "on-surface-variant": "#e2cbd0",
        "inverse-surface": "#fce7ea",
        "inverse-on-surface": "#221318",
        "outline": "#997b82",
        "outline-variant": "#4d3a40",
        "surface-tint": "#f43f5e",
        "primary": "#fda4af",
        "on-primary": "#4c0519",
        "primary-container": "#dc2626", // Dominant Corporate Red
        "on-primary-container": "#fff1f2",
        "inverse-primary": "#be123c",
        "secondary": "#fca5a5",
        "on-secondary": "#450a0a",
        "secondary-container": "#991b1b", // Rich Deep Red
        "on-secondary-container": "#fee2e2",
        "tertiary": "#fb7185", // Bright Coral/Ruby Accent
        "on-tertiary": "#4c0519",
        "tertiary-container": "#e11d48",
        "on-tertiary-container": "#ffe4e6",
        "error": "#ffb4ab",
        "on-error": "#690005",
        "error-container": "#93000a",
        "on-error-container": "#ffdad6",
        "primary-fixed": "#ffe4e6",
        "primary-fixed-dim": "#fda4af",
        "on-primary-fixed": "#4c0519",
        "secondary-fixed": "#fee2e2",
        "secondary-fixed-dim": "#fca5a5",
        "tertiary-fixed": "#ffe4e6",
        "tertiary-fixed-dim": "#fb7185",
        "background": "#0d090b",
        "on-background": "#fce7ea"
      },
      fontFamily: {
        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
        headline: ['"Plus Jakarta Sans"', 'sans-serif'],
        body: ['Inter', 'sans-serif'],
      },
      keyframes: {
        'fade-in-up': {
          '0%': { opacity: '0', transform: 'translateY(22px) scale(0.985)' },
          '100%': { opacity: '1', transform: 'translateY(0) scale(1)' },
        },
        'fade-in': {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        'scale-in': {
          '0%': { opacity: '0', transform: 'scale(0.96)' },
          '100%': { opacity: '1', transform: 'scale(1)' },
        },
        'float-slow': {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(-6px)' },
        },
      },
      animation: {
        'fade-in-up': 'fade-in-up 0.55s cubic-bezier(0.16, 1, 0.3, 1) both',
        'fade-in': 'fade-in 0.4s ease-out both',
        'scale-in': 'scale-in 0.45s cubic-bezier(0.16, 1, 0.3, 1) both',
        'float-slow': 'float-slow 4s ease-in-out infinite',
      },
    },
  },
  plugins: [],
}
