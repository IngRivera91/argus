const path = require('path');

module.exports = {
  entry: [
      './src/index.js',
      './node_modules/jquery/dist/jquery.js',
      './node_modules/select2/dist/js/select2.full.min.js',
      './node_modules/bootstrap-switch/dist/js/bootstrap-switch.min.js',
      './node_modules/bootstrap/dist/js/bootstrap.min.js',
      './node_modules/admin-lte/dist/js/adminlte.min.js',
    ],
  output: {
    filename: 'bundle.js',
    path: path.resolve(__dirname, './public/dist'),
  },
  module: {
    rules: [
      {
        test: /\.css$/i,
        use: ['style-loader', 'css-loader'],
      },
    ],
  },
};