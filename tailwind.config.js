module.exports = {
  content: [
    "./**/*.{html,js,php}",
    "./admin/**/*.{html,js,php}",
    "./assets/**/*.{html,js,php}",
    // Ajoutez d'autres dossiers si nécessaire
  ],
  theme: {
    extend: {
      colors: {
        gray: {
          custom: "#A9A9A9",
        },
        green: {
          custom: "#008000",
        },
        blue: {
          custom: "#0047AB",
        },
        gold: {
          custom: "#FFD700",
        },
      },
    },
  },
  plugins: [],
};
