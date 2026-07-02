/**
 * Copyright 2020 Design Barn Inc.
 */

module.exports = {
  root: true,
  plugins: [],
  extends: [
    'plugin:@lottiefiles/esnext',
    'plugin:@lottiefiles/typescript',
    'plugin:@lottiefiles/typescript-typechecking',
    'plugin:@lottiefiles/nodejs',
    'plugin:@lottiefiles/prettier',
  ],
  parserOptions: {
    project: 'tsconfig.json',
    tsconfigRootDir: __dirname,
    sourceType: 'module',
    createDefaultProgram: true,
  },
  rules: {
    'import/no-unresolved': 'off',
    'import/no-unassigned-import': 'off',
    'eslint-comments/no-unused-disable': 'off',
    '@typescript-eslint/no-var-requires': 0,
    '@typescript-eslint/no-unnecessary-condition': 'off',
    'filenames/match-regex': 'off',
    '@lottiefiles/import-filename-format': 'off',
    '@typescript-eslint/no-namespace': 'off',
    'tsdoc/syntax': 'off',
    'no-warning-comments': 'off',
    'no-console': 'off',
    '@typescript-eslint/explicit-function-return-type': 'off',
  },
};
