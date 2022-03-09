module.exports = {
  purge: {
    content: ['./templates/**/*.html.twig']
  },
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      minHeight: {
        500: "500px",
        550: "550px",
        650: "650px"
      },
      backgroundImage: {
        'neon-pink': "linear-gradient(to top, rgb(107, 33, 168), rgb(76, 29, 149), rgb(107, 33, 168))" ,
        'neonreverted': "linear-gradient(to left, rgb(251, 113, 133), rgb(217, 70, 239), rgb(99, 102, 241))",
        'blueshred' : ' linear-gradient(311deg, rgb(144, 100, 159) 0%, rgb(144, 100, 159) 24%,rgb(112, 112, 163) 24%, rgb(112, 112, 163) 28%,rgb(79, 124, 166) 28%, rgb(79, 124, 166) 40%,rgb(47, 136, 170) 40%, rgb(47, 136, 170) 84%,rgb(14, 148, 173) 84%, rgb(14, 148, 173) 100%),linear-gradient(266deg, rgb(144, 100, 159) 0%, rgb(144, 100, 159) 24%,rgb(112, 112, 163) 24%, rgb(112, 112, 163) 28%,rgb(79, 124, 166) 28%, rgb(79, 124, 166) 40%,rgb(47, 136, 170) 40%, rgb(47, 136, 170) 84%,rgb(14, 148, 173) 84%, rgb(14, 148, 173) 100%),linear-gradient(401deg, rgb(144, 100, 159) 0%, rgb(144, 100, 159) 24%,rgb(112, 112, 163) 24%, rgb(112, 112, 163) 28%,rgb(79, 124, 166) 28%, rgb(79, 124, 166) 40%,rgb(47, 136, 170) 40%, rgb(47, 136, 170) 84%,rgb(14, 148, 173) 84%, rgb(14, 148, 173) 100%),linear-gradient(356deg, rgb(79, 35, 157),rgb(43, 171, 222)); background-blend-mode:overlay,overlay,overlay,normal;',
        'purpleshred' : ' linear-gradient(112.5deg, rgb(225,101,118) 0%, rgb(225,101,118) 3%,rgb(219, 107, 130) 3%, rgb(219, 107, 130) 34%,rgb(187, 104, 131) 34%, rgb(187, 104, 131) 46%,rgb(156, 102, 131) 46%, rgb(156, 102, 131) 51%,rgb(124, 99, 132) 51%, rgb(124, 99, 132) 52%,rgb(93, 97, 132) 52%, rgb(93, 97, 132) 76%,rgb(61, 94, 133) 76%, rgb(61, 94, 133) 84%,rgb(30, 92, 133) 84%, rgb(30, 92, 133) 100%),linear-gradient(157.5deg, rgb(225,101,118) 0%, rgb(225,101,118) 3%,rgb(219, 107, 130) 3%, rgb(219, 107, 130) 34%,rgb(187, 104, 131) 34%, rgb(187, 104, 131) 46%,rgb(156, 102, 131) 46%, rgb(156, 102, 131) 51%,rgb(124, 99, 132) 51%, rgb(124, 99, 132) 52%,rgb(93, 97, 132) 52%, rgb(93, 97, 132) 76%,rgb(61, 94, 133) 76%, rgb(61, 94, 133) 84%,rgb(30, 92, 133) 84%, rgb(30, 92, 133) 100%),linear-gradient(325deg, rgb(225,101,118) 0%, rgb(225,101,118) 3%,rgb(219, 107, 130) 3%, rgb(219, 107, 130) 34%,rgb(187, 104, 131) 34%, rgb(187, 104, 131) 46%,rgb(156, 102, 131) 46%, rgb(156, 102, 131) 51%,rgb(124, 99, 132) 51%, rgb(124, 99, 132) 52%,rgb(93, 97, 132) 52%, rgb(93, 97, 132) 76%,rgb(61, 94, 133) 76%, rgb(61, 94, 133) 84%,rgb(30, 92, 133) 84%, rgb(30, 92, 133) 100%),linear-gradient(370deg, rgb(71, 69, 135),rgb(149,12,103)); background-blend-mode:overlay,overlay,overlay,normal;'
      }

    },
  },
  variants: {
    extend: {
      ringColor: ['hover'],
      ringWidth: ['hover'],
      backgroundImage: ['hover'],

    },
  },
  plugins: [
    require('@tailwindcss/forms')
  ],
}