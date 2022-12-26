/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    theme: {
      extend: {},
    },daisyui: {
      themes: [
        {
          mytheme: {
          "primary": "#519259",
          "secondary": "#F0BB62",
          "accent": "#F4EEA9",
          "neutral": "#E8E1D9",
          "base-100": "#FFFFFF",
          "info": "#3ABFF8",
          "success": "#36D399",
          "warning": "#FBBD23",
          "error": "#F87272",
          },
        },
      ],
    },
    plugins: [require("daisyui"),
    require('flowbite/plugin')],
  }
  // 519259
  // F4EEA9
