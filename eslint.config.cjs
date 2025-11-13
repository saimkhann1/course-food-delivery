// root: true,  <- remove this line
const { defineConfig } = require("eslint-define-config");

module.exports = [
  defineConfig({
    files: ["resources/js/**/*.js", "resources/js/**/*.vue"],
    ignores: ["vendor/**", "public/build/**"],
    languageOptions: {
      parser: require("vue-eslint-parser"),
      parserOptions: {
        parser: require("@babel/eslint-parser"),
        requireConfigFile: false,
        ecmaVersion: 2020,
        sourceType: "module",
      },
      globals: {
        window: "readonly",
        document: "readonly",
        console: "readonly",
        process: "readonly",
      },
    },
    plugins: {
      vue: require("eslint-plugin-vue"),
    },
    rules: {
      "no-console": "warn",
    },
  }),
];
