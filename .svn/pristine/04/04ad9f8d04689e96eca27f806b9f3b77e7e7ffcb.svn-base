<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', ["uses"=>"IndexController@index", 'as' => 'Index' ]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/product_details/{id?}', ["uses"=>"ProductsController@productDetails", 'as' => 'productDetails']);

Route::get('/about', ["uses"=>"AboutController@index", 'as' => 'About']);

Route::get('/categories', ["uses"=>"CategoriesController@index", 'as' => 'Categories']);

Route::get('/cart', ["uses"=>"CartController@index", 'as' => 'Cart']);

Route::get('/cart_qty_plus/{id}', ["uses" => "CartController@increaseSingleProduct", 'as' => 'increaseSingleProduct']);

Route::get('/cart_qty_minus/{id}', ["uses" => "CartController@decreaseSingleProduct", 'as' => 'decreaseSingleProduct']);

Route::get('/cart/deleteItemFromCart/{id}', ["uses"=>"CartController@deleteItemFromCart", 'as' => 'DeleteItemFromCart']);

Route::get('/cart/addToCart/{id}', ["uses"=>"CartController@addProductToCart", 'as' => 'AddToCartProduct']);

Route::get('/checkout', ["uses"=>"CheckoutController@index", 'as' => 'Checkout']);

Route::get('/blog', ["uses"=>"BlogController@index", 'as' => 'Blog']);

Route::get('/blog/search', ["uses"=>"BlogController@searchBlog", 'as' => 'searchBlog']);

Route::get('/blog_details/{id}', ["uses"=>"BlogController@blogDetails", 'as' => 'blogDetails']);

Route::post('/blog_details/comment/{id}', ["uses"=>"BlogController@sendComment", 'as' => 'sendComment'])->middleware('auth');

Route::get('/blog_details/comment/edit/{blog}/{comment}', ["uses"=>"BlogController@editComment", 'as' => 'editComment'])->middleware('auth');

Route::post('/blog_details/comment/update/{blog}/{comment}', ["uses"=>"BlogController@updeteComment", 'as' => 'updeteComment'])->middleware('auth');

Route::get('/blog_details/comment/delete/{id}', ["uses"=>"BlogController@deleteComment", 'as' => 'deleteComment'])->middleware('auth');

Route::get('/blog_details/{id}/like', ["uses"=>"BlogController@blogLike", 'as' => 'blogLike'])->middleware('auth');

Route::get('/blog_details/{id}/unlike', ["uses"=>"BlogController@blogUnLike", 'as' => 'blogUnLike'])->middleware('auth');

Route::get('/contact', ["uses"=>"ContactController@index", 'as' => 'Contact']);

Route::post('/send_order', ["uses"=>"CheckoutController@sendOrder", 'as' => 'sendOrder']);

Route::get('/search', ["uses"=>"ProductsController@searchProduct", 'as' => 'searchProduct']);

Route::get('/search_all', ["uses"=>"HomeController@searchAll", 'as' => 'searchAll'])->middleware('restricToAdmin');

//review
Route::post('/product_review/{id}', ["uses"=>"ProductsController@reviewProduct", 'as' => 'reviewProduct']);

//payment
Route::post('tbpapi/{id}', ["uses"=>"CheckoutController@paymentResponse", 'as' => 'paymentResponse']);



// !Admin product

// *product group
Route::get('/admin/product/group', ["uses"=>"Admin\Product\ProductGroupController@index", 'as' => 'adminProductGroup'])->middleware('restricToAdmin');

Route::post('/admin/product/group/insert', ["uses"=>"Admin\Product\ProductGroupController@productGroupInsert", 'as' => 'productGroupInsert'])->middleware('restricToAdmin');

Route::get('/admin/product/group/edit/{id}', ["uses"=>"Admin\Product\ProductGroupController@productGroupEdit", 'as' => 'productGroupEdit'])->middleware('restricToAdmin');

Route::post('/admin/product/group/update', ["uses"=>"Admin\Product\ProductGroupController@productGroupUpdate", 'as' => 'productGroupUpdate'])->middleware('restricToAdmin');

Route::get('/admin/product/group/delete/{id}', ["uses"=>"Admin\Product\ProductGroupController@productGroupDelete", 'as' => 'productGroupDelete'])->middleware('restricToAdmin');

// *product type
Route::get('/admin/product/type', ["uses"=>"Admin\Product\ProductTypeController@index", 'as' => 'adminProductType'])->middleware('restricToAdmin');

Route::post('/admin/product/type/insert', ["uses"=>"Admin\Product\ProductTypeController@productTypeInsert", 'as' => 'productTypeInsert'])->middleware('restricToAdmin');

Route::get('/admin/product/type/edit/{id}', ["uses"=>"Admin\Product\ProductTypeController@productTypeEdit", 'as' => 'productTypeEdit'])->middleware('restricToAdmin');

Route::post('/admin/product/type/update', ["uses"=>"Admin\Product\ProductTypeController@productTypeUpdate", 'as' => 'productTypeUpdate'])->middleware('restricToAdmin');

Route::get('/admin/product/type/delete/{id}', ["uses"=>"Admin\Product\ProductTypeController@productTypeDelete", 'as' => 'productTypeDelete'])->middleware('restricToAdmin');

// *product brand
Route::get('/admin/product/brand', ["uses"=>"Admin\Product\ProductBrandController@index", 'as' => 'adminProductBrand'])->middleware('restricToAdmin');

Route::post('/admin/product/brand/insert', ["uses"=>"Admin\Product\ProductBrandController@productBrandInsert", 'as' => 'productBrandInsert'])->middleware('restricToAdmin');

Route::get('/admin/product/brand/edit/{id}', ["uses"=>"Admin\Product\ProductBrandController@productBrandEdit", 'as' => 'productBrandEdit'])->middleware('restricToAdmin');

Route::post('/admin/product/brand/update', ["uses"=>"Admin\Product\ProductBrandController@productBrandUpdate", 'as' => 'productBrandUpdate'])->middleware('restricToAdmin');

Route::get('/admin/product/brand/delete/{id}', ["uses"=>"Admin\Product\ProductBrandController@productBrandDelete", 'as' => 'productBrandDelete'])->middleware('restricToAdmin');

// *product model
Route::get('/admin/product/model', ["uses"=>"Admin\Product\ProductModelController@index", 'as' => 'adminProductModel'])->middleware('restricToAdmin');

Route::post('/admin/product/model/insert', ["uses"=>"Admin\Product\ProductModelController@productModelInsert", 'as' => 'productModelInsert'])->middleware('restricToAdmin');

Route::get('/admin/product/model/edit/{id}', ["uses"=>"Admin\Product\ProductModelController@productModelEdit", 'as' => 'productModelEdit'])->middleware('restricToAdmin');

Route::post('/admin/product/model/update', ["uses"=>"Admin\Product\ProductModelController@productModelUpdate", 'as' => 'productModelUpdate'])->middleware('restricToAdmin');

Route::get('/admin/product/model/delete/{id}', ["uses"=>"Admin\Product\ProductModelController@productModelDelete", 'as' => 'productModelDelete'])->middleware('restricToAdmin');

// *product unitofmeasurepos
Route::get('/admin/product/unitofmeasurepos', ["uses"=>"Admin\Product\ProductUnitofmeasureposController@index", 'as' => 'adminProductUnitofmeasurepos'])->middleware('restricToAdmin');

Route::post('/admin/product/unitofmeasurepos/insert', ["uses"=>"Admin\Product\ProductUnitofmeasureposController@productUomInsert", 'as' => 'productUomInsert'])->middleware('restricToAdmin');

Route::get('/admin/product/unitofmeasurepos/edit/{id}', ["uses"=>"Admin\Product\ProductUnitofmeasureposController@productUomEdit", 'as' => 'productUomEdit'])->middleware('restricToAdmin');

Route::post('/admin/product/unitofmeasurepos/update', ["uses"=>"Admin\Product\ProductUnitofmeasureposController@productUomUpdate", 'as' => 'productUomUpdate'])->middleware('restricToAdmin');

Route::get('/admin/product/unitofmeasurepos/delete/{id}', ["uses"=>"Admin\Product\ProductUnitofmeasureposController@productUomDelete", 'as' => 'productUomDelete'])->middleware('restricToAdmin');

// *product main
Route::get('/admin/product', ["uses"=>"Admin\Product\ProductController@index", 'as' => 'adminProduct'])->middleware('restricToAdmin');

Route::post('/admin/product/insert', ["uses"=>"Admin\Product\ProductController@productInsert", 'as' => 'productInsert'])->middleware('restricToAdmin');








// ! treasury








Route::get('/admin/products', ["uses"=>"Admin\ProductsController@index", 'as' => 'adminProducts'])->middleware('restricToAdmin');

Route::get('/admin/products/search', ["uses"=>"Admin\ProductsController@searchProduct", 'as' => 'adminSearchProduct'])->middleware('restricToAdmin');

Route::get('/admin/products/add', ["uses"=>"Admin\ProductsController@addProduct", 'as' => 'addProduct'])->middleware('restricToAdmin');

// Route::post('/admin/products/create', ["uses"=>"Admin\ProductsController@createProduct", 'as' => 'createProduct'])->middleware('restricToAdmin');

// Route::get('/admin/products/edit/{id}', ["uses" => "Admin\ProductsController@editProduct", 'as' => 'editProduct'])->middleware('restricToAdmin');
// Route::post('/admin/products/update/{id}', ["uses" => "Admin\ProductsController@updateProduct", 'as' => 'updateProduct'])->middleware('restricToAdmin');

// Route::post('admin/products/add_image/{id}', ["uses"=>"Admin\ProductsController@addProductImage", 'as' => 'addProductImage'])->middleware('restricToAdmin');
// Route::get('/admin/products/edit_image/{id}', ["uses"=>"Admin\ProductsController@editProductImage", 'as' => 'editProductImage'])->middleware('restricToAdmin');
// Route::post('/admin/products/update_image/{id}', ["uses" => "Admin\ProductsController@updateProductImage", 'as' => 'updateProductImage'])->middleware('restricToAdmin');

// Route::get('/admin/products/delete_image/{id}/{index}', ["uses"=>"Admin\ProductsController@deleteProductImage", 'as' => 'deleteProductImage'])->middleware('restricToAdmin');

// Route::get('/admin/products/delete/{id}', ["uses"=>"Admin\ProductsController@deleteProduct", 'as' => 'deleteProduct'])->middleware('restricToAdmin');

//Admin Blog
Route::get('/admin/blogs', ["uses"=>"Admin\BlogsController@index", 'as' => 'adminBlogs'])->middleware('restricToAdmin');

Route::get('/admin/blogs/search', ["uses"=>"Admin\BlogsController@searchBlog", 'as' => 'adminSearchBlog'])->middleware('restricToAdmin');

Route::get('/admin/blogs/add', ["uses"=>"Admin\BlogsController@addBlog", 'as' => 'addBlog'])->middleware('restricToAdmin');
Route::post('/admin/blogs/create', ["uses"=>"Admin\BlogsController@createBlog", 'as' => 'createBlog'])->middleware('restricToAdmin');

Route::get('/admin/blogs/delete/{id}', ["uses"=>"Admin\BlogsController@deleteBlog", 'as' => 'deleteBlog'])->middleware('restricToAdmin');

Route::get('/admin/blogs/edit/{id}', ["uses"=>"Admin\BlogsController@editBlog", 'as' => 'editBlog'])->middleware('restricToAdmin');
Route::post('/admin/blogs/update/{id}', ["uses"=>"Admin\BlogsController@updateBlog", 'as' => 'updateBlog'])->middleware('restricToAdmin');


//Admin categories
Route::get('/admin/categories', ["uses"=>"Admin\CategoriesController@index", 'as' => 'adminCategories'])->middleware('restricToAdmin');

Route::get('/admin/categories/search', ["uses"=>"Admin\CategoriesController@searchCategorie", 'as' => 'adminSearchCategorie'])->middleware('restricToAdmin');

Route::get('/admin/categories/{id}/show_products', ["uses"=>"Admin\CategoriesController@showProducts", 'as' => 'showProducts'])->middleware('restricToAdmin');

Route::post('admin/categories/create', ["uses" => "Admin\CategoriesController@createCategorie", 'as' => 'createCategorie'])->middleware('restricToAdmin');

Route::get('admin/categories/edit/{id}', ["uses" => "Admin\CategoriesController@editCategorie", 'as' => 'editCategorie'])->middleware('restricToAdmin');
Route::post('admin/categories/update/{id}', ["uses" => "Admin\CategoriesController@updateCategorie", 'as' => 'updateCategorie'])->middleware('restricToAdmin');

Route::get('admin/categories/delete/{id}', ["uses" => "Admin\CategoriesController@deleteCategorie", 'as' => 'deleteCategorie'])->middleware('restricToAdmin');

//Admin product
Route::get('/profile', 'profilecontroller@showdata')->name('profile')->middleware('restricToAdmin');

//Admin users
Route::get('/admin/users', ["uses"=>"Admin\UsersController@index", 'as' => 'adminUsers'])->middleware('restricToAdmin');

Route::get('/admin/users/search', ["uses"=>"Admin\UsersController@searchUser", 'as' => 'adminSearchUser'])->middleware('restricToAdmin');

// Route::get('/admin/user/create', ["uses"=>"Admin\UsersController@createUser", 'as' => 'createUser'])->middleware('restricToAdmin');
// Route::post('/admin/user/create/add', ["uses"=>"Admin\UsersController@addUser", 'as' => 'addUser'])->middleware('restricToAdmin');

Route::get('/admin/user/edit/{id}', ["uses"=>"Admin\UsersController@editUser", 'as' => 'editUser'])->middleware('restricToAdmin');
Route::post('/admin/user/update/{id}', ["uses"=>"Admin\UsersController@updateUser", 'as' => 'updateUser'])->middleware('restricToAdmin');

//profile
Route::get('/profile/resetpassword/{id}', ["uses" => "profilecontroller@resetpass", 'as' => 'resetPassword'])->middleware('restricToAdmin');
Route::post('/profile/updatepass/{id}', ["uses" => "profilecontroller@updatePassword", 'as' => 'updatePassword'])->middleware('restricToAdmin');
Route::post('/profile/editprofile/{id}', ["uses" => "profilecontroller@editProfile", 'as' => 'editProfile'])->middleware('restricToAdmin');
Route::get('/profile', 'profilecontroller@showdata')->name('profile')->middleware('auth');

//reset password
Route::post('reset_password_without_token', 'AccountsController@validatePasswordRequest');

Route::post('reset_password_with_token', 'AccountsController@resetPassword');

//chat video
Route::post('get_messages', 'Chat\ChatController@fetchMessages');
Route::post('messages', 'Chat\ChatController@sendMessage');
Route::post('update_message', 'Chat\ChatController@updateMessage');
Route::delete('message', 'Chat\ChatController@destroyMessage');

Route::post('friends_list', 'Chat\UserController@getFriends');
Route::post('/recount_unread', 'Chat\ChatController@reCount');

Route::get('/user', 'Chat\UserController@getUser');

Route::post('/reading', 'Chat\ChatController@reading');
Route::post('/re_reading', 'Chat\ChatController@reReading');
Route::post('/upload', 'Chat\ChatController@uploadFile');
Route::get('/download/{file}', 'Chat\ChatController@downloadFile');
Route::post('/video_time', 'Chat\ChatController@videoTime');
Route::post('/video_time_end', 'Chat\ChatController@videoTimeEnd');

Route::get('locale/{locale}', 'LanguageController@index')->middleware('setLanguage')->name('locale.setting');

Route::post('get_badge', 'Chat\ChatController@getBadge');

// Route::get('pos_one', 'Posone\PosoneProductsController@index');

// Route::get('pos_one_test', 'Posone\Showstockcontroller@show');

// Route::get('posone_test', 'Posone\Showstockcontroller@index');

// Route::post('posone_test/add', 'Posone\Showstockcontroller@productGroupInsert')->name('productGroupInsert');

// Route::get('posone_test/edit/{id}', 'Posone\Showstockcontroller@productGroupEdit')->name('productGroupEdit');

// Route::post('posone_test/update', 'Posone\Showstockcontroller@productGroupUpdate')->name('productGroupUpdate');

// Route::get('posone_test/delete/{id}', 'Posone\Showstockcontroller@productGroupDelete')->name('productGroupDelete');