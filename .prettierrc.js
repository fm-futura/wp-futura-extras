/** @typedef {import('prettier').Options} PrettierOptions */

/**
 * @typedef WPPrettierOptions
 *
 * @property {boolean} [parenSpacing=true] Insert spaces inside parentheses.
 */

// Disable reason: The current JSDoc tooling does not yet understand TypeScript
// union types.

/** @type {PrettierOptions & WPPrettierOptions} */
const config = {
    useTabs: false,
    tabWidth: 2,
    printWidth: 80,
    singleQuote: true,
    trailingComma: 'es5',
    bracketSpacing: true,
    parenSpacing: false,
    jsxBracketSameLine: false,
    semi: true,
    arrowParens: 'always',
};

module.exports = config;
