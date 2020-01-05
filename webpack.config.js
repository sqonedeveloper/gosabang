const path = require('path');
const webpack = require('webpack');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');

module.exports = {
	entry: {
		topbar: './src/Topbar.js',
		sidebar: './src/Sidebar.js',
		adminDashboard: './src/Admin/Dashboard.js',
		adminCategories: './src/Admin/Categories/Lists.js',
		adminCategoriesForms: './src/Admin/Categories/Forms.js',
	},

	output: {
		filename: '[name].js',
		path: path.resolve(__dirname, 'public/bundle')
	},

	plugins: [
		new webpack.ProgressPlugin(),
		new HtmlWebpackPlugin(),
		new webpack.DefinePlugin({
			'process.env.NODE_ENV': JSON.stringify('production')
		})
	],

	module: {
		rules: [
			{
				test: /.(js|jsx)$/,
				include: [path.resolve(__dirname, 'src')],
				loader: 'babel-loader',

				options: {
					plugins: ['syntax-dynamic-import'],

					presets: [
						[
							'@babel/preset-env',
							{
								modules: false
							}
						]
					]
				}
			}
		]
	},

	optimization: {
		splitChunks: {
			chunks: 'all',
			automaticNameDelimiter: '.',
			cacheGroups: {
				vendors: {
					test: /[\\/]node_modules[\\/]/,
					name: 'vendor'
				}
			}
		},
		minimizer: [
			new UglifyJsPlugin({
				uglifyOptions: {
					output: {
						comments: false
					}
				}
			})
		]
	},

	devServer: {
		open: true,
		disableHostCheck: true
	}
};
