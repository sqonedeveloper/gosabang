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
		adminProfile: './src/Admin/Profile/Lists.js',
		adminProfileForms: './src/Admin/Profile/Forms.js',
		login: './src/Login.js',
		adminUsersAccount: './src/Admin/Users/Account/Lists.js',
		adminUsersAccountForms: './src/Admin/Users/Account/Forms.js',
		adminBlog: './src/Admin/Blogs/Lists.js',
		adminBlogForms: './src/Admin/Blogs/Forms.js',
		usahaDashboard: './src/Usaha/Dashboard.js',
		usahaAccount: './src/Usaha/Account.js',
		usahaProfileItemForms: './src/Usaha/Profile/Item/Forms.js',
		usahaProfileInfoForms: './src/Usaha/Profile/Info/Forms.js',
		usahaGallery: './src/Usaha/Gallery.js',
		home: './src/Production/Home.js',
		categoriesLists: './src/Production/Categories/Lists.js',
		businessDetail: './src/Production/Business/Detail.js',
		blogDetail: './src/Production/Blog.js',
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
