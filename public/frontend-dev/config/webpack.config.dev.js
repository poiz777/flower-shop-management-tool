const path                = require('path');
const webpack             = require('webpack');
const UglifyJsPlugin      = require('uglifyjs-webpack-plugin');
// const VueLoaderPlugin     = require('vue-loader/lib/plugin');
const HTMLWebpackPlugin   = require('html-webpack-plugin');

module.exports            = { 
  mode                : "production",
  entry               : {
    pz        : [ path.resolve(__dirname, "../index.js") ]
  },
  
  output              : {
    path      :  path.resolve(__dirname, '../js'),
    filename  : "[name]-jobs-admin.js",  //-[hash]
    sourceMapFilename: "[name]-jobs-admin.map",
  },
  
  devtool: 'source-map',
  
  module              : {
    rules: [
      {
        test    : /\.js[x]?/,
        use     : {
          loader: "babel-loader"
        },
        exclude: /node_modules/,
      },
      
      {
        test    : /\.htm[l]?/,
        use     : ["file-loader", "html-loader"],
        exclude : path.resolve(__dirname, '../_tpl/index.html')
      },
      
      {
        test  : /\.vue[x]?$/,
        use   : ["vue-loader"]
      },
    ]
  },
  
  /*
  optimization: {
    minimizer: [
      new UglifyJsPlugin({
        parallel: true,
        test: /\.js(\?.*)?$/i,
        uglifyOptions: {
          sourceMap   : true,
          warnings    : false,
          parse       : {},
          compress    : {},
          mangle      : true, // Note `mangle.properties` is `false` by default.
          output      : null,
          toplevel    : false,
          nameCache   : null,
          ie8         : false,
          keep_fnames : false,
        },
      })
    ],
    minimize: true
  },
  
  plugins             : [
    // new VueLoaderPlugin(),
    new HTMLWebpackPlugin({
      title: 'Love Rules',
      //template: path.resolve(__dirname, "../_tpl/index.html"),
      hash: false,
      myPageHeader: 'Hello World',
      // template: './_tpl/index.html',
      filename: '../js/index.html' //relative to root of the application
    }),
  ]
  */
};