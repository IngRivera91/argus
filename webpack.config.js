const path = require('path');

module.exports = {
  entry: [
      './node_modules/admin-lte/plugins/jquery/jquery.min.js',
      './node_modules/admin-lte/plugins/select2/js/select2.full.min.js',
      './node_modules/admin-lte/plugins/bootstrap-switch/js/bootstrap-switch.min.js',
      './node_modules/admin-lte/plugins/bootstrap/js/bootstrap.min.js',
      './node_modules/admin-lte/dist/js/adminlte.min.js',
      './src/index.js',
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