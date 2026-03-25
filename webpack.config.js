const path = require('path');

module.exports = {
  entry: {
    admin: './assets/src/admin.js',
    public: './assets/src/public.js'
  },
  output: {
    filename: '[name].bundle.js',
        path: path.resolve(__dirname, 'public/dist')  },
  module: {
    rules: [
      {
        test: /\.jsx?$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: [
              '@babel/preset-env',
              '@babel/preset-react'
            ]
          }
        }
      },
      {
        test: /\.css$/,
        use: ['style-loader', 'css-loader']
      }
    ]
  },
  resolve: {
    extensions: ['.js', '.jsx']
  },
  externals: {
    'react': 'React',
    'react-dom': 'ReactDOM',
    'jquery': 'jQuery'
  }
};
