/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,php}",
          "index.php",
          "index.html",
          "./pages/*.php",
          "./includes/*.php",
          "./node_modules/flyonui/dist/js/*.js",
          "./auth_pages/*.php",
          "./passanger/*.php",
          './node_modules/datatables.net/js/dataTables.min.js'
  ],
  
  theme: {
    extend: {
      fontFamily: {
        custom:['cascadia','Lora-VariableFont_wght', 'serif']
      },
      
    },
  },
  flyonui: {
    themes: [
      {
        mytheme: {
          "primary": "oklch(51% 0.262 276.966)",
          "primary-content": "oklch(96% 0.018 272.314)",
        
          "secondary": "oklch(43% 0 0)",
          "secondary-content": "oklch(98% 0 0)",
        
          "accent": "oklch(64% 0.222 41.116)",
          "accent-content": "oklch(98% 0.016 73.684)",
        
          "neutral": "oklch(44% 0.11 240.79)",
          "neutral-content": "oklch(97% 0.013 236.62)",
        
          "base-100": "oklch(29% 0.066 243.157)",
          "base-200": "oklch(39% 0.09 240.876)",
          "base-300": "oklch(44% 0.11 240.79)",
          "base-content": "oklch(95% 0.026 236.824)",
        
          "info": "oklch(70% 0.165 254.624)",
          "info-content": "oklch(28% 0.091 267.935)",
        
          "success": "oklch(84% 0.238 128.85)",
          "success-content": "oklch(27% 0.072 132.109)",
        
          "warning": "oklch(85% 0.199 91.936)",
          "warning-content": "oklch(28% 0.066 53.813)",
        
          "error": "oklch(70% 0.191 22.216)",
          "error-content": "oklch(25% 0.092 26.042)",
        
          "rounded-box": "4rem", 
          "rounded-btn": "0.5rem",
          "rounded-tooltip": "1.9rem",
        
          "animation-btn": "0.25s",
          "animation-input": "0.2s",
          "btn-focus-scale": "0.95",
        
          "border-btn": "1px",
          "tab-border": "1px",
          "tab-radius": "0.5rem"
        }
      }
    ]
  },
  plugins: [
    require("flyonui"),
    require("flyonui/plugin") // Require only if you want to use FlyonUI JS component
  ],
}