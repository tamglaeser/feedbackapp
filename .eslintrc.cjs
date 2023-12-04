module.exports = {
  root: true,
  env: {
    node: true,
  },
  parser: '@babel/eslint-parser',
  extends: ['plugin:vue/vue3-essential', 'eslint:recommended'],
  parserOptions: {
    requireConfigFile: false, // Set to true if using a separate Babel config file
    babelOptions: {
      configFile: './.babelrc', // Path to your Babel config file
    },
    //parser: 'babel-eslint',
  },
  rules: {
    // Your custom rules here
  },
};

