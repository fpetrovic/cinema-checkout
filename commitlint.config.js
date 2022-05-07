module.exports = {
  extends: ['@commitlint/config-conventional'],
  parserPreset: {
    parserOpts: {
      issuePrefixes: ['CO-', 'TD-', 'RVN-'],
      headerPattern: /^([A-Z]+-\d+ )?(\S+.*)$/,
      headerCorrespondence: ['references', 'subject'],
    },
  },
  rules: {
    'type-empty': [0, 'always'],
    'scope-empty': [0, 'always'],
    'references-empty': [2, 'never'],
    'subject-empty': [2, 'never'],
    'subject-case': [0, 'never'],
    'body-max-line-length': [0, 'never'],
    'body-leading-blank': [2, 'always'],
    'header-max-length': [2, 'always', 100],
    'footer-max-line-length': [0, 'never'],
    'footer-leading-blank': [0, 'never'],
  },
};
